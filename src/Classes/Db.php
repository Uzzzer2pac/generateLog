<?php

namespace Uzzzer2pac\GenerateLog\Classes;

use Illuminate\Support\Facades\Session as FacadesSession;
use Uzzzer2pac\GenerateLog\GLogInterface;
use Uzzzer2pac\GenerateLog\Logging;

class Db implements GLogInterface
{
    function make($type, $message, $data, $exception, $request, $response)
    {

        $backtrace = debug_backtrace();
        Logging::create([
            'type' => $type,
            'url' => url()->current(),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'file_parent' => $backtrace[3]['class'],
            'file' => $backtrace[2]['class'],
            'line' => $backtrace[1]['line'],
            'function' => $backtrace[2]['function'],
            'username' => FacadesSession::get('username'),
            'msg' => $message,
            'data' => $data,
            'request_body' => $request,
            'response' => $response,
            'exception' => $exception
        ]);
    }
}
