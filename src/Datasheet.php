<?php
namespace Vika;

use CURLFile;
use Vika\Common\Record;
use Vika\Common\Request;

/**
 * Class Datasheet
 * @package Vika
 *
 */
class Datasheet implements DatasheetInterface {
    // 常量
    const DEFAULT_MAX_PAGE_SIZE = 2;
    const DEFAULT_PAGE_NUM = 1;
    // 请求url
    protected static $recordPath= '/fusion/v1/datasheets/%s/records';
    protected static $attachPath = '/fusion/v1/datasheets/%s/attachments';

    protected $datasheetId;
    /**
     * @var Request
     */
    private $request;

    public function __construct($datasheetId)
    {
        $this->datasheetId = $datasheetId;
        $this->request = new Request();
    }

    public function all($params = [])
    {
        $params['pageSize'] = self::DEFAULT_MAX_PAGE_SIZE;
        $params['pageNum'] = self::DEFAULT_PAGE_NUM;
        $result = $this->request->params($params)->url(sprintf(self::$recordPath, $this->datasheetId))->send();
        $data = $result->getData();
        if (!$result->isSuccess()) {
            return $result;
        }
        $total = $data->getTotal();
        echo sprintf("[第1次请求]pageSize: %d, recordCount: %d, total: %d\n ", $data->getPageSize(), count($data->getRecords()), $data->getTotal());
	    // 计算循环总次数
	    if ($total > self::DEFAULT_MAX_PAGE_SIZE) {
            $times = intval(ceil(floatval($total / self::DEFAULT_MAX_PAGE_SIZE)));
            echo sprintf("循环总次数{$times}\n");
            for($i = 2; $i <= $times; $i++)  {
                $params['pageNum'] = $i;
                $tmp = $this->request->params($params)->url(sprintf(self::$recordPath, $this->datasheetId))->send();
                if (!$tmp->isSuccess()) {
                    return $tmp;
                }
                echo sprintf("[第{$i}次请求]pageSize: %d, recordCount: %d, total: %d\n ", $tmp->getData()->getPageSize(), count($tmp->getData()->getRecords()), $tmp->getData()->getTotal());
                $data->setRecords(array_merge($data->getRecords(), $tmp->getData()->getRecords()));
            }
	    }
	    $data->setPageSize(null)->setPageNum(null)->setTotal(null);
        return $result->setData($data);
    }

    public function get($params = [])
    {
        return $this->request->params($params)->url(sprintf(self::$recordPath, $this->datasheetId))->send();
    }

    public function find($recordIds = [], $fieldKey = 'name')
    {
        return $this->request->params(['recordIds' => $recordIds, 'fieldKey' => $fieldKey])
            ->url(sprintf(self::$recordPath, $this->datasheetId))
            ->send();
    }

    public function update($records, $fieldKey = 'name')
    {
        return $this->request->method(Request::PATCH)->headers(Request::DEFAULT_JSON_CONTENT_TYPE)
            ->url(sprintf(self::$recordPath, $this->datasheetId))
            ->params(json_encode(['records' => $records, 'fieldKey' => $fieldKey]))
            ->send();
    }

    public function add($records, $fieldKey = 'name')
    {
        return $this->request->method(Request::POST)->headers(Request::DEFAULT_JSON_CONTENT_TYPE)
            ->url(sprintf(self::$recordPath, $this->datasheetId))
            ->params(json_encode(['records' => $records, 'fieldKey' => $fieldKey]))
            ->send();
    }

    public function del($recordIds)
    {
        return $this->request->method(Request::DELETE)->params(['recordIds' => $recordIds])
            ->url(sprintf(self::$recordPath, $this->datasheetId))->send();
    }

    public function upload($file)
    {
        $request = new Request();
        $fileName = basename($file);
        $fields = [
            'file' => new CurlFile($fileName, mime_content_type($fileName), $fileName)
        ];
        return $request->method(Request::POST)
            ->url(sprintf(self::$attachPath, $this->datasheetId))
            ->params($fields)->send();
    }
}