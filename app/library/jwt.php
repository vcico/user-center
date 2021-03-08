<?php


namespace app\library;


use app\exceptions\NoFoundPayloadException;

class jwt
{
    const SECRET = '!#$%^*+_)(*&~!@#$%&_+_|}{?><":LK{POIUYT';
    protected $header = ['alg'=>'HS256','typ'=>'JWT'];
    protected $payload;

    public function setPayload(array $p) : jwt {  // setUserinfo会获取默认 payload 。所以 setPayload应在 setUserinfo之前
        $this->payload = $p;
        return $this;
    }

    /**
     * 设置header信息
     * @param array $h
     */
    public function setHeader(array $h) : jwt {
        $this->header = $h;
        return $this;
    }

    /**
     * 设置payload内容
     * @param array $kvs payload内容键值对
     */
    public function setPayloadKV(array $kvs) : jwt {
        if (!$this->payload){
            throw new NoFoundPayloadException();
        }
        $this->payload = array_merge($this->payload,$kvs);
        return $this;
    }

    public function setDefaultPayload() : jwt {
        $t =  time();
        $this->payload = [
            'exp'=> strtotime('+1day'),      // 过期时间
            'nbf' => $t,   // 生效时间
            // 'jti' => '',  // 编号
            'iat' => $t, // 签发时间
            // 自定义字段
            // 'sub' => '',
            // 'name' => '',
        ];
        return $this;
    }

    public function Token():string{
        if (!$this->payload){
            throw new NoFoundPayloadException();
        }
        $h = enBase64URL(json_encode($this->header));
        $p = enBase64URL(json_encode($this->payload));
        $str = "$h.$p";
        return $str.'.'.hash_hmac('sha256',$str , self::SECRET);
    }

    public static function Verify($token) : array {
        list($h,$p,$s) = explode('.',$token);
        if (!hash_hmac('sha256',"$h.$p",self::SECRET ) == $s){
            return [];
        }
        $payload = json_decode(deBase64URL($p));
        if (isset($payload['exp']) && time() > (int)$payload['exp']){
            return [];
        }
        if (isset($payload['nbf']) && time() < (int)$payload['nbf']){
            return [];
        }
        return $payload;
    }

}