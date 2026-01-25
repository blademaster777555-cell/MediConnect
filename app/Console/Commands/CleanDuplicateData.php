<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;
use App\Models\Specialization;

class CleanDuplicateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:clean-duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove duplicate cities and specializations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Cleaning duplicate cities...');

        // Xóa cities trùng lặp, giữ lại record có id nhỏ nhất
        $duplicates = City::select('name')
            ->groupBy('name')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            $cities = City::where('name', $duplicate->name)->orderBy('id')->get();
            // Giữ lại city đầu tiên, xóa các city còn lại
            for ($i = 1; $i < $cities->count(); $i++) {
                $cities[$i]->delete();
                $this->line("Deleted duplicate city: {$duplicate->name} (ID: {$cities[$i]->id})");
            }
        }

        $this->info('Cleaning duplicate specializations...');

        // Xóa specializations trùng lặp
        $duplicates = Specialization::select('name')
            ->groupBy('name')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            $specs = Specialization::where('name', $duplicate->name)->orderBy('id')->get();
            // Giữ lại specialization đầu tiên, xóa các specialization còn lại
            for ($i = 1; $i < $specs->count(); $i++) {
                $specs[$i]->delete();
                $this->line("Deleted duplicate specialization: {$duplicate->name} (ID: {$specs[$i]->id})");
            }
        }

        $this->info('Duplicate data cleanup completed!');
        $this->info('Cities remaining: ' . City::count());
        $this->info('Specializations remaining: ' . Specialization::count());
    }
}
