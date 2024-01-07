@extends('layouts.app')

@section('content')
    <h2>Edit Dosen</h2>

    <form method="POST" action="{{ route('dosen.update', $dosen->id) }}">
        @csrf
        @method('PUT')

        <label for="nama">Nama:</label>
        <input type="text" name="nama" value="{{ $dosen->nama }}" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ $dosen->email }}" required>

        <!-- tambahkan input untuk kolom-kolom lain yang perlu diupdate -->

        <button type="submit">Simpan Perubahan</button>
    </form>
@endsection
