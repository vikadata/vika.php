<?php
namespace Vika\Common;

use Exception;
use Vika\Vika;

/**
 * Class Request
 * @package Vika\Common
 */
class Request {
    const POST = 'POST';
    const GET = 'GET';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';
    const DEFAULT_MULTI_CONTENT_TYPE = ['Content-Type: multipart/form-data'];
    const DEFAULT_JSON_CONTENT_TYPE = ['Content-Type: application/json'];
    /**
     * @var array|mixed|string[] 请求头
     */
    protected $headers = [];
    /**
     * @var string 请求url
     */
    protected $url;
    /**
     * @var string 请求方法
     */
    private $method = Request::GET;
    /**
     * @var int 请求超时时间
     */
    private $timeout = 0;
    /**
     * @var mixed 请求参数
     */
    protected $params;

    /**
     * @param mixed $headers
     * @return Request
     */
    public function headers($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param mixed $url
     * @return Request
     */
    public function url($url)
    {
        $this->url = Vika::getHost() . $url;
        return $this;
    }

    /**
     * @param mixed $params
     * @return Request
     */
    public function params($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param mixed $timeout
     * @return Request
     */
    public function timeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @param mixed $method
     * @return Request
     */
    public function method($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return Response
     */
    public function send()
    {
        $headers = array_merge([
                'Authorization: Bearer ' . Vika::getApiToken()
            ], $this->headers);
        $timeout = $this->timeout ? $this->timeout : Vika::getRequestTimeout();
        return self::_sendRequest($this->method, $this->url, $headers, $timeout, $this->params);
    }

    /**
     * sendRequest
     * @param $method
     * @param $url
     * @param array $headers
     * @param $timeout
     * @param $params
     * @return Response
     */
    private static function _sendRequest($method, $url, array $headers, $timeout, $params)
    {
        try {
            $ch = curl_init();
            if ($method == Request::POST || $method == Request::PATCH) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            } else {
                $url .= '?' . http_build_query($params);
            }
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // headers
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            if (false !== strpos($url, "https")) {
                // 证书
                // curl_setopt($ch,CURLOPT_CAINFO,"ca.crt");
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
            }
            $resultStr = curl_exec($ch);
            curl_close ($ch);
            return Response::init($resultStr);
        } catch (Exception $e) {
           return Response::error($e);
        }
    }
}