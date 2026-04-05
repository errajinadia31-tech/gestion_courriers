@extends('layouts.custom')

@section('title', 'Dashboard- GEC')

@section('content')

<div class="flex justify-end mb-6">
    <a href="{{ route('ajouter') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nouveau courrier</a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex flex-col items-start">
        <a href="{{route('courrier') }}" class="font-semibold text-gray-700 mb-2">Courriers Départ</a>
        <p class="text-3xl font-bold text-indigo-600">{{ $courriersDepart }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex flex-col items-start">
        <a href="{{ route('courrier')}}" class="font-semibold text-gray-700 mb-2">Courriers Arrivés</a>
        <p class="text-3xl font-bold text-green-600">{{ $courriersArrives }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex flex-col items-start">
        <a href="{{ route('transmissions.list')}}" class="font-semibold text-gray-700 mb-2">Transmissions</a>
        <p class="text-3xl font-bold text-yellow-500">{{ $transmissions }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex flex-col items-start">
        <a href="{{ route('archive')}}" class="font-semibold text-gray-700 mb-2">Archives</a>
        <p class="text-3xl font-bold text-gray-700">{{ $archives }}</p>
    </div>
</div>

<!-- Derniers Courriers Table -->
<div class="bg-white rounded-lg shadow p-6 overflow-x-auto">
    <h2 class="text-xl font-bold mb-4">Derniers Courriers</h2>
    <table class="min-w-full divide-y divide-gray-200 table-auto">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 font-medium text-gray-600 text-left">Objet</th>
                <th class="px-4 py-3 font-medium text-gray-600 text-left">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lastCourriers as $courrier)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2 text-gray-700 max-w-xs text-justify break-words">{{ $courrier->objet }}</td>
                <td class="px-4 py-2">{{ $courrier->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td class="px-4 py-4 text-center text-gray-500 italic" colspan="2">Aucun courrier trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection