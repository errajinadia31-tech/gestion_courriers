<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archive;
use App\Models\Courrier;

class ArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Liste des archives
    public function index()
    {
        $archives = Archive::with('courrier', 'user')->latest()->get();
        return view('archive', compact('archives'));
    }

    // Archiver un courrier
    public function archive(Courrier $courrier)
    {
        if (Archive::where('courrier_id', $courrier->id_courrier)->exists()) {
            return redirect()->back()->with('error', 'Ce courrier est déjà archivé');
        }

        Archive::create([
            'courrier_id' => $courrier->id_courrier,
            'user_id' => auth()->id(),
            'date_archivage' => now(),
            'emplacement' => 'Armoire A',
        ]);

        $courrier->update(['statut' => 'Archivé']);

        return redirect()->route('archive')->with('success', 'Courrier archivé avec succès');
    }

        public function restore(Courrier $courrier)
    {
        $archive = Archive::where('courrier_id', $courrier->id_courrier)->first();

        if (! $archive) {
            return redirect()->back()->with('error', 'Ce courrier n\'est pas archivé');
        }

        $archive->delete();

        $courrier->update(['statut' => 'En cours']);

        return redirect()->route('courrier')->with('success', 'Courrier restauré avec succès');
    }
    // Supprimer une archive
    public function destroy($id)
    {
        $archive = Archive::findOrFail($id);
        $courrier = $archive->courrier; 

        $archive->delete();

        if($courrier) {
            $courrier->update(['statut' => 'En cours']);
        }

        return redirect()->route('archive')->with('success', 'Archive supprimée avec succès.');
    }
}