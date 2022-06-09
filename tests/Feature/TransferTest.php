<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function transaction_()
    {
        $response = $this->get('api/transfer');

        $response->assertStatus(200);

        $payer=User::create([
            'full_name'=>'Nykolas Fornaziero dos Santos',
            'document_number'=>34600721802,
            'type'=>'física',
            'password'=>'##123456789@@'
        ]);

        $payee=User::create([
            'full_name'=>'Janaina Magalhães Flor',
            'document_number' => 86409352034,
            'type'=>'jurídica',
            'password'=>'##123456789@@'
        ]);
    }
}
