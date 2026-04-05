@extends('layouts.custom')
@section('title', 'Modifier un courrier - GEC')

@section('content')
<div class="flex justify-center bg-gray-100 min-h-screen p-4">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">
                Modifier le courrier : <span class="text-blue-600">{{ $courrier->reference }}</span>
            </h2>

            <form method="POST" action="{{ route('courrier.update', $courrier->id_courrier) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Référence -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Référence <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="reference" value="{{ old('reference', $courrier->reference) }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700">
                    </div>

                    <!-- Année -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Année <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="annee" value="{{ old('annee', $courrier->annee ?? date('Y')) }}"
                            min="2000" max="2100"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700">
                    </div>

                    <!-- Type -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Type <span class="text-red-500">*</span>
                        </label>
                        <select name="type" id="type" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                            <option value="arrivee" {{ $courrier->type=='arrivee'?'selected':'' }}>Arrivé</option>
                            <option value="depart" {{ $courrier->type=='depart'?'selected':'' }}>Départ</option>
                        </select>
                    </div>

                    <!-- Statut -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Statut</label>
                        <select name="statut" id="statut"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                            <option value="En cours" {{ $courrier->statut=='En cours'?'selected':'' }}>En cours</option>
                            <option value="Traité" {{ $courrier->statut=='Traité'?'selected':'' }}>Traité</option>
                            <option value="Archivé" {{ $courrier->statut=='Archivé'?'selected':'' }}>Archivé</option>
                        </select>
                    </div>

                    <!-- Objet -->
                    <div class="md:col-span-2 flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Objet <span class="text-red-500">*</span></label>
                        <textarea name="objet" placeholder="Objet du courrier" required rows="4"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700 resize-none text-justify">{{ old('objet', $courrier->objet) }}</textarea>
                    </div>

                    <!-- Date d'envoi -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Date d'envoi <span class="text-red-500">*</span></label>
                        <input type="date" name="date" required id="date_envoi"
                            value="{{ old('date', $courrier->date) }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700">
                    </div>

                    <!-- Date de réception -->
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Date de réception</label>
                        <input type="date" name="date_reception" id="date_reception"
                            value="{{ old('date_reception', $courrier->date_reception) }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-blue-500 outline-none text-gray-700">
                    </div>

                    <!-- Utilisateur -->
                    <div class="md:col-span-2 flex flex-col">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Utilisateur</label>
                        <input type="text" value="{{ $courrier->user->name ?? auth()->user()->name }}" readonly
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-gray-50 outline-none text-gray-700 cursor-not-allowed font-medium">
                        <input type="hidden" name="user_id" value="{{ $courrier->user_id ?? auth()->user()->id }}">
                    </div>

                    <!-- Expéditeur + Emplacement -->
                    <div class="md:col-span-2 flex flex-col md:flex-row gap-4">
                        <div class="flex flex-col flex-1">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Expéditeur</label>
                            <input type="text" name="expediteur" value="{{ old('expediteur', $courrier->expediteur) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none text-gray-700">
                        </div>
                        <div id="archive_fields" class="flex flex-col flex-1 {{ $courrier->statut=='Archivé'?'':'hidden' }}">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Emplacement de l'archive</label>
                            <select name="emplacement" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-white focus:border-blue-500 outline-none text-gray-700">
                                <option value="Armoire A" {{ $courrier->emplacement=='Armoire A'?'selected':'' }}>Armoire A</option>
                                <option value="Armoire B" {{ $courrier->emplacement=='Armoire B'?'selected':'' }}>Armoire B</option>
                                <option value="Armoire C" {{ $courrier->emplacement=='Armoire C'?'selected':'' }}>Armoire C</option>
                            </select>
                        </div>
                    </div>

                    <!-- Destinataire externe + Mode d’envoi -->
                    <div id="departFields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 {{ $courrier->type=='depart'?'':'hidden' }}">
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Destinataire externe</label>
                            <input type="text" name="destinataire_externe" value="{{ old('destinataire_externe', $courrier->destinataire_externe) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Mode d’envoi</label>
                            <select name="mode_envoi" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none bg-white">
                                <option value="email" {{ $courrier->mode_envoi=='email'?'selected':'' }}>Email</option>
                                <option value="poste" {{ $courrier->mode_envoi=='poste'?'selected':'' }}>Poste</option>
                            </select>
                        </div>
                    </div>

                    <!-- Upload fichier -->
                    <div class="md:col-span-2 mt-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Courrier</label>
                        <div class="relative w-full h-40 border-2 border-dashed border-gray-200 rounded-xl flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-all cursor-pointer group">
                            <input type="file" name="file" id="file-input" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                            <div class="text-center">
                                <p class="text-gray-400 group-hover:text-blue-500 transition-colors">
                                    {{ $courrier->file ? 'Fichier actuel : '.basename($courrier->file) : 'Click to upload or drag and drop' }}
                                </p>
                                <p class="text-gray-400 group-hover:text-blue-500">Changer le fichier (laisser vide pour garder l'actuel)</p>
                                <p id="file-name" class="text-blue-600 font-medium mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="md:col-span-2 flex justify-end mt-4 items-center">
                        <a href="{{ route('courrier') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 transition mr-4">Annuler</a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition shadow-sm">
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
    const depart = document.getElementById('departFields');
    const statutSelect = document.getElementById('statut');
    const archiveFields = document.getElementById('archive_fields');
    const fileInput = document.getElementById('file-input');
    const fileNameDisplay = document.getElementById('file-name');

    function toggleFields(){ depart.classList.toggle('hidden', typeSelect.value==='arrivee'); }
    function toggleArchiveFields(){ archiveFields.classList.toggle('hidden', statutSelect.value!=='Archivé'); }

    typeSelect.addEventListener('change', toggleFields);
    statutSelect.addEventListener('change', toggleArchiveFields);
    window.onload = ()=>{ toggleFields(); toggleArchiveFields(); }

    fileInput.addEventListener('change', ()=>{ fileNameDisplay.textContent = fileInput.files[0]?.name || ''; });

    const dateEnvoi=document.getElementById('date_envoi');
    const dateReception=document.getElementById('date_reception');
    const today=new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth()+1).padStart(2,'0');
    const dd = String(today.getDate()).padStart(2,'0');
    const todayStr = `${yyyy}-${mm}-${dd}`;
    dateEnvoi.max = dateReception.max = todayStr;

    function checkWeekend(input){ 
        const day = new Date(input.value).getDay(); 
        if(day===0||day===6){ alert('Weekends are not allowed!'); input.value=''; } 
    }
    dateEnvoi.addEventListener('input', ()=>checkWeekend(dateEnvoi));
    dateReception.addEventListener('input', ()=>checkWeekend(dateReception));
</script>
@endsection