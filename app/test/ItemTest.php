<?php

// require "../../vendor/autoload.php";

use app\exceptions\itemException;
use PHPUnit\Framework\TestCase;
use app\item;
use Respect\Validation\Rules\AbstractRule;
use Respect\Validation\Rules;


class ItemTest extends TestCase{
/*
        public function testItemInit(){
            $validator = new Rules\AllOf(
                new Rules\Alnum(),
                new Rules\NoWhitespace(),
                new Rules\Length(1, 15)
            );
            $value = "gsfdghsdgh";
            $item = new item($validator, $value );
            $this->assertInstanceOf(AbstractRule::class, $item->getValidator());
            $this->assertEquals($value,$item->getValue());
        }

        public function testItemValue(){
            $item = new item();
            $value = "gsdgsert";
            $item->setValue($value);
            $this->assertEquals($value,$item->getValue());
        }

        public function testItemValidator(){
            $item = new item();
//            $validator = new Rules\AllOf(
//                new Rules\Alnum(),
//                new Rules\NoWhitespace(),
//                new Rules\Length(1, 15)
//            );
            //$item->setValidator();
            //$this->assertInstanceOf(AbstractRule::class, $item->getValidator());
            $this->assertNull($item->getValidator());
        }

        public function testItemVerifySuccess(){
            $validator = new Rules\Length(1, 15);
            $item = new item($validator,"1234243");
            $this->assertTrue($item->verify());
        }
        */

        public function testItemVerifyFail(){
            $validator = new Rules\AllOf(
                new Rules\Alnum(),
                new Rules\NoWhitespace(),
                new Rules\Length(1, 15)
            );
//            $item = new item($validator,"中 agdggfrtetrqtqrqwergaggsdgfsg");
//            $this->expectException(\Respect\Validation\Exceptions\ValidationException::class);
//            $this->assertNull($item->verify());

            //$item = new item($validator);
            //$this->expectException(itemException::class);
            //$this->expectExceptionCode(2);
            //$item->verify();

            $item = new item();
            //$this->expectException(itemException::class);
            $this->expectExceptionCode(1);
            $item->verify();
        }

}