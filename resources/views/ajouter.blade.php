@extends('layouts.custom')
@section('title', 'Créer un courrier - GEC')

@section('content')
<div class="flex justify-center bg-gray-100 min-h-screen p-4">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">
                Créer un courrier
            </h2>

            <form method="POST" action="{{ route('courrier.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Référence -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Référence <span class="text-red-500">*</span></label>
                        <input type="text" name="reference" value="{{ old('reference', $nextRef) }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700">
                        @error('reference')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Année -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Année <span class="text-red-500">*</span></label>
                        <input type="number" name="annee" value="{{ old('annee', date('Y')) }}" min="2000" max="2100"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700">
                    </div>

                    <!-- Type -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Type <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                            <option value="arrivee">Arrivé</option>
                            <option value="depart">Départ</option>
                        </select>
                    </div>

                    <!-- Statut -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Statut</label>
                        <select name="statut" id="statut"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                            <option value="En cours">En cours</option>
                            <option value="Traité">Traité</option>
                            <option value="Archivé">Archivé</option>
                        </select>
                    </div>

                    <!-- Objet -->
                    <div class="md:col-span-2 flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Objet <span class="text-red-500">*</span></label>
                        <textarea name="objet" placeholder="Objet du courrier" required rows="4"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700 resize-none text-justify">{{ old('objet') }}</textarea>
                    </div>

                    <!-- Date d'envoi -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Date d'envoi <span class="text-red-500">*</span></label>
                        <input type="date" name="date" required id="date_envoi"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-500">
                    </div>

                    <!-- Date de réception -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Date de réception</label>
                        <input type="date" name="date_reception" id="date_reception"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-500">
                    </div>

                    <!-- Utilisateur -->
                    <div class="md:col-span-2 flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Utilisateur</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-gray-50 outline-none text-gray-700 cursor-not-allowed font-medium">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    </div>

                    <!-- Expéditeur + Emplacement -->
                    <div class="md:col-span-2 flex flex-col md:flex-row gap-4">
                        <div class="flex flex-col flex-1">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Expéditeur</label>
                            <input type="text" name="expediteur" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none text-gray-700">
                        </div>
                        <div id="archive_fields" class="flex flex-col flex-1 hidden">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Emplacement de l'archive</label>
                            <select name="emplacement" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                                <option value="Armoire A">Armoire A</option>
                                <option value="Armoire B">Armoire B</option>
                                <option value="Armoire C">Armoire C</option>
                            </select>
                        </div>
                    </div>

                  

                    <!-- Upload fichier -->
                    <div class="md:col-span-2 mt-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Courrier (PDF)<span class="text-red-500">*</span></label>
                        <div class="relative w-full h-40 border-2 border-dashed border-gray-200 rounded-xl flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-all cursor-pointer group">
                            <input type="file" name="file" id="file-input" required class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                            <div class="text-center">
                                <p class="text-gray-400 group-hover:text-blue-500 transition-colors">Click to upload or drag and drop</p>
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-gray-600 font-medium text-center">
                            Fichier sélectionné : <span id="file-name" class="text-blue-600 font-semibold italic">Aucun</span>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="md:col-span-2 flex justify-end mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition shadow-sm">
                            Enregistrer
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
@endif



<script>
    // Afficher le nom du fichier sélectionné
    document.getElementById('file-input').addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : 'Aucun';
        document.getElementById('file-name').textContent = fileName;
    });

    // Afficher les champs d'archive si le statut est "Archivé"
    document.getElementById('statut').addEventListener('change', function() {
        const archiveFields = document.getElementById('archive_fields');
        if (this.value === 'Archivé') {
            archiveFields.classList.remove('hidden');
        } else {
            archiveFields.classList.add('hidden');
        }
    });
</script>
@endsection