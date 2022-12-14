<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\MeanUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(12);
        return view('user.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('register_users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        $user->save();
        return redirect()->route('panel_admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $mean
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $means = MeanUser::latest()->paginate(6);    

        return view('info' , ['means' => $means]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, User $user)
    {
        $language = Language::all(); 
        $user = User::find($id);
        return view('user.edit_users', ['user' =>$user, 'language' => $language]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id, User $users)
    {
        $means = MeanUser::all();
        $language = Language::all();
        
        $request->validate([
            'name',
            'email',
            'avatar',
        ]);
        $path = $request->file('avatar')->storeAs('avatar', $request->file('avatar')->getClientOriginalName());
        $users = User::find($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->avatar = $path;

        $users->update();
        return view('info',  ['means' => $means, 'language' => $language]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $mean
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('user.users');
    }
}
