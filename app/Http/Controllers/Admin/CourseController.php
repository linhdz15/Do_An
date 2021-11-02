<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Course;
use App\Actions\Image\ImageService;
use App\Models\Curriculum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends BaseController
{
    protected $imageService;
    protected $folder;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->folder = $this->imageService->folder('courses');
    }

    public function index(Request $request)
    {
        $query = Course::query()
            ->orderBy('id', 'desc');
        $user = auth()->user();

        if ($user->isEditor()) {
            $query->where('editor_id', $user->id);
        }

        if ($request->title) {
            $query->whereLike('title', $request->title);
        }

        $courses = $query->paginate(25);

        return view('admin.courses.index', [
            'courses' => $courses,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Course::class);

        return view('admin.courses.create', [
            'course' => new Course,
            'action' => route('admin.courses.store'),
        ]);
    }

    public function store(CourseRequest $request)
    {
        DB::beginTransaction();
        $this->authorize('create', Course::class);

        $input = $request->only([
            'title',
            'slug',
            'description',
            'status',
            'seo_title',
            'seo_description',
            'seo_keywords',
            'subject_id',
            'grade_id',
            'chapter_id',
            'lesson_id',
            'editor_id',
        ]);

        if (!empty($request->file('banner'))) {
            $input['banner'] = $this->imageService->upload($this->folder, $request->file('banner'));
        }

        if(empty($input['editor_id'])) {
            $input['editor_id'] = Auth::id();
        }

        $course = Course::create($input);

        Curriculum::create([
            'title' => 'Phần 1',
            'slug' => 'phan-1-' . now(),
            'course_id' => $course->id,
            'status' => Curriculum::ACTIVE,
            'type' => 0,
        ]);

        DB::commit();

        return redirect()->route('admin.courses.index')->with('message', __('Thêm mới thành công'));
    }

    public function edit(Request $request, Course $course)
    {
        $this->authorize('edit', $course);

        return view('admin.courses.edit', [
            'course' => $course,
            'action' => route('admin.courses.update', $course),
        ]);
    }

    public function update(CourseRequest $request, Course $course)
    {
        $this->authorize('edit', $course);

        $input = $request->only([
            'title',
            'slug',
            'description',
            'status',
            'seo_title',
            'seo_description',
            'seo_keywords',
            'subject_id',
            'grade_id',
            'chapter_id',
            'lesson_id',
            'editor_id',
        ]);
        if (!empty($request->file('banner'))) {
            $input['banner'] = $this->imageService->upload($this->folder, $request->file('banner'));
        }

        if(empty($input['editor_id'])) {
            $input['editor_id'] = Auth::id();
        }

        $course->update($input);

        return redirect()->route('admin.courses.index')->with('message', __('Sửa thành công'));
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return back()->with(['message' => __('Course was deleted!')]);
    }

    public function changeStatus(Course $course, Request $request)
    {
        $status = $request->status;

        $course->update(['status' => $status == 'true' ? Course::ACTIVE : Course::DISABLE]);

        return $this->jsonSuccess(['changed' => true]);
    }
}
