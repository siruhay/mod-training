<?php

namespace ModuleTraining\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->call('module:migrate', ['module' => 'Training']);
        
        $this->call(TrainingBaseSeeder::class);
        $this->call(TrainingDataSeeder::class);
        $this->call(TrainingUserSeeder::class);
    }
}
