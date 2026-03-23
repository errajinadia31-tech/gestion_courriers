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
                    <th class="p-3">Courrier</th>
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
                    <td class="p-3">{{ $transmission->courrier->objet ?? 'N/A' }}</td>
                    <td class="p-3">{{ $transmission->expediteur->name ?? 'N/A' }}</td>
                    <td class="p-3">{{ $transmission->destinataire->name ?? 'N/A' }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($transmission->date_transmission)->format('d/m/Y') }}</td>
                    <td class="p-3">{{ $transmission->commentaire }}</td>
                    <td class="p-3">
                        <form action="{{ route('transmissions.destroy', $transmission->id_transmission) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette transmission ?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Supprimer</button>
                        </form>
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
@endsection