<?php

namespace Devsofpixel7\Notificare;

use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\DocBlock\Tags\Generic;
use GuzzleHttp\Middleware;
use GuzzleHttp\Client;

class NotificareController extends Controller
{

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
     * Send test notification via Notification.
     *
     * @return Response
     */
    public static function sendNotification($message, $receiver)
    {


        $type = 'generic';
        $title = $message;


        //function sendNotification($email, $type = 'message', $title = '', $message = '', $extra = array()) {

        $dataObject = array(
            'type' => 're.notifica.notification.None',
            'ttl' => 3600,
            'sound' => 'default',
            'content' => array(array(
                'type' => 're.notifica.content.Text'
            ))
        );

        switch ($type) {
            /*
            case 'link':
                $dataObject['message'] = $title;
                $dataObject['content'][0]['data'] = $message;
                $dataObject['extra'] = array(
                    'action' => 'communications',
                    'message' => $message,
                    'url' => $message
                );
                break;
            */
            case 'generic':
                $dataObject['message'] = $title;
                $dataObject['content'][0]['data'] = $title;
                $dataObject['extra'] = array(
                    'action' => 'textmessage',
                    'message' => $message
                );
                break;
                /*
            case 'update':
                $dataObject['message'] = 'Please update RSA application';
                $dataObject['content'][0]['data'] = 'Please update RSA application';
                $dataObject['extra'] = array(
                    'action' => 'sysmessage'
                );
                break;
                */

                /*
            default:
                $dataObject['message'] = $title;
                $dataObject['content'][0]['data'] = $message;
                if (count($extra) > 0) {
                    $dataObject['extra'] = $extra;
                } else {
                    $dataObject['extra'] = array(
                        'action' => $type,
                        'message' => $message
                    );
                }
                */
        }


        print_r ($dataObject);


        // getting to api


/*
        Array
    (
    [type] => re.notifica.notification.None
    [ttl] => 3600
    [sound] => default
    [content] => Array
        (
            [0] => Array
                (
                    [type] => re.notifica.content.Text
                    [data] => test push message.
                )

        )

    [message] => test push message.
    [extra] => Array
        (
            [action] => textmessage
            [message] => test push message.
        )

   )
*/





        ///////////////////////////////////////////////
        // own request object

        $request['type'] = 're.notifica.notification.None';
        $request['ttl'] = 3600;
        $request['sound'] = 'default';
        $request['content'][0]['type'] = 're.notifica.content.Text';
        $request['content'][0]['data'] = 'test push message.';
        $request['message'] = 'default';
        $request['extra']['action'] = 'textmessage';
        $request['extra']['message'] = 'test push message.';

        // end own
        ///////////////////////////////////////////////


        ///////////////////////////////////////////////
        // own request object2
        /*
        $dataObject['message'] = $title;
        $dataObject['content'][0]['data'] = $title;
        $dataObject['extra'] = array(
            'action' => 'textmessage',
            'message' => $message
        );
        */
        // end own2
        ///////////////////////////////////////////////

        //+------------------------------------------------------------------------------------------------------------------------------+//

        $curl = curl_init();

        // send notification to user
        curl_setopt($curl, CURLOPT_URL, 'https://push.notifica.re/notification/user/' . urlencode($receiver));

        // check notifications
        //curl_setopt($curl, CURLOPT_URL, 'https://push.notifica.re/notification/user/'.urlencode($email).'limit=10&skip=0');

        // search users
        //curl_setopt($curl, CURLOPT_URL, 'https://push.notifica.re/user/'.'hkot'.'/search?limit=10&skip=0');

        // get user info
        //curl_setopt($curl, CURLOPT_URL, 'https://push.notifica.re/user/foruserid/112233');

        // get api status
        //curl_setopt($curl, CURLOPT_URL, 'https://push.notifica.re/status');
        //curl_setopt($curl, CURLOPT_URL, 'https://push.notifica.re/status' . '$qry_str = "?x=10&y=20";');


        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_USERPWD, self::$notificareAppKey . ':' . self::$notificareMasterSecret);


