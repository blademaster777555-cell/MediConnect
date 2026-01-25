<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Specialization;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    /**
     * API endpoint để lấy danh sách thành phố cho combobox
     */
    public function cities(): JsonResponse
    {
        $cities = City::select('id', 'name')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $cities
        ]);
    }

    /**
     * API endpoint để lấy danh sách chuyên khoa cho combobox
     */
    public function specializations(): JsonResponse
    {
        $specializations = Specialization::select('id', 'name', 'description')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $specializations
        ]);
    }

    /**
     * API endpoint để lấy cả cities và specializations cùng lúc
     */
    public function comboboxData(): JsonResponse
    {
        $cities = City::select('id', 'name')->orderBy('name')->get();
        $specializations = Specialization::select('id', 'name', 'description')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'cities' => $cities,
                'specializations' => $specializations
            ]
        ]);
    }
    /**
     * Get available time slots for a doctor on a specific date
     */
    public function getDoctorAvailability(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctor_profiles,id',
            'date' => 'required|date',
        ]);

        $date = $request->date;
        $doctorId = $request->doctor_id;

        // Get Doctor's Schedule for the Date
        $availability = \App\Models\DoctorAvailability::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->first();

        // If no schedule or explicitly set as not available
        if (!$availability || !$availability->is_available) {
            return response()->json([
                'available' => false,
                'slots' => [],
                'message' => 'Bác sĩ không làm việc vào ngày này.'
            ]);
        }

        // Generate Slots
        $slots = [];
        $startTime = \Carbon\Carbon::parse($availability->start_time);
        $endTime = \Carbon\Carbon::parse($availability->end_time);
        
        // duration of each slot in minutes
        $slotDuration = 30; 

        while ($startTime->addMinutes($slotDuration)->lte($endTime)) {
            // Reset to start of slot
            $startTime->subMinutes($slotDuration);
            
            $timeString = $startTime->format('H:i:00');
            
            // Format display based on locale
            if (app()->getLocale() == 'en') {
                $startFormat = $startTime->format('h:i A');
                $endFormat = $startTime->copy()->addMinutes($slotDuration)->format('h:i A');
            } else {
                $startFormat = $startTime->format('H:i');
                $endFormat = $startTime->copy()->addMinutes($slotDuration)->format('H:i');
            }
            
            $displayTime = $startFormat . ' - ' . $endFormat;

            // Check if booked
            $isBooked = \App\Models\Appointment::where('doctor_id', $doctorId)
                ->where('date', $date)
                ->where('time', $timeString)
                ->whereIn('status', ['pending', 'confirmed', 'completed'])
                ->exists();

            $slots[] = [
                'time' => $timeString,
                'display' => $displayTime,
                'is_booked' => $isBooked
            ];

            $startTime->addMinutes($slotDuration);
        }

        return response()->json([
            'available' => true,
            'slots' => $slots
        ]);
    }
}