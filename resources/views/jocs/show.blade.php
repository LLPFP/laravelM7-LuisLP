@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h1 class="h3 mb-4 text-center fw-bold text-primary">{{ $joc->nom }}</h1>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2">
                            <span class="fw-semibold text-secondary">Gènere:</span>
                            <span class="ms-2">{{ $joc->genere }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold text-secondary">Any de llançament:</span>
                            <span class="ms-2">{{ $joc->any_llancament }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold text-secondary">Desenvolupador:</span>
                            <span class="ms-2">{{ $joc->desenvolupador }}</span>
                        </li>
                        <li>
                            <span class="fw-semibold text-secondary">Descripció:</span>
                            <span class="ms-2">{{ $joc->descripcio }}</span>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('jocs.index') }}" class="btn btn-outline-primary">Tornar al llistat</a>
                        <a href="{{ route('jocs.edit', $joc) }}" class="btn btn-outline-warning">Editar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
