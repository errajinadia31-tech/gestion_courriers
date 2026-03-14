<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\User;

class CourrierController extends Controller
{
    // Formulaire création courrier
    public function create()
    {
        $users = User::all();
        return view('courrier.create', compact('users'));
    }

    // Enregistrement courrier
    public function store(Request $request)
    {
        $data = $request->validate([
            'reference' => 'required|string|max:255',
            'objet' => 'required|string|max:255',
            'type' => 'required|in:Entrant,Sortant,Interne',
            'date_envoi' => 'nullable|date',
            'date_reception' => 'nullable|date',
            'statut' => 'required|in:En cours,Traité,Archivé',
            'user_id' => 'required|exists:users,id',
            'image' => 'required|image|max:2048',
        ]);

        // Upload image
        $path = $request->file('image')->store('courriers', 'public');
        $data['image'] = $path;

        Courrier::create($data);

        return redirect()->route('dashboard')->with('success', 'Courrier créé avec succès');
    }
}