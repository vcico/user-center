<?php


namespace app\interfaces;


use app\event;

interface observerIterface
{
    public function handle(event $event);
}