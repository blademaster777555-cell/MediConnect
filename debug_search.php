<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DoctorProfile;
use App\Models\City;
use App\Models\Specialization;

$bienhoa = City::where('name', 'like', '%Bien Hoa%')->first();
$timmach = Specialization::where('name', 'like', '%Tim mach%')->first();

echo "City: " . ($bienhoa ? $bienhoa->id . ' - ' . $bienhoa->name : 'Not Found') . "\n";
echo "Spec: " . ($timmach ? $timmach->id . ' - ' . $timmach->name : 'Not Found') . "\n";

if ($bienhoa && $timmach) {
    echo "Checking Doctors with City ID {$bienhoa->id} and Spec ID {$timmach->id}...\n";
    $doctors = DoctorProfile::where('city_id', $bienhoa->id)
                ->where('specialization_id', $timmach->id)
                ->get();
    echo "Found " . $doctors->count() . " doctors based on doctor_profiles.city_id.\n";
    foreach($doctors as $d) {
        echo " - Doctor ID: {$d->id}, User ID: {$d->user_id}, Approved: {$d->is_approved}\n";
    }

    echo "Checking Doctors with User City ID {$bienhoa->id}...\n";
    $doctorsUser = DoctorProfile::join('users', 'doctor_profiles.user_id', '=', 'users.id')
                    ->where('users.city_id', $bienhoa->id)
                    ->where('doctor_profiles.specialization_id', $timmach->id)
                    ->select('doctor_profiles.id', 'users.city_id as user_city_id')
                    ->get();
    echo "Found " . $doctorsUser->count() . " doctors based on users.city_id.\n";
     foreach($doctorsUser as $d) {
        echo " - Doctor ID: {$d->id}, User City ID: {$d->user_city_id}\n";
    }
}
