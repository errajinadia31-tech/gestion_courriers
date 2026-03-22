@extends('layouts.custom')

@section('title', 'Liste des courriers - GEC')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Liste des courriers</h2>
        <a href="{{ route('ajouter') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nouveau courrier</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 mb-4 rounded border border-green-200">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Référence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Objet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fichier</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($courriers as $courrier)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $courrier->reference }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $courrier->objet }}</td>
                    <td class="px-6 py-4 whitespace-nowrap italic text-sm text-gray-600">{{ $courrier->type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 rounded text-xs text-white {{ $courrier->statut == 'En cours' ? 'bg-orange-500' : 'bg-green-500' }}">
                            {{ $courrier->statut }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $courrier->user->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($courrier->file)
                            @php $extension = pathinfo($courrier->file, PATHINFO_EXTENSION); @endphp
                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ asset('storage/' . $courrier->file) }}" alt="image" class="h-12 w-auto rounded shadow-sm border border-gray-100">
                            @else
                                <span class="inline-flex items-center text-red-600 font-bold text-xs uppercase">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path></svg>
                                    PDF
                                </span>
                            @endif
                        @else
                            <span class="text-gray-400 text-xs italic">Aucun file</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                        <a href="{{ route('show.view', $courrier->id_courrier) }}" class="text-blue-600 hover:text-blue-900 font-bold">Voir</a>
                        
<a href="{{ route('courrier.edit', $courrier->id_courrier) }}" class="text-yellow-500 font-bold hover:underline">
    Modifier
</a>
<form action="{{ route('courrier.destroy', $courrier->id_courrier) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ?')" class="text-red-600 font-bold hover:underline">
        Supprimer
    </button>
</form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 italic bg-gray-50">
                        Aucun courrier trouvé dans la base de données.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($courriers, 'links'))
    <div class="mt-6">
        {{ $courriers->links() }}
    </div>
    @endif
</div>
@endsection