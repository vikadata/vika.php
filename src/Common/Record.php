<?php
namespace Vika\Common;

/**
 * Class Record
 * @package Vika\Common
 */
class Record {
    /**
     * @var int $pageNum 当前页
     */
    protected $pageNum;
    /**
     * @var int $pageSize 当前页分页大小 对应count($records)
     */
    protected $pageSize;
    /**
     * @var array $records 记录数组
     */
    protected $records;
    /**
     * @var int $total 全部数据条数
     */
    protected $total;
    /**
     * @param int $pageNum
     * @return Record
     */
    public function setPageNum($pageNum)
    {
        $this->pageNum = $pageNum;
        return $this;
    }

    /**
     * @param int $pageSize
     * @return Record
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        return $this;
    }

    /**
     * @param array $records
     * @return Record
     */
    public function setRecords($records)
    {
        $this->records = $records;
        return $this;
    }

    /**
     * @param int $total
     * @return Record
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return int
     */
    public function getPageNum()
    {
        return $this->pageNum;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @return array
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param $data
     * @return Record
     */
    public static function init($data)
    {
        $record = new Record();
        if (isset($data['pageSize'])) {
            $record->pageSize = $data['pageSize'];
        }
        if (isset($data['pageNum'])) {
            $record->pageNum = $data['pageNum'];
        }
        if (isset($data['total'])) {
            $record->total = $data['total'];
        }
        if (isset($data['records'])) {
            $record->records = $data['records'];
        }
        return $record;
    }
}