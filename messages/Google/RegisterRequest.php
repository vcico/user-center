<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: register.proto

namespace Google;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>Google.RegisterRequest</code>
 */
class RegisterRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string username = 1;</code>
     */
    protected $username = '';
    /**
     * Generated from protobuf field <code>string password = 2;</code>
     */
    protected $password = '';
    /**
     * Generated from protobuf field <code>string passwordRepeat = 3;</code>
     */
    protected $passwordRepeat = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $username
     *     @type string $password
     *     @type string $passwordRepeat
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Register::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string username = 1;</code>
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Generated from protobuf field <code>string username = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setUsername($var)
    {
        GPBUtil::checkString($var, True);
        $this->username = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string password = 2;</code>
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Generated from protobuf field <code>string password = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setPassword($var)
    {
        GPBUtil::checkString($var, True);
        $this->password = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string passwordRepeat = 3;</code>
     * @return string
     */
    public function getPasswordRepeat()
    {
        return $this->passwordRepeat;
    }

    /**
     * Generated from protobuf field <code>string passwordRepeat = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setPasswordRepeat($var)
    {
        GPBUtil::checkString($var, True);
        $this->passwordRepeat = $var;

        return $this;
    }

}
