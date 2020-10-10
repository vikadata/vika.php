<?php
namespace Vika\Common;

use Exception;

/**
 * Class Response
 * @package Vika\Common
 */
class Response {
    const DEFAULT_ERROR_CODE = 500;
    const DEFAULT_ERROR_SUCCESS = false;
    /**
     * @var int $code api返回code
     */
    protected $code;
    /**
     * @var string $message api返回信息
     */
    protected $message;
    /**
     * @var boolean $success 请求业务处理是否成功
     */
    protected $success;
    /**
     * @var mixed $data 请求返回具体的数据
     */
    protected $data;

    /**
     * @param mixed $data
     * @return Response
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param string $resultStr 返回的str
     * @return Response
     */
    public static function init($resultStr)
    {
        $response = new Response();
        $result = json_decode($resultStr, true);
        if (!$result) {
            $response->code = 500;
            $response->message = $resultStr;
            $response->success = false;
        }
        if (isset($result['code'])) {
            $response->code = $result['code'];
        }
        if (isset($result['data'])) {
            if (isset($result['data']['records'])) {
                $response->data = Record::init($result['data']);
            }
            if (isset($result['data']['token'])) {
                $response->data = Attachment::init($result['data']);
            }
        }
        if (isset($result['message'])) {
            $response->message = $result['message'];
        }
        if (isset($result['success'])) {
            $response->success = $result['success'];
        }
        return $response;
    }

    /**
     * @param Exception $e
     * @return Response
     */
    public static function error(Exception $e)
    {
        $response = new Response();
        $response->code = $e->getCode();
        $response->message = $e->getMessage();
        $response->success = false;
        return $response;
    }

}