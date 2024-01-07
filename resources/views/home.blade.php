@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.sidebar')

        <div class="col-md-9">
            <div class="jumbotron">
                <h2><strong>STMIK-MI</strong></h2> 
                @if (Auth::user()->isDosen())
                    <p>Silahkan klik tombol di bawah untuk untuk akses & upload modul-modul pembelajaran ke dalam repository e-module.</p> 
                @elseif (Auth::user()->isMhs())
                    <p>Silahkan klik tombol di bawah ini atau melalui menu navigasi untuk mengakses modul-modul pembelajaran yang diupload oleh Dosen.</p> 
                @endif
                <p>
                  
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
