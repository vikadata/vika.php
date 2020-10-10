<?php
namespace Vika;

/**
 * Class Vika
 * SDK入口文件
 */
class Vika {
    protected static $apiToken;
    protected static $fieldKey;
    protected static $host;
    protected static $requestTimeout;

    /**
     * @param string $apiToken  (必填) 你的 API Token，用于鉴权
     * @param string $fieldKey  (选填）全局指定 field 的查询和返回的 key。默认使用列名  'name' 。指定为 'id' 时将以 fieldId 作为查询和返回方式（使用 id 可以避免列名的修改导致代码失效问题）
     * @param string $host 选填）目标服务器地址 默认值: https://api.vika.cn
     * @param int $requestTimeout (选填）请求失效时间,默认10s
     */
    public static function auth($apiToken, $host = 'https://api.vika.cn', $fieldKey = 'name', $requestTimeout = 10) {
        self::$apiToken = $apiToken;
        self::$requestTimeout = $requestTimeout;
        self::$host = $host;
        self::$fieldKey = $fieldKey;
    }

    /**
     * @param string $datasheetId 数表ID
     * @return Datasheet 数表实例
     */
    public static function datasheet($datasheetId) {
        return new Datasheet($datasheetId);
    }

    /**
     * @return string
     */
    public static function getApiToken()
    {
        return self::$apiToken;
    }

    /**
     * @return string
     */
    public static function getFieldKey()
    {
        return self::$fieldKey;
    }

    /**
     * @return string
     */
    public static function getHost()
    {
        return self::$host;
    }

    /**
     * @return int
     */
    public static function getRequestTimeout()
    {
        return self::$requestTimeout;
    }
}