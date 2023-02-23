<?php

require 'vendor/autoload.php';
// require FCPATH.'vendor/autoload.php';
// use PhpOffice\PhpSpreadSheet\Spreadsheet;
// use PhpOffice\PhpSpreadSheet\IOFactory;
// require FCPATH.'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_Rekap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('kinerja/M_Kinerja', 'kinerja');
        $this->load->model('user/M_User', 'user');
        $this->load->model('rekap/M_Rekap', 'rekap');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function rekapAbsensi(){
        $data['jam_kerja'] = $this->general->getAll('t_jam_kerja');
        render('rekap/V_RekapAbsensi', '', '', $data);
    }

    public function rekapAbsensiNew(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        $data['jam_kerja'] = $this->general->getAll('t_jam_kerja');
        render('rekap/V_RekapAbsensiNew', '', '', $data);
    }

    public function readAbsensiExcel(){
        $data = $this->rekap->readAbsensiExcel();
        $this->session->set_userdata('data_read_absensi_excel', $data);
        $data['flag_print'] = 0;
        $this->load->view('rekap/V_RekapAbsensiResult', $data);
    }

    public function readAbsensiExcelNew(){
        $temp = $this->rekap->readAbsensiExcelNew();
        $data = $this->rekap->buildDataAbsensi($temp);
        $this->session->set_userdata('data_read_absensi_excel', $data);
        $data['flag_print'] = 0;
        $this->rekap->saveDbRekapAbsensi($data);
        $this->load->view('rekap/V_RekapAbsensiResultNew', $data);
    }

    public function downloadAbsensi(){
        $data = $this->session->userdata('data_read_absensi_excel');
        $data['flag_print'] = 1;
        $this->load->view('rekap/V_RekapAbsensiResult', $data);
    }

    public function downloadAbsensiNew(){
        $data = $this->session->userdata('data_read_absensi_excel');
        $data['flag_print'] = 1;
        $this->load->view('rekap/V_RekapAbsensiResultNew', $data);
    }

    public function readAbsensiFromDb(){
      
        $data = $this->rekap->readAbsensiFromDb($this->input->post());
       
        // if($temp){
        //     $data = json_decode($temp['json_result'], true);
        // }
        // dd($data);
        $this->session->set_userdata('data_read_absensi_excel', $data);
        $data['flag_print'] = 0;
        $this->load->view('rekap/V_RekapAbsensiResultNew', $data);
    }

    public function rekapPenilaian(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        render('rekap/V_RekapPenilaian', '', '', $data);
    }

    public function rekapPenilaianSearch($flag_print = 0){
        $data['parameter'] = $this->input->post();
        $data['flag_print'] = $flag_print;
        if($flag_print == 1){
            $data['result'] = $this->session->userdata('data_penilaian_produktivitas_kerja');
            $data['parameter'] = $this->session->userdata('parameter_data_penilaian_produktivitas_kerja'); 
        } else {
            $data['result'] = $this->rekap->rekapPenilaianSearch($this->input->post());
            $this->session->set_userdata('data_penilaian_produktivitas_kerja', $data['result']);
            $this->session->set_userdata('parameter_data_penilaian_produktivitas_kerja', $data['parameter']);
        }
        
        $this->load->view('rekap/V_RekapPenilaianResult', $data);
    }

    public function rekapDisiplin(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        render('rekap/V_RekapDisiplin', '', '', $data);
    }

    public function rekapDisiplinSearch($flag_print = 0){
        $data['parameter'] = $this->input->post();
        $data['flag_print'] = $flag_print;

        $data['result_db'] = null;
        $result_db = $this->rekap->getRekapAbsen($data['parameter']);
        if($result_db){
            $data['result_db'] = json_decode($result_db['json_result'], true);
        }
        if($flag_print == 1){
            $data['result'] = $this->session->userdata('data_penilaian_disiplin_kerja');
            $data['parameter'] = $this->session->userdata('parameter_data_disiplin_kerja');
        } else {
            $data['result'] = $this->rekap->rekapDisiplinSearch($this->input->post());
        }

        $this->session->set_userdata('data_penilaian_disiplin_kerja', $data['result_db']);
        $this->session->set_userdata('data_penilaian_disiplin_kerja_excel', $data['result']);
        $this->session->set_userdata('parameter_data_disiplin_kerja', $data['parameter']);

        $this->load->view('rekap/V_RekapDisiplinResult', $data);
    }

    public function saveExcelDisiplin(){
        $data['result'] = $this->session->userdata('data_penilaian_disiplin_kerja');
        $data['parameter'] = $this->session->userdata('parameter_data_disiplin_kerja');
        $this->load->view('rekap/V_RekapDisiplinExcel', $data);
    }

    public function saveDbRekapDisiplin(){
        $excel = $this->session->userdata('data_penilaian_disiplin_kerja_excel');
        if($excel){
            $data['result'] = $excel;
        } else {
            $data['result'] = $this->session->userdata('data_penilaian_disiplin_kerja');
        }
        $data['parameter'] = $this->session->userdata('parameter_data_disiplin_kerja');
        $this->rekap->saveDbRekapDisiplin($data);
    }

    public function rekapPenilaianDisiplin(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        render('rekap/V_RekapPenilaianDisiplin', '', '', $data);
    }

    public function rekapPenilaianDisiplinSearch(){
        $data = $this->rekap->rekapPenilaianDisiplinSearch($this->input->post());
        $data['flag_print'] = 0;
        $this->load->view('rekap/V_RekapPenilaianDisiplinResult', $data);
    }

    public function rekapPenilaianDisiplinSearchOld(){
        $rs = $this->rekap->rekapPenilaianDisiplinSearch($this->input->post());
        $data['result'] = json_decode($rs['json_result'], true);
    }

    public function rekapKehadiran(){
        $data['result'] = $this->rekap->rekapKehadiran($this->session->userdata('data_penilaian_disiplin_kerja'), $this->session->userdata('parameter_data_disiplin_kerja'));
    }

    public function rekapTpp(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        render('rekap/V_RekapTpp', '', '', $data);
    }

    public function rekapTppSearch(){
        
        $this->session->set_userdata('params_rekap_tpp', $this->input->post());
        $data = $this->rekap->rekapTppSearch($this->input->post());
        // dd($data['json_result']);
        $data['data_serach'] = $this->input->post();
        $this->load->view('rekap/V_RekapTppResult', $data);
    }

    public function loadViewByJenisFile($jenis_file){
        $data_absen = $this->session->userdata('data_absen_rekap_tpp');
        $param = $this->session->userdata('params_rekap_tpp');
        $skpd = explode(";", $param['skpd']);
        $data_absen['unitkerja'] = $skpd[0];
        $data_absen['bulan'] = $param['bulan'];
        $data_absen['tahun'] = $param['tahun'];
        // dd($data_absen['raw_data_excel']);
        $data_rekap = $this->session->userdata('rekap_'.$param['bulan'].'_'.$param['tahun']);
        
        switch($jenis_file){
            case "absen":
                $data = null;
                if(isset($data_absen['raw_data_excel'])){
                    // if($data_rekap && isset($data_rekap['absen'])){
                    //     $data = $data_rekap['absen'];
                    // } else {
                        $data = $this->rekap->buildDataAbsensi(json_decode($data_absen['raw_data_excel'], true));
                        $temp['absen'] = $data;
                        // $this->session->set_userdata('rekap_'.$param['bulan'].'_'.$param['tahun'], $temp);
                    // }
                }
                $this->load->view('rekap/V_RekapAbsensiResultNew', $data);
            break;

            case "produktivitas_kerja":
                // if($data_rekap && isset($data_rekap['produktivitas_kerja'])){
                //     $data['result'] = $data_rekap['produktivitas_kerja'];
                // } else {
                    $data['result'] = $this->rekap->rekapPenilaianSearch($param);
                    $data['parameter'] = $param;
                    $data['flag_print'] = 0;
                    $data['use_header'] = 0;
                // }

                $temp['produktivitas_kerja'] = $data;
                // $this->session->set_userdata('rekap_'.$param['bulan'].'_'.$param['tahun'], $temp);

                $this->load->view('rekap/V_RekapPenilaianResult', $data);
            break;

            case "penilaian_disiplin_kerja":
                // if($data_rekap && isset($data_rekap['penilaian_disiplin_kerja'])){
                //     $data = $data_rekap['penilaian_disiplin_kerja'];
                // } else {
                    $data = $this->rekap->rekapPenilaianDisiplinSearch($param);
                    $data['flag_print'] = 0;
                    $data['use_header'] = 0;
                // }

                $temp['penilaian_disiplin_kerja'] = $data;
                // $this->session->set_userdata('rekap_'.$param['bulan'].'_'.$param['tahun'], $temp);
                
                $this->load->view('rekap/V_RekapPenilaianDisiplinResult', $data);
            break;

            case "daftar_perhitungan_tpp":
                // if($data_rekap && isset($data_rekap['daftar_perhitungan_tpp'])){
                //     $data['result'] = $data_rekap['daftar_perhitungan_tpp'];
                // } else {
                    $explode_param = explode(";", $param['skpd']);
                    $pagu_tpp = $this->kinerja->countPaguTpp(['id_unitkerja' => $explode_param[0]]);
                    $data['result'] = $this->rekap->getDaftarPerhitunganTpp($pagu_tpp, $data_rekap, $param);
                    $temp['daftar_perhitungan_tpp'] = $data['result'];
                    $this->session->set_userdata('rekap_'.$param['bulan'].'_'.$param['tahun'], $temp);
                // }
               
                $this->load->view('rekap/V_RekapPerhitunganTpp', $data);
            break;

            case "daftar_permintaan":
                // if($data_rekap && isset($data_rekap['daftar_perhitungan_tpp'])){
                //     $data['result'] = $data_rekap['daftar_perhitungan_tpp'];
                // } else {
                    $explode_param = explode(";", $param['skpd']);
                    $pagu_tpp = $this->kinerja->countPaguTpp(['id_unitkerja' => $explode_param[0]]);
                    $data['result'] = $this->rekap->getDaftarPerhitunganTpp($pagu_tpp, $data_rekap, $param);
                    $temp['daftar_perhitungan_tpp'] = $data['result'];
                    $this->session->set_userdata('rekap_'.$param['bulan'].'_'.$param['tahun'], $temp);
                // }
                $this->load->view('rekap/V_DaftarPermintaanTpp', $data);
            break;

            case "daftar_pembayaran":
                // if($data_rekap && isset($data_rekap['daftar_perhitungan_tpp'])){
                //     $data['result'] = $data_rekap['daftar_perhitungan_tpp'];
                // } else {
                    $explode_param = explode(";", $param['skpd']);
                    $pagu_tpp = $this->kinerja->countPaguTpp(['id_unitkerja' => $explode_param[0]]);
                    $data['result'] = $this->rekap->getDaftarPerhitunganTpp($pagu_tpp, $data_rekap, $param);
                    $temp['daftar_perhitungan_tpp'] = $data['result'];
                    $this->session->set_userdata('rekap_'.$param['bulan'].'_'.$param['tahun'], $temp);
                // }
                $this->load->view('rekap/V_DaftarPembayaranTpp', $data);
            break;
        }
    }


    public function downloadPdf(){

        // $data = $this->session->userdata('data_read_absensi_excel');
        // $data['flag_print'] = 1;
        // $this->load->view('rekap/V_RekapAbsensiResultNew', $data);

        // dd($this->input->post());
        $data = $this->rekap->readAbsensiFromDb($this->input->post());
        $data['penilaian'] = $this->rekap->rekapPenilaianSearch($this->input->post());
        $data['parameter'] = $this->input->post();
        $data['disiplin'] = $this->rekap->rekapPenilaianDisiplinSearch($this->input->post());

        $explode_param = explode(";", $data['parameter']['skpd']);
        $data_rekap = $this->session->userdata('rekap_'.$data['parameter']['bulan'].'_'.$data['parameter']['tahun']);
        $pagu_tpp = $this->kinerja->countPaguTpp(['id_unitkerja' => $explode_param[0]]);
        $data['perhitungan_tpp'] = $this->rekap->getDaftarPerhitunganTpp($pagu_tpp, $data_rekap, $data['parameter']);
        $temp['daftar_perhitungan_tpp'] = $data['perhitungan_tpp'];
      

    

        // dd($data['disiplin']);

        // $this->load->view('rekap/V_RekapTppPdf', $data);
        
        // $data['flag_print'] = 1;
        // $html = $this->load->view('rekap/V_RekapTppPdf',$data, true);
        // $mpdf = new \Mpdf\Mpdf([
        //     'format'=>'A4',
        //     'orientation'=>'landscape',
        //     'margin_top'=>5,
        //     'margin_right'=>10,
        //     'margin_left'=>10,
        //     'margin_bottom'=>10,
        // ]);
        // $mpdf->WriteHTML($html);
        // $mpdf->Output();

        $html = $this->load->view('rekap/V_RekapTppPdf', $data, true);
        $this->mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [215, 330]]);
        // $this->stylesheet = file_get_contents('css/style.css');
        $this->mpdf->AddPage('L', // L - landscape, P - portrait
                '', '', '', '',
                10, // margin_left
                10, // margin right
                5, // margin top
                10, // margin bottom
                18, // margin header
                12); // margin footer
        $this->mpdf->WriteHTML($html);
        $skpd = explode(";", $data['parameter']['skpd']);
        $bulan = getNamaBulan($data['parameter']['bulan']);
        // $this->mpdf->Output('Rekap TPP '.$skpd[1].' '.$bulan.' '.$data['parameter']['tahun'].'.pdf', 'D'); // download force
        $this->mpdf->Output('Rekap TPP '.$skpd[1].' '.$bulan.' '.$data['parameter']['tahun'].'.pdf', 'I'); // view in the explorer
    
    }


}
