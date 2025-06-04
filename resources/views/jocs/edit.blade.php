@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edita joc</h1>
    <form action="{{ route('jocs.update', $joc) }}" method="POST">
        @csrf
        @method('PUT')
        @include('jocs.form')
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn btn-primary">Actualitza</button>
        </div>
    </form>
</div>

@endsection
