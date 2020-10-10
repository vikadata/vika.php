<?php
namespace Vika;

use Vika\Common\Response;

/**
 * Interface DatasheetInterface
 * @package Vika
 */
interface DatasheetInterface {
    /**
     * 获取全部的记录
     * @param array $params 参数
     * @return Response
     */
    public function all($params = []);

    /**
     * 根据查询条件获取记录
     * @param array $params
     * @return Response
     */
    public function get($params = []);

    /**
     * 根据recordId获取指定数据
     * @param array $recordIds
     * @param string $fieldKey
     * @return Response
     */
    public function find($recordIds = [], $fieldKey = 'name');

    /**
     * 更新记录
     * @param $records
     * @param string $fieldKey
     * @return Response
     */
    public function update($records, $fieldKey = 'name');

    /**
     * 添加记录
     * @param $records
     * @param string $fieldKey
     * @return Response
     */
    public function add($records, $fieldKey = 'name');

    /**
     * 删除记录
     * @param array $recordIds 记录recordId
     * @return Response
     */
    public function del($recordIds);

    /**
     * 上传文件
     * @param string $file 文件路径
     * @return Response
     */
    public function upload($file);
}