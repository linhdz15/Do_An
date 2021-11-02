<x-admin-layout>
    <div class="container">
        <div class="row  align-items-center justify-content-between">
            <div class="col-11 col-sm-12 page-title">
                <h3>Quản lý bài học</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Tạo mới</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.lessons.store')}}" method="POST" enctype="multipart/form-data">
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
                                    <option value="{{\App\Models\Lesson::DISABLE}}">Ẩn</option>
                                    <option value="{{\App\Models\Lesson::ENABLE}}">Hiện</option>
                                </select>
                                @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="type">Chương</label>
                                {{ Form::select('chapter_id', [], null, [
                                        'class' => 'form-control input-selected-2',
                                        'id' => 'chapter_id',
                                        'data-placeholder' => 'Chọn chương',
                                        'required' => true,
                                        'data-ajax-url' => route('suggest.chapters'),
                                    ])
                                }}
                                @error('chapter_id')
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
                                <th class="sortable" data-sortby="id">{{ __('Id') }}</th>
                                <th class="sortable" data-sortby="title">{{ __('Tên') }}</th>
                                <th> {{__('Hành động')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lessons as $lesson)
                                <tr>
                                    <td>{{$lesson->id}}</td>
                                    <td>{{$lesson->title}}</td>
                                    <td>
                                        <form action="{{route('admin.lessons.destroy', $lesson->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-link" href="{{route('admin.lessons.edit', $lesson->id)}}"><i class="fa fa-edit"></i></a>
                                            <button class="btn btn-link before-delete"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$lessons->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
