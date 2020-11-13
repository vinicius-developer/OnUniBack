<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genero;

class GenerosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genero::create([
            'nome_generos' => 'Feminino',
        ]);

        Genero::create([
            'nome_generos' => 'Masculino',
        ]);

        Genero::create([
            'nome_generos' => 'Não Binário',
        ]);

        Genero::create([
            'nome_generos' => 'Outros',
        ]);

        Genero::create([
            'nome_generos' => 'Prefiro não dizer',
        ]);
    }
}
