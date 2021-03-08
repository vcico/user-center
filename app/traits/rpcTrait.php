<?php


namespace app\traits;


const PACK = 'N';
const PACK_LEN = 4;

use Google\Protobuf\Internal\Message;
use Google\Response;
use RpcException\mergeException;
use RpcException\missParamException;
use app\exceptions\undefinedServicesException;
use app\service;
use app\exceptions\ClassMatchException;
use Google\Request;
use RpcException\RpcBaseException;
use RpcException\serviceNotExistException;
use Google\Protobuf\Any;

trait rpcTrait
{


    protected $server;
    protected $servicesMap;

    public function Register(array $services){
        foreach($services as $service){
            try {
                $z = new \ReflectionClass($service);
            }catch (\ReflectionException $e){
                throw $e;
            }
            if (!$z->isSubclassOf(service::class)){
                throw new ClassMatchException('service class is not  extends BaseService: '.$service);
            }
            //todo 如果有参数
            $this->servicesMap[$z->getShortName()] =  $z->newInstance();
        }
    }

    public function run()
    {
        if(!$this->servicesMap){
            throw new undefinedServicesException('not register rpc service');
        }
        $this->server = new Swoole\Server(self::$config['rpcHost'], self::$config['rpcPort']);
        $this->server->set(array(
            'worker_num' => self::$config['worker_num'],
            'open_length_check' => true,
            'package_max_length' => 81920,
            'package_length_type' => PACK, //see php pack()
            'package_length_offset' => 0,
            'package_body_offset' => PACK_LEN,
        ));
        $this->server->on('WorkerStart', $this->workerStart);
        $this->server->on('Receive', $this->receive);
        $this->server->on('Close', $this->close);
        $this->server->on('Connect',$this->connect);
        $this->server->start();
    }


    protected function workerStart($server, $worker_id)
    {

    }

    protected function connect($server, $fd)
    {

    }

    protected function receive($server, $fd, $from_id, $data)
    {
        try{
            $request = $this->_request($data);
            if(!array_key_exists($request->getController(),$this->servicesMap)){
                throw new serviceNotExistException('service not exist');
            }
            $result = call_user_func([$this->servicesMap[$request->getController()],$request->getMethod()] , $request->getReq() );
        }catch (RpcBaseException $e){
            // $server->send($fd, );
        }
    }



    protected function close($server, $fd)
    {
        echo "Client: Close.\n";
    }

    protected function throwRpcException(string $className, RpcBaseException $e){
        $resp = new Response();
        $resp->setSuccess(false);
        $any = new Any();
        $any->pack( (new \Google\ResultException())->setClassName($className) );
        $resp->setResult($any);
        $resp->setInfo($e->getMessage());
        return $this->_packResponse($resp);
    }

    protected function _request(&$data){
        $request = new Request();
        try {
            $request->mergeFromString($data);
        }catch (\Exception $e){
            throw  new mergeException('protobuf merge fail');
        }
        if($request->hasReq()){
            throw new missParamException('Missing parameter');
        }
        return $request;
    }

    protected function _ResponseString(Message $result){
        $resp = new Response();
        $resp->setSuccess(true);
        $any = new Any();
        $any->pack($result);
        $resp->setResult($any);
        return $this->_packResponse($resp);
    }

    protected function _packResponse(Response $resp){
        $str = $resp->serializeToString();
        return  pack(PACK,strlen($str)).$str;
    }


}