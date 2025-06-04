<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <h4 class="fw-semibold mb-0">Formulari Joc</h4>
                    </div>
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $joc->nom ?? '') }}">
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="genere" class="form-label">Gènere</label>
                        <input type="text" name="genere" class="form-control @error('genere') is-invalid @enderror" value="{{ old('genere', $joc->genere ?? '') }}">
                        @error('genere')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="any_llancament" class="form-label">Any llançament</label>
                        <input type="number" name="any_llancament" class="form-control @error('any_llancament') is-invalid @enderror" value="{{ old('any_llancament', $joc->any_llancament ?? '') }}">
                        @error('any_llancament')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="desenvolupador" class="form-label">Desenvolupador</label>
                        <input type="text" name="desenvolupador" class="form-control @error('desenvolupador') is-invalid @enderror" value="{{ old('desenvolupador', $joc->desenvolupador ?? '') }}">
                        @error('desenvolupador')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcio" class="form-label">Descripció</label>
                        <textarea name="descripcio" class="form-control @error('descripcio') is-invalid @enderror" rows="3">{{ old('descripcio', $joc->descripcio ?? '') }}</textarea>
                        @error('descripcio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
