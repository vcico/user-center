<?php


namespace app;


use app\interfaces\eventInterface;

abstract class event implements eventInterface
{

    protected $observers;
    public $form;

    public function __construct()
    {
        $this->observers = [];
    }

    public function register(observer $observer)
    {
        // TODO: Implement register() method.
        $this->observers[] = $observer;
    }

    public function setForm(form $form){
        $this->form = $form;
    }


    public function dispatch(){
        foreach($this->observers as $observer){
            $observer->handle($this);
        }
    }

}