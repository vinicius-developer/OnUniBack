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
            'nome_causa_social' => 'Auxílio a desabrigados'
        ]);

        CausaSocial::create([
            'nome_causa_social' => 'Auxílio a crianças'
        ]);

        CausaSocial::create([
            'nome_causa_social' => 'Cuidados a deficientes fisícos'
        ]);

        CausaSocial::create([
            'nome_causa_social' => 'Auxílio a idosos'
        ]);
    }
}
