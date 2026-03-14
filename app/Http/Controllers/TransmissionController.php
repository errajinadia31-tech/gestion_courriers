<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transmission;
use App\Models\Courrier;
use App\Models\User;

class TransmissionController extends Controller
{
    public function index()
    {
        $transmissions = Transmission::latest()->paginate(10);
        return view('transmissions.index', compact('transmissions'));
    }

    public function create()
    {
        $courriers = Courrier::all();
        $users = User::all();
        return view('transmissions.create', compact('courriers', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'courrier_id' => 'required|exists:courriers,id',
            'to_user_id' => 'required|exists:users,id',
        ]);

        Transmission::create([
            'courrier_id' => $request->courrier_id,
            'from_user_id' => auth()->id(),
            'to_user_id' => $request->to_user_id,
            'status' => 'en cours',
        ]);

        return redirect()->route('transmissions.index')->with('success', 'Transmission créée!');
    }
}