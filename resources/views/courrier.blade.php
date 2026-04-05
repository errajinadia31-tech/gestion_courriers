@extends('layouts.custom')

@section('title', 'Liste des courriers - GEC')

@section('content')
<div class="p-4 max-w-6xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Liste des courriers</h2>
        <a href="{{ route('ajouter') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nouveau courrier</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 mb-4 rounded border border-green-200 text-center">
        {{ session('success') }}
    </div>
    @endif

    <!-- Table pour desktop -->
    <div class="hidden md:block overflow-x-auto bg-white shadow rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Référence</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Objet</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expéditeur</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Destinataire</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fichier</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($courriers as $courrier)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2 whitespace-nowrap font-medium">{{ $courrier->reference }}</td>
                    <td class="px-4 py-2 max-w-xs break-words text-justify">{{ $courrier->objet }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm italic">{{ $courrier->type }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $courrier->date ? \Carbon\Carbon::parse($courrier->date)->format('d/m/Y') : '-' }}</td>
                    <td class="px-4 py-2 max-w-xs truncate" title="{{ $courrier->expediteur }}">{{ $courrier->expediteur ?? '-' }}</td>
                    <td class="px-4 py-2 max-w-xs truncate" title="{{ $courrier->destinataire_externe }}">{{ $courrier->destinataire_externe ?? '-' }}</td>
                    <td class="px-4 py-2 text-center">
                        <span class="px-4 py-1 rounded text-xs text-white whitespace-nowrap {{ $courrier->statut == 'En cours' ? 'bg-orange-500' : ($courrier->statut == 'Traité' ? 'bg-green-500' : 'bg-blue-500') }}">
                            {{ $courrier->statut }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-sm">{{ $courrier->user->name }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">
                        @if($courrier->file)
                        @php $extension = pathinfo($courrier->file, PATHINFO_EXTENSION); @endphp
                        @if(in_array(strtolower($extension), ['jpg','jpeg','png','gif']))
                        <img src="{{ asset('storage/' . $courrier->file) }}" alt="image" class="h-12 w-auto rounded shadow-sm border border-gray-100">
                        @else
                        <span class="inline-flex items-center text-red-600 font-bold text-xs uppercase">PDF</span>
                        @endif
                        @else
                        <span class="text-gray-400 text-xs italic">Aucun file</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-center flex flex-col gap-2 items-center">
                        <a href="{{ route('show.view', $courrier->id_courrier) }}" class="text-blue-600 hover:text-blue-900 font-bold">Voir</a>
                        <a href="{{ route('courrier.edit', $courrier->id_courrier) }}" class="text-yellow-500 font-bold hover:underline">Modifier</a>
                        <button type="button" onclick="openModal({{ $courrier->id_courrier }})" class="text-red-600 font-bold hover:underline">Supprimer</button>
                        <div id="deleteModal-{{ $courrier->id_courrier }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-80">
                                <h3 class="text-lg font-semibold mb-4">Confirmer la suppression</h3>
                                <p class="mb-6">Voulez-vous vraiment supprimer ce courrier ?</p>
                                <div class="flex justify-end gap-3">
                                    <button onclick="closeModal({{ $courrier->id_courrier }})" class="px-4 py-2 bg-gray-300 rounded">Annuler</button>
                                    <form action="{{ route('courrier.destroy', $courrier->id_courrier) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-4 py-4 text-center text-gray-500 italic bg-gray-50">Aucun courrier trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Cards pour mobile -->
    <div class="md:hidden grid gap-4">
        @forelse($courriers as $courrier)
        <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between">
            <div class="space-y-1">
                <p><span class="font-semibold">Réf:</span> {{ $courrier->reference }}</p>
                <p><span class="font-semibold">Objet:</span> {{ $courrier->objet }}</p>
                <p><span class="font-semibold">Type:</span> {{ $courrier->type }}</p>
                <p><span class="font-semibold">Date:</span> {{ $courrier->date ? \Carbon\Carbon::parse($courrier->date)->format('d/m/Y') : '-' }}</p>
                <p><span class="font-semibold">Expéditeur:</span> {{ $courrier->expediteur ?? '-' }}</p>
                <p><span class="font-semibold">Destinataire:</span> {{ $courrier->destinataire_externe ?? '-' }}</p>
                <p><span class="font-semibold">Statut:</span>
                    <span class="px-2 py-1 rounded text-xs text-white {{ $courrier->statut == 'En cours' ? 'bg-orange-500' : ($courrier->statut == 'Traité' ? 'bg-green-500' : 'bg-blue-500') }}">
                        {{ $courrier->statut }}
                    </span>
                </p>
                <p><span class="font-semibold">Utilisateur:</span> {{ $courrier->user->name ?? 'N/A' }}</p>
            </div>
            <div class="mt-2 flex flex-col gap-2">
                <a href="{{ route('show.view', $courrier->id_courrier) }}" class="text-blue-600 font-bold">Voir</a>
                <a href="{{ route('courrier.edit', $courrier->id_courrier) }}" class="text-yellow-500 font-bold">Modifier</a>
                <button type="button" onclick="openModal({{ $courrier->id_courrier }})" class="text-red-600 font-bold">Supprimer</button>
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500">Aucun courrier trouvé.</p>
        @endforelse
    </div>

    @if(method_exists($courriers, 'links'))
    <div class="mt-6">
        {{ $courriers->links() }}
    </div>
    @endif
</div>

<script>
    function openModal(id) {
        document.getElementById('deleteModal-' + id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById('deleteModal-' + id).classList.add('hidden');
    }
</script>
@endsection