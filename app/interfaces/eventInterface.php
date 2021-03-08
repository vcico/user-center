<?php


namespace app\interfaces;

use app\event;
use app\form;
use app\observer;


interface eventInterface
{
    public function register(observer $observer);
    public function setForm(form $form);
    public function dispatch();
}