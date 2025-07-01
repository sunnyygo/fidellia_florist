<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::orderByRaw("FIELD(role, 'admin', 'user')")->get();
        return view('admin.crud-member', [
            'title' => 'Daftar Member',
            'users' => $users
        ]);

        
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required',
            'address' => 'required|string',
        ]);

        User::create([
            'member_name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'address' => $request->alamat,
        ]);

        session()->flash('success', 'Member has been added');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

    session()->flash('success', 'Role has been updated');
    return redirect()->back();
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('success', 'Member has been removed');
        return redirect()->back();
    }
}
