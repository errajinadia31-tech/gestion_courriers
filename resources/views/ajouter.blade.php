@extends('layouts.custom')
@section('title', 'Créer un courrier - GEC')

@section('content')

<div class="flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-5xl bg-white p-6 rounded-xl shadow">

        <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">
            Créer un courrier
        </h2>

        <form method="POST" action="{{ route('courrier.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Type -->
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Type de courrier</label>
                    <select name="type" id="type" class="w-full border rounded-lg px-3 py-2">
                        <option value="arrivee">📥 Courrier Arrivée</option>
                        <option value="depart">📤 Courrier Départ</option>
                    </select>
                </div>

                <!-- Référence -->
                <div>
                    <label class="text-sm text-gray-600">Référence</label>
                    <input type="text" name="reference" class="w-full border rounded-lg px-3 py-2">
                </div>

                <!-- Date -->
                <div>
                    <label class="text-sm text-gray-600">Date</label>
                    <input type="date" name="date" class="w-full border rounded-lg px-3 py-2">
                </div>

                <!-- Objet -->
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Objet</label>
                    <input type="text" name="objet" class="w-full border rounded-lg px-3 py-2">
                </div>

                <!-- Type document -->
                <div>
                    <label class="text-sm text-gray-600">Type document</label>
                    <input type="text" name="type_document" placeholder="Facture, lettre..." class="w-full border rounded-lg px-3 py-2">
                </div>

                <!-- Fichier -->
                <div>
                    <label class="text-sm text-gray-600">Fichier</label>
                    <input type="file" name="file" class="w-full border rounded-lg px-3 py-2">
                </div>

                <!-- === ARRIVEE === -->
                <div id="arriveeFields" class="contents">

                    <div>
                        <label class="text-sm text-gray-600">Expéditeur</label>
                        <input type="text" name="expediteur" class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Destinataire (interne)</label>
                        <select name="user_id" class="w-full border rounded-lg px-3 py-2">
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- === DEPART === -->
                <div id="departFields" class="contents hidden">

                    <div>
                        <label class="text-sm text-gray-600">Destinataire externe</label>
                        <input type="text" name="destinataire_externe" class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Mode d’envoi</label>
                        <select name="mode_envoi" class="w-full border rounded-lg px-3 py-2">
                            <option value="email">Email</option>
                            <option value="poste">Poste</option>
                        </select>
                    </div>

                </div>

                <!-- Submit -->
                <div class="md:col-span-2 text-right">
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Enregistrer
                    </button>
                </div>

            </div>

        </form>
    </div>
</div>

<!-- Script -->
<script>
    const typeSelect = document.getElementById('type');
    const arrivee = document.getElementById('arriveeFields');
    const depart = document.getElementById('departFields');

    function toggleFields() {
        if (typeSelect.value === 'arrivee') {
            arrivee.classList.remove('hidden');
            depart.classList.add('hidden');
        } else {
            depart.classList.remove('hidden');
            arrivee.classList.add('hidden');
        }
    }

    typeSelect.addEventListener('change', toggleFields);
    window.onload = toggleFields;
</script>

@endsection