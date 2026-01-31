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

echo "City ID: " . $bienhoa->id . "\n";
echo "Spec ID: " . $timmach->id . "\n";

echo "--- Check Raw Record ---\n";
$d = DoctorProfile::find(1);
echo "Doctor 1: Appr={$d->is_approved}, City={$d->city_id}, Spec={$d->specialization_id}, UserID={$d->user_id}\n";
$d->is_approved = 1;
$d->save();
echo "Forced Approval.\n";

echo "--- Run Search Query Logic ---\n";
$query = DoctorProfile::query()
    ->join('users', 'doctor_profiles.user_id', '=', 'users.id')
    ->where('doctor_profiles.is_approved', true) // or 1
    ->where('doctor_profiles.city_id', $bienhoa->id)
    ->where('doctor_profiles.specialization_id', $timmach->id)
    ->select('doctor_profiles.*');

$results = $query->get();
echo "Query Results Count: " . $results->count() . "\n";

if ($results->count() == 0) {
    echo "Query failed. Printing SQL:\n";
    echo $query->toSql() . "\n";
    echo "Bindings: " . json_encode($query->getBindings()) . "\n";
} else {
    echo "Success! Found {$results->first()->id}\n";
}
