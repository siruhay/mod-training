<?php

namespace ModuleTraining\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Module\Training\Imports\DataImport;

class TrainingDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $path = base_path(
            'modules' . DIRECTORY_SEPARATOR .
                'training' . DIRECTORY_SEPARATOR .
                'database' . DIRECTORY_SEPARATOR .
                'masters' . DIRECTORY_SEPARATOR .
                'data-seeder.xlsx'
        );

        if (File::exists($path)) {
            Excel::import(new DataImport($this->command), $path);
        }
    }
}
