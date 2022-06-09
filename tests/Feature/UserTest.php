<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_type_1_fisico()
    {
        $this->faker = Factory::create('pt_BR');

        $userPayload = [
                'full_name' => $this->faker->name,
                'email' => $this->faker->email,
                'document_number' => $this->faker->cpf(),
                'type'=>1,
                'password' => '##123456789##',
            ];

        $response = $this->post('api/user',$userPayload);

        $response->assertStatus(200);

    }

    public function test_create_user_type_2_juridico()
    {
        $this->faker = Factory::create('pt_BR');
        $value=$this->faker->randomFloat(2, 0, 100);

        $userPayload = [
            'full_name' => $this->faker->name,
            'email' => $this->faker->email,
            'document_number' => preg_replace("/[^0-9]/", "", $this->faker->cnpj()),
            'type'=>2,
            'password' => '##123456789##',
        ];

        $response = $this->post('api/user',$userPayload);

        $response->assertStatus(200);

    }

    public function test_create_user__unique_email_error(){

        $this->artisan('db:seed', ['--class' => 'UserSeeder']);

        $this->faker = Factory::create('pt_BR');

        $userPayload = [
            'full_name' => $this->faker->name,
            'email' => 'nyfornaziero@gmail.com',
            'document_number' => $this->faker->cpf(),
            'type'=>1,
            'password' => '##123456789##',
        ];

        $response = $this->post('api/user',$userPayload);

        $response->assertStatus(302);
    }

    public function test_create_user__unique_document_number_error(){

        $this->artisan('db:seed', ['--class' => 'UserSeeder']);

        $this->faker = Factory::create('pt_BR');

        $userPayload = [
            'full_name' => $this->faker->name,
            'email' => $this->faker->email,
            'document_number' => 34600721802,
            'type'=>1,
            'password' => '##123456789##',
        ];

        $response = $this->post('api/user',$userPayload);

        $response->assertStatus(302);
    }
}
