<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail as MailWelcomeMail;
use App\Models\Courrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use WelcomeMail;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $courrier = Courrier::latest()->first(); 

    Mail::to('erraji.nadia.31@gmail.com')->send(new MailWelcomeMail($courrier));

    return 'Email sent successfully';
}
}
