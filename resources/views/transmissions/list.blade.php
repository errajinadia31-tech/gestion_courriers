@extends('layouts.custom')

@section('title', 'Liste des transmissions - GEC')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center text-blue-700">Transmissions</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full bg-white rounded shadow">
            <thead>
                <tr class="bg-blue-600 text-left text-white">
                    <th class="p-3">Objet</th>
                    <th class="p-3">Reference</th>
                    <th class="p-3">Expéditeur</th>
                    <th class="p-3">Destinataire</th>
                    <th class="p-3">Date de transmission</th>
                    <th class="p-3">Commentaire</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transmissions as $transmission)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $transmission->courrier->objet }}</td>
                    <td class="p-3">{{ $transmission->courrier->reference }}</td>
                    <td class="p-3">{{ $transmission->expediteur->name  }}</td>
                    <td class="p-3">{{ $transmission->destinataire->name }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($transmission->date_transmission)->format('d/m/Y') }}</td>
                    <td class="p-3">{{ $transmission->commentaire }}</td>
                    <td class="p-3">
                                              <a href="{{ route('show.view', $transmission->courrier) }}"
   class="text-blue-600 hover:underline font-bold">
   Voir
</a>
                       <!-- Transmission delete button -->
<button
    onclick="openDeleteTransmissionModal({{ $transmission->id_transmission }})"
    class="text-red-600 font-bold hover:underline"
>
    Supprimer
</button>

<!-- Delete Modal -->
<div id="deleteTransmissionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Confirmer la suppression</h3>
        <p class="mb-6">Voulez-vous vraiment supprimer cette transmission ?</p>
        <div class="flex justify-end gap-3">
            <button
                onclick="closeDeleteTransmissionModal()"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
            >
                Annuler
            </button>
            <form id="deleteTransmissionForm" method="POST">
                @csrf
                @method('DELETE')
                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="p-3 text-center" colspan="6">Aucune transmission trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transmissions->links() }}
    </div>
</div>
<script>
    function openDeleteTransmissionModal(id) {
        const modal = document.getElementById('deleteTransmissionModal');
        modal.classList.remove('hidden');

        const form = document.getElementById('deleteTransmissionForm');
        form.action = '/transmissions/' + id; 
    }

    function closeDeleteTransmissionModal() {
        document.getElementById('deleteTransmissionModal').classList.add('hidden');
    }
</script>
@endsection