<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckingAdminLoginPost as AdminLogin;
use App\Models\Admins as AdminModel;

class LoginController extends Controller
{ 
    public function loginView(Request $request)
    {
    	$messi = $request->session()->get('error');
    	// $messages = $_GET['error'] ?? '';
    	return view('admin.login.login_view')->with('error',$messi);
    }

    public function handleLogin(AdminLogin $request, AdminModel $admin)
    {
    	// thuc hien validation form 
    	$username = $request->username;
    	$username = trim(strip_tags($username));

    	$password = $request->password;
    	$password = trim(strip_tags($password));

    	$infoData = $admin->checkAadminLogin($username, $password);
    	if (isset($infoData['id']) && isset($infoData['username'])){
    		// luu thong tin cua nguoi dung vao session
    		$request->session()->put('user',$infoData['username']);
    		// $_SESSION['user'] = $infoData['username'];
    		$request->session()->put('email',$infoData['email']);
    		$request->session()->put('id',$infoData['id']);
    		$request->session()->put('role',$infoData['role']);
    		// $_SESSION['role'] = $infoData['role'];
    		// cho vao trang dashboard admin
    		return redirect()->route('admin.dashboard');
    	} else {
    		// luu loi vao session flash
    		// quay ve lai dung trang login
    		$request->session()->flash('error','Username or password invalid');
    		return redirect()->route('admin.loginView');
    	}
    }

    public function logout(Request $request)
    {
        // xoa session
        $request->session()->forget('user');
        // unset($_SESSION['user']);
        $request->session()->forget('email');
        $request->session()->forget('id');
        $request->session()->forget('role');
        // quay ve lai trang login
        return redirect()->route('admin.loginView');
    }

}
