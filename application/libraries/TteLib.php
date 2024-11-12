<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class TteLib{
    // ganti dg url api dan token sesuai di admin panel
    public $URL;
    public $USERNAME;
    public $PASSWORD;
    public $STATE;
    protected $tte;

    public function __construct()
    {
        $this->STATE = "PROD"; //DEV = development, PROD = production
        $this->URL = "103.186.201.237/";
        $this->USERNAME = "esign";
        $this->PASSWORD = "qwerty";
        if($this->STATE == 'PROD'){
            $this->URL = "103.178.15.54/";
            $this->USERNAME = "esign";
            $this->PASSWORD = "qwerty";
        }
        
        $this->tte = &get_instance();
    }

    public function hash(){
        return [
            'state' => $this->STATE,
            'url' => $this->URL,
            'username' => $this->USERNAME,
            'password' => $this->PASSWORD
        ];
    }

    public function signPdfNikPass($data){
        $hash = $this->hash();
        $url = $hash['url'].'api/v2/sign/pdf';
        if($hash['state'] == 'DEV'){
            $data['nik'] = trim(TTE_NIK_DEV);
            $data['passphrase'] = trim(TTE_PASS_DEV);
        }
        $resp = $this->postCurl($url, $data, 'POST');
        return $resp;
    }

    public function verifPdf($data){
        $hash = $this->hash();
        $url = $hash['url'].'api/v2/verify/pdf';

        return $this->postCurl($url, $data, 'POST');
    }

    // public function saveLog($data){
    //     $this->tte->general->insert('t_log_tte', $data);
    // }

    function postCurl($url, $data, $method = "POST") {
        $id_ref = isset($data['id_ref']) ? $data['id_ref'] : 0;
        unset($data['id_ref']);
        
        $table_ref = isset($data['table_ref']) ? $data['table_ref'] : 0;
        unset($data['table_ref']);
        
        $request_json = json_encode($data, JSON_UNESCAPED_SLASHES); 
        
        $hash = $this->hash();
        $curl = curl_init();
        $url = $url;
        // dd(json_encode($data));
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 20,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $request_json,
        CURLOPT_TIMEOUT => 50,
        // CURLOPT_HTTPAUTH => CURLAUTH_ANY,
        CURLOPT_USERPWD => $hash['username'].":".$hash['password'],
        CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json; charset=utf-8",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if($err){
            $response = $err;
        }

        curl_close($curl);

        // $this->saveLog([
        //     'id_ref' => json_encode($id_ref),
        //     'table_ref' => $table_ref,
        //     'request' => $request_json,
        //     'response' => $response,
        //     'url' => $url
        // ]);

        return $response;
    }

}