@extends('layouts.custom')

@section('title', 'Archive- GEC')

@section('content')

    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center text-blue-700">Archives</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-blue-600 text-left">
                        <th class="p-3">Reference</th>
                        <th class="p-3">Objet</th>
                        <th class="p-3">Archivé par</th>
                        <th class="p-3">Date d'archivage</th>
                        <th class="p-3">Emplacement</th>
                        <th class="p-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($archives as $archive)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $archive->courrier->reference }}</td>
                        <td class="p-3">{{ $archive->courrier->objet }}</td>
                        <td class="p-3">{{ $archive->user->name }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($archive->date_archivage)->format('d/m/Y') }}</td>
                        <td class="p-3">{{ $archive->emplacement }}</td>
                        <td class="p-3 flex gap-2">
<button
    type="button"
    onclick="openRestoreModal()"
    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
>
    Restaurer
</button>

<div id="restoreModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Confirmer la restauration</h3>
        <p class="mb-6">Voulez-vous vraiment restaurer ce courrier ?</p>
        <div class="flex justify-end gap-3">
            <button
                onclick="closeRestoreModal()"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
            >
                Annuler
            </button>
          <form action="{{ route('courrier.restore', $archive->courrier->id_courrier) }}" method="POST">
    @csrf
    @method('PUT')
    <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
        Restaurer
    </button>
</form>
        </div>
    </div>
</div>


<button
    type="button"
    onclick="openDeleteModal({{ $archive->id_archive }})"
    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
>
    Supprimer
</button>

<!-- Modal Supprimer -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Confirmer la suppression</h3>
        <p class="mb-6">Voulez-vous vraiment supprimer ce courrier archivé ?</p>
        <div class="flex justify-end gap-3">
            <button
                onclick="closeDeleteModal()"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
            >
                Annuler
            </button>
            <form id="deleteForm" action="" method="POST">
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
                        <td class="p-3 text-center" colspan="5">Aucune archive trouvée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

       
    </div>
<script>
    function openRestoreModal() {
        document.getElementById('restoreModal').classList.remove('hidden');
    }

    function closeRestoreModal() {
        document.getElementById('restoreModal').classList.add('hidden');
    }

    function openDeleteModal(id) {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');

        const form = document.getElementById('deleteForm');
        form.action = '/archive/' + id; 
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function openRestoreModal() {
        document.getElementById('restoreModal').classList.remove('hidden');
    }

    function closeRestoreModal() {
        document.getElementById('restoreModal').classList.add('hidden');
    }
</script>
@endsection