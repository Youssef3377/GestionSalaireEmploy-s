@extends('layouts.template')

@section('content')
<h1 class="app-page-title">Modifier un administrteur</h1>
<hr class="mb-4">
<div class="row g-4 settings-section">
    <div class="col-12 col-md-4">
        <h3 class="section-title">Edition</h3>
        <div class="section-intro">Lors de la mise à jour des informations de l'administrteur, merci de vérifier attentivement les identifiants saisis (nom, prénom, adresse e-mail, numéro de contact, etc.). Une erreur pourrait entraîner des problèmes dans le traitement des données ou l’accès aux systèmes.
            Assurez-vous que toutes les informations sont correctes avant de valider.</div>
    </div>
    <div class="col-12 col-md-8">
        <div class="app-card app-card-settings shadow-sm p-4">

            <div class="app-card-body">
                <form class="settings-form" action="{{ route('employer.update', $employer->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Utilise PUT pour la mise à jour -->

                    <!-- Sélection du département -->
                    <div class="col-auto">
                        <label for="departement_id" class="form-label">Département</label>
                        <select class="form-select w-auto" name="departement_id" id="departement_id" class="form-control" required>
                            <option value="">Sélectionner un département</option>
                            @foreach ($departements as $departement)
                                <option value="{{ $departement->id }}" {{ $employer->departement_id == $departement->id ? 'selected' : '' }}>
                                    {{ $departement->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('departement_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Champ Nom -->
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" value="{{ old('nom', $employer->nom) }}" placeholder="Entrez le nom" name="nom" required>
                        @error('nom')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Champ Prénom -->
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" value="{{ old('prenom', $employer->prenom) }}" placeholder="Entrez le prénom" name="prenom" required>
                        @error('prenom')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Champ Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="{{ old('email', $employer->email) }}" placeholder="Entrez le mail" name="email">
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Champ Contact -->
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" value="{{ old('contact', $employer->contact) }}" placeholder="Entrez le contact" name="contact">
                        @error('contact')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Champ Montant Journalier -->
                    <div class="mb-3">
                        <label for="montant_journalier" class="form-label">Montant Journalier</label>
                        <input type="number" class="form-control" id="montant_journalier" value="{{ old('montant_journalier', $employer->montant_journalier) }}" placeholder="Entrez le montant" name="montant_journalier">
                    </div>

                    <!-- Bouton Soumettre -->
                    <button type="submit" class="btn app-btn-primary">Mettre à jour</button>
                </form>
            </div><!--//app-card-body-->

        </div><!--//app-card-->
    </div>
</div><!--//row-->

@endsection
