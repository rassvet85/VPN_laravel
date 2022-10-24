<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmartAdmin extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($folderName, $fileName)
    {
        // Render perticular view file by foldername and filename
        if (\View::exists($folderName . "." . $fileName)) {
            return view($folderName . "." . $fileName);
        } else {
            abort(404);
        }
    }

    public function root()
    {
        // Render perticular view file by foldername and filename
        return view('dashboard/index');
    }

    public function welcome($fileName)
    {
        if (\View::exists($fileName)) {
            return view($fileName);
        } else {
            abort(404);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
