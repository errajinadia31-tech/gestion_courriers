<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use Illuminate\Support\Facades\Auth;

class CourrierController extends Controller
{
    // Appliquer le middleware auth
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 1️⃣ Liste de tous les courriers
    public function index() // méthode index pour la liste
    {
        $courriers = Courrier::latest()->paginate(10); // récupère les courriers avec pagination
        return view('courrier', compact('courriers')); // passe $courriers à la vue
    }

    // 2️⃣ Formulaire de création
    public function create()
    {
        return view('courrier');
    }

    // 3️⃣ Stocker le nouveau courrier
    public function store(Request $request)
    {
        $data = $request->validate([
            'reference' => 'required|string|max:255',
            'objet' => 'required|string|max:255',
            'type' => 'required|in:Entrant,Sortant,Interne',
            'date_envoi' => 'nullable|date',
            'date_reception' => 'nullable|date',
            'statut' => 'required|in:En cours,Traité,Archivé',
            'image' => 'nullable|image|max:2048', // facultatif
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courriers', 'public');
        }

        $data['user_id'] = Auth::id();

        Courrier::create($data);

        return redirect()->route('courrier')->with('success', 'Courrier créé avec succès');
    }

    // 4️⃣ Afficher un courrier
    public function show(Courrier $courrier)
    {
        return view('courrier.show', compact('courrier'));
    }

    // 5️⃣ Formulaire d’édition
    public function edit(Courrier $courrier)
    {
        return view('courrier.edit', compact('courrier'));
    }

    // 6️⃣ Mettre à jour le courrier
    public function update(Request $request, Courrier $courrier)
    {
        $data = $request->validate([
            'reference' => 'required|string|max:255',
            'objet' => 'required|string|max:255',
            'type' => 'required|in:Entrant,Sortant,Interne',
            'date_envoi' => 'nullable|date',
            'date_reception' => 'nullable|date',
            'statut' => 'required|in:En cours,Traité,Archivé',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courriers', 'public');
        }

        $courrier->update($data);

        return redirect()->route('courrier')->with('success', 'Courrier mis à jour avec succès');
    }

    // 7️⃣ Supprimer un courrier
    public function destroy(Courrier $courrier)
    {
        $courrier->delete();
        return redirect()->route('courrier')->with('success', 'Courrier supprimé avec succès');
    }
}