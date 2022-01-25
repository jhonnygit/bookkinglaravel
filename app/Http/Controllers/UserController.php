<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('user_index'),403);
        $users=User::paginate(5);
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('user_create'),403);
        $roles=Role::all()->pluck('name','id');
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        //
        //$request->validate([
        //    'name'=>'required|min:3|max:10',
        //    'username'=>'required',
        //    'email'=>'required|email|unique:users',
        //    'password'=>'required'
        //]);
        $user=User::create($request->only('name','username','email')
                    +[
                        'password' => bcrypt($request->input('password')),
                    ]);
        $roles=$request->input('roles',[]);
        $user->syncRoles($roles);
        return redirect()->route('users.show',$user->id)->with('success','Usuareio creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        abort_if(Gate::denies('user_show'),403);
        $user->load('roles');        
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        abort_if(Gate::denies('user_edit'),403);
        $roles=Role::all()->pluck('name','id');
        $user->load('roles');
        return view('users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request,User $user)
    {
        //
        $data = $request->only('name', 'username', 'email');
        $password=$request->input('password');
        if($password)
            $data['password'] = bcrypt($password);   
        $user->update($data);
        
        $roles = $request->input('roles', []);
        $user->syncRoles($roles);  
        return redirect()->route('users.show', $user->id)->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_destroy'),403);
        //para que no elimine al mismo usuario que esta logueado
        if (auth()->user()->id == $user->id) {
            return redirect()->route('users.index');
        }

        $user->delete();
        $user->delete();
        return back()->with('success','Usuario eliminado Correptamente');
    }
}
