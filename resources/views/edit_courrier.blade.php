@extends('layouts.custom')
@section('title', 'Modifier le courrier - GEC')

@section('content')

<div class="flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-5xl bg-white p-6 rounded-xl shadow">

        <h2 class="text-2xl font-semibold text-gray-700 mb-2 text-center">
            Modifier le courrier : <span class="text-blue-600">{{ $courrier->reference }}</span>
        </h2>

        <form method="POST" action="{{ route('courrier.update', $courrier->id_courrier) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600 font-bold">Type de courrier</label>
                    <select name="type" id="type" class="w-full border rounded-lg px-3 py-2 bg-gray-50">
                        <option value="arrivee" {{ $courrier->type == 'arrivee' ? 'selected' : '' }}>📥 Courrier Arrivée</option>
                        <option value="depart" {{ $courrier->type == 'depart' ? 'selected' : '' }}>📤 Courrier Départ</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-600 font-bold">Référence</label>
                    <input type="text" name="reference" value="{{ $courrier->reference }}" class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-sm text-gray-600 font-bold">Date</label>
                    <input type="date" name="date" value="{{ $courrier->date }}" class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600 font-bold">Objet</label>
                    <input type="text" name="objet" value="{{ $courrier->objet }}" class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-sm text-gray-600 font-bold">Statut</label>
                    <select name="statut" class="w-full border rounded-lg px-3 py-2">
                        <option value="En cours" {{ $courrier->statut == 'En cours' ? 'selected' : '' }}>En cours</option>
                        <option value="Traité" {{ $courrier->statut == 'Traité' ? 'selected' : '' }}>Traité</option>
                        <option value="Archivé" {{ $courrier->statut == 'Archivé' ? 'selected' : '' }}>Archivé</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-600 font-bold">Type document</label>
                    <input type="text" name="type_document" value="{{ $courrier->type_document }}" placeholder="Facture, lettre..." class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="md:col-span-2 border-t pt-4 mt-2">
                    <label class="text-sm text-gray-600 font-bold">Modifier le Fichier (Laissez vide لعدم التغيير)</label>
                    <input type="file" name="file" class="w-full border rounded-lg px-3 py-2 mb-2">
                    @if($courrier->file)
                        <p class="text-xs text-gray-500 italic">Fichier actuel : {{ basename($courrier->file) }}</p>
                    @endif
                </div>

                <div id="arriveeFields" class="contents">
                    <div>
                        <label class="text-sm text-gray-600 font-bold">Expéditeur</label>
                        <input type="text" name="expediteur" value="{{ $courrier->expediteur }}" class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600 font-bold">Destinataire (interne)</label>
                        <select name="user_id" class="w-full border rounded-lg px-3 py-2">
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}" {{ $courrier->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="departFields" class="contents hidden">
                    <div>
                        <label class="text-sm text-gray-600 font-bold">Destinataire externe</label>
                        <input type="text" name="destinataire_externe" value="{{ $courrier->destinataire_externe }}" class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600 font-bold">Mode d’envoi</label>
                        <select name="mode_envoi" class="w-full border rounded-lg px-3 py-2">
                            <option value="email" {{ $courrier->mode_envoi == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="poste" {{ $courrier->mode_envoi == 'poste' ? 'selected' : '' }}>Poste</option>
                        </select>
                    </div>
                </div>

                <div class="md:col-span-2 text-right mt-6 border-t pt-6 space-x-3">
                    <a href="{{ route('courrier') }}" class="text-gray-500 hover:underline mr-4">Annuler</a>
                    <button type="submit" class="bg-yellow-500 text-white px-8 py-2 rounded-lg hover:bg-yellow-600 font-bold shadow">
                        Mettre à jour
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    const typeSelect = document.getElementById('type');
    const arrivee = document.getElementById('arriveeFields');
    const depart = document.getElementById('departFields');

    function toggleFields() {
        if (typeSelect.value === 'arrivee') {
            arrivee.classList.remove('hidden');
            depart.classList.add('hidden');
        } else {
            depart.classList.remove('hidden');
            arrivee.classList.add('hidden');
        }
    }

    typeSelect.addEventListener('change', toggleFields);
    window.onload = toggleFields;
</script>

@endsection