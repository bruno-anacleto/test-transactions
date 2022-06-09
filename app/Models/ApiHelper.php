<?php

namespace App\Models;

use App\Mail\SubscriptionSuccessMail;
use Illuminate\Database\Eloquent\Model;

abstract class ApiHelper extends Model
{
    const externalServiceNotificationApi = "http://o4d9z.mocklab.io/notify";
    const externalAuthorizerApi = "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6";

    public static function curlWrapper($endpoint,$method='GET'){

        $curl = curl_init();
        $certificate_location = "/usr/local/openssl-0.9.8/certs/cacert.pem";
        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST=>$certificate_location,
            CURLOPT_SSL_VERIFYPEER=>$certificate_location,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    public static function verifyNotifyService(){
        $status=self::curlWrapper(self::externalServiceNotificationApi);

        if($status->message=='Success'){
            return true;
        }else{
            return false;
        }
    }

    public static function verifyTransferAuthorizeService(){
        $status=self::curlWrapper(self::externalAuthorizerApi);

        if($status->message=='Autorizado'){
            return true;
        }else{
            return false;
        }
    }
}
