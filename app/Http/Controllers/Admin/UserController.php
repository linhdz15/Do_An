<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\Admin\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function index()
    {
        $this->authorize('view', User::class);

        $users = User::where('deleted_at', null)
            ->get();

        return view ('admin.users.index', [
            'users' => $users
        ]);
    }

    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);

        $inputs = $request->only([
            'name',
            'email',
            'role',
            'password',
        ]);

        $inputs['password'] = Hash::make($inputs['password']);
        $inputs['status'] = User::ENABLE;
        $inputs['email_verified_at'] = now();

        User::create($inputs);

        return redirect()->route('admin.users.index')->with('message', 'Tạo người dùng mới thành công');
    }

    public function edit(User $user)
    {
        $this->authorize('edit', $user);

        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    public function update(User $user, UserRequest $request)
    {
        $inputs = $request->only([
            'name',
            'status',
            'role',
        ]);

        $user->update($inputs);

        return redirect()->route('admin.users.index')->with('message', 'Chỉnh sửa người dùng thành công');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index')->with('message', 'Xóa người dùng thành công');
    }

    public function changeStatus(User $user)
    {
        $this->authorize('edit', $user);

        if ($user->status == User::DISABLE) {
            $user->update(['status' => User::ENABLE]);

            return redirect()->back()->with('message', 'Đã active ' . $user->email);
        } else if ($user->status == User::ENABLE) {
            $user->update(['status' => User::DISABLE]);

            return redirect()->back()->with('message', 'Đã ẩn ' . $user->email);
        } else {
            return redirect()->back()->with('error', 'Có lỗi khi thay đổi trạng thái, vui lòng thử lại');
        }
    }
}
