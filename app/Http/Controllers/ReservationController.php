<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Reservations;
use App\Events\ReservationCreated;

class ReservationController extends Controller
{
    public function create(): View
    {
        return view('reservations.create');
    }

    public function store(Request $request)
    {
        $reservation = Reservations::create([
            'user_id' => auth()->id(),
            'res_no' => Str::random(8),
            'res_name' => $request->res_name,
            'res_count' => $request->res_count,
            'res_date' => $request->res_date,
            'res_time' => $request->res_time,
            'res_phone' => $request->res_phone,
            'res_email' => $request->res_email,
            'res_notes' => $request->res_notes,
        ]);

        // Get the count of reservations with "Received" status
        $receivedCount = Reservations::where('res_status', 'Received')->count();

        // Broadcast the ReservationCreated event along with the count
        event(new ReservationCreated($reservation, $receivedCount));

        return redirect()->back()->with('success', 'Reservation created successfully.');
    }
}
