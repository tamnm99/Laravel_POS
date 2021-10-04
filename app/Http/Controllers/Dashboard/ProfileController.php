<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with('roles', 'permissions')->where('email', Auth::user()->email)->first();
        return view('dashboard.profile.edit_profile')->with(compact('user', $user));
    }

    public function updateProfile(Request $request, $userId)
    {
        $request->validate([
            'full_name' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'avatar' => 'mimes:jpg,png'
        ], [
            'full_name.required' => 'Họ và Tên không được để trống',
            'birthday.required' => 'Ngày Sinh không được để trống',
            'address.required' => 'Địa Chỉ không được để trống',
            'avatar.mimes' => 'Ảnh avatar phải là loại .jpg hoặc .png'
        ]);

        $user = User::with('roles', 'permissions')->find($userId);
        $path = $this->_upload($request);
        if ($path) {
            $avatar = $path;
        }
        if ($user) {
            $user->full_name = $request->full_name;
            $user->birthday = date('Y-m-d', strtotime($request->birthday));
            $user->address = $request->address;
            if ($path != null) {
                Storage::delete($user->avatar);
                $user->avatar = $avatar;
            }
            $user->save();
            return redirect()->back()->with('success', ('Cập nhật thông tin thành công'));
        } else {
            return redirect()->back()->with('error', ('Không tìm thấy thông tin về Người Dùng này'));
        }
    }

    public function changePassword(Request $request, $userId)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'retype_new_password' => 'required|same:new_password',

        ], [
            'old_password.required' => 'Mật Khẩu Cũ không được để trống',
            'new_password.required' => 'Mật Khẩu Mới không được để trống',
            'new_password.min' => 'Mật Khẩu Mới phải chứa ít nhất 6 ký tự',
            'retype_new_password.required' => 'Nhập lại mật khẩu mới không được để trống',
            'retype_new_password.same' => 'Nhập lại mật khẩu mới không khớp với dữ liệu Mật Khẩu mới',
        ]);

        $user = User::find($userId);
        if ($user) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                return redirect()->back()->with('success', ('Thay đổi mật khẩu thành công'));
            } else {
                return redirect()->back()->with('error', ('Mật khẩu cũ không đúng'));
            }
        }else{
            return redirect()->back()->with('error', ('Không Tìm Thấy Người Dùng này'));
        }
    }

    private function _upload($request)
    {
        if ($request->hasFile('avatar')) {
            $photo = $request->file('avatar');
            $path = $photo->storeAs('uploads/profile', $photo->getClientOriginalName());
            return $path;
        }
        return false;

    }
}
