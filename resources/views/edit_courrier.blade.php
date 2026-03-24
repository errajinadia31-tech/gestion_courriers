@extends('layouts.custom')
@section('title', 'Modifier le courrier - GEC')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100 p-4">
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-8 text-center">
                Modifier le courrier : <span class="text-blue-600">{{ $courrier->reference }}</span>
            </h2>

            <form method="POST" action="{{ route('courrier.update', $courrier->id_courrier) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 text-sm">
                    
                    <div class="md:col-span-2 flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Type de courrier <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-gray-50 focus:border-blue-500 outline-none text-gray-700 font-medium transition">
                            <option value="arrivee" {{ $courrier->type == 'arrivee' ? 'selected' : '' }}>📥 Courrier Arrivée</option>
                            <option value="depart" {{ $courrier->type == 'depart' ? 'selected' : '' }}>📤 Courrier Départ</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Référence <span class="text-red-500">*</span></label>
                        <input type="text" name="reference" value="{{ $courrier->reference }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none transition text-gray-700 bg-white">
                    </div>

                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="date" value="{{ $courrier->date }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-600 bg-white">
                    </div>

                    <div class="md:col-span-2 flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Objet <span class="text-red-500">*</span></label>
                        <input type="text" name="objet" value="{{ $courrier->objet }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700 bg-white text-base">
                    </div>

                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Statut</label>
                        <select name="statut" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none">
                            <option value="En cours" {{ $courrier->statut == 'En cours' ? 'selected' : '' }}>En cours</option>
                            <option value="Traité" {{ $courrier->statut == 'Traité' ? 'selected' : '' }}>Traité</option>
                            <option value="Archivé" {{ $courrier->statut == 'Archivé' ? 'selected' : '' }}>Archivé</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Type document</label>
                        <input type="text" name="type_document" value="{{ $courrier->type_document }}" placeholder="Facture, lettre..." class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none bg-white">
                    </div>

                    <div id="arriveeFields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Expéditeur</label>
                            <input type="text" name="expediteur" value="{{ $courrier->expediteur }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none bg-white">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Destinataire (interne)</label>
                            <select name="user_id" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white outline-none">
                                @foreach($users ?? [] as $user)
                                    <option value="{{ $user->id }}" {{ $courrier->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="departFields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 hidden">
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Destinataire externe</label>
                            <input type="text" name="destinataire_externe" value="{{ $courrier->destinataire_externe }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none bg-white">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Mode d’envoi</label>
                            <select name="mode_envoi" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white outline-none">
                                <option value="email" {{ $courrier->mode_envoi == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="poste" {{ $courrier->mode_envoi == 'poste' ? 'selected' : '' }}>Poste</option>
                            </select>
                        </div>
                    </div>

                    <div class="md:col-span-2 mt-2 border-t pt-6">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1 italic text-blue-600">
                            Fichier actuel : {{ $courrier->file ? basename($courrier->file) : 'Aucun fichier' }}
                        </label>
                        <div class="relative w-full h-32 border-2 border-dashed border-gray-200 rounded-xl flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-all cursor-pointer group">
                            <input type="file" name="file" id="file-input" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full text-sm">
                            <div class="text-center">
                                <p id="file-placeholder" class="text-gray-400 group-hover:text-blue-500">Changer le fichier (laisser vide pour garder l'actuel)</p>
                                <p id="file-name" class="text-blue-600 font-medium mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 flex justify-end items-center mt-6 space-x-4">
                        <a href="{{ route('courrier') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 transition">
                            Annuler
                        </a>
                        <button type="submit" class="bg-blue-600 text-white px-10 py-2.5 rounded-lg font-bold hover:bg-blue-700 transition shadow-sm">
                            Mettre à jour
                        </button>
                    </div>

                </div>
            </form>
        </div>
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


    const fileInput = document.getElementById('file-input');
    const fileNameDisplay = document.getElementById('file-name');
    const filePlaceholder = document.getElementById('file-placeholder');

    fileInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            fileNameDisplay.textContent = "Nouveau fichier : " + this.files[0].name;
            filePlaceholder.classList.add('hidden');
        } else {
            fileNameDisplay.textContent = "";
            filePlaceholder.classList.remove('hidden');
        }
    });
</script>
@endsection