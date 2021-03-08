<?php

namespace app;
use app\exceptions\formItemException;
use app\exceptions\formUndefinedMessage;
use app\interfaces\formInterface;
use Illuminate\Database\Eloquent\Model;
use Google\Protobuf\Internal\Message;


abstract class form implements formInterface {

    protected $message;

    protected $rules;

    public $error;

    public function __construct()
    {
        $this->rules = $this::getRules();
    }

    abstract static public function getRules();

    public function setMessage(Message $message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param array $data
     * @throw Respect\Validation\Exceptions\ValidationException
     */
    public function load(array $data)
    {
        foreach($this->rules as $key => $rule){
            if(array_key_exists($key,$data)){
                $rule->check($data[$key]);
                call_user_func([$this->message,'set'.ucfirst($key)],$data[$key]);
            }
        }
    }

    public function loadModel(Model $model)
    {
        // TODO: Implement loadModel() method.
    }

    public function __get($key){
        $this->checkMessage();
        if (!array_key_exists($key,$this->rules)){
            throw new formItemException("item attribute {$key} is not exist");
        }
        return call_user_func([$this->message,'get'.ucfirst($key)]);
    }

    public function __set($name, $value)
    {
        $this->checkMessage();
        if (!array_key_exists($name,$this->rules)){
            throw new formItemException("item attribute {$name} is not exist");
        }
        call_user_func([$this->message,'set'.ucfirst($name)],$value);
    }

    protected function checkMessage(){
        if(!$this->message){
            throw new formUndefinedMessage('undefined message');
        }
    }

    public function __isset($key){
        return array_key_exists($key,$this->rules);
    }

    public function verify(){
        foreach ($this->rules as $key => $rule){
            try{
                $rule->check( call_user_func([$this->message,'get'.ucfirst($key)]) );
            }catch(\Exception $e){
                $this->error = $e;
                return false;
            }
        }
        return true;
    }

}
