@extends('layouts.main',['activePage'=>'users','titlePage'=>'Usuarios'])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Usuarios</h4>
                                <p card-category>Usuario registrados</p>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                <div class="alert alert-success" role="success">
                                    {{session('success')}}
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-12 text-right">
                                        @can('user_create')
                                        <a href="{{route('users.create')}}" class="btn btn-sm btn-facebook">Añadir usuario</a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="table-resposive">
                                    <table class="table">
                                        <thead class="text-primary">
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Username</th>
                                            <th>Roles</th>
                                            <th class="text-right">Acciones</th>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>{{$user->id}} </td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->username}}</td>
                                            <td>
                                                @forelse ($user->roles as $role)
                                                    <span class="badge badge-info">{{ $role->name }}</span>
                                                @empty
                                                    <span class="badge badge-danger">No roles</span> 
                                                @endforelse
                                            </td>
                                            <td class="td-actions text-right">
                                                @can('user_show')
                                                <a href="{{route('users.show',$user)}} " class="btn btn-info"><i class="material-icons">person</i></a>
                                                @endcan
                                                @can('user_edit')
                                                <a href="{{route('users.edit',$user)}} " class="btn btn-warning"><i class="material-icons">edit</i></a>
                                                @endcan
                                                @can('user_destroy')
                                                <form action="{{route('users.destroy',$user->id)}}" method="POST" style="display: inline-block" onsubmit="return confirm('estas seguro?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit" rel="tooltip">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </form>                                             
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer mr-auto">
                                {{$users->links()}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
