<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    // index
    public function index()
    {
        $user = Auth::user();
        // schedule where orderby date asc
        $schedule = Schedule::where('user_id', $user->id)->orderBy('date', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $schedule
        ], 200);
    }

    public function getScheduleByDate()
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login
        $today = Carbon::today(); // Mendapatkan tanggal hari ini

        $schedule = Schedule::where('user_id', $user->id) // Filter berdasarkan user ID
            ->whereDate('date', $today) // Filter berdasarkan tanggal hari ini
            ->orderBy('date', 'asc') // Urutkan berdasarkan tanggal secara ascending
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $schedule,
        ], 200);
    }
}
