<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\SubjectRequest;
use App\Models\Subject;
use App\Actions\Image\ImageService;

class SubjectController extends BaseController
{
    protected $imageService;
    protected $folder;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->folder = $this->imageService->folder('subjects');
    }

    public function index()
    {
        $subjects = Subject::get();

        return view('admin.subjects.index')->with([
            'subjects' => $subjects
        ]);
    }


    public function store(SubjectRequest $request)
    {
        $input = $request->only(['title', 'status', 'seo_title', 'seo_keywords', 'seo_description']);

        $input['editor_id'] = auth()->id();

        if (!empty($request->file('banner'))) {
            $input['banner'] = $this->imageService->upload($this->folder, $request->file('banner'));
        }

        Subject::create($input);

        return redirect()->route('admin.subjects.index')->with('message', 'Tạo mới thành công');
    }

    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit')->with([
            'subject' => $subject
        ]);
    }

    public function update(SubjectRequest $request, Subject $subject)
    {
        $input = $request->only(['title', 'status', 'seo_title', 'seo_keywords', 'seo_description']);

        $input['editor_id'] = auth()->id();

        if (!empty($request->file('banner'))) {
            $input['banner'] = $this->imageService->upload($this->folder, $request->file('banner'));
        }

        $subject->update($input);

        return redirect()->route('admin.subjects.index')->with('message', 'Sửa thành công');
    }

    public function destroy(Subject $subject)
    {
        //
    }

    public function changeStatus(Subject $subject)
    {
        if ($subject->status == Subject::DISABLE) {
            $subject->update(['status' => Subject::ENABLE]);

            return redirect()->back()->with('message', 'Đã active ' . $subject->title);
        } else if ($subject->status == Subject::ENABLE) {
            $subject->update(['status' => Subject::DISABLE]);

            return redirect()->back()->with('message', 'Đã ẩn ' . $subject->title);
        } else {
            return redirect()->back()->with('error', 'Có lỗi khi thay đổi trạng thái, vui lòng thử lại');
        }
    }
}
