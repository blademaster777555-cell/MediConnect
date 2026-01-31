<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new column
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->text('certificates')->nullable()->after('certificate');
        });
        
        // Migrate data
        $profiles = DB::table('doctor_profiles')->whereNotNull('certificate')->get();
        foreach ($profiles as $profile) {
            if (!empty($profile->certificate)) {
                 // Assume it's a single file path string, wrap in array
                $data = json_encode([$profile->certificate]);
                DB::table('doctor_profiles')->where('id', $profile->id)->update(['certificates' => $data]);
            }
        }
        
        // Drop old column
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->dropColumn('certificate');
        });

        // Rename new column to old name
        Schema::table('doctor_profiles', function (Blueprint $table) {
             $table->renameColumn('certificates', 'certificate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add old string column
        Schema::table('doctor_profiles', function (Blueprint $table) {
             $table->string('certificate_temp')->nullable();
        });

        // Migrate first item back
        $profiles = DB::table('doctor_profiles')->whereNotNull('certificate')->get();
        foreach ($profiles as $profile) {
            $decoded = json_decode($profile->certificate, true);
            if (is_array($decoded) && count($decoded) > 0) {
                 DB::table('doctor_profiles')->where('id', $profile->id)->update(['certificate_temp' => $decoded[0]]);
            }
        }

        // Drop array column
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->dropColumn('certificate');
        });
        
        // Rename back
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->renameColumn('certificate_temp', 'certificate');
        });
    }
};
