@extends('layouts.master')

@section('content')
<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Roles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                        <li class="breadcrumb-item active">Edit Roles</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class=" d-flex align-items-center justify-content-between">
                            <a href="{{ route('roles.index')}}" class="btn">
                                <i class="fas fa-arrow-left  text-purple  "></i>
                            </a>
                            <span>Form Edit Role</span>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <form method="POST" action="{{ route('roles.update', $role->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="role">Role role</label>
                                        <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" role="role" id="role" value="{{ $role->name }}"  placeholder="Masukkan Nama Role" autofocus>
                                        @error('role')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="">Permission</label><br>
                                        <div class="form-check">
                                            @foreach ($permissions as $item)
                                                
                                                <input class="form-check-input" type="checkbox" 
                                                    name="permissions[]" 
                                                    value="{{$item->name}}" 
                                                    id="{{$item->id}}"
                                                    @foreach ($role->permissions as $perm)
                                                        {{ ($perm->name == $item->name) ? 'checked' : '' }}
                                                    @endforeach 
                                                >
                                                <label class="form-check-label" for="{{$item->id}}">{{ $item->name }}</label><br>
                                                    
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div class="form-group d-flex justify-content-end">
                                        <a class="btn btn-default " href="{{ route('roles.index') }}">Batal</a>
                                        <button type="submit" class="btn btn-primary ml-2">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    {{-- <div class="card-footer clearfix">
                        tes
                    </div> --}}
                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
@endsection
