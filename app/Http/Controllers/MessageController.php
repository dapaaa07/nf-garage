<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageModel;

class MessageController extends Controller
{
    public function index() {
        $chat = MessageModel::paginate(10);
        return view('message', compact('chat'));
    }
}
