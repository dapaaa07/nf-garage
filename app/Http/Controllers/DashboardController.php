<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageModel;
use App\Models\BookingModel;

class DashboardController extends Controller
{
    public function index()
    {
        $chat = MessageModel::all();
        $totalMessages = MessageModel::count();
        $bookings = BookingModel::count();
        return view('dashboard', compact('chat', 'totalMessages', 'bookings'));
    }
}
