<x-admin-layout>
    <div class="container">

        <div class="row">
            <div class="col-sm-16">
                <form action="{{route('admin.lessons.update', $lesson)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="m-0">Sửa Bài học</h5>
                            <hr>
                            <div class="row justify-content-center">
                                <div class="col-md-10 ">
                                    <div class="form-group row">
                                        <div class="col-lg-8 col-md-8">
                                            <label for="title">Tên</label>
                                            <input id="title" type="text" class="form-control" placeholder=""
                                                   value="{{$lesson->title}}" name="title">
                                            @error('title')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <label for="banner">Ảnh đại diện</label>
                                            <input type="file" class="form-control" name="banner">
                                            @error('banner')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-8 col-md-8">
                                            <label for="status">Trạng thái</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="{{\App\Models\Grade::DISABLE}}"
                                                    @if($lesson->status == \App\Models\Grade::DISABLE) selected @endif
                                                >Ẩn</option>
                                                <option value="{{\App\Models\Grade::ENABLE}}"
                                                    @if($lesson->status == \App\Models\Grade::ENABLE) selected @endif
                                                >Hiện</option>
                                            </select>
                                            @error('status')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <label for="chapter_id">Chương</label>
                                            {{ Form::select('chapter_id', [$lesson->chapter->id => $lesson->chapter->title], $lesson->chapter->id , [
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
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-8 col-md-8">
                                            <label for="seo_title">Seo title</label>
                                            <input id="seo_title" type="text" class="form-control" placeholder=""
                                                   value="{{$lesson->seo_title}}" name="seo_title">
                                            @error('seo_title')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <label for="seo_keywords">Seo Keyword</label>
                                            <input id="seo_keywords" type="text" class="form-control" placeholder=""
                                                   value="{{$lesson->seo_keywords}}" name="seo_keywords">
                                            @error('seo_keywords')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-16 col-md-16">
                                            <label for="seo_description">Seo description</label>
                                            <textarea class="form-control" placeholder="Type here" rows="4"
                                                      name="seo_description"
                                                      id="seo_description">{{$lesson->seo_description}}</textarea>
                                            @error('seo_description')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('admin.lessons.index')}}" class="btn btn-secondary">Cancel</a>
                            <button class="btn btn-success pull-right" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
