@extends('layouts.custom')
@section('title', 'Liste des courriers - GEC')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Liste des courriers</h2>
        <a href="{{ route('ajouter') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nouveau courrier</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Objet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($courriers as $courrier)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $courrier->reference }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $courrier->objet }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $courrier->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $courrier->statut }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $courrier->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($courrier->image)
                                <img src="{{ asset('storage/'.$courrier->image) }}" alt="image" class="h-16 w-auto rounded">
                            @else
                                <span class="text-gray-400 text-sm">Pas d'image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                            <a href="" class="text-blue-600 hover:underline">Voir</a>
                            <a href="" class="text-yellow-500 hover:underline">Modifier</a>
                            <form action="" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ce courrier ?')" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucun courrier trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $courriers->links() }} 
    </div>
</div>
@endsection