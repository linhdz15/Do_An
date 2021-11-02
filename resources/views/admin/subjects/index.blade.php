<x-admin-layout>
    <div class="container">
        <div class="row  align-items-center justify-content-between">
            <div class="col-11 col-sm-12 page-title">
                <h3>Quản lý môn học</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Tạo mới</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.subjects.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Tên</label>
                                <input name="title" class="form-control" type="text" value="{{old('title')}}">
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="banner">Ảnh banner</label>
                                <input name="banner" class="form-control" type="file" accept=".pdf,.jpeg,.jpg,.png">
                                @error('banner')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Trạng thái</label>
                                <select class="form-control" name="status">
                                    <option value="{{\App\Models\Subject::DISABLE}}">Ẩn</option>
                                    <option value="{{\App\Models\Subject::ENABLE}}">Hiện</option>
                                </select>
                                @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="seo_title">Seo title</label>
                                <input name="seo_title" class="form-control" type="text" value="{{old('seo_title')}}">
                                @error('seo_title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="seo_keywords">Seo keyword</label>
                                <input name="seo_keywords" class="form-control" type="text"
                                       value="{{old('seo_keywords')}}">
                                @error('seo_keywords')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="seo_description">Seo description</label>
                                <textarea name="seo_description" id="seo_description"
                                          class="form-control">{{old('seo_description')}}</textarea>
                                @error('seo_description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit"> Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-11">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Danh sách</h6>
                    </div>
                    <div class="card-body">
                        @include('layouts.partials.notices')
                        <table class="table table-hover" id="table-classes">
                            <thead>
                            <tr>
                                <th class="sortable" data-sortby="id">{{ __('ID') }}</th>
                                <th class="sortable" data-sortby="title">{{ __('Tên môn học') }}</th>
                                <th class="sortable" data-sortby="title">{{ __('Trạng thái') }}</th>
                                <th> {{__('Hành động')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td>{{$subject->id}}</td>
                                    <td>{{$subject->title}}</td>
                                    <td>
                                        <form action="{{route('admin.subjects.change-status', $subject)}}"
                                              method="POST">
                                            @csrf
                                            @method('patch')
                                            <button class="btn btn-link">
                                                @if($subject->status == \App\Models\Subject::DISABLE)
                                                    <i class="fa fa-toggle-off"></i>
                                                @elseif($subject->status == \App\Models\Subject::ENABLE)
                                                    <i class="fa fa-toggle-on"></i>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{route('admin.subjects.destroy', $subject->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-link"
                                               href="{{route('admin.subjects.edit', $subject->id)}}"><i
                                                    class="fa fa-edit"></i></a>
                                            <button class="btn btn-link before-delete"><i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
