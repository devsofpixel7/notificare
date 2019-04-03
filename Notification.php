<?php

namespace Devsofpixel7\Notificared;

use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\DocBlock\Tags\Generic;
use Devsofpixel7\Notificared\Handler as Handler;

class Notification {

    /**
     * Send test notification via Notification.
     *
     * @return Response
     */
    public function send($message, $receiver, $type)
    {
        return (new Handler)->sendNotification($receiver, $message, $type);
    }
}