<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class Response
{
    public static function successWithLimit($data, $limit = '')
    {
        $response = [

            "ok"    => true,
            "data"  => [
                "reminders" => $data,
                "limit"     => $limit
            ]
            
        ];

        return response($response);
    }

    public static function success($data, $code = 200)
    {
        $response = [

            "ok"    => true,
            "data"  => $data
        ];

        return response($response, $code);
    }

    public static function custome($data, $code = 200)
    {
        $response = [

            "ok"    => true,
            "data"  => [
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
            "ok" => true,
        ];

        return response($response, $code);
    }

    public static function unauthorized () {
        $response = [
            "ok"    => false,
            "err"   => "ERR_INVALID_ACCESS_TOKEN",
            "msg"   => "invalid access token"
        ];

        return response($response, 401);
    }

    public static function errNotFound($code = 404)
    {
        $response = [
            "ok"    => false,
            "err"   => "ERR_NOT_FOUND",
            "msg"   => "resource is not found"
        ];

        return response($response, $code);
    }

    public static function internalServerError($code = 500)
    {
        $response = [
            "status"    => 500,
            "err"       => "ERR_INTERNAL_ERROR",
            "msg"       => "unable to connect into database"
        ];

        return response($response, $code);
    }
}
