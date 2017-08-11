<?php

namespace browner12\percy;

class Build
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
        $this->finalizeLink = $response->data->meta->{'finalize-link'};
        $this->approveLink = $response->data->meta->{'approve-link'};
    }
}
