@extends('layouts.custom')
@section('title','consulter-CEG')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="">
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
                        <div class="border border-red-200 rounded p-3 bg-red-50 flex flex-col items-center">
                            <svg class="w-12 h-12 text-red-500 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                            </svg>
                            <p class="text-red-700 text-sm mb-2">Document PDF</p>
                            <a href="{{ asset('storage/' . $courrier->file) }}" target="_blank" class="bg-red-600 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-red-700">
                                Ouvrir / Consulter
                            </a>
                        </div>
                    @endif
                @else
                    <p class="italic text-gray-400">Aucun fichier attaché.</p>
                @endif
            </div>
        </div>

        <div class="bg-gray-100 px-6 py-3 flex justify-between rounded-b-lg">
            <a href="{{ route('courrier') }}" class="text-gray-700 hover:text-gray-900 font-medium">← Retour</a>
            <a href="{{ route('courrier.edit', $courrier->id_courrier) }}" class="bg-yellow-400 text-black px-4 py-2 rounded shadow hover:bg-yellow-500 font-semibold">Modifier</a>
        </div>
    </div>
</div>
@endsection