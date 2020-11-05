<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CausasSociais;

class CausasSociaisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CausasSociais::create([
            'nome_causa_social' => 'Auxílio a desabrigados'
        ]);

        CausasSociais::create([
            'nome_causa_social' => 'Auxílio a crianças'
        ]);

        CausasSociais::create([
            'nome_causa_social' => 'Cuidados a deficientes fisícos'
        ]);

        CausasSociais::create([
            'nome_causa_social' => 'Auxílio a idosos'
        ]);
    }
}