        // POST
        //curl_setopt($curl, CURLOPT_POST, TRUE);
        //curl_setopt($curl, CURLOPT_POST, FALSE);

        // GET
        curl_setopt($curl, CURLOPT_HTTPGET, TRUE);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
        curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);


        //print_r (json_encode($dataObject));
        print_r (json_encode($request));



        $callResult = curl_exec($curl);
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($callResult)
            return array('message' => (print_r($callResult)));
        else
            return array('result' => false, 'reason' => $curlError);


        //+------------------------------------------------------------------------------------------------------------------------------+//



        // via API




        /*

        $client = new \GuzzleHttp\Client(['defaults' => [
            'verify' => false
        ]]);

        */

        /*
        $request = $client->get('http://myexample.com');
        $response = $request->getBody();
        dd($response);
        */

        /*

        try {

            /*
            // Create a request with auth credentials
            $request = $client->post('https://push.notifica.re/notification/user/' . urlencode($receiver),
                [
                    'auth'=>[self::$notificareAppKey,self::$notificareMasterSecret],
                    'form_params'=>json_encode($request)
                ]);
            // Get the actual response without headers
            $res = $request->getBody();
            */


            /*

            $res = $client->request('POST', 'https://push.notifica.re/notification/user/' . urlencode($receiver), [
                'headers' => [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'auth' => [self::$notificareAppKey, self::$notificareMasterSecret],
                'json' => $request

            ]);

            */



            /*

            // Grab the client's handler instance.
            $clientHandler = $client->getConfig('handler');
            // Create a middleware that echoes parts of the request.
            $tapMiddleware = Middleware::tap(function ($request) {
                echo $request->getHeaderLine('Content-Type');
                // application/json
                echo $request->getBody();
                // {"foo":"bar"}
            });

            $res = $client->request('POST', 'https://push.notifica.re/notification/user/' . urlencode($receiver), [
                //'json'    => ['foo' => 'bar'],
                'json'    => $request,
                'auth'    => [self::$notificareAppKey, self::$notificareMasterSecret],
                'handler' => $tapMiddleware($clientHandler)
            ]);


            */


            /*
            $client->request('POST', '', [
                'headers' => [
                    //'Authorization' => 'Bearer 905290532905902390523905krai20',
                    'Content-Type' => 'application/json'
                ]
            ]);
            */


            /*
            $res = $client->request('POST', 'https://push.notifica.re/notification/user/' . urlencode($receiver),
                [
                'auth' => [self::$notificareAppKey, self::$notificareMasterSecret],
                'headers' => [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json'
                ],

                //'json' => json_encode($request)
                'form_params' => $request
                ]);

                */

            /*


            //return \Ejabberd\Handler::regularResponse(json_decode($res->getBody(), JSON_PRETTY_PRINT));
            print_r (json_encode($res));


        } catch (ClientException $e) {

            /*
            if ($this->debug=='true') {
                Log::info("Error occurred while executing the command " . $command . ", on url:".$url.".");
            }
            */

            //return \Ejabberd\Handler::noContentResponse(json_decode($e->getResponse()->getBody(true)));
            /*
            return json_decode($e->getResponse()->getBody(true));


        }
            */



       //$client->request('POST', 'http://whatever', ['body' => $request]);

        /*
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://push.notifica.re/notification/user/',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
        */







        //print_r (json_encode($response));



/*

        $request['type'] = 're.notifica.notification.None';
        $request['ttl'] = 3600;
        $request['sound'] = 'default';
        $request['content'][0]['type'] = 're.notifica.content.Text';
        $request['content'][0]['data'] = 'test push message.';
        $request['message'] = 'default';
        $request['extra'][0]['action'] = 'textmessage';
        $request['extra'][0]['message'] = 'test push message.';


        print_r (json_encode($request));

        $url = self::$notificareApiUrl.'/notification/user/'.urlencode($receiver);
        return  (new Api)->request('POST', $url, $request);
*/



    }
}