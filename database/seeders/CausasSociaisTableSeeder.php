<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CausaSocial;

class CausasSociaisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CausaSocial::create([
            'nome_causa_social' => 'Proteção Ambiental'
        ]);

        CausaSocial::create([
            'nome_causa_social' => 'Educação Infantil'
        ]);

        CausaSocial::create([
            'nome_causa_social' => 'Tratamento Médico'
        ]);

        CausaSocial::create([
            'nome_causa_social' => 'Proteção Animal'
        ]);

        CausaSocial::create([
            'nome_causa_social' => 'Casa Solidária'
        ]);

        CausaSocial::create([
            'nome_causa_social' => 'Refugiados'
        ]);

        CausaSocial::create([
            'nome_causa_social' => 'Doação de Alimento'
        ]);

        CausaSocial::create([
            'nome_causa_social' => 'Violência Doméstica'
        ]);

        CausaSocial::create([
            'nome_causa_social' => 'Outros'
        ]);
    }
}
