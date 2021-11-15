<?php

namespace App\Actions\Image;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Pngquant;

class ImageService
{
    private function storage()
    {
        return Storage::disk(config('image.storage_disk'));
    }

    private function logger()
    {
        return Log::channel('images_service');
    }

    public function folder($prefixFolder)
    {
        $folder = config('image.base_folder') . $prefixFolder;

        $this->storage()->makeDirectory($folder);

        return $folder;
    }

    protected function resizedImagePath($originalFilePath, $width, $height)
    {
        $lastPositionOfDot = strrpos($originalFilePath, '.');
        if ($lastPositionOfDot === false) {
            return sprintf('%s_%sx%s', $originalFilePath, $width, $height);
        }

        $extension = substr($originalFilePath, $lastPositionOfDot);
        $startName = substr($originalFilePath, 0, $lastPositionOfDot);

        return sprintf('%s_%sx%s%s', $startName, $width, $height, $extension);
    }

    protected function deleteOldFiles($oldFiles)
    {
        try {
            $this->storage()->delete($oldFiles);
        } catch (Exception $e) {
            $this->logger()->error($e);
        }
    }

    protected function resizes($uploadedFile, $storedFilePath, $resizes)
    {
        try {
            $image = Image::make($uploadedFile);
            foreach ($resizes as $size) {
                $imageData = (clone $image)
                    ->fit($size[0], $size[1])
                    ->encode()
                    ->getEncoded();

                $imageName = $this->resizedImagePath($storedFilePath, $size[0], $size[1]);

                $this->storage()->put($imageName, $imageData, 'public');
            }
        } catch (Exception $e) {
            $this->logger()->error($e);
        }
    }

    protected function deleteOldResizedFiles($oldFiles, $resizes)
    {
        try {
            foreach ($resizes as $size) {
                $oldResizedFiles = $this->resizedImagePath($oldFiles, $size[0], $size[1]);

                $this->storage()->delete($oldResizedFiles);
            }
        } catch (Exception $e) {
            $this->logger()->error($e);
        }
    }

    private function constructFileName($fileName, $extension)
    {
        $fileName = Str::slug($fileName, '-') . '-' . time();

        return strtolower("{$fileName}.{$extension}");
    }

    public function upload($folder, $file, $resizes = [], $oldFiles = [])
    {
        try {
            // Optimize image before store to storage
            $optimizerChain = (new OptimizerChain)
                ->addOptimizer(new Jpegoptim([
                    '--strip-all',
                    '--all-progressive',
                ]))
                ->addOptimizer(new Pngquant([
                    '--force',
                ]));
            $optimizerChain->optimize($file->path());

            $image = Image::make($file->get())->encode()->getEncoded();
            // $storedFilePath = $file->hashName($folder); // or
            $fileName = $this->constructFileName(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), $file->getClientOriginalExtension());
            $storedFilePath = $folder . '/' . $fileName;

            // If using S3 driver => we need set file visibility to be pulic
            // https://laravel.com/docs/6.0/filesystem#file-visibility

            $isUploaded = $this->storage()->put($storedFilePath, $image, 'public');

            if (!$isUploaded) {
                return null;
            }

            if ($resizes) {
                $this->resizes($file, $storedFilePath, $resizes);
            }

            if ($oldFiles) {
                $this->deleteOldFiles($oldFiles);
            }

            return $storedFilePath;
        } catch (Exception $e) {
            $this->logger()->error($e);
            return null;
        }
    }

    public function uploadedImageUrl($uploadedPath)
    {
        return $this->storage()->url($uploadedPath);
    }

    public function relativeFileUrl($uploadedPath)
    {
        return diskFilePath(config('image.storage_disk'), $uploadedPath); // diskFilePath define helpers function
    }

    public function resizedImageUrl($uploadedPath, $size)
    {
        $imagePath = $this->resizedImagePath($uploadedPath, $size[0], $size[1]);

        return $this->storage()->url($imagePath);
    }

    public function move($fromPath, $toPath)
    {
        $this->storage()->move($fromPath, $toPath);

        return $this->storage()->path($toPath);
    }

    public function images($folder, $page = 1)
    {
        if (!$this->storage()->exists($folder)) {
            return [
                'images' => collect([]),
                'hasMore' => false,
            ];
        }

        $limit = 50;

        $images = collect(File::files($this->storage()->path($folder)))
            ->sortBy(function ($file) {
                return $file->getFilename();
            })
            ->slice(($page - 1) * $limit, $limit)
            ->map(function ($file) use ($folder) {
                $path = $folder . '/' . $file->getFilename();

                return [
                    'path' => $path,
                    'url' => $this->storage()->url($path),
                ];
            })
            ->values();

        return [
            'images' => $images,
            'hasMore' => $images->count() >= $limit,
        ];
    }

    public function delete($uploadedPaths)
    {
        $this->deleteOldFiles($uploadedPaths);
    }
}
