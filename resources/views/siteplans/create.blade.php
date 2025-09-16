@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Tambah Siteplan Baru</h2>
                <a class="btn btn-primary" href="{{ route('siteplans.index') }}"> Kembali</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('siteplans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('siteplans._form', ['siteplan' => new \App\Models\Siteplan()])

        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection
