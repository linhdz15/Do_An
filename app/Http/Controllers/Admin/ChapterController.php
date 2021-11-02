<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\ChapterRequest;
use App\Models\Chapter;
use App\Models\Grade;
use App\Models\Subject;
use App\Actions\Image\ImageService;

class ChapterController extends BaseController
{
    protected $imageService;
    protected $folder;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->folder = $this->imageService->folder('chapters');
    }

    public function index()
    {
        $grades = Grade::active()->pluck('title', 'id');
        $subjects =  Subject::active()->pluck('title', 'id');
        $chapters = Chapter::with('grade')
            ->with('subject')
            ->orderBy('id', 'desc')
            ->paginate(config('paginate.admin.common'));

        return view('admin.chapters.index', [
            'chapters' => $chapters,
            'grades' => $grades,
            'subjects' => $subjects,
        ]);
    }

    public function store(ChapterRequest $request)
    {
        $input = $request->only(['title', 'status', 'grade_id', 'subject_id', 'seo_title', 'seo_keywords', 'seo_description']);

        $input['editor_id'] = auth()->id();

        if (!empty($request->file('banner'))) {
            $input['banner'] = $this->imageService->upload($this->folder, $request->file('banner'));
        }

        Chapter::create($input);

        return redirect()->route('admin.chapters.index')->with('message', 'Tạo mới thành công');
    }


    public function edit(Chapter $chapter)
    {
        $grades = Grade::active()->pluck('title', 'id');
        $subjects =  Subject::active()->pluck('title', 'id');

        return view('admin.chapters.edit')->with([
            'chapter' => $chapter,
            'grades' => $grades,
            'subjects' => $subjects,
        ]);
    }

    public function update(ChapterRequest $request, Chapter $chapter)
    {
        $input = $request->only(['title', 'status', 'grade_id', 'subject_id', 'seo_title', 'seo_keywords', 'seo_description']);

        $input['editor_id'] = auth()->id();

        if (!empty($request->file('banner'))) {
            $input['banner'] = $this->imageService->upload($this->folder, $request->file('banner'));
        }

        $chapter->update($input);

        return redirect()->route('admin.chapters.index')->with('message', 'Sửa thành công');
    }

    public function destroy(Chapter $chapter)
    {
        // TODO : destroy record
    }
}
