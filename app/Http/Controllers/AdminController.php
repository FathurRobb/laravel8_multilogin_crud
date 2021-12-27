<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::select("*")->orderBy("level","asc")->paginate(5);
        return view('admin.dashboard', compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('admin.users_create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'username'  => 'required',
            'level'     => 'required',
            'email'     => 'required',
            'password'  => 'required',
            'image'     => 'required|image|mimes:png,jpg,jpeg'
        ]);
        //upload image
        $image = $request->file('image');
        $image->storeAs('public/pp',$image->hashName());

        $user = User::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'level'     => $request->level,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'image'     => $image->hashName()
        ]);

        if ($user) {
            return redirect()->route('admin.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else {
            return redirect()->route('admin.index')->with(['error' => 'Data Gagal Disimpan!']);
        }

        // $this->validate($request, [
        //     'name'      => 'required',
        //     'username'  => 'required',
        //     'level'     => 'required',
        //     'email'     => 'required',
        //     'password'  => 'required',
        //     'image'     => 'required|image|mimes:png,jpg,jpeg'
        // ]);

        // $input_image = $request->image;

        // if ($image = $request->file('image')) {
        //     $destinationPath = 'pp/';
        //     $profileImage = date('YmdHis').".".$image->getClientOriginalExtension();
        //     $image->move($destinationPath, $profileImage);
        //     $input_image = "$profileImage";
        // }

        // $user = User::create([
        //     'name'      => $request->name,
        //     'username'  => $request->username,
        //     'level'     => $request->level,
        //     'email'     => $request->email,
        //     'password'  => Hash::make($request->password),
        //     'image'     => $input_image
        // ]);

        // return redirect()->route('admin.index')->with('success','User baru berhasil dibuat');
    }

    public function show(User $user)
    {
        return view('admin.users_show', compact('user'));
    }

    public function edit(User $admin)
    {
        // dd("balbdlba");
        return view('admin.users_edit', ['user' => $admin]);
    }

    // public function update(Request $request, User $user)
    // {
    //     $this->validate($request, [
    //         'username'  => 'required',
    //         'name'      => 'required',
    //         'level'     => 'required',
    //         'email'     => 'required',
    //         'password'  => 'required'
    //     ]);

    //     $input_image = $request->image;
        
    //     if ($image = $request->file('image')) {
    //         $destinationPath = 'pp/';
    //         $profileImage = date('YmdHis').".".$image->getClientOriginalExtension();
    //         $image->move($destinationPath, $profileImage);
    //         $input_image = "$profileImage";
    //     } else {
    //         unset($input_image);
    //     }

    //     $user = User::update([
    //         'name'      => $request->name,
    //         'username'  => $request->username,
    //         'level'     => $request->level,
    //         'email'     => $request->email,
    //         'password'  => Hash::make($request->password),
    //         'image'     => $input_image
    //     ]);
    //     dd("balala");
    //     return redirect()->route('admin.index')->with('success','User berhasil diupdate');
    // }

    // public function destroy(User $user)
    // {
    //     $user->delete();
    //     return redirect()->route('admin.index')->with('success','User berhasil dihapus');
    // }


    public function update(Request $request, User $admin)
    {
        $this->validate($request, [
            'name'      => 'required',
            'username'  => 'required',
            'level'     => 'required',
            'email'     => 'required'
        ]);
        
        $admin = User::findOrFail($admin->id);

        if ($request->file('image') == "") {
            $admin->update([
                'name'      => $request->name,
                'username'  => $request->username,
                'level'     => $request->level,
                'email'     => $request->email
            ]);
        }else {
            //hapus old image
            Storage::disk('local')->delete('public/pp/'.$admin->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/pp', $image->hashName());

            $admin->update([
                'name'      => $request->name,
                'username'  => $request->username,
                'level'     => $request->level,
                'email'     => $request->email,
                'image'     => $image->hashName()
            ]);
        }

        if ($admin) {
            return redirect()->route("admin.index")->with(['success' => 'Data Berhasil Diupdate!']);
        }else {
            return redirect()->route("admin.index")->with(['error' => 'Data Berhasil Diupdate!']);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Storage::disk('local')->delete('public/pp/'.$user->image);
        $user->delete();

        if($user){
            //redirect dengan pesan sukses
            return redirect()->route('admin.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
}
