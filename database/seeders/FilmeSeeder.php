<?php

namespace Database\Seeders;

use App\Models\Filme;
use Illuminate\Database\Seeder;

class FilmeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Filme::create([
            'nome' => 'Vingadores'
        ]);
    }
}
