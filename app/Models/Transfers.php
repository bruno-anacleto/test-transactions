<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Transfers extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sender_user_id',
        'receiver_user_id',
        'transferred_value',
        'old_sender_balance',
        'old_receiver_balance',
    ];


    protected $hidden = [
        'id',
        'old_sender_balance',
        'old_receiver_balance',
        'created_at',
        'updated_at',
    ];

    public static function makeTransfer($userSender,$userReceiver,$transferred_value=0){
        DB::beginTransaction();

        try{
            $transaction= new Transfers();
            $transaction->sender_user_id=$userSender->id;
            $transaction->receiver_user_id=$userReceiver->id;
            $transaction->transferred_value=$transferred_value;
            $transaction->old_sender_balance=$userSender->account_balance;
            $transaction->old_receiver_balance=$userReceiver->account_balance;
            $transaction->save();

            $userSender->account_balance=$userSender->account_balance-$transferred_value;

            $userReceiver->account_balance=$userReceiver->account_balance+$transferred_value;
            $userSender->save();
            $userReceiver->save();


            if(ApiHelper::verifyTransferAuthorizeService()){
                DB::commit();
            }else{
                DB::rollBack();
            }

            if(ApiHelper::verifyNotifyService()){
                NotifyHelper::sendTransferNotification($userSender,$userReceiver,$transferred_value);
            }

            return response($transaction,200);

        }catch (Exception $e){
            DB::rollBack();
            return response($e,500);
        }
    }

}
