<?php
namespace Vika\Common;

/**
 * Class Attachment
 * @package Vika\Common
 */
class Attachment {
    /**
     * @var string $token 附件token
     */
    protected $token;
    /**
     * @var string $mimeType 附件mimeType
     */
    protected $mimeType;
    /**
     * @var int $size 附件大小
     */
    protected $size;
    /**
     * @var int $height 附件高（图片才有返回）
     */
    protected $height;
    /**
     * @var int $width 附件高（图片才有返回）
     */
    protected $width;
    /**
     * @var string $name 附件名称
     */
    protected $name;
    /**
     * @var string $url 附件下载路径
     */
    protected $url;
    /**
     * @var string $preview 附件缩略图
     */
    protected $preview;

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @param $data
     * @return Attachment
     */
    public static function init($data)
    {
        $attach = new Attachment();
        if (isset($data['token'])) {
            $attach->token = $data['token'];
        }
        if (isset($data['mimeType'])) {
            $attach->mimeType = $data['mimeType'];
        }
        if (isset($data['size'])) {
            $attach->size = $data['size'];
        }
        if (isset($data['height'])) {
            $attach->height = $data['height'];
        }
        if (isset($data['width'])) {
            $attach->width = $data['width'];
        }
        if (isset($data['name'])) {
            $attach->name = $data['name'];
        }
        if (isset($data['url'])) {
            $attach->url = $data['url'];
        }
        if (isset($data['preview'])) {
            $attach->preview = $data['preview'];
        }
        return $attach;
    }
}