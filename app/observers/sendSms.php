<?php


namespace app\observers;


use app\event;
use app\observer;

class sendSms extends observer
{

    public function handle(event $event)
    {
        // TODO: Implement handle() method.
        echo "发送短信\n";
    }
}