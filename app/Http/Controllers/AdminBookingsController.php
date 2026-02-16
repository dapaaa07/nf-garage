<?php

namespace App\Http\Controllers;

use App\Models\BookingModel;
use Illuminate\Http\Request;

class AdminBookingsController extends Controller
{
    public function index()
    {
        $bookings = BookingModel::with('user')->latest()->paginate(12);
        return view('admin.bookings', compact('bookings'));
    }

    public function show(BookingModel $booking)
    {
        $booking->load('user');
        return view('admin.booking_show', compact('booking'));
    }

    public function confirm(BookingModel $booking)
    {
        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->route('admin.booking')->with('success', 'Booking berhasil dikonfirmasi!');
    }
    public function cancel(BookingModel $booking)
    {
        $booking->status = 'cancelled';

        $booking->save();

        return redirect()->route('admin.booking')->with('success', 'Booking telah dibatalkan.');
    }
}
