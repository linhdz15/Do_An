<x-admin-layout>
    <div class="container">
        <div class="row  align-items-center justify-content-between">
            <div class="col-11 col-sm-12 page-title">
                <h3>Quản lý chương</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Tạo mới</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.chapters.store')}}" method="POST" enctype="multipart/form-data">
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
                                    <option value="{{\App\Models\Grade::DISABLE}}">Ẩn</option>
                                    <option value="{{\App\Models\Grade::ENABLE}}">Hiện</option>
                                </select>
                                @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="grade_id">Lớp</label>
                                {{ Form::select('grade_id', [], null, [
                                        'class' => 'form-control input-selected-2',
                                        'id' => 'grade_id',
                                        'data-placeholder' => 'Chọn lớp',
                                        'required' => true,
                                        'data-ajax-url' => route('suggest.grades'),
                                    ])
                                }}
                                @error('grade_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="subject_id">Môn học</label>
                                {{ Form::select('subject_id', [], null, [
                                    'class' => 'form-control input-selected-2',
                                    'id' => 'subject_id',
                                    'data-placeholder' => 'Chọn môn',
                                    'required' => true,
                                    'data-ajax-url' => route('suggest.subjects'),
                                    ])
                                }}
                                @error('subject_id')
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
                                <textarea name="seo_description"
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
                        <table class="table table-hover" id="table-classes">
                            <thead>
                            <tr>
                                <th class="sortable" data-sortby="id">{{ __('ID') }}</th>
                                <th class="sortable" data-sortby="title">{{ __('Tên chương') }}</th>
                                <th> {{__('Môn học')}}</th>
                                <th> {{__('Lớp')}}</th>
                                <th> {{__('Hành động')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($chapters as $chapter)
                                <tr>
                                    <td>{{$chapter->id}}</td>
                                    <td>{{$chapter->title}}</td>
                                    <td>{{$chapter->subject->title}}</td>
                                    <td>{{$chapter->grade->title}}</td>
                                    <td>
                                        <form action="{{route('admin.chapters.destroy', $chapter->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-link" href="{{route('admin.chapters.edit', $chapter->id)}}"><i class="fa fa-edit"></i></a>
                                            <button class="btn btn-link before-delete"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$chapters->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
