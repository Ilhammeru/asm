<?php

namespace Database\Seeders;

use App\Models\ItemUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ItemUnit::truncate();
        $data = [
            ['name' => 'Pcs'],
            ['name' => 'Pack'],
            ['name' => 'Pasang'],
            ['name' => 'Liter'],
            ['name' => 'Rim'],
            ['name' => 'Unit'],
            ['name' => 'Strip'],
        ];

        foreach ($data as $d) {
            ItemUnit::create($d);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
