<?php 
use chriskacerguis\RestServer\RestController;

class Api extends RestController {

    public $responseMessage;
    
    public function __construct(){
        parent::__construct();
        $this->load->model('general/M_General', 'm_general');
        $this->load->model('user/M_User', 'user');
        $this->load->model('kinerja/M_Kinerja', 'kinerja');
        $this->responseMessage = ['code' => 200, 'status' => true, 'message' => "", 'data' => null];
    }

    public function validateKey($arr, $method, $flag_siladen = 0){
        if($flag_siladen != 0){
            array_push($arr, 'username', 'password');
        }
        if($method == 'POST'){
            foreach($arr as $a){
                if(!$this->input->post($a)){
                    $this->responseMessage = ['code' => 400,'status' => false, 'message' => "Key '".$a."' Tidak Ditemukan"];
                }
            }
        } else if($method == 'DELETE'){
            foreach($arr as $a){
                if(!$this->delete($a)){
                    $this->responseMessage = ['code' => 400,'status' => false, 'message' => "Key '".$a."' Tidak Ditemukan"];
                }
            }
        } else if($method == 'GET'){
            foreach($arr as $a){
                if(!$this->get($a)){
                    $this->responseMessage = ['code' => 400,'status' => false, 'message' => "Key '".$a."' Tidak Ditemukan"];
                }
            }
        }
    }

    public function getUserSiladen_post(){
        $log['request'] = json_encode($this->input->post());
        $log['response'] = null;
        $this->validateKey(['nohp'], 'POST');
        if($this->responseMessage['code'] == 200){
            $rs = $this->m_general->getUserSiladenByNoHp($this->input->post('nohp'));
            if($rs){
                $this->responseMessage['status'] = true;
                $this->responseMessage['code'] = 200;
                $this->responseMessage['data'] = $rs;
            } else {
                $this->responseMessage['status'] = false;
                $this->responseMessage['code'] = 404;
                $this->responseMessage['message'] = "Data Tidak Ditemukan";
                $this->responseMessage['data'] = null;
            }
        }
        // $log['response'] = json_encode($this->responseMessage);
        // $this->m_general->saveLogWs($log);
        $this->response(
            $this->responseMessage, 
            $this->responseMessage['code']
        );
    }

    public function getDokumen_post(){
        $log['request'] = json_encode($this->input->post());
        $log['response'] = null;
        $this->validateKey(['filename'], 'POST');
        if($this->responseMessage['code'] == 200){
            $login = $this->m_general->authWs($this->input->post());
            if($login['code'] == 0){
                $pathFile = $this->input->post('filename');
                $rs = fileToBase64($pathFile);
                $this->responseMessage['status'] = true;
                $this->responseMessage['code'] = 200;
                $this->responseMessage['data'] = $rs;
            } else {
                $this->responseMessage['status'] = false;
                $this->responseMessage['code'] = 404;
                $this->responseMessage['message'] = $login['message'];
            }
        }
        // $log['response'] = json_encode($this->responseMessage);
        // $this->m_general->saveLogWs($log);
        $this->response(
            $this->responseMessage, 
            $this->responseMessage['code']
        );
    }

    public function saveDokumen_post(){
        
        $log['request'] = json_encode($this->input->post());
        $log['response'] = null;
        $this->validateKey(['filename', 'docfile'], 'POST');
        if($this->responseMessage['code'] == 200){
            $login = $this->m_general->authWs($this->input->post());
            if($login['code'] == 0){
                $pathFile = $this->input->post('filename');
                $file = $this->input->post('docfile');
                $upload = base64ToFile($file, $pathFile);
                if(filesize($upload) > 0){
                    $this->responseMessage['status'] = true;
                    $this->responseMessage['code'] = 201;
                    $this->responseMessage['message'] = "File berhasil diupload";
                } else {
                    $this->responseMessage['status'] = false;
                    $this->responseMessage['code'] = 500;
                    $this->responseMessage['data'] = json_encode($upload);
                    $this->responseMessage['message'] = "File gagal upload";    
                }
            } else {
                $this->responseMessage['status'] = false;
                $this->responseMessage['code'] = 404;
                $this->responseMessage['message'] = $login['message'];
            }
        }
        $log['response'] = json_encode($this->responseMessage);
        // $this->general->saveLogWs($log);
        $this->response(
            $this->responseMessage, 
            $this->responseMessage['code']
        );
    }


    public function deleteDokumen_post(){
        $log['request'] = json_encode($this->input->post());
        $log['response'] = null;
        $this->validateKey(['filename'], 'POST');
        if($this->responseMessage['code'] == 200){
            $login = $this->m_general->authWs($this->input->post());
            if($login['code'] == 0){
                $pathFile = $this->input->post('filename');
                unlink($pathFile);
                $this->responseMessage['status'] = true;
                $this->responseMessage['code'] = 201;
                $this->responseMessage['message'] = "File berhasil dihapus";
            } else {
                $this->responseMessage['status'] = false;
                $this->responseMessage['code'] = 404;
                $this->responseMessage['message'] = $login['message'];
            }
        }
        $log['response'] = json_encode($this->responseMessage);
        $this->response(
            $this->responseMessage, 
            $this->responseMessage['code']
        );
    }

    public function getNoHpAll_post(){
        $log['request'] = json_encode($this->input->post());
        $log['response'] = null;
        $this->validateKey([], 'POST');
        if($this->responseMessage['code'] == 200){
            $login = $this->m_general->authWs($this->input->post());
            if($login['code'] == 0){
                $result = $this->m_general->getNoHpAll();
                $this->responseMessage['status'] = true;
                $this->responseMessage['code'] = 200;
                $this->responseMessage['message'] = $result;
            } else {
                $this->responseMessage['status'] = false;
                $this->responseMessage['code'] = 404;
                $this->responseMessage['message'] = $login['message'];
            }
        }
        $log['response'] = json_encode($this->responseMessage);
        $this->response(
            $this->responseMessage, 
            $this->responseMessage['code']
        );
    }

}