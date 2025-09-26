<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $lista=[
        //     ['identificationtype_id'=>'1', 'nroidenti'=>'12345678', 'password'=>Hash::make("1234"), 'nombres'=>'Jolhfred', 'apellido_pa'=>'Alania', 'apellido_ma'=>'Chalan', 'fecnac'=>'1990-01-01', 'correo'=>'correo1@gmail.com', 'telefono' => '987654321', 'celular' => '987654321', 'direccion' => 'Carabayllo', 'estado' => '1', 'ubigeo_id' => "090101", 'genre_id' => '1', 'usertype_id' => "1"],
        //     ['identificationtype_id'=>'1', 'nroidenti'=>'99999991', 'password'=>Hash::make("1234"), 'nombres'=>'Jefferson', 'apellido_pa'=>'Huaman', 'apellido_ma'=>'Perez', 'fecnac'=>'1990-01-01', 'correo'=>'correo2@gmail.com', 'telefono' => '987654322', 'celular' => '987654322', 'direccion' => 'Carabayllo', 'estado' => '1', 'ubigeo_id' => "090101", 'genre_id' => '1', 'usertype_id' => "2"],
        //     ['identificationtype_id'=>'1', 'nroidenti'=>'99999992', 'password'=>Hash::make("1234"), 'nombres'=>'Henry', 'apellido_pa'=>'Torero', 'apellido_ma'=>'Ramirez', 'fecnac'=>'1990-01-01', 'correo'=>'correo3@gmail.com', 'telefono' => '987654323', 'celular' => '987654323', 'direccion' => 'Carabayllo', 'estado' => '1', 'ubigeo_id' => "090101", 'genre_id' => '1', 'usertype_id' => "3"],
        //     ['identificationtype_id'=>'1', 'nroidenti'=>'99999993', 'password'=>Hash::make("1234"), 'nombres'=>'Clever', 'apellido_pa'=>'Bravo', 'apellido_ma'=>'Ayala', 'fecnac'=>'1990-01-01', 'correo'=>'correo4@gmail.com', 'telefono' => '987654324', 'celular' => '987654324', 'direccion' => 'Carabayllo', 'estado' => '1', 'ubigeo_id' => "090101", 'genre_id' => '1', 'usertype_id' => "4"],
        //     ['identificationtype_id'=>'1', 'nroidenti'=>'99999994', 'password'=>Hash::make("1234"), 'nombres'=>'Lionel', 'apellido_pa'=>'Perez', 'apellido_ma'=>'Berrospi', 'fecnac'=>'1990-01-01', 'correo'=>'correo5@gmail.com', 'telefono' => '987654325', 'celular' => '987654555', 'direccion' => 'Carabayllo', 'estado' => '1', 'ubigeo_id' => "090101", 'genre_id' => '1', 'usertype_id' => "5"],
        //     ['identificationtype_id'=>'1', 'nroidenti'=>'99999995', 'password'=>Hash::make("1234"), 'nombres'=>'Pierina', 'apellido_pa'=>'Ruesta', 'apellido_ma'=>'Henriquez', 'fecnac'=>'1990-01-01', 'correo'=>'correo6@gmail.com', 'telefono' => '987654326', 'celular' => '987654326', 'direccion' => 'Carabayllo', 'estado' => '1', 'ubigeo_id' => "090101", 'genre_id' => '2', 'usertype_id' => "6"],
        //     ['identificationtype_id'=>'1', 'nroidenti'=>'99999996', 'password'=>Hash::make("1234"), 'nombres'=>'Juan', 'apellido_pa'=>'Pantoja', 'apellido_ma'=>'Rojas', 'fecnac'=>'1990-01-01', 'correo'=>'correo7@gmail.com', 'telefono' => '987654327', 'celular' => '987654327', 'direccion' => 'Carabayllo', 'estado' => '1', 'ubigeo_id' => "090101", 'genre_id' => '1', 'usertype_id' => "7"],
        //     ];

        // $user = $this->faker->unique()->randomElement($lista);

        // return $user;

        return
        [
            'identificationtype_id' => "1",
            // 'nroidenti' => "8765000" . $this->faker->unique()->numberBetween(1, 7),
            'nroidenti' => "12345678",
            'password' => Hash::make("1234"),
            'nombres' => $this->faker->unique()->firstname,
            'apellido_pa' => $this->faker->unique()->lastName,
            'apellido_ma' => $this->faker->unique()->lastName,
            'fecnac' => $this->faker->dateTimeBetween('1990-01-01', '2005-12-31')->format('Y-m-d'),
            'correo' => $this->faker->unique()->safeEmail,
            'telefono' => $this->faker->phoneNumber,
            'celular' => $this->faker->phoneNumber,
            'direccion' => $this->faker->city,
            'estado' => "1",
            'ubigeo_id' => "090101",
            'genre_id' => '1',
            // 'usertype_id' => $this->faker->randomElement(["1", "2", "3", "4", "5", "6", "7"])
            'usertype_id' => "1"
        ];
    }
}
