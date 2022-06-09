<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_type_2_cant_transfer_money()
    {

        $this->faker = Factory::create();
        $value=$this->faker->randomFloat(2, 0, 100);

        $payer=User::create([
            'full_name'=>'Nykolas Fornaziero dos Santos',
            'email'=>'nyfornaziero@gmail.com',
            'document_number'=>34600721802,
            'type'=>'jurídica',
            'password'=>'##123456789@@'
        ]);

        $payee=User::create([
            'full_name'=>'Janaina Magalhães Flor',
            'email'=>'janaina.magalhães@gmail.com',
            'document_number' => 86409352034,
            'type'=>'física',
            'password'=>'##123456789@@'
        ]);

        $payload = [
            'sender_user_id' => $payer->id,
            'receiver_user_id' => $payee->id,
            'transferred_value' => $value
        ];
        $response = $this->post('api/transfer',$payload);

        $response->assertStatus(401);
    }

    public function test_user_send_money_to_self()
    {
        $this->faker = Factory::create();
        $value=$this->faker->randomFloat(2, 0, 100);

        $payer=User::create([
            'full_name'=>'Nykolas Fornaziero dos Santos',
            'email'=>'nyfornaziero@gmail.com',
            'document_number'=>34600721802,
            'type'=>'jurídica',
            'password'=>'##123456789@@'
        ]);

        $payload = [
            'sender_user_id' => $payer->id,
            'receiver_user_id' => $payer->id,
            'transferred_value' => $value
        ];
        $response = $this->post('api/transfer',$payload);

        $response->assertStatus(422);
    }

    public function test_user_check_account_balance_to_transfer()
    {
        $this->faker = Factory::create();
        $value=$this->faker->randomFloat(2, 0, 100);

        $payer=User::create([
            'full_name'=>'Nykolas Fornaziero dos Santos',
            'email'=>'nyfornaziero@gmail.com',
            'document_number'=>34600721802,
            'type'=>'física',
            'password'=>'##123456789@@'
        ]);

        $payee=User::create([
            'full_name'=>'Janaina Magalhães Flor',
            'email'=>'janaina.magalhães@gmail.com',
            'document_number' => 86409352034,
            'type'=>'jurídica',
            'password'=>'##123456789@@'
        ]);

        $payload = [
            'sender_user_id' => $payer->id,
            'receiver_user_id' => $payee->id,
            'transferred_value' => $value
        ];
        $response = $this->post('api/transfer',$payload);

        $response->assertStatus(401);
    }

    public function test_user_type_1_make_a_transfer_to_user_type_1(){
        $this->faker = Factory::create();
        $value=$this->faker->randomFloat(2, 0, 1000);
        $account_balance=$this->faker->randomFloat(2, 1000, 2000);

        $payer=User::create([
            'full_name'=>'Nykolas Fornaziero dos Santos',
            'email'=>'nyfornaziero@gmail.com',
            'document_number'=>34600721802,
            'account_balance' => $account_balance,
            'type'=>'física',
            'password'=>'##123456789@@'
        ]);

        $payee=User::create([
            'full_name'=>'Janaina Magalhães Flor',
            'email'=>'janaina.magalhães@gmail.com',
            'document_number' => 86409352034,
            'account_balance' => $account_balance,
            'type'=>'física',
            'password'=>'##123456789@@'
        ]);

        $payload = [
            'sender_user_id' => $payer->id,
            'receiver_user_id' => $payee->id,
            'transferred_value' => $value
        ];
        $response = $this->post('api/transfer',$payload);

        $response->assertStatus(200);
    }

    public function test_user_type_1_make_a_transfer_to_user_type_2(){
        $this->faker = Factory::create();
        $value=$this->faker->randomFloat(2, 0, 1000);
        $account_balance=$this->faker->randomFloat(2, 1000, 2000);

        $payer=User::create([
            'full_name'=>'Nykolas Fornaziero dos Santos',
            'email'=>'nyfornaziero@gmail.com',
            'document_number'=>34600721802,
            'account_balance' => $account_balance,
            'type'=>'física',
            'password'=>'##123456789@@'
        ]);

        $payee=User::create([
            'full_name'=>'Janaina Magalhães Flor',
            'email'=>'janaina.magalhães@gmail.com',
            'document_number' => 86409352034,
            'account_balance' => $account_balance,
            'type'=>'jurídica',
            'password'=>'##123456789@@'
        ]);

        $payload = [
            'sender_user_id' => $payer->id,
            'receiver_user_id' => $payee->id,
            'transferred_value' => $value
        ];
        $response = $this->post('api/transfer',$payload);

        $response->assertStatus(200);
    }

}
