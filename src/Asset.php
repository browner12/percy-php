<?php

namespace browner12\percy;

class Asset
{
    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $mimeType;

    /**
     * @var bool
     */
    public $isRoot;

    /**
     * @var string
     */
    public $hash;

    /**
     * @var string
     */
    public $encoding;

    /**
     * constructor
     *
     * @param string $content
     * @param string $url
     * @param string $mimeType
     * @param bool   $isRoot
     * @internal param $sha
     */
    public function __construct($content, $url, $mimeType, $isRoot)
    {
        //assign
        $this->content = $content;
        $this->url = $url;
        $this->mimeType = $mimeType;
        $this->isRoot = $isRoot;

        //hash and encode
        $this->hash = $this->hashContent($this->content);
        $this->encoding = $this->encodeContent($this->content);
    }

    /**
     * @param string $input
     * @return string
     */
    public function hashContent($input)
    {
        return hash('sha256', $input);
    }

    /**
     * @param string $input
     * @return string
     */
    public function encodeContent($input)
    {
        return base64_encode($input);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'type'       => 'resources',
            'id'         => $this->hash,
            'attributes' => [
                'resource-url' => $this->url,
                'mimetype'     => $this->mimeType,
                'is-root'      => $this->isRoot,
            ],
        ];
    }
}
