<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function check( Request $request )
    {
        $request->validate( [
            'email'    => 'required|email|exists:admins,email',
            'password' => 'required|min:5|max:30',
        ], [
            'email.exists' => 'The email not found on the system',
        ] );

        $creds = $request->only( 'email', 'password' );
        if ( Auth::guard( 'admin' )->attempt( $creds, $request->has( 'remember' ) ) )
        {
            return redirect()->route( 'admin.index' )->with( 'success', 'Admin is logged on.' );
        }
        else
        {
            return redirect()->back()->with( 'fail', 'Failed to login.' );
        }
    }

    public function changepassword( Request $request )
    {
        $request->validate( [
            'password'       => 'required',
            'new_password'   => 'required|min:5|max:30',
            'renew_password' => 'required|min:5|max:30|same:new_password',
        ] );

        $admin = Admin::where( 'id', Auth::guard( 'admin' )->user()->id )->first();
        if ( !Hash::check( $request->password, $admin->password ) )
        {
            return redirect()->back()->with( 'fail', 'รหัสผ่านปัจจุบันไม่ถูกต้อง' );
        }

        $admin->password = Hash::make( $request->new_password );
        $admin->save();

        return redirect()->back()->with( 'success', 'เปลี่ยนรหัสผ่านเสร็จสิ้น' );

    }

    public function logout()
    {
        Auth::guard( 'admin' )->logout();

        return redirect()->route( 'admin.login' );
    }
}