<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->orderBy('level','ASC')->paginate(10);
        return view('admin.dashboard', compact('users'));
    }
}
