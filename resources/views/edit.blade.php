@extends('layouts.custom')
@section('title', 'Modifier Courrier - GEC')

@section('content')
<div class="p-6 max-w-xl mx-auto bg-white shadow rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Modifier Courrier</h2>

    <form action="{{ route('courrier.update', $courrier->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700">Référence</label>
            <input type="text" name="reference" value="{{ old('reference', $courrier->reference) }}" class="w-full border px-3 py-2 rounded">
            @error('reference')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Objet</label>
            <input type="text" name="objet" value="{{ old('objet', $courrier->objet) }}" class="w-full border px-3 py-2 rounded">
            @error('objet')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Type</label>
            <select name="type" class="w-full border px-3 py-2 rounded">
                <option value="Entrant" {{ $courrier->type=='Entrant'?'selected':'' }}>Entrant</option>
                <option value="Sortant" {{ $courrier->type=='Sortant'?'selected':'' }}>Sortant</option>
                <option value="Interne" {{ $courrier->type=='Interne'?'selected':'' }}>Interne</option>
            </select>
            @error('type')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Date d'envoi</label>
            <input type="date" name="date_envoi" value="{{ old('date_envoi', $courrier->date_envoi) }}" class="w-full border px-3 py-2 rounded">
            @error('date_envoi')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Date de réception</label>
            <input type="date" name="date_reception" value="{{ old('date_reception', $courrier->date_reception) }}" class="w-full border px-3 py-2 rounded">
            @error('date_reception')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Statut</label>
            <select name="statut" class="w-full border px-3 py-2 rounded">
                <option value="En cours" {{ $courrier->statut=='En cours'?'selected':'' }}>En cours</option>
                <option value="Traité" {{ $courrier->statut=='Traité'?'selected':'' }}>Traité</option>
                <option value="Archivé" {{ $courrier->statut=='Archivé'?'selected':'' }}>Archivé</option>
            </select>
            @error('statut')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Image</label>
            @if($courrier->image)
                <img src="{{ asset('storage/'.$courrier->image) }}" class="h-20 mb-2">
            @endif
            <input type="file" name="image" class="w-full border px-3 py-2 rounded">
            @error('image')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mettre à jour</button>
        <a href="{{ route('courrier') }}" class="ml-2 text-gray-600 hover:underline">Annuler</a>
    </form>
</div>
@endsection