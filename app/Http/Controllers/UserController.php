<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(Request $request)
    {
        
        $showDeleted = $request->show_deleted ?? false;

        $usersPaginator = User::with('roles')->when($showDeleted,function ($query){
            $query->withTrashed();
        })->paginate(20);


        return view('User.index', ['usersPaginator' => $usersPaginator,'showDeleted' => $showDeleted]);
    }


    //Show Create User Page
    public function create()
    {
        return view('User.create');
    }

    public function store(CreateUserRequest $request)
    {
        $user = User::create($request->validated());
        event(new Registered($user));
        // Auth::login($user);
        return redirect(route('users.index'))->with('success', 'User Created Successfully');
    }

    public function edit(User $user)
    {
        return view('User.edit',['user' =>$user]);
    }

    public function update(EditUserRequest $request,User $user)
    {   
        $user->update($request->validated());
        return redirect(route('users.index'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User Deleted');
    }
}
