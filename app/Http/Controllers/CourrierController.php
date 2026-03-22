<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourrierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
public function index() {
    $courriers = Courrier::paginate(10); 
    return view('courrier', compact('courriers'));
}
    public function store(Request $request){

        $data = $request->validate([
        'reference' => 'required|string|max:255',
        'objet' => 'required|string|max:255',
        'type' => 'required|in:arrivee,depart',
        'date' => 'required|date',
        'type_document' => 'nullable|string',

        'expediteur' => 'nullable|string',
        'destinataire_externe' => 'nullable|string',
        'mode_envoi' => 'nullable|in:email,poste',

        'user_id' => 'nullable|exists:users,id',

        'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);
    if ($request->hasFile('file')) {
        $data['file'] = $request->file('file')->store('courriers', 'public');
    }

    $data['user_id'] = $data['user_id'] ?? Auth::id();

    if ($data['type'] === 'arrivee') {
        $data['destinataire_externe'] = null;
        $data['mode_envoi'] = null;
    } else {
        $data['expediteur'] = null;
    }

    $courrier = Courrier::create($data);

    return redirect()->route('courrier')
        ->with('success', 'Courrier créé avec succès');
    }


public function destroy($id) 
{
    $courrier = Courrier::where('id_courrier', $id)->first();

    if ($courrier) {
  
        if ($courrier->file) {
            Storage::disk('public')->delete($courrier->file);
        }
        
        $courrier->delete();
        
        return redirect()->route('courrier')->with('success', 'Courrier supprimé avec succès');
    }

    return redirect()->route('courrier')->with('error', 'Courrier introuvable');
}
public function show(Courrier $courrier)
{
    $courrier->load('user'); 
    return view('show', compact('courrier'));
}
public function edit($id)
{
    $courrier = Courrier::where('id_courrier', $id)->firstOrFail();
    return view('edit_courrier', compact('courrier'));
}

public function update(Request $request, $id)
{
    $courrier = Courrier::where('id_courrier', $id)->firstOrFail();

    $data = $request->validate([
        'reference' => 'required|string|max:255',
        'objet' => 'required|string|max:255',
        'type' => 'required|in:arrivee,depart',
        'date' => 'required|date',
        'statut' => 'required|in:En cours,Traité,Archivé',
        'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('file')) {
        if ($courrier->file) {
            Storage::disk('public')->delete($courrier->file);
        }
        $data['file'] = $request->file('file')->store('courriers', 'public');
    }

    $courrier->update($data);

    return redirect()->route('courrier')->with('success', 'Courrier modifié avec succès');
}
}