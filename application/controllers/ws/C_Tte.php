<?php

use chriskacerguis\RestServer\RestController;

class C_Tte extends RestController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fetch_post(){
        $params = $this->input->post();
        dd(json_encode($params));
        // echo json_encode($this->ttelib->postCurl());
    }
}
