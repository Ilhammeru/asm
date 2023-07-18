<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        $keuangan = Division::select('id')
            ->where('name', 'Keuangan')
            ->first();
        $hrd = Division::select('id')
            ->where('name', 'HRD')
            ->first();

        $data = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'division_id' => $keuangan->id,
            ],
            [
                'name' => 'Warehouse',
                'email' => 'warehouse@gmail.com',
                'password' => Hash::make('password'),
                'division_id' => $keuangan->id,
            ],
            [
                'name' => 'hrd',
                'email' => 'hrd@gmail.com',
                'password' => Hash::make('password'),
                'division_id' => $hrd->id,
            ],
        ];
        foreach ($data as $d) {
            User::create($d);
        }
    }
}
