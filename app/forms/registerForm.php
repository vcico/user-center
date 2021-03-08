<?php


namespace app\forms;


use app\application;
use app\form;
use Respect\Validation\Rules;

class registerForm extends form
{

    static public function getRules()
    {
        $rule = new Rules\AllOf(
            new Rules\Alnum(),
            new Rules\NoWhitespace(),
            new Rules\Length(1, 15)
        );
        return [
            'username' => $rule,
            'password' => $rule,
            'passwordRepeat' => $rule,
        ];
    }

    // 保存注册信息
    public function save(){
        echo "注册保存\n";
        application::trigger(\app\events\registerAfter::class, $this);
    }

}