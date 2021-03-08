<?php


use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;


// 注册ORM
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '192.168.1.6',
    'database' => 'user_center',
    'username' => 'root',
    'password' => '123456',
    'charset' => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix' => '',
]);
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();


if (!function_exists('enBase64URL')) {
    function enBase64URL($str)
    {
        $result = base64_encode($str);
        return str_replace(array('+', '/', '='), array('-', '_', ''), $result);
    }
}

if (!function_exists('deBase64URL')) {
    function deBase64URL($str)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $str);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}

if (!function_exists('create_container')) {
    /**
     * 创建容器 并注入类/实例
     * 此容器和 laravel 容器 实现/使用方法一致
     * @return \Illuminate\Container\Container
     */
    function create_container()
    {
        $container = new \Illuminate\Container\Container();

        $jwt = new \Vcico\jwt();
        $container->instance('jwt', $jwt);
        return $container;
    }
}





