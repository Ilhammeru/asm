<?php

namespace Database\Seeders;

use App\Models\ItemCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ItemCategory::truncate();
        $data = [
            ['name' => 'ATK'],
            ['name' => 'Alat Kebersihan'],
            ['name' => 'Alat Perawatan'],
            ['name' => 'Seragam kerja'],
            ['name' => 'Alat kesehatan'],
            ['name' => 'Asset'],
            ['name' => 'Alat bengkel'],
            ['name' => 'Permintaan produksi'],
            ['name' => 'Elektronik'],
            ['name' => 'Lain - lain'],
        ];

        foreach ($data as $d) {
            ItemCategory::create($d);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
