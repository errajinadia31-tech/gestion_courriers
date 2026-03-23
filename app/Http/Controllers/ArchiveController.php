<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archive;
use App\Models\Courrier;

class ArchiveController extends Controller
{
    public function archive()
    {
        $archives = Archive::latest()->paginate(10);
        return view('archive', compact('archives'));
    }

    public function store(Courrier $courrier)
    {
        Archive::create([
            'courrier_id' => $courrier->id,
            'archived_by' => auth()->id(),
            'date_archivage' => now(),
            'emplacement' => 'Archive centrale',
        ]);

        return back()->with('success', 'Courrier archivé!');
    }

}