<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Courrier;
use App\Models\User;
use Illuminate\Http\Request;
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
    $query = Courrier::query();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('reference', 'LIKE', "%$search%")
              ->orWhere('objet', 'LIKE', "%$search%")
              ->orWhere('expediteur', 'LIKE', "%$search%")
              ->orWhere('destinataire_externe', 'LIKE', "%$search%");
        });
    }

    $courriers = $query->latest('id_courrier')->paginate(10);

    return view('courrier', compact('courriers'));
}
  
    public function ajouter()
    {
        $users = User::all();

        $lastRef = Courrier::latest('id_courrier')->value('reference');

        if ($lastRef) {
            preg_match('/\d+$/', $lastRef, $matches);
            $lastNumber = isset($matches[0]) ? (int)$matches[0] : 0;
            $number = $lastNumber + 1;
        } else {
            $number = 1;
        }

        $nextRef = 'N°' . $number;

        return view('ajouter', compact('users', 'nextRef'));
    }

   public function show(Courrier $courrier)
    {
        return view('show', compact('courrier'));
    }
  public function store(Request $request)
{
    $data = $request->validate([
        'reference'            => 'required|string|max:255|unique:courriers,reference',
        'objet'                => 'required|string|max:255',
        'type'                 => 'required|in:arrivee,depart',
        'date'                 => 'required|date',
        'statut'               => 'required|in:En cours,Traité,Archivé',
        'type_document'        => 'nullable|string',
        'expediteur'           => 'nullable|string',
        'destinataire_externe' => 'nullable|string',
        'mode_envoi'           => 'nullable|in:email,poste',
        'user_id'              => 'nullable|exists:users,id',
        'file'                 => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'emplacement'          => 'nullable|string', // optional for archive
    ]);

    if ($request->hasFile('file')) {
        $data['file'] = $request->file('file')->store('courriers', 'public');
    }

    $data['user_id'] = $data['user_id'] ?? Auth::id();


    if ($data['type'] === 'arrivee') {
        $data['destinataire_externe'] = null;
        $data['mode_envoi'] = null;
    } elseif ($data['type'] === 'depart') {
        $data['expediteur'] = null;
    }

 
    $courrier = Courrier::create($data);

    if ($data['statut'] === 'Archivé') {
        Archive::create([
            'date_archivage' => now(),
            'emplacement'    => $data['emplacement'] ?? 'Armoire A',
            'courrier_id'    => $courrier->id_courrier,
            'user_id'        => auth()->id(),
        ]);
    }

    return redirect()->route('courrier')->with('success', 'Courrier créé avec succès');
}


        
        public function destroy($id)
        {
            $courrier = Courrier::findOrFail($id);
            
            if ($courrier->file) {
                Storage::disk('public')->delete($courrier->file);
                }
                
                $courrier->delete();
                
                return redirect()->back()->with('success', 'Courrier supprimé avec succès');
}
    public function archive(Courrier $courrier)
    {
        if (Archive::where('courrier_id', $courrier->id_courrier)->exists()) {
            return redirect()->back()->with('error', 'Ce courrier est déjà archivé');
        }

        Archive::create([
            'date_archivage' => Carbon::now(),
            'emplacement'    => 'Armoire A',
            'courrier_id'    => $courrier->id_courrier,
            'user_id'        => Auth::id(),
        ]);

        $courrier->update(['statut' => 'Archivé']);
        

        return redirect()->route('archive')->with('success', 'Courrier archivé avec succès');
    }

    public function edit($id)
    {
        $courrier = Courrier::findOrFail($id);
        $users = User::all();
        return view('edit_courrier', compact('courrier', 'users'));
    }

  
public function update(Request $request, $id)
{
    $courrier = Courrier::findOrFail($id);

    $data = $request->validate([
        'reference'            => 'required|string|max:255|unique:courriers,reference,'.$id.',id_courrier',
        'objet'                => 'required|string|max:255',
        'type'                 => 'required|in:arrivee,depart',
        'date'                 => 'required|date',
        'statut'               => 'required|in:En cours,Traité,Archivé',
        'type_document'        => 'nullable|string',
        'expediteur'           => 'nullable|string',
        'destinataire_externe' => 'nullable|string',
        'mode_envoi'           => 'nullable|in:email,poste',
        'user_id'              => 'nullable|exists:users,id',
        'file'                 => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
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

    return redirect()->route('courrier')->with('success', 'Courrier mis à jour');
}
    public function restore(Courrier $courrier)
    {
        $archive = Archive::where('courrier_id', $courrier->id_courrier)->first();

        if (!$archive) {
            return redirect()->back()->with('error', 'Ce courrier n\'est pas archivé');
        }

        $archive->delete();

        $courrier->update(['statut' => 'En cours']);

        return redirect()->route('courrier')->with('success', 'Courrier restauré avec succès');
    }
}