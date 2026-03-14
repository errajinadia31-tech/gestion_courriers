<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archives</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">Archives</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-200 text-left">
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
                        <td class="p-3">{{ $archive->courrier->objet }}</td>
                        <td class="p-3">{{ $archive->user->name }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($archive->date_archivage)->format('d/m/Y') }}</td>
                        <td class="p-3">{{ $archive->emplacement }}</td>
                        <td class="p-3 flex gap-2">
                            <form action="{{ route('archive.destroy', $archive->id_archive) }}" method="POST" onsubmit="return confirm('Vraiment supprimer?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Supprimer</button>
                            </form>
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

        <div class="mt-4">
            {{ $archives->links() }}
        </div>
    </div>

</body>
</html>