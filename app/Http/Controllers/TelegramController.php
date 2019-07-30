<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function telegram()
    {
        ini_set('max_execution_time', 30);

        return Telegram::getMe();
    }
}
