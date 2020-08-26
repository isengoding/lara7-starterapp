@extends('layouts.master')

@section('content')
<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Data Users</li>
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
                        <div class="d-flex justify-content-between">
                            
                            <a href="{{ route('users.create') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus    "></i>
                                Tambah Data
                            </a>
                            <div class="">
                                {{-- <a href="" class="btn btn-default btn-flat " title="Print">
                                    <i class="fas fa-print    "></i>
                                </a>
                                <a href="" class="btn btn-default btn-flat" title="PDF">
                                    <i class="fas fa-file-pdf    "></i>
                                </a>
                                <a href="" class="btn btn-default btn-flat" title="Excel">
                                    <i class="fas fa-file-excel    "></i>
                                </a> --}}
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <form action="{{ route('users.index') }}" method="GET">
                            {{-- @csrf --}}
                            <div class="input-group input-group mb-3 float-right" style="width: 250px;">
                                <input type="text" name="keyword" class="form-control float-right"
                                placeholder="Search" value="{{request()->query('keyword')}}">
    
                                
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="input-group-append">
                                    <a href="{{ route('users.index') }}" title="Refresh" class="btn btn-default"><i class="fas fa-circle-notch    "></i></a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-head-fixed text-nowrap  table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <td style="width: 20px">#</td>
                                        <th style="width: 50px">No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Role</th>
                                        {{-- <th>#</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $row)
                                    <tr>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn px-1" data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v    "></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('users.edit', $row->id) }}">
                                                            <i class="fas fa-edit    "></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="handleDelete ({{$row->id}})" >
                                                            <i class="fas fa-trash"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{ $loop->iteration + $users->firstItem() - 1 }}
                                        </td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->email}}</td>
                                        <td class="text-center">
                                            @if ($row->status == 1)
                                                <div class="badge badge-success">Aktif</div>
                                            @else 
                                                <div class="badge badge-warning">Non Aktif</div>
                                            @endif
                                        </td>
                                        <td class="text-center"><span class="tag tag-success">{{$row->roles[0]->name}}</span></td>
                                        
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Data Tidak Ada</td>
                                        </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                            {{ $users->appends(['keyword' => request()->query('keyword')])->links() }}
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <span class="text-sm float-right">Total Entries : {{$users->total()}}</span>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>

<!-- Modal Delete-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Hapus Data Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <p class="mt-3">Apakah kamu yakin menghapus Data Users  ?</p>
        </div>
        <div class="modal-footer">
            <form action="" method="POST" id="deleteForm">
                @method('DELETE')
                @csrf
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak, Kembali</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function handleDelete(id){
            let form = document.getElementById('deleteForm')
            form.action = `./users/${id}`
            console.log(form)
            $('#deleteModal').modal('show')
        }  
    </script>

    @if (session()->has('success'))
    <script>
        $(document).ready(function() {
            toastr["success"]('{{ session()->get('success') }}')

        });
    </script>
    @endif

    @if(session()->has('error'))
    <script>
        $(document).ready(function () {
            toastr["info"]('{{ session()->get('error') }}')
        });

    </script>
    @endif

@endsection
