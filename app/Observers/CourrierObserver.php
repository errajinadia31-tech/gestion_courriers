<?php

namespace App\Observers;

use App\Models\Courrier;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class CourrierObserver
{
    
    public function created(Courrier $courrier)
    {
        Mail::to('erraji.nadia.31@gmail.com') ->send(new WelcomeMail($courrier));
    }
}