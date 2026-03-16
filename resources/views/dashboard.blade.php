@extends('layouts.custom')

@section('title', 'Dashboard- GEC')

@section('content')

<!-- Top Action -->
<div class="flex justify-end mb-6">
           <a href="{{ route('ajouter') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nouveau courrier</a>

</div>

<!-- Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-gray-500 mb-2">Courriers Départ</h3>
        <p class="text-3xl font-bold text-indigo-600">{{ $courriersDepart }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-gray-500 mb-2">Courriers Arrivés</h3>
        <p class="text-3xl font-bold text-green-600">{{ $courriersArrives }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-gray-500 mb-2">Transmissions</h3>
        <p class="text-3xl font-bold text-yellow-500">{{ $transmissions }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-gray-500 mb-2">Archives</h3>
        <p class="text-3xl font-bold text-gray-700">{{ $archives }}</p>
    </div>
</div>

<!-- Last Courriers -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Derniers Courriers</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 font-medium text-gray-600">Objet</th>
                    <th class="p-3 font-medium text-gray-600">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lastCourriers as $courrier)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $courrier->objet }}</td>
                        <td class="p-3">{{ $courrier->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-3" colspan="2">Aucun courrier trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection