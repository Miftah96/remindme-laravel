<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class Response
{
    public static function success($data, $code = 200)
    {
        $response = [

            'ok'    => true,
            'data'  => $data
        ];

        return response($response, $code);
    }

    public static function custome($data, $code = 200)
    {
        $response = [

            'ok'    => true,
            'data'  => [
                "id"    => $data->id,
                "title" => $data->title,
                "description"   => $data->description,
                "remind_at"     => $data->remind_at,
                "event_at"      => $data->event_at
            ]
        ];

        return response($response, $code);
    }

    public static function delete($code = 202)
    {
        $response = [
            'ok' => true,
        ];

        return response($response, $code);
    }

    public static function internalServerError()
    {
        $response = [
            "status"    => 500,
            "err"       => "ERR_INTERNAL_ERROR",
            "msg"       => "unable to connect into database"
        ];

        return response($response);
    }
}
