<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $importFile = database_path('production_import.sql');
        
        if (File::exists($importFile)) {
            $this->command->info('Running production_import.sql migration...');
            DB::unprepared(file_get_contents($importFile));
            $this->command->info('Import finished.');
        } else {
            $this->call([
                AdminSeeder::class,
                ProfilDesaSeeder::class,
                VisiMisiSeeder::class,
                StrukturOrganisasiSeeder::class,
                DummyDataSeeder::class,
            ]);
        }
    }
}
