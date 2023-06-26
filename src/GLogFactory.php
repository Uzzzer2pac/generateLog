<?php
namespace Uzzzer2pac\GenerateLog;

use Uzzzer2pac\GenerateLog\Classes\Db;
use Uzzzer2pac\GenerateLog\Classes\DbAndStorage;
use Uzzzer2pac\GenerateLog\Classes\Storage;

class GLogFactory
{
    protected $state_active;

    public function __construct()
    {
        $this->state_active = config('GLog.state_active');
    }

    public function create($type, $message, $data, $exception, $request, $response)
    {
        $log_type = config("GLog.log_type_active.{$type}");

        if ($log_type || $this->state_active === 'db') {
            $strategy = $this->getStrategy();
            $strategy->make($type, $message, $data, $exception, $request, $response);
        }
    }

    protected function getStrategy()
    {
        switch ($this->state_active) {
            case 'db':
                return new db();
            case 'storage':
                return new storage();
            case 'dbAndStorage':
                return new dbAndStorage();
            default:
                throw new InvalidArgumentException("Invalid state_active value: {$this->state_active}");
        }
    }
}