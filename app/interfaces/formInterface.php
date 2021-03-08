<?php

namespace  app\interfaces;
use Illuminate\Database\Eloquent\Model;
use Google\Protobuf\Internal\Message;

interface formInterface{
    public static function getRules();
    public function getMessage();
    public function setMessage(Message $message);
    public function load(array $data);
    public function loadModel(Model $model);
    public function verify();
}