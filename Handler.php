<?php

namespace Devsofpixel7\Notificare;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class Handler {

    protected $notificareAppKey;
    protected $notificareAppSecret;
    protected $notificareMasterSecret;
    protected $notificareApiUrl;



    public function __construct()
    {
        $this->notificareAppKey = env('NOTIFICARE_APP_KEY');
        $this->notificareAppSecret = env('NOTIFICARE_APP_SECRET');
        $this->notificareMasterSecret = env('NOTIFICARE_MASTER_SECRET');
        $this->notificareApiUrl = 'https://push.notifica.re/';

    }



    /**
     * @param IEjabberdCommand $command
     * @return null|\Psr\Http\Message\StreamInterface
     */
    public function sendNotification($receiver, $message, $type)
    {

        $apiUrlSuffix = 'notification/user/';
        $request['type'] = 're.notifica.notification.None';
        $request['ttl'] = 3600;
        $request['sound'] = 'default';
        $request['content'][0]['type'] = 're.notifica.content.Text';
        $request['content'][0]['data'] = 'test push message.';
        $request['message'] = $message;
        $request['extra']['action'] = 'textmessage';
        $request['extra']['message'] = $message;
        $url = $this->notificareApiUrl . $apiUrlSuffix . urlencode($receiver);

        return (new Api)->request('GET', $url, $request, $message);

    }



    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public static function noContentResponse($response)
    {

        return response()->json(
            [
                'no_content' => [
                    'data' => $response,
                ]
            ]);

    }

    /**
     * Render a regular response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public static function regularResponse($response)
    {

        return response()->json(
            [
                'data' => $response
            ]);

    }

    /**
     * Render an extended response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public static function extendedResponse($msgResponse, $notifKey, $notifResponse)
    {

        return response()->json(
            [
                'data' => [
                    'message' => $msgResponse,
                    $notifKey => $notifResponse
                ]

            ]);

    }


}