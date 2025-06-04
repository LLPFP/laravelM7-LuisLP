@extends('layouts.app')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h2 class="card-title mb-4 text-center fw-semibold">Nou joc</h2>
                    <form action="{{ route('jocs.store', [], true) }}" method="POST" autocomplete="off">
                        @csrf
                        @include('jocs.form')
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Desa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
