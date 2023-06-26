<?php
namespace Uzzzer2pac\GenerateLog;

interface GLogInterface
{
    public function make($type, $message, $data, $exception, $request, $response);
}