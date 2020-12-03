<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loja;

class LojasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Loja::create([
            'nome_fantasia_loja' => 'Carefour',
            'link_loja' => 'https://mercado.carrefour.com.br/'
        ]);

        Loja::create([
            'nome_fantasia_loja' => 'Telhanorte',
            'link_loja' => 'https://www.telhanorte.com.br/'
        ]);

        Loja::create([
            'nome_fantasia_loja' => 'Leroy Merlin',
            'link_loja' => 'https://www.leroymerlin.com.br/'
        ]);

        Loja::create([
            'nome_fantasia_loja' => 'Pão de Açucar',
            'link_loja' => 'https://www.paodeacucar.com/'
        ]);

        Loja::create([
            'nome_fantasia_loja' => 'C&C',
            'link_loja' => 'https://www.cec.com.br/'
        ]);

        Loja::create([
            'nome_fantasia_loja' => 'Americanas',
            'link_loja' => 'https://www.americanas.com.br/'
        ]);

        Loja::create([
            'nome_fantasia_loja' => 'C&A',
            'link_loja' => 'https://www.cea.com.br/'
        ]);
    }
}
