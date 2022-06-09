<?php

namespace App\Models;

use App\Mail\TransferNotifySuccesMail;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

abstract class NotifyHelper extends Model
{
    public function sendTransferNotification($userSender=null,$userReceiver=null,$transfer=null){
        try{
            Mail::to($userSender->email)->send(new TransferNotifySuccesMail($userSender,$userReceiver,$transfer));
        }catch (Exception $e){
            dd($e->getMessage());
        }

    }
}
