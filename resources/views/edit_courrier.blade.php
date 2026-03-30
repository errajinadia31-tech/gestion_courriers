@extends('layouts.custom')
@section('title', 'Modifier un courrier - GEC')

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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">

                    <!-- Référence -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Référence <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="reference" value="{{ old('reference', $courrier->reference) }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700">
                    </div>

                    <!-- Type -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Type <span class="text-red-500">*</span>
                        </label>
                        <select name="type" id="type" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                            <option value="arrivee" {{ $courrier->type == 'arrivee' ? 'selected' : '' }}>Entrant</option>
                            <option value="depart" {{ $courrier->type == 'depart' ? 'selected' : '' }}>Sortant</option>
                        </select>
                    </div>

                    <!-- Objet -->
                    <div class="md:col-span-2 flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Objet <span class="text-red-500">*</span>
                        </label>
                        <textarea name="objet" placeholder="Objet du courrier" required
                            rows="4"
                            style="text-align: justify;"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700 resize-none">{{ old('objet', $courrier->objet) }}</textarea>
                    </div>
<!-- Date d'envoi -->
<div class="flex flex-col">
 <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
  Date d'envoi <span class="text-red-500">*</span>
 </label>
 <input type="date" name="date" required id="date_envoi"
  class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-500">
</div>

<!-- Date de réception -->
<div class="flex flex-col">
 <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
  Date de réception
 </label>
 <input type="date" name="date_reception" id="date_reception" 
  class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-500">
</div>

                    <!-- Statut -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Statut</label>
                        <select name="statut" id="statut"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                            <option value="En cours" {{ $courrier->statut == 'En cours' ? 'selected' : '' }}>En cours</option>
                            <option value="Traité" {{ $courrier->statut == 'Traité' ? 'selected' : '' }}>Traité</option>
                            <option value="Archivé" {{ $courrier->statut == 'Archivé' ? 'selected' : '' }}>Archivé</option>
                        </select>
                    </div>

                    <!-- Utilisateur -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Utilisateur
                        </label>
                        <input type="text"
                            value="{{ $courrier->user->name ?? auth()->user()->name }}"
                            readonly
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-gray-50 outline-none text-gray-700 cursor-not-allowed font-medium">
                        <input type="hidden" name="user_id" value="{{ $courrier->user_id ?? auth()->user()->id }}">
                    </div>

                    <!-- Expéditeur + Destinataire -->
                    <div id="arriveeFields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Expéditeur</label>
                            <input type="text" name="expediteur" value="{{ $courrier->expediteur }}"
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none text-gray-700">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                                Destinataire interne
                            </label>
                            <input type="text" name="destinataire_interne"
                                value="{{ old('destinataire_interne', $courrier->destinataire_interne) }}"
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none text-gray-700">
                        </div>
                    </div>

                    <!-- Destinataire externe + mode d’envoi -->
                    <div id="departFields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 hidden">
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Destinataire externe</label>
                            <input type="text" name="destinataire_externe" value="{{ $courrier->destinataire_externe }}"
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Mode d’envoi</label>
                            <select name="mode_envoi" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none bg-white">
                                <option value="poste" {{ $courrier->mode_envoi == 'poste' ? 'selected' : '' }}>Poste</option>
                                <option value="email" {{ $courrier->mode_envoi == 'email' ? 'selected' : '' }}>Email</option>
                            </select>
                        </div>
                    </div>

                    <!-- Emplacement (visible seulement si Archivé) -->
                    <div id="archive_fields" class="md:col-span-2 flex flex-col {{ $courrier->statut == 'Archivé' ? '' : 'hidden' }}">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Emplacement de l'archive</label>
                        <select name="emplacement"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                            <option value="Armoire A" {{ $courrier->emplacement == 'Armoire A' ? 'selected' : '' }}>Armoire A</option>
                            <option value="Armoire B" {{ $courrier->emplacement == 'Armoire B' ? 'selected' : '' }}>Armoire B</option>
                            <option value="Armoire C" {{ $courrier->emplacement == 'Armoire C' ? 'selected' : '' }}>Armoire C</option>
                        </select>
                    </div>

                    <!-- Upload fichier -->
                    <div class="md:col-span-2 mt-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Courrier
                        </label>
                        <div class="relative w-full h-40 border-2 border-dashed border-gray-200 rounded-xl flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-all cursor-pointer group">
                            <input type="file" name="file" id="file-input" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                            <div class="text-center">
                                <p id="file-placeholder" class="text-gray-400 group-hover:text-blue-500 transition-colors">
                                    {{ $courrier->file ? 'Fichier actuel : ' . basename($courrier->file) : 'Click to upload or drag and drop' }}
                                </p>
                                <p id="file-placeholder" class="text-gray-400 group-hover:text-blue-500">Changer le fichier (laisser vide pour garder l'actuel)</p>
                                <p id="file-name" class="text-blue-600 font-medium mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="md:col-span-2 flex justify-end mt-4">
                        <a href="{{ route('courrier') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 transition mr-4">Annuler</a>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition shadow-sm">
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
    const statutSelect = document.getElementById('statut');
    const archiveFields = document.getElementById('archive_fields');
    const fileInput = document.getElementById('file-input');
    const fileNameDisplay = document.getElementById('file-name');
    const filePlaceholder = document.getElementById('file-placeholder');

    // Toggle type fields
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

    // Toggle archive fields
    function toggleArchiveFields() {
        if (statutSelect.value === 'Archivé') {
            archiveFields.classList.remove('hidden');
        } else {
            archiveFields.classList.add('hidden');
        }
    }
    statutSelect.addEventListener('change', toggleArchiveFields);

    // File input display
    fileInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            fileNameDisplay.textContent = "Nouveau fichier : " + this.files[0].name;
            filePlaceholder.classList.add('hidden');
        } else {
            fileNameDisplay.textContent = "";
            filePlaceholder.classList.remove('hidden');
        }
    });

    // Initialize on load
    window.onload = function() {
        toggleFields();
        toggleArchiveFields();
    };
     // Pour Date d'envoi
  const dateEnvoi = document.getElementById('date_envoi');
  const maxDate = new Date('2026-03-27');
  dateEnvoi.max = maxDate.toISOString().split('T')[0]; // yyyy-mm-dd

  dateEnvoi.addEventListener('input', () => {
      const selectedDate = new Date(dateEnvoi.value);
      const day = selectedDate.getDay();
      if(day === 0 || day === 6){
          alert('Weekends are not allowed!');
          dateEnvoi.value = '';
      }
  });

  // Pour Date de réception
  const dateReception = document.getElementById('date_reception');
  dateReception.max = maxDate.toISOString().split('T')[0];

  dateReception.addEventListener('input', () => {
      const selectedDate = new Date(dateReception.value);
      const day = selectedDate.getDay();
      if(day === 0 || day === 6){
          alert('Weekends are not allowed!');
          dateReception.value = '';
      }
  });
</script>
@endsection