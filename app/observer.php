<?php


namespace app;


abstract class observer
{
    abstract public function handle(event $event);
}