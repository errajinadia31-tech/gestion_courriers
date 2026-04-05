@extends('layouts.custom')
@section('title','consulter-CEG')

@section('content')
@if(session('success'))
    <div class="bg-green-200 text-green-800 p-2 rounded mb-2">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-200 text-red-800 p-2 rounded mb-2">
        {{ session('error') }}
    </div>
@endif
<div class="max-w-3xl mx-auto py-8">

        <!-- Header -->
        <div class="text-blue-600 font-bold text-lg px-6 py-3 rounded-t-lg">
            Détails du Courrier : {{ $courrier->reference }}
        </div>


        <!-- Contenu -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
            <!-- Infos courrier -->
            <div class="space-y-3 text-gray-700">
                <p><span class="font-semibold">Référence :</span> {{ $courrier->reference }}</p>
                <p><span class="font-semibold">Objet :</span> {{ $courrier->objet }}</p>
                <p><span class="font-semibold">Type :</span> {{ $courrier->type }}</p>
                <p><span class="font-semibold">Date Envoi :</span> {{ $courrier->date }}</p>
                <p><span class="font-semibold">Expéditeur :</span> {{ $courrier->expediteur ?? '-' }}</p>
                <p><span class="font-semibold">Destinataire :</span> {{ $courrier->destinataire ?? '-' }}</p>
                <p><span class="font-semibold">Statut :</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $courrier->statut == 'En cours' ? 'bg-yellow-400 text-black' : 'bg-green-500 text-white' }}">
                        {{ $courrier->statut }}
                    </span>
                </p>
                <p><span class="font-semibold">Ajouté par :</span> {{ $courrier->user->name ?? 'Système' }}</p>
            </div>

            <!-- Document joint -->
            <div class="border-l border-gray-300 pl-4">
                <h3 class="font-semibold mb-2 text-gray-600">Document Joint :</h3>
                @if($courrier->file)
                @php $ext = pathinfo($courrier->file, PATHINFO_EXTENSION); @endphp
                @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                <a href="{{ asset('storage/' . $courrier->file) }}" target="_blank">
                    <img src="{{ asset('storage/' . $courrier->file) }}" class="w-full rounded border border-gray-200 shadow-sm hover:opacity-90 transition">
                </a>
                @elseif(strtolower($ext) == 'pdf')
            <div class="w-full h-[200px] border rounded">
    <object data="{{ asset('storage/' . $courrier->file) }}" type="application/pdf" width="100%" height="100%">
    </object>
</div>
                @endif
                @else
                <p class="italic text-gray-400">Aucun fichier attaché.</p>
                @endif
            </div>
        </div>

        <div class="bg-gray-100 px-6 py-3 flex justify-between rounded-b-lg items-center">
            <a href="{{ route('courrier') }}" class="text-gray-700 hover:text-gray-900 hover:underline font-medium">Retour</a>
            <div class="flex items-center gap-2">
<form action="{{ route('courrier.archive', $courrier->id_courrier) }}" method="POST">
    @csrf
    @method('PUT') 
    <button type="submit" class="text-white hover:bg-blue-700 px-4 py-2 font-bold rounded bg-blue-600">
        Archiver
    </button>
</form>
<a href="{{ route('print', $courrier->id_courrier) }}" target="_blank">
    <button class="bg-orange-600 text-white px-4 py-2 font-bold rounded hover:bg-orange-700">Imprimer PDF</button>
</a>
<a href="{{ route('courrier.download', $courrier->id_courrier) }}">
    <button class="bg-green-600 text-white px-4 py-2 font-bold rounded hover:bg-green-700">Télécharger PDF</button>
</a>
            </div>  
        </div>
        <div class="mt-6 p-4 border rounded shadow">
    <h2 class="text-xl font-semibold mb-3 text-blue-600">Ajouter une transmission</h2>


    <form action="{{ route('transmissions.store') }}" method="POST">
        @csrf
        <input type="hidden" name="courrier_id" value="{{ $courrier->id_courrier }}">

        <div class="mb-3">
            <label for="expediteur_id" class="block font-medium">Expéditeur</label>
            <select name="expediteur_id" id="expediteur_id" class="w-full border p-2 rounded">
                @foreach(\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="destinataire_id" class="block font-medium">Destinataire</label>
            <select name="destinataire_id" id="destinataire_id" class="w-full border p-2 rounded">
                @foreach(\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date_transmission" class="block font-medium">Date de transmission</label>
            <input type="date" name="date_transmission" id="date_transmission" class="w-full border p-2 rounded" value="{{ date('Y-m-d') }}">
        </div>

        <div class="mb-3">
            <label for="commentaire" class="block font-medium">Commentaire (optionnel)</label>
            <textarea name="commentaire" id="commentaire" class="w-full border p-2 rounded"></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</button>
    </form>
</div>
</div>
@endsection 