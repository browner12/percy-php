<?php

namespace browner12\percy;

class Snapshot
{
    /**
     * @var array
     */
    public $response;

    /**
     * @var string
     */
    public $id;

    /**
     * constructor
     *
     * @param $response
     */
    public function __construct($response)
    {
        //assign the full response so people can use as they see fit
        $this->response = $response;

        //but we will pull out some stuff
        $this->id = $response->data->id;
    }

    /**
     * @return array
     */
    public function getMissingResources()
    {
        return [];
    }
}
