<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Image\ImageService;
use App\Http\Requests\Admin\LessonRequest;
use App\Models\Chapter;
use App\Models\Lesson;

class LessonController extends BaseController
{
    protected $imageService;
    protected $folder;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->folder = $this->imageService->folder('lessons');
    }

    public function index()
    {
        $chapters = Chapter::active()->pluck('title', 'id');
        $lessons = Lesson::orderBy('id', 'desc')->paginate(config('paginate.admin.common'));

        return view('admin.lessons.index')->with([
            'lessons' => $lessons,
            'chapters' => $chapters,
        ]);
    }

    public function store(LessonRequest $request)
    {
        $input = $request->only(['title', 'status', 'chapter_id', 'seo_title', 'seo_keywords', 'seo_description']);

        $input['editor_id'] = auth()->id();

        if (!empty($request->file('banner'))) {
            $input['banner'] = $this->imageService->upload($this->folder, $request->file('banner'));
        }

        Lesson::create($input);

        return redirect()->route('admin.lessons.index')->with('message', 'Tạo mới thành công');
    }

    public function edit(Lesson $lesson)
    {
        $chapters = Chapter::active()->pluck('title', 'id');

        return view('admin.lessons.edit')->with([
            'chapters' => $chapters,
            'lesson' => $lesson,
        ]);
    }

    public function update(LessonRequest $request, Lesson $lesson)
    {
        $input = $request->only(['title', 'status', 'chapter_id', 'seo_title', 'seo_keywords', 'seo_description']);

        $input['editor_id'] = auth()->id();

        if (!empty($request->file('banner'))) {
            $input['banner'] = $this->imageService->upload($this->folder, $request->file('banner'));
        }

        $lesson->update($input);

        return redirect()->route('admin.lessons.index')->with('message', 'Sửa thành công');
    }


    public function destroy(Lesson $lesson)
    {
        // TODO : destroy
    }
}
