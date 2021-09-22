<?php

namespace Database\Factories;

use App\Models\Rekening;
use Illuminate\Database\Eloquent\Factories\Factory;

class RekeningFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rekening::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'jenis_id' => 1,
            'user_id' => 21,
            'nama_akun' => $this->faker->name(),
            'nama_bank' => null,
            'saldo_sekarang' => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
            'saldo_mengendap' => null,
            'keterangan' => $this->faker->text(50),
        ];
    }
}
