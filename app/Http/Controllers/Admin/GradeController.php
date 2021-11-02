<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\GradeRequest;
use App\Models\Grade;
use App\Actions\Image\ImageService;

class GradeController extends BaseController
{
    protected $imageService;
    protected $folder;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->folder = $this->imageService->folder('grades');
    }

    public function index()
    {
        $grades = Grade::get();

        return view('admin.grades.index')->with([
            'grades' => $grades
        ]);
    }

    public function store(GradeRequest $request)
    {
        $input = $request->only(['title', 'status', 'type', 'seo_title', 'seo_keywords', 'seo_description']);
        $input['editor_id'] = auth()->id();
        
        if (!empty($request->file('banner'))) {
            $input['banner'] = $this->imageService->upload($this->folder, $request->file('banner'));
        }

        Grade::create($input);

        return redirect()->route('admin.grades.index')->with('message', 'Tạo mới thành công');
    }

    public function edit(Grade $grade)
    {
        return view('admin.grades.edit')->with([
            'grade' => $grade
        ]);
    }

    public function update(GradeRequest $request, Grade $grade)
    {
        $input = $request->only(['title', 'status', 'type', 'seo_title', 'seo_keywords', 'seo_description']);
        $input['editor_id'] = auth()->id();

        if (!empty($request->file('banner'))) {
            $input['banner'] = $this->imageService->upload($this->folder, $request->file('banner'));
        }

        $grade->update($input);

        return redirect()->route('admin.grades.index')->with('message', 'Sửa thành công');
    }

    public function destroy(Grade $grade)
    {
        // TODO : delete
    }

    public function changeStatus(Grade $grade)
    {
        if ($grade->status == Grade::DISABLE) {
            $grade->update(['status' => Grade::ENABLE]);

            return redirect()->back()->with('message', 'Đã active ' . $grade->title);
        } else if ($grade->status == Grade::ENABLE) {
            $grade->update(['status' => Grade::DISABLE]);

            return redirect()->back()->with('message', 'Đã ẩn ' . $grade->title);
        } else
            return redirect()->back()->with('error', 'Có lỗi khi thay đổi trạng thái, vui lòng thử lại');
    }
}
