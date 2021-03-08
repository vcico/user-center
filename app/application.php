<?php

namespace app;
use app\exceptions\eventNotExistException;

class application{

    const CONFIG_PATH = "app/config.php";
    public static $config;
    public static $events;
    public static $container;

    public function __construct()
    {
        if (is_file($this::CONFIG_PATH)){
            $this::$config = include_once $this::CONFIG_PATH;
        }else{
            throw new \Exception("load config fail");
        }
        self::$events = [];
        self::$container = create_container();
    }

    public static function trigger($eventName,form $form){
        if( ! array_key_exists($eventName,self::$events)){
            if(!array_key_exists($eventName,self::$config['events'])){
                throw new eventNotExistException('event is not exist: '.$eventName);
            }
            $event = new $eventName;
            foreach(self::$config['events'][$eventName] as $observer){
                $event->register(new $observer);
            }
            self::$events[$eventName] = $event;
        }
        self::$events[$eventName]->setForm($form);
        self::$events[$eventName]->dispatch();
    }

}
