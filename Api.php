<?php

namespace Devsofpixel7\Notificares;

use Devsofpixel7\Notificare\Exceptions as Exception;
use JsonSerializable;

class Api {

    static $notificareAppKey;
    static $notificareAppSecret;
    static $notificareMasterSecret;
    static $notificareApiUrl;

    public function __construct()
    {
        self::$notificareAppKey = env('NOTIFICARE_APP_KEY');
        self::$notificareAppSecret = env('NOTIFICARE_APP_SECRET');
        self::$notificareMasterSecret = env('NOTIFICARE_MASTER_SECRET');
        self::$notificareApiUrl = 'https://push.notifica.re/';
    }


    /**
     * @param $method
     * @param $url
     * @param $request
     * @param $message
     * @return array
     */
    public function request($method, $url, $request, $message)
    {

        $curl = curl_init();

        // send notification to user
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_USERPWD, self::$notificareAppKey . ':' . self::$notificareMasterSecret);

        curl_setopt($curl, CURLOPT_HTTPGET, TRUE);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
        curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);

        $pushResponse = curl_exec($curl);
        $pushError= curl_error($curl);
        curl_close($curl);


        if ($pushResponse){

            $pushResponseMessagesAll = preg_split('/{(.*)}/', $pushResponse, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            $pushResponseMessage = '{'.str_replace('true','', print_r($pushResponseMessagesAll[1], true)).'}';
            $pushResponseMessageRow = preg_split ('/,/', $pushResponseMessage);
            $responseData = preg_split ('/:/', $pushResponseMessageRow[0]);

            return Handler::extendedResponse('Push notification sent.','notification' ,
                ['id'  => json_decode($responseData[1]),
                 'text' => $message
                ]);

        }
        else
        {
            return Exception::pushException($pushError);
        }


    }

}