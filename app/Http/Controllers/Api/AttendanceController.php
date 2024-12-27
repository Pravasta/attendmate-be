<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    //store
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'note' => 'nullable|max:255',
        ]);

        $user = Auth::user();
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $note = $request->note;

        // Mengecek apakah pengguna sudah check-in hari ini
        $attendanceToday = Attendance::where('user_id', $user->id)
            ->whereDate('check_in', Carbon::today()) // Mengecek apakah ada check-in di hari ini
            ->exists();

        if ($attendanceToday) {
            return response()->json([
                'success' => false,
                'message' => 'You have already checked in today.',
            ], 400); // Status code 400 untuk request yang tidak valid
        }

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'check_in' => now(),
            'check_out' => null,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'note' => $note ?? null,
            'status' => 'Present',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance recorded successfully',
            'data' => $attendance
        ], 201);
    }

    // check out
    public function update(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'note' => 'nullable|max:255',
        ]);

        $user = Auth::user();
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $note = $request->note;

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('check_in', Carbon::today()) // Tetap gunakan filter berdasarkan tanggal
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'You have not checked in today',
                'data' => null,
            ], 404);
        }

        // Mengecek apakah pengguna sudah check-in hari ini
        $attendanceToday = Attendance::where('user_id', $user->id)
            ->whereDate('check_out', Carbon::today()) // Mengecek apakah ada check-in di hari ini
            ->exists();

        if ($attendanceToday) {
            return response()->json([
                'success' => false,
                'message' => 'You have already checked out today.',
            ], 400); // Status code 400 untuk request yang tidak valid
        }

        $attendance->update([
            'check_out' => now()->format('Y-m-d H:i:s'), // Gunakan timestamp sekarang
            'latitude' => $latitude,
            'longitude' => $longitude,
            'note' => ($note == null || $note == "") ? $attendance->note : $note,
            'status' => 'Present',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance updated successfully',
            'data' => $attendance
        ]);
    }

    public function checkCheckInToday()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mencari data attendance berdasarkan user_id dan tanggal check_in hari ini
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('check_in', Carbon::today()) // Memfilter dengan tanggal hari ini
            ->first();

        // Jika attendance ditemukan, berarti sudah check-in
        if ($attendance) {
            return response()->json([
                'success' => true,
                'message' => 'You have already checked in today.',
                'data' => $attendance
            ]);
        }

        // Jika tidak ditemukan, berarti belum check-in
        return response()->json([
            'success' => false,
            'message' => 'You have not checked in today.',
            'data' => null,
        ], 404);
    }

    public function getAllAttendanceHistory()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mengambil seluruh data attendance untuk user yang login, diurutkan berdasarkan check_in
        $attendanceHistory = Attendance::where('user_id', $user->id)
            ->orderBy('check_in', 'desc') // Menyortir berdasarkan check_in secara menurun (terbaru di atas)
            ->get();

        // Mengecek apakah data attendance ditemukan
        if ($attendanceHistory->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No attendance history found.',
                'data' => null,
            ], 404);
        }

        // Mengembalikan response dengan data attendance history
        return response()->json([
            'success' => true,
            'message' => 'Attendance history retrieved successfully.',
            'data' => $attendanceHistory,
        ]);
    }
}
