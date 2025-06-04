@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0 fw-bold">Llistat de jocs</h1>
            <a href="{{ route('jocs.create') }}" class="btn btn-primary shadow-sm">Afegir joc</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Gènere</th>
                        <th>Any llançament</th>
                        <th>Desenvolupador</th>
                        <th class="text-end">Accions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jocs as $joc)
                        <tr>
                            <td class="fw-semibold">{{ $joc->nom }}</td>
                            <td>{{ $joc->genere }}</td>
                            <td>{{ $joc->any_llancament }}</td>
                            <td>{{ $joc->desenvolupador }}</td>
                            <td class="text-end">
                                <a href="{{ route('jocs.show', $joc) }}" class="btn btn-outline-info btn-sm me-1" title="Veure">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('jocs.edit', $joc) }}" class="btn btn-outline-warning btn-sm me-1" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('jocs.destroy', $joc) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" title="Eliminar" onclick="return confirm('Segur que vols eliminar aquest joc?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
