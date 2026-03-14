@extends('layouts.custom')
@section('content')

<div class="flex items-center justify-center bg-gray-100 overflow-hidden">
    <div class="w-full max-w-5xl">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center">
            Créer un courrier
        </h2>

        <form class="grid grid-cols-1 md:grid-cols-2 gap-4" method="POST" action="{{ route('courrier.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Référence -->
            <div>
                <label class="block text-gray-600 text-sm mb-1">Référence</label>
                <input type="text" name="reference" value="{{ old('reference') }}"
                    placeholder="Référence"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <x-input-error :messages="$errors->get('reference')" class="mt-1"/>
            </div>

            <!-- Type -->
            <div>
                <label class="block text-gray-600 text-sm mb-1">Type</label>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="Entrant" {{ old('type')=='Entrant'?'selected':'' }}>Entrant</option>
                    <option value="Sortant" {{ old('type')=='Sortant'?'selected':'' }}>Sortant</option>
                    <option value="Interne" {{ old('type')=='Interne'?'selected':'' }}>Interne</option>
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-1"/>
            </div>

            <!-- Objet -->
            <div class="md:col-span-2">
                <label class="block text-gray-600 text-sm mb-1">Objet</label>
                <input type="text" name="objet" value="{{ old('objet') }}"
                    placeholder="Objet du courrier"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <x-input-error :messages="$errors->get('objet')" class="mt-1"/>
            </div>

            <!-- Date envoi -->
            <div>
                <label class="block text-gray-600 text-sm mb-1">Date d'envoi</label>
                <input type="date" name="date_envoi" value="{{ old('date_envoi') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <x-input-error :messages="$errors->get('date_envoi')" class="mt-1"/>
            </div>

            <!-- Date réception -->
            <div>
                <label class="block text-gray-600 text-sm mb-1">Date de réception</label>
                <input type="date" name="date_reception" value="{{ old('date_reception') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <x-input-error :messages="$errors->get('date_reception')" class="mt-1"/>
            </div>

            <!-- Statut -->
            <div>
                <label class="block text-gray-600 text-sm mb-1">Statut</label>
                <select name="statut" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="En cours" {{ old('statut')=='En cours'?'selected':'' }}>En cours</option>
                    <option value="Traité" {{ old('statut')=='Traité'?'selected':'' }}>Traité</option>
                    <option value="Archivé" {{ old('statut')=='Archivé'?'selected':'' }}>Archivé</option>
                </select>
                <x-input-error :messages="$errors->get('statut')" class="mt-1"/>
            </div>

            <!-- Utilisateur -->
            <div>
                <label class="block text-gray-600 text-sm mb-1">Utilisateur</label>
                <select name="user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @forelse($users ?? [] as $user)
                        <option value="{{ $user->id }}" {{ old('user_id')==$user->id?'selected':'' }}>{{ $user->name }}</option>
                    @empty
                        <option value="">Aucun utilisateur disponible</option>
                    @endforelse
                </select>
                <x-input-error :messages="$errors->get('user_id')" class="mt-1"/>
            </div>

            <!-- Upload -->
            <div class="md:col-span-2">
                <label class="block text-gray-600 text-sm mb-1">Courrier</label>
                <label class="flex flex-col items-center justify-center w-full h-[140px] border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                    <p class="text-gray-400 text-sm">Click to upload or drag and drop</p>
                    <input type="file" name="image" class="hidden">
                </label>
                <x-input-error :messages="$errors->get('image')" class="mt-1"/>
            </div>

            <!-- Button -->
            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Enregistrer
                </button>
            </div>

        </form>
    </div>
</div>

@endsection