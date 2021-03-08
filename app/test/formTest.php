<?php


namespace app\test;


use app\exceptions\formUndefinedMessage;
use app\forms\registerForm;
use Google\RegisterRequest;
use PHPUnit\Framework\TestCase;

class formTest extends TestCase
{
    public function testMessage(){
        $message = new RegisterRequest();
        $r = new registerForm();
        $r->setMessage($message);
        $this->assertInstanceOf(RegisterRequest::class, $r->getMessage());
    }

    public function testGetAttr(){
        $message = new RegisterRequest();
        $message->setUsername('admin');
        $r = new registerForm();
        $r->setMessage($message);
        $this->assertEquals('admin',$r->username);
    }

    public function testSetAttr(){
        $message = new RegisterRequest();
        $r = new registerForm();
        $r->setMessage($message);
        $r->username = 'admin';
        $this->assertEquals('admin',$r->username);
    }

    public function testUndefineMessage(){
        $this->expectException(formUndefinedMessage::class);
        $r = new registerForm();
        $r->username = 'admin';
        $this->assertEquals('admin',$r->username);
    }

    public function testLoad(){
        $message = new RegisterRequest();
        $r = new registerForm();
        $r->setMessage($message);
        $this->expectException(\Respect\Validation\Exceptions\ValidationException::class);  // load 不符合规则的数据 报错
        $r->load([
            'username' => 'admin',
            'password' => '123 456',
        ]);
        $this->assertEquals('admin',$r->username);
        $this->assertEquals('123456',$r->password);
        //$a = $r->getMessage();
        //fwrite(STDOUT, "---{$a->getPassword()}---");
    }

    public function testVerify(){
        $message = new RegisterRequest();
        $message->setUsername('admin');
        $message->setPassword('123456');
        $message->setPasswordRepeat('123 456');
        $r = new registerForm();
        $r->setMessage($message);
        //$this->assertTrue($r->verify());
        $r->verify();
        $this->assertInstanceOf(\Respect\Validation\Exceptions\ValidationException::class, $r->error);
        fwrite(STDOUT, "##{$r->error}##");
    }



}