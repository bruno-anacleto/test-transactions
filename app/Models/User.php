<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'document_number',
        'account_balance',
        'type',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password){
        $this->attributes['password']= Hash::make($password);
    }

    public function setDocumentNumberAttribute($document_number){
        $this->attributes['document_number']=preg_replace("/[^0-9]/", "", $document_number);
    }

    public function checkUserTypeTransfer(){
        if($this->type=='jurídica'){
            return 0;
        }else{
            return 1;
        }
    }

    public function checkBalance($valueToCheck){
        if($this->attributes['account_balance']>$valueToCheck){
            return true;
        }else{
            return false;
        }
    }

}
