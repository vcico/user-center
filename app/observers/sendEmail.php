<?php


namespace app\observers;


use app\event;
use app\observer;

class sendEmail extends observer
{
    public function handle(event $event)
    {
        // $event->formTest->email
        echo "发送邮箱\n";
    }
}