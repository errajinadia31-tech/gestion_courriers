<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourrierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
public function index(Request $request)
{
    $search = $request->input('search');

    $courriers = Courrier::when($search, function ($query, $search) {
        $query->where(function($q) use ($search) {
            $q->where('reference', 'like', "%$search%")
              ->orWhere('destinataire_externe', 'like', "%$search%")
              ->orWhere('expediteur', 'like', "%$search%");
        });
    })->paginate(50);
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
        'type_document' => 'nullable|string',
        'expediteur' => 'nullable|string',
        'destinataire_externe' => 'nullable|string',
        'mode_envoi' => 'nullable|in:email,poste',
        'user_id' => 'nullable|exists:users,id',
        'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('file')) {
        if ($courrier->file) {
            Storage::disk('public')->delete($courrier->file);
        }
        $data['file'] = $request->file('file')->store('courriers', 'public');
    }

    if ($data['type'] === 'arrivee') {
        $data['destinataire_externe'] = null;
        $data['mode_envoi'] = null;
    } elseif ($data['type'] === 'depart') {
        $data['expediteur'] = null;
    }

    $courrier->update($data);

    return redirect()->route('courrier')->with('success', 'Courrier modifié avec succès');
}

public function archive(Courrier $courrier)
{

     if (Archive::where('courrier_id', $courrier->id_courrier)->exists()) {
        return redirect()->back()->with('error', 'Ce courrier est déjà archivé');
    }

        Archive::create([
            'date_archivage' => Carbon::now(),
            'emplacement' => 'Armoire A', 
            'courrier_id' => $courrier->id_courrier,
            'user_id' => Auth::id(),
        ]);

           $courrier->update([
        'statut' => 'Archivé',
    ]);
    

    return redirect()->route('archive')->with('success', 'Courrier archivé avec succès');
    }
public function restore(Courrier $courrier)
{
    $archive = Archive::where('courrier_id', $courrier->id_courrier)->first();

    if (!$archive) {
        return redirect()->back()->with('error', 'Ce courrier n\'est pas archivé');
    }

    $archive->delete();

    $courrier->update([
        'statut' => 'En cours',
    ]);

    return redirect()->route('courrier')->with('success', 'Courrier restauré avec succès');
}
}