<?php

namespace Database\Factories;

use App\Models\Ong;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RegisterOngFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ong::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_ongs' => md5(uniqid(rand(), true)),
            'id_causas_sociais' => rand(1, 9),
            'cnpj' => Str::random(16),
            'nome_fantasia' => $this->faker->company,
            'razao_social' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt(Str::random(16)),
            'descricao_ong' => $this->faker->text,
            'img_perfil' => 'pothoPerfilOng/photoOng.png',
            'status' => 'false'
        ];
    }
}
