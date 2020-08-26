@extends('layouts.master')

@section('content')
<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
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
                        <div class="card-title">
                            <span class="float-right">
                                Settings Aplikasi
                            </span>
                            {{-- <a href="{{ route('users.index')}}" class="btn btn-info btn-sm">Kembali</a> --}}
                        </div>
                        <div class="card-tools">
                            
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('setting.update', 1) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="app_name">Nama Aplikasi</label>
                                                <input type="text" class="form-control @error('app_name') is-invalid @enderror" name="app_name" id="app_name" value="{{ $setting->app_name }}"  placeholder="Masukkan Nama kategori" autofocus>
                                                @error('app_name')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
        
                                            <div class="form-group">
                                                <label for="footer_left">Footer Kiri</label>
                                                <input type="text" class="form-control @error('footer_left') is-invalid @enderror" name="footer_left" id="footer_left" value="{{ $setting->footer_left }}"  placeholder="Masukkan Nama kategori" autofocus>
                                                @error('footer_left')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
        
                                            <div class="form-group">
                                                <label for="footer_right">Footer Kanan</label>
                                                <input type="text" class="form-control @error('footer_right') is-invalid @enderror" name="footer_right" id="footer_right" value="{{ $setting->footer_right }}"  placeholder="Masukkan Nama kategori" autofocus>
                                                @error('footer_right')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- /.col-md -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="logo">Logo</label>
                                                <input type="file" class="form-control logo @error('logo') is-invalid @enderror" name="logo" id="logo" value="{{ old('logo') }}"  data-height="100" data-width="160" data-default-file="{{ asset('/img/'.$setting->logo) }}">
                                                @error('logo')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
        
                                            <div class="form-group">
                                                <label for="favicon">favicon</label>
                                                <input type="file" class="form-control favicon @error('favicon') is-invalid @enderror" name="favicon" id="favicon" value="{{ old('favicon') }}"  data-height="100" data-width="160" data-default-file="{{ asset('/img/'.$setting->favicon) }}">
                                                @error('favicon')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- /.col-md -->
                                    </div>
                                    <!-- /.row -->
                                    

                                    

                                    <hr>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-right">
                                            Submit
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

@section('scripts')
<script>

    $(document).ready(function() {
        $('.dropify').dropify();
        $('.logo').dropify();
        $('.favicon').dropify();
    });

</script>
@if(session()->has('success'))
    <script>
        $(document).ready(function () {
            toastr["success"]('{{ session()->get('success') }}')
        });

    </script>
@endif
@endsection
