<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Mail\Error;
use App\Models\SendMail;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendErrorMail($user, $exception){
        $mail = new SendMail;
        $mail->user_logged = $user;
        $mail->error = $exception;
        Mail::to('gsistemas@globomatik.com')->send(new Error($mail));
    }
}
