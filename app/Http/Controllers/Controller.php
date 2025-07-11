<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    function a()
    {
        config("mail.mailers.smtp.username");
    }
}
