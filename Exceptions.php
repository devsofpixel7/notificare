<?php

namespace Devsofpixel7\Notificare;

use Exception;

class Exceptions
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];


    /**
     * Render a push exception response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public static function pushException($response)
    {
        return response()->json(
            [
                'error' => [
                    'message' => $response
                ]
            ], 422);
    }

}
