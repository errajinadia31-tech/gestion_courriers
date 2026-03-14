<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Courrier;
use App\Models\Transmission;
use App\Models\Archive;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $users = User::count();
        $courriersDepart = Courrier::where('type', 'Sortant')->count();
        $courriersArrives = Courrier::where('type', 'Entrant')->count();
        $transmissions = Transmission::count();
        $archives = Archive::count();

        // Last 5 courriers
        $lastCourriers = Courrier::latest()->take(5)->get();

        // Send all data to the dashboard view
        return view('dashboard', compact(
            'users',
            'courriersDepart',
            'courriersArrives',
            'transmissions',
            'archives',
            'lastCourriers'
        ));
    }
}