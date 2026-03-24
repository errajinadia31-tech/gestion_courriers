@extends('layouts.custom')
@section('title', 'Créer un courrier - GEC')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100 p-4">
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-8 text-center">
                Créer un courrier
            </h2>

            <form method="POST" action="{{ route('courrier.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">

                    <!-- Référence -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Référence <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="reference" value="{{ old('reference', $nextRef) }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700">
                    </div>

                    <!-- Type -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Type <span class="text-red-500">*</span>
                        </label>
                        <select name="type" id="type" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                            <option value="arrivee">Entrant</option>
                            <option value="depart">Sortant</option>
                        </select>
                    </div>

                    <!-- Objet -->
                    <div class="md:col-span-2 flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Objet <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="objet" placeholder="Objet du courrier" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700">
                    </div>

                    <!-- Date d'envoi -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Date d'envoi <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-500">
                    </div>

                    <!-- Date de réception -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Date de réception
                        </label>
                        <input type="date" name="date_reception"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-500">
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

                    <!-- Utilisateur -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Utilisateur</label>
                        <select name="user_id"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                            @forelse($users ?? [] as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @empty
                                <option disabled selected>Aucun utilisateur disponible</option>
                            @endforelse
                        </select>
                    </div>

                    <!-- Expéditeur + Emplacement côte à côte -->
                    <div class="md:col-span-2 flex flex-row gap-4 mt-2">

                        <!-- Expéditeur -->
                        <div class="flex flex-col flex-1">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Expéditeur</label>
                            <input type="text" name="expediteur"
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none text-gray-700">
                        </div>

                        <!-- Emplacement (Archivé uniquement) -->
                        <div id="archive_fields" class="flex flex-col flex-1 hidden">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Emplacement de l'archive</label>
                            <select name="emplacement"
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                                <option value="Armoire A">Armoire A</option>
                                <option value="Armoire B">Armoire B</option>
                                <option value="Armoire C">Armoire C</option>
                            </select>
                        </div>
                    </div>

                    <!-- Destinataire externe + mode d’envoi (depart) -->
                    <div id="departFields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 hidden">
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Destinataire externe</label>
                            <input type="text" name="destinataire_externe"
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Mode d’envoi</label>
                            <select name="mode_envoi"
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none bg-white">
                                <option value="email">Email</option>
                                <option value="poste">Poste</option>
                            </select>
                        </div>
                    </div>

                    <!-- Upload fichier -->
                    <div class="md:col-span-2 mt-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Courrier <span class="text-red-500">*</span>
                        </label>
                        <div
                            class="relative w-full h-40 border-2 border-dashed border-gray-200 rounded-xl flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-all cursor-pointer group">
                            <input type="file" name="file" id="file-input" required
                                class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
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
                        <button type="submit"
                            class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition shadow-sm">
                            Enregistrer
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const typeSelect = document.getElementById('type');
    const depart = document.getElementById('departFields');

    function toggleFields() {
        if (typeSelect.value === 'arrivee') {
            depart.classList.add('hidden');
        } else {
            depart.classList.remove('hidden');
        }
    }
    typeSelect.addEventListener('change', toggleFields);

    const statutSelect = document.getElementById('statut');
    const archiveFields = document.getElementById('archive_fields');

    function toggleArchiveFields() {
        if (statutSelect.value === 'Archivé') {
            archiveFields.classList.remove('hidden');
        } else {
            archiveFields.classList.add('hidden');
        }
    }
    statutSelect.addEventListener('change', toggleArchiveFields);

    window.onload = function() {
        toggleFields();
        toggleArchiveFields();
    };

    const fileInput = document.getElementById('file-input');
    const fileNameDisplay = document.getElementById('file-name');
    fileInput.addEventListener('change', function () {
        if (this.files && this.files.length > 0) {
            fileNameDisplay.textContent = this.files[0].name;
        } else {
            fileNameDisplay.textContent = "Aucun";
        }
    });
</script>
@endsection