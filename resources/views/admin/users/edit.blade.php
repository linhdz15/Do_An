<x-admin-layout>
    <div class="container">
        <div class="row">
            <div class="col-sm-16">
                <form action="{{route('admin.users.update', $user)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="m-0">Sửa lớp</h5>
                            <hr>
                            <div class="row justify-content-center">
                                <div class="col-md-10 ">
                                    <div class="form-group row">
                                        <div class="col-lg-8 col-md-8">
                                            <label for="name">Tên</label>
                                            <input id="name" type="text" class="form-control" placeholder=""
                                                   value="{{$user->name}}" name="name">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <label for="email">Email</label>
                                            <input id="email" type="text" class="form-control text-dark" placeholder=""
                                                value="{{$user->email}}" disabled>
                                            @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-8 col-md-8">
                                            <label for="status">Trạng thái</label>
                                            <select class="form-control input-selected-2" name="status" id="status">
                                                <option value="{{\App\Models\Grade::DISABLE}}"
                                                    @if($user->status == \App\Models\Grade::DISABLE) selected @endif
                                                >Chặn</option>
                                                <option value="{{\App\Models\Grade::ENABLE}}"
                                                    @if($user->status == \App\Models\Grade::ENABLE) selected @endif
                                                >Hoạt động</option>
                                            </select>
                                            @error('status')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <label for="type">Quyền</label>
                                            <select class="form-control input-selected-2" name="role">
                                                <option
                                                    value="{{\App\Models\User::NORMAL_USER}}"
                                                    @if($user->role == \App\Models\User::NORMAL_USER) selected @endif
                                                >
                                                    Người dùng
                                                </option>
                                                <option
                                                    value="{{\App\Models\User::EDITOR}}"
                                                    @if($user->role == \App\Models\User::EDITOR) selected @endif
                                                >
                                                    Cộng tác viên
                                                </option>
                                                <option
                                                    value="{{\App\Models\User::ADMIN}}"
                                                    @if($user->role == \App\Models\User::ADMIN) selected @endif
                                                >
                                                    Quản trị viên
                                                </option>
                                            </select>
                                            @error('role')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('admin.users.index')}}" class="btn btn-secondary">Hủy</a>
                            <button class="btn btn-success pull-right" type="submit">Gửi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
