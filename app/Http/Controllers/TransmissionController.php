<?php

namespace App\Http\Controllers;

use App\Models\Transmission;
use Illuminate\Http\Request;

class TransmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // القائمة ديال كل الـ transmissions
    public function list()
    {
        $transmissions = Transmission::with(['courrier', 'expediteur', 'destinataire'])
            ->latest()
            ->paginate(10);

        return view('transmissions.list', compact('transmissions'));
    }

    // إنشاء transmission جديد
    public function store(Request $request)
    {
        $data = $request->validate([
            'courrier_id' => 'required|exists:courriers,id_courrier',
            'expediteur_id' => 'required|exists:users,id',
            'destinataire_id' => 'required|exists:users,id',
            'date_transmission' => 'required|date',
            'commentaire' => 'nullable|string',
        ]);

        Transmission::create($data);

        return redirect()->route('transmissions.list')->with('success', 'Transmission créée avec succès!');
    }

    // حذف transmission
    public function destroy(Transmission $transmission)
    {
        $transmission->delete();
        return back()->with('success', 'Transmission supprimée!');
    }
}