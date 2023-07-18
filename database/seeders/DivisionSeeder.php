<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Division::truncate();
        $data = [
            ['name' => 'Keuangan'],
            ['name' => 'House Keeping'],
            ['name' => 'Poli'],
            ['name' => 'PO dan Asset'],
            ['name' => 'E O'],
            ['name' => 'HRD'],
            ['name' => 'Security'],
            ['name' => 'Produksi'],
        ];

        foreach ($data as $d) {
            Division::create($d);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
