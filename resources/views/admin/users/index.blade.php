<x-admin-layout>
    <div class="container">
        <div class="row  align-items-center justify-content-between">
            <div class="col-11 col-sm-12 page-title">
                <h3> Quản lý người dùng </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Tạo mới</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.users.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên (*) </label>
                                <input name="name" class="form-control" type="text" value="{{old('name')}}">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email (*) </label>
                                <input name="email" class="form-control" type="text" value="{{old('email')}}">
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="role">Quyền (*) </label>
                                <select class="form-control input-selected-2" name="role">
                                    <option
                                        value="{{\App\Models\User::NORMAL_USER}}"
                                        @if(old('role') == \App\Models\User::NORMAL_USER) selected @endif
                                    >
                                        Người dùng
                                    </option>
                                    <option
                                        value="{{\App\Models\User::EDITOR}}"
                                        @if(old('role') == \App\Models\User::EDITOR) selected @endif
                                    >
                                        Cộng tác viên
                                    </option>
                                    <option
                                        value="{{\App\Models\User::ADMIN}}"
                                        @if(old('role') == \App\Models\User::ADMIN) selected @endif
                                    >
                                        Quản trị viên
                                    </option>
                                </select>
                                @error('role')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu (*)</label>
                                <input name="password" class="form-control" type="password" value="{{old('password')}}">
                                @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Xác nhận mật khẩu (*)</label>
                                <input name="password_confirmation" class="form-control" type="password"
                                    value="{{old('password_confirmation')}}">
                                @error('password_confirmation')
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
                                    <th class="sortable" data-sortby="title">{{ __('Tên') }}</th>
                                    <th class="sortable" data-sortby="status">{{ __('Email') }}</th>
                                    <th class="sortable" data-sortby="status">{{ __('Quyền') }}</th>
                                    <th class="sortable" data-sortby="status">{{ __('Trạng thái') }}</th>
                                    <th> {{__('Hành động')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ App\Models\User::ROLE_TEXT[$user->role] }}</td>
                                    <td>
                                        <form action="{{route('admin.users.change-status', $user)}}" method="POST">
                                            @csrf
                                            @method('patch')
                                            <button class="btn btn-link">
                                                @if($user->status == \App\Models\User::DISABLE)
                                                    <i class="fa fa-toggle-off"></i>
                                                @elseif($user->status == \App\Models\User::ENABLE)
                                                    <i class="fa fa-toggle-on"></i>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        @can('edit', $user)
                                            <a class="btn btn-link" href="{{route('admin.users.edit', $user->id)}}"><i class="fa fa-edit"></i></a>
                                        @endcan
                                        @can('delete', $user)
                                            <form action="{{route('admin.users.destroy', $user->id)}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-link before-delete"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endcan
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