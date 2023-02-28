<?php
	class M_Kinerja extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function insertLaporanKegiatan(){
            // dd($_FILES);
        $countfiles = count($_FILES['files']['name']);
        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        $ress = 1;

        $this->db->trans_begin();
       
        if(implode($_FILES['files']['name']) == ""){
            
            $nama_file = '[""]';
            $image = $nama_file;
            $dataPost = $this->input->post();
            $this->createLaporanKegiatan($dataPost,$image);
        } else {
        for($i=0;$i<$countfiles;$i++){
         
            if(!empty($_FILES['files']['name'][$i])){
      
              // Define new $_FILES array - $_FILES['file']
              $_FILES['file']['name'] = $this->general_library->getUserName().'_'.$_FILES['files']['name'][$i];
              $_FILES['file']['type'] = $_FILES['files']['type'][$i];
              $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
              $_FILES['file']['error'] = $_FILES['files']['error'][$i];
              $_FILES['file']['size'] = $_FILES['files']['size'][$i];
            //   dd($_FILES['file']['type']);

              if($_FILES['file']['type'] != "image/png"  AND $_FILES['file']['type'] != "image/jpeg") {
                $ress = 0;
                $res = array('msg' => 'Hanya bisa upload file gambar', 'success' => false);
                break;
              }
            
                
            //   if($_FILES['file']['size'] > 1048576){
            //     $ress = 0;
            //     $res = array('msg' => 'File tidak boleh lebih dari 1 MB', 'success' => false);
            //     break;
            //   }
           
              // Set preference
              $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
              $config['upload_path'] = './assets/bukti_kegiatan'; 
            //   $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
              $config['allowed_types'] = '*';
            //   $config['max_size'] = '5000'; // max_size in kb
            //   $config['file_name'] = $this->getUserName().'_'.$_FILES['file']['name'];
             
              //Load upload library
              $this->load->library('upload',$config); 
            //   $res = array('msg' => 'something went wrong', 'success' => false);
              // File upload
              if($this->upload->do_upload('file')){
               
               $data = $this->upload->data(); 
                 //    kompress
            //    if($data['file_type'] == "image/png" || $data['file_type'] == "image/jpeg") {
            //    $insert['name'] = $data['file_name'];
            //    $config['image_library'] = 'gd2';
            //    $config['source_image'] = './assets/bukti_kegiatan/'.$data["file_name"];
            //    $config['create_thumb'] = FALSE;
            //    $config['maintain_ratio'] = FALSE;
               
            //    if($data['file_size'] > 1000) {
               
            //     // $imgdata=exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');
            //     $tinggi = $data['image_height'] * 50 / 100;
            //     $lebar  = $data['image_width'] * 50 / 100;
            //     $config['height'] = round($tinggi);
            //     $config['width'] = round($lebar);
              
            //    } 
            // //    else {
            // //     $config['height'] =600;  
            // //     $config['width'] = 600;
               
            // //    }
            //    $config['master_dim'] = 'auto';
            //    $config['quality'] = "50%";


            //    $this->load->library('image_lib');
            //             $this->image_lib->initialize($config);
            //             if (!$this->image_lib->resize()) {
            //                 echo $this->image_lib->display_errors();
            //             }
            //     $this->image_lib->clear();
            // tutup kompress
            // }
            
              }
            }
            $nama_file[] = $data['file_name'];
           }
           if($ress == 1){
            $image = json_encode($nama_file); 
            $dataPost = $this->input->post();
            $this->createLaporanKegiatan($dataPost,$image);
           }   
        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $rs['code'] = 1;
            $rs['message'] = 'Terjadi Kesalahan';
        } else {
            $this->db->trans_commit();
        }

        return $res;
        }

        public function createLaporanKegiatan($dataPost,$image){
  
        $this->db->trans_begin();
        $data = array('tanggal_kegiatan' => $dataPost['tanggal_kegiatan'], 
                      'deskripsi_kegiatan' => $dataPost['deskripsi_kegiatan'],
                      'realisasi_target_kuantitas' => $dataPost['target_kuantitas'],
                      'satuan' => $dataPost['satuan'],
                      'target_kualitas' => 100,
                      'id_t_rencana_kinerja' => $dataPost['tugas_jabatan'],
                      'bukti_kegiatan' => $image,
                      'id_m_user' => $this->general_library->getId()
        );
        $result = $this->db->insert('t_kegiatan', $data);
       
        //cek 
        $id =  $this->general_library->getId();
        $bulan = date('n');
        $tahun = date('Y');
        // $cek = $this->db->select('a.*,
        // (select sum(b.realisasi_target_kuantitas) from t_kegiatan as b where a.id = b.id_t_rencana_kinerja and b.flag_active = 1) as realisasi_target_kuantitas
        // ')
        //                 ->from('t_rencana_kinerja a')
        //                 ->where('a.id_m_user', $id)
        //                 ->where('a.tahun', $tahun)
        //                 ->where('a.bulan', $bulan)
        //                 ->where('a.id', $dataPost['tugas_jabatan'])
        //                 ->where('a.flag_active', 1)
        //                 ->get()->result_array();

        // if($cek){          
        //  if($cek['0']['realisasi_target_kuantitas'] > $cek['0']['target_kuantitas']){
        //     $this->db->where('id',  $dataPost['tugas_jabatan'])
        //              ->update('t_rencana_kinerja', [
        //              'updated_by' => $this->general_library->getId(),
        //              'target_kuantitas' => $cek['0']['realisasi_target_kuantitas']
        //     ]);
        //  }
        // }
         if ($this->db->trans_status() === FALSE)
            {
                    $this->db->trans_rollback();
            }
            else
            {
                    $this->db->trans_commit();
            }
      

        }

        public function loadKegiatan($tahun,$bulan){
            $id =  $this->general_library->getId();
            return $this->db->select('a.*, b.tugas_jabatan,c.status_verif, a.status_verif as id_status_verif')
                ->from('t_kegiatan a')
                ->join('t_rencana_kinerja b', 'a.id_t_rencana_kinerja = b.id')
                ->join('m_status_verif c', 'a.status_verif = c.id')
                ->where('a.id_m_user', $id)
                ->where('year(a.tanggal_kegiatan)', $tahun)
                ->where('month(a.tanggal_kegiatan)', $bulan)
                ->where('a.flag_active', 1)
                ->order_by('a.id', 'desc')
                ->get()->result_array();
           
        }


        public function loadRencanaKinerja($bulan, $tahun){
            $id =  $this->general_library->getId();
            return $this->db->select('a.*,
            (select count(b.id) from t_kegiatan as b where a.id = b.id_t_rencana_kinerja and b.flag_active = 1) as count')
                            ->from('t_rencana_kinerja a')
                            ->where('a.id_m_user', $id)
                            ->where('a.flag_active', 1)
                            ->where('a.bulan', $bulan)
                            ->where('a.tahun', $tahun)
                            ->get()->result_array();
        }


        public function getRencanaKinerja($bulan, $tahun){
            $id =  $this->general_library->getId();
            return $this->db->select('*')
                            ->from('t_rencana_kinerja as a')
                            ->where('a.id_m_user', $id)
                            ->where('a.tahun', $tahun)
                            ->where('a.bulan', $bulan)
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
        }

        public function getSatuan()
    {      
        $id = $this->input->post('id_t_rencana_kinerja');
        $this->db->select('*, , (select  sum(realisasi_target_kuantitas) from t_kegiatan where t_kegiatan.id_t_rencana_kinerja = a.id and t_kegiatan.status_verif = 1) as total_realisasi_kuantitas,
        ( SELECT sum( realisasi_target_kuantitas ) FROM t_kegiatan WHERE t_kegiatan.id_t_rencana_kinerja = a.id AND t_kegiatan.status_verif = 0 ) AS total_belum_verif ')
            ->from('t_rencana_kinerja as a')
            ->where('a.id', $id)
            ->where('a.flag_active', 1)
            ->limit(1);
            return $this->db->get()->result_array();
    }

    public function loadRekapKinerjaBU(){

        
        $id =  $this->general_library->getId();
        if($this->input->post()) {
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
        } else {
            $bulan = date('n');
            $tahun = date('Y');
        }
       
       
        $query = $this->db->select('a.*,
        (select sum(b.realisasi_target_kuantitas) from t_kegiatan as b where a.id = b.id_t_rencana_kinerja and b.flag_active = 1 and b.status_verif = 1) as realisasi_target_kuantitas
        ')
                        ->from('t_rencana_kinerja a')
                        ->where('a.id_m_user', $id)
                        ->where('a.tahun', $tahun)
                        ->where('a.bulan', $bulan)
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
        // dd($query);
        return $query;  
    }

    public function loadRekapKinerja($tahun,$bulan){

        
        $id =  $this->general_library->getId();
        if($tahun) {
            $bulan = $bulan;
            $tahun = $tahun;
        } else {
            $bulan = date('n');
            $tahun = date('Y');
        }
       
       
        $query = $this->db->select('a.*,
        (select sum(b.realisasi_target_kuantitas) from t_kegiatan as b where a.id = b.id_t_rencana_kinerja and b.flag_active = 1 and b.status_verif = 1) as realisasi_target_kuantitas
        ')
                        ->from('t_rencana_kinerja a')
                        ->where('a.id_m_user', $id)
                        ->where('a.tahun', $tahun)
                        ->where('a.bulan', $bulan)
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
        // dd($query);
        return $query;  
    }


    function getRencanaKerja(){
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $query = $this->db->get_where('t_rencana_kinerja', array('flag_active' => 1, 'bulan' => $bulan, 'tahun' => $tahun, 'id_m_user' => $this->general_library->getId()));
        return $query;
    }

    
    public function getReaslisasiKinerjaEdit($id){
        return $this->db->select('a.*, b.tugas_jabatan')
                        ->from('t_kegiatan a')
                        ->join('t_rencana_kinerja b', 'a.id_t_rencana_kinerja = b.id')
                        ->where('a.id', $id)
                        ->where('a.flag_active', 1)
                        ->limit(1)
                        ->get()->row_array();
    }


    public function editRealisasiKinerja(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        
        $this->db->trans_begin();
        $id_kegiatan = $datapost['id_kegiatan'];

        $data["realisasi_target_kuantitas"] = $datapost["edit_realisasi_target_kuantitas"];
        $data["deskripsi_kegiatan"] = $datapost["edit_deskripsi_kegiatan"];
        $data["tanggal_kegiatan"] = $datapost["edit_tanggal_kegiatan"];


        $this->db->where('id', $id_kegiatan)
                ->update('t_kegiatan', $data);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }


    public function editRencanaKinerja(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        
        $this->db->trans_begin();
        $id_rencana_kinerja = $datapost['id_rencana_kinerja'];

    
        $data["target_kuantitas"] = $datapost["edit_target_kuantitas"];
        $data["satuan"] = $datapost["edit_satuan"];


        $this->db->where('id', $id_rencana_kinerja)
                ->update('t_rencana_kinerja', $data);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }


    public function getRencanaKinerjaEdit($id){
        return $this->db->select('a.*')
                        ->from('t_rencana_kinerja a')
                        ->where('a.id', $id)
                        ->where('a.flag_active', 1)
                        ->limit(1)
                        ->get()->row_array();
    }

    public function createSkpBulanan($data){
        $pegawai = $this->db->select('a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, 
        a.id_m_bidang, c.id_unitkerja, c.id_unitkerjamaster, f.nama_bidang, a.id_m_sub_bidang,
        (SELECT aa.nm_jabatan FROM db_pegawai.pegjabatan aa WHERE b.id_peg = aa.id_pegawai ORDER BY aa.tmtjabatan DESC LIMIT 1) as nama_jabatan')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            // ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_bidang f', 'a.id_m_bidang = f.id', 'left')
                            ->where('a.flag_active', 1)
                            ->where('a.id', $this->general_library->getId())
                            ->get()->row_array();
        // dd($pegawai);
        $atasan = "";
        $flag_sekolah = false;
        $flag_kelurahan = false;
        $flag_kecamatan = false;
        $explodeuk = explode(" ", $pegawai['nm_unitkerja']);
        $kepala_pd = "kepalabadan";

        if($this->general_library->isPelaksana() || $this->general_library->isKasub()){
            $atasan = 'kepalabidang';
            if($explodeuk[0] == 'Kelurahan'){
                $flag_kelurahan = true;
                $atasan = 'sekretarisbadan';
                $kepala_pd = "lurah";
            } else if($explodeuk[0] == 'Kecamatan'){
                $flag_kecamatan = true;
                $atasan = 'sekretarisbadan';
                $kepala_pd = "camat";
            }

            if($pegawai['nama_bidang'] == 'Sekretariat'){
                $atasan = 'subkoordinator';
            }
        } else if($this->general_library->isKabid() || $this->general_library->isSekban()){
            $atasan = 'kepalabadan';
            if($explodeuk[0] == 'Kelurahan'){
                $flag_kelurahan = true;
                $atasan = 'lurah';
                $kepala_pd = "camat";
            } else if($explodeuk[0] == 'Kecamatan'){
                $flag_kecamatan = true;
                $atasan = 'camat';
                $kepala_pd = "setda";
            }
        } else if($this->general_library->isKaban()){
            $atasan = 'setda';
        } else if($this->general_library->isSetda()){
            $atasan = 'walikota';
        } else if($this->general_library->isGuruStaffSekolah()){
            $atasan = 'kepalasekolah';
            $flag_sekolah = true;
        } else if($this->general_library->isKepalaSekolah()){
            $atasan = 'kepalabidang';
            $flag_sekolah = true;
        } else if($this->general_library->isLurah()){
            $atasan = 'camat';
            $kepala_pd = "setda";
            $flag_kelurahan = true;
        } else if($this->general_library->isCamat()){
            $atasan = 'setda';
            $kepala_pd = "setda";
            $flag_kecamatan = true;
        }

        // $flag_sekolah = false;
        // if($this->general_library->isPelaksana()){
        //     $kepala_pd = 'kepalabadan';
        // } else if($this->general_library->isKabid() || $this->general_library->isSekban()){
        //     $kepala_pd = 'kepalabadan';
        // } else if($this->general_library->isKaban()){
        //     $kepala_pd = 'setda';
        // } else if($this->general_library->isSetda()){
        //     $kepala_pd = 'walikota';
        // } else if($this->general_library->isGuruStaffSekolah()){
        //     $kepala_pd = 'kepalasekolah';
        //     $flag_sekolah = true;
        // } else if($this->general_library->isKepalaSekolah()){
        //     $kepala_pd = 'kepalabidang';
        //     $flag_sekolah = true;
        // }

    
        // dd($kepala_pd);
        $atasan_pegawai = null;
        if($flag_sekolah){
            //kepala pd guru dan kepsek adalah kadis pendidikan
            $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('b.skpd', ID_UNITKERJA_DIKBUD)
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $kepala_pd)
                            ->where('a.flag_active', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            if($this->general_library->isGuruStaffSekolah()){
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            // ->where('a.id_m_bidang', $pegawai['id_m_bidang'])
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $atasan)
                            ->where('a.flag_active', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            } else if ($this->general_library->isKepalaSekolah()){
                $id_role_kabid = '58'; //kepsek SMP
                if($pegawai['id_unitkerjamaster'] == '8010000'){
                    $id_role_kabid = '57'; //kepsek SD
                }
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('a.id_m_bidang', $id_role_kabid)
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $atasan)
                            ->where('a.flag_active', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            }
        } else if($flag_kecamatan || $flag_kelurahan){
            //jika pegawai kecamatan atau kelurahan
            // $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, f.id_m_bidang')
            //                             ->from('m_user a')
            //                             ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            //                             ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
            //                             ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
            //                             ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
            //                             ->join('m_sub_bidang f', 'a.id_m_sub_bidang = f.id')
            //                             ->join('m_user_role g', 'a.id = g.id_m_user')
            //                             ->join('m_role h', 'g.id_m_role = h.id')
            //                             ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
            //                             ->where('a.id !=', $this->general_library->getId())
            //                             ->where('h.role_name', $atasan)
            //                             ->where('a.flag_active', 1)
            //                             ->where('g.flag_active', 1)
            //                             ->group_by('a.id')
            //                             ->limit(1)
            //                             ->get()->row_array();

            if($atasan == 'lurah' || $atasan == 'sekretarisbadan'){
                //jika atasan lurah, maka kepala_pd camat
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $atasan)
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();

                $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $kepala_pd)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
            } else if($atasan == 'camat') {
                //jika atasan camat, maka kepala_pd setda
                if($flag_kelurahan){
                    $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $atasan)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
                } else {
                    $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $atasan)
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
                }

                $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        // ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $kepala_pd)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
            } else if ($atasan == 'setda'){
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        // ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $kepala_pd)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
                $kepala_pd = $atasan_pegawai;
            }
        } else {
            $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('b.skpd', $pegawai['id_unitkerja'])
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $kepala_pd)
                            ->where('g.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            if($atasan == 'kepalabadan'){
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $atasan)
                                        ->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->group_by('a.id')
                                        ->limit(1)->get()->row_array();
            } else {
                $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $atasan)
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->group_by('a.id')
                                        ->limit(1);

                if($atasan != 'setda'){
                    $this->db->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
                            ->where('a.id_m_bidang', $pegawai['id_m_bidang']);
                }

                if($pegawai['nama_bidang'] == 'Sekretariat' && $atasan == 'subkoordinator'){
                    $this->db->where('a.id_m_sub_bidang', $pegawai['id_m_sub_bidang'])
                            ->where('d.eselon !=', "Non Eselon");
                }

                $atasan_pegawai = $this->db->get()->row_array();
            }
            if(!$atasan_pegawai){
                $atasan = 'sekretarisbadan';
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $atasan)
                            ->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
                            ->where('a.flag_active', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
                if(!$atasan_pegawai){
                    $atasan = 'kepalabadan';
                    $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $atasan)
                            ->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
                            ->where('g.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
                }
            }
        }

        $rencana_kinerja = $this->db->select('a.*,
                                (SELECT SUM(b.realisasi_target_kuantitas)
                                FROM t_kegiatan b
                                WHERE b.id_t_rencana_kinerja = a.id
                                AND b.flag_active = 1) as realisasi')
                                ->from('t_rencana_kinerja a')
                                ->where('a.id_m_user', $pegawai['id'])
                                ->where('a.bulan', floatval($data['bulan']))
                                ->where('a.tahun', floatval($data['tahun']))
                                ->where('a.flag_active', 1)
                                ->order_by('a.created_date')
                                ->get()->result_array();
        
        $komponen_kinerja = $this->db->select('*')
                                    ->from('t_komponen_kinerja a')
                                    ->where('a.id_m_user', $pegawai['id'])
                                    ->where('a.bulan', floatval($data['bulan']))
                                    ->where('a.tahun', floatval($data['tahun']))
                                    ->where('a.flag_active', 1)
                                    ->get()->row_array();

        return [$pegawai, $atasan_pegawai, $rencana_kinerja, $kepala_pd, $komponen_kinerja];
    }


    public function getListRencanaKinerjaTugas(){
        return $this->db->select('a.tugas_jabatan')
                        ->from('t_rencana_kinerja as a ')
                        ->where('a.id_m_user',$this->general_library->getId())
                        ->where('a.flag_active', 1)
                        ->group_by('a.tugas_jabatan')
                        ->get()->result_array();
    }

    public function getListRencanaKinerjaSasaran(){
        return $this->db->select('a.sasaran_kerja')
                        ->from('t_rencana_kinerja as a ')
                        ->where('a.id_m_user',$this->general_library->getId())
                        ->where('a.flag_active', 1)
                        ->group_by('a.sasaran_kerja')
                        ->get()->result_array();
    }

    public function loadDataPendukungByStatus($status, $bulan, $tahun, $id_unitkerja = 0){
        $this->db->select('c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user, d.status as status_dokumen, e.nama as nama_verif')
        ->from('t_dokumen_pendukung a')
        ->join('m_user b', 'a.id_m_user = b.id')
        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        ->join('m_status_dokumen_pendukung d', 'a.status = d.id')
        ->join('m_user e', 'a.id_m_user_verif = e.id', 'left')
        ->where('a.bulan', floatval($bulan))
        ->where('a.tahun', floatval($tahun))
        ->where('a.status', floatval($status))
        ->where('a.flag_active', 1)
        ->order_by('a.created_date', 'desc');
        
        if($this->general_library->isAdministrator()){
           $this->db->where('c.skpd', $this->general_library->getUnitKerjaPegawai()); 
        } 
        // else if($this->general_library->isProgrammer ) {
        //     $this->db->where('a.id_m_user', $this->general_library->getId());
        // } 
        else {
            $this->db->where('a.id_m_user', $this->general_library->getId());
        }

        $result = $this->db->get()->result_array();

        $id_count = $this->general_library->getId();
        if($this->general_library->isAdministrator() || $this->general_library->isProgrammer()){
            $id_count = $this->general_library->getUnitKerjaPegawai();
        } 
        $count = $this->countTotalDataPendukung($id_count, $bulan, $tahun);
        return [$result, $count];
    }

    public function searchDisiplinKerja($data){
        $result = null;

        if(!isset($data['id_unitkerja'])){
            if($this->general_library->isProgrammer() || $this->general_library->isAdministrator()) {
                $data['id_unitkerja'] = $this->general_library->getUnitKerjaPegawai();
            }
        }

        $this->db->select('c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user, d.status as status_dokumen, e.nama as nama_verif')
            ->from('t_dokumen_pendukung a')
            ->join('m_user b', 'a.id_m_user = b.id')
            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
            ->join('m_status_dokumen_pendukung d', 'a.status = d.id')
            ->join('m_user e', 'a.id_m_user_verif = e.id', 'left')
            ->where('a.bulan', floatval($data['bulan']))
            ->where('a.tahun', floatval($data['tahun']))
            ->where('a.flag_active', 1)
            ->order_by('a.created_date', 'desc');
        if(isset($data['id_unitkerja'])){
            $this->db->where('c.skpd', $data['id_unitkerja']);
        } else {
            $this->db->where('a.id_m_user', $this->general_library->getId());
        }
        $disiplin_kerja = $this->db->get()->result_array();
        // if(!isset($data['id_unitkerja'])){
            $result['pengajuan'] = [];
            $result['diterima'] = [];
            $result['ditolak'] = [];
            $result['batal'] = [];
            if($disiplin_kerja){
                foreach($disiplin_kerja as $d){
                    if($d['status'] == 1){
                        $result['pengajuan'][] = $d;
                    } else if($d['status'] == 2){
                        $result['diterima'][] = $d;
                    } else if($d['status'] == 3){
                        $result['ditolak'][] = $d;
                    } else if($d['status'] == 4){
                        $result['batal'][] = $d;
                    }
                }
            }
            return $result;
        // }

        // if($disiplin_kerja){
        //     foreach($disiplin_kerja as $dk){
        //         $result[$dk['nip']]['nip'] = $dk['nip'];
        //         $result[$dk['nip']]['nama'] = getNamaPegawaiFull($dk);
        //         $result[$dk['nip']]['id_m_user'] = $dk['id_m_user'];
                
        //         if(isset($result[$dk['nip']]['jenis_disiplin'])){
        //             if(!in_array($dk['keterangan'], $result[$dk['nip']]['jenis_disiplin'])){
        //                 $result[$dk['nip']]['jenis_disiplin'][] = $dk['keterangan'];
        //             }
        //         } else {
        //             $result[$dk['nip']]['jenis_disiplin'][] = $dk['keterangan'];
        //         }
        //     }
        // }

        // return $result;
    }

    public function insertDisiplinKerja($data, $filename){
        $rs['code'] = 0;
        $rs['message'] = '';

        $this->db->trans_begin();

        $tanggal = explodeRangeDateNew($data['range_periode']);
        $jenis_disiplin = explode(';', $data['jenis_disiplin']);

        $list_tanggal = getDateBetweenDates($tanggal[0], $tanggal[1]);
        
        $insert_data = null;
        $i = 0;
        foreach($data['pegawai'] as $d){
            $disiplin = explode(';', $data['jenis_disiplin']);
            foreach($list_tanggal as $l){
                // if(getNamaHari($l) != 'Sabtu' && getNamaHari($l) != 'Minggu'){
                    $date = explode('-', $l);
                    $insert_data[$i]['id_m_user'] = $d;
                    $insert_data[$i]['tahun'] = $date[0];
                    $insert_data[$i]['bulan'] = $date[1];
                    $insert_data[$i]['tanggal'] = $date[2];
                    $insert_data[$i]['id_m_jenis_disiplin_kerja'] = $disiplin[0];
                    if($disiplin[0] == 14){
                        $insert_data[$i]['keterangan'] = $data['jenis_tugas_luar'];
                    } else {
                        $insert_data[$i]['keterangan'] = $disiplin[1];
                    }
                   
                    $insert_data[$i]['pengurangan'] = $disiplin[2];
                    $insert_data[$i]['dokumen_pendukung'] = $filename;
                    $insert_data[$i]['created_by'] = $this->general_library->getId();

                    $i++;
                // }
            }
        }
        $this->db->insert_batch('t_dokumen_pendukung', $insert_data);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $rs;
    }

    public function countTotalDataPendukung($id, $bulan, $tahun, $flag_verif = 0){
        $rs['pengajuan'] = 0;
        $rs['diterima'] = 0;
        $rs['ditolak'] = 0;
        $rs['batal'] = 0;

        $this->db->select('COUNT(a.id) as total, a.status')
                ->from('t_dokumen_pendukung a')
                ->join('m_status_dokumen_pendukung b', 'a.status = b.id')
                ->join('m_user c', 'a.id_m_user = c.id')
                ->join('db_pegawai.pegawai d', 'c.username = d.nipbaru_ws')
                ->where('a.bulan', floatval($bulan))
                ->where('a.tahun', floatval($tahun))
                ->where('a.flag_active', 1)
                ->group_by('a.status');

        if($this->general_library->isProgrammer() || $this->general_library->isAdministrator() || ($this->general_library->getBidangUser() == ID_BIDANG_PEKIN && $flag_verif == 1)){
            $this->db->where('d.skpd', $id);
        } else {
            $this->db->where('a.id_m_user', $id);
        }
        
        $count = $this->db->get()->result_array(); 

        if($count){
            
            foreach($count as $c){
                if($c['status'] == 1){
                    $rs['pengajuan'] = $c['total'];
                } else if($c['status'] == 2){
                    $rs['diterima'] = $c['total'];
                } else if($c['status'] == 3){
                    $rs['ditolak'] = $c['total'];
                } else if($c['status'] == 4){
                    $rs['batal'] = $c['total'];
                }
            }
        }

        return $rs;
    }

    public function deleteDataDisiplinKerja($id){
        $res['code'] = 0;
        $res['message'] = 'OK';
        $res['data'] = null;

        $this->db->trans_begin();

        $this->db->where('id', $id)
                ->update('t_dokumen_pendukung', ['flag_active' => 0]);
        
        $tmp = $this->db->select('*')
                        ->from('t_dokumen_pendukung', $id)
                        ->get()->row_array();

        $id_count = $tmp['id_m_user'];
        if($this->general_library->isProgrammer() || $this->general_library->isAdministrator()){
            $id_count = $this->general_library->getUnitKerjaPegawai();
        }
        $res['data'] = $this->countTotalDataPendukung($id_count, $tmp['bulan'], $tmp['tahun']);

        if(!$res['data']){
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan Saat Menghapus Data';
        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }
        
        return $res;
    }

    public function deleteDataDisiplinKerjaByIdUser($data){
        $this->db->where('id_m_user', $data['id_m_user'])
                ->where('bulan', $data['bulan'])
                ->where('tahun', $data['tahun'])
                ->update('t_dokumen_pendukung', ['flag_active' => 0]);
    }

    public function cekRencanaKinerjaApelPagi(){

        $this->db->trans_begin();
        $bulan = date('n');
        $kegiatan = "Mengikuti Apel Pagi";
         $cekApelPagi = $this->db->select('*')
                        ->from('t_rencana_kinerja as a ')
                        ->where('a.id_m_user',$this->general_library->getId())
                        ->where('a.bulan', $bulan)
                        ->where('a.tugas_jabatan', $kegiatan)
                        ->where('a.flag_active', 1)
                        ->get()->row_array();
                       
        if(!$cekApelPagi) {
            $data["id_m_user"] = $this->general_library->getId();
            $data["tugas_jabatan"] = "Mengikuti Apel Pagi";
            $data["sasaran_kerja"] = "Terciptanya Disiplin Pegawai";
            $data["tahun"] = 2022;
            $data["bulan"] = 6;
            $data["target_kuantitas"] = 1;
            $data["satuan"] = "Kegiatan";
            $data["target_kualitas"] = 100;
            $this->db->insert('t_rencana_kinerja', $data);
        } 

        if ($this->db->trans_status() === FALSE)
            {
                    $this->db->trans_rollback();
            }
            else
            {
                    $this->db->trans_commit();
            }        
    }
    
    public function openModalDetailDisiplinKerja($id, $bulan, $tahun){
        return $this->db->select('a.*, c.nama, c.gelar1, c.gelar2, b.username as nip, b.id as id_m_user')
                        ->from('t_dokumen_pendukung a')
                        ->join('m_user b', 'a.id_m_user = b.id')
                        ->join('db_pegawai.pegawai c', 'c.nipbaru_ws = b.username')
                        ->where('b.id', $id)
                        ->where('a.bulan', $bulan)
                        ->where('a.tahun', $tahun)
                        ->where('a.flag_active', 1)
                        ->order_by('a.created_date', 'desc')
                        ->get()->result_array();
    }

    public function searchVerifDokumen($data){
        $this->db->select('c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user, d.status as status_dokumen')
            ->from('t_dokumen_pendukung a')
            ->join('m_user b', 'a.id_m_user = b.id')
            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
            ->join('m_status_dokumen_pendukung d', 'a.status = d.id')
            ->where('a.bulan', floatval($data['bulan']))
            ->where('a.tahun', floatval($data['tahun']))
            ->where('c.skpd', $data['id_unitkerja'])
            ->where('a.flag_active', 1)
            ->order_by('a.created_date', 'desc');

        $disiplin_kerja = $this->db->get()->result_array();
        // if(!isset($data['id_unitkerja'])){
            $result['pengajuan'] = [];
            $result['diterima'] = [];
            $result['ditolak'] = [];
            $result['batal'] = [];
            if($disiplin_kerja){
                foreach($disiplin_kerja as $d){
                    if($d['status'] == 1){
                        $result['pengajuan'][] = $d;
                    } else if($d['status'] == 2){
                        $result['diterima'][] = $d;
                    } else if($d['status'] == 3){
                        $result['ditolak'][] = $d;
                    } else if($d['status'] == 4){
                        $result['batal'][] = $d;
                    }
                }
            }
            return $result;
    }

    public function loadSearchVerifDokumen($status, $bulan, $tahun, $id_unitkerja = 0){
        $this->db->select('c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user, d.status as status_dokumen, e.nama as nama_verif')
        ->from('t_dokumen_pendukung a')
        ->join('m_user b', 'a.id_m_user = b.id')
        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        ->join('m_status_dokumen_pendukung d', 'a.status = d.id')
        ->join('m_user e', 'a.id_m_user_verif = e.id', 'left')
        ->where('a.bulan', floatval($bulan))
        ->where('a.tahun', floatval($tahun))
        ->where('a.status', floatval($status))
        ->where('c.skpd', $id_unitkerja)
        ->where('a.flag_active', 1);

        if($status == 1){
            $this->db->order_by('created_date', 'asc');
        } else {
            $this->db->order_by('a.updated_date', 'desc');
        }

        $result = $this->db->get()->result_array();

        $id_count = $id_unitkerja;
        $count = $this->countTotalDataPendukung($id_count, $bulan, $tahun, 1);
        return [$result, $count];
    }
    
    public function verifDokumen($id, $status){
        $rs['code'] = 0;        
        $rs['message'] = 'OK';        
        $this->db->trans_begin();

        $data_verif['status'] = $status;
        $data_verif['id_m_user_verif'] = $this->general_library->getId();
        $data_verif['updated_by'] = $this->general_library->getId();
        $data_verif['tanggal_verif'] = date('Y-m-d H:i:s');
        if($status == 2 || $status == 3){
            $data_verif['keterangan_verif'] = $this->input->post('keterangan');
        }

        $this->db->where('id', $id)
                ->update('t_dokumen_pendukung', $data_verif);

        $temp = $this->db->select('c.skpd, a.bulan, a.tahun')
                        ->from('t_dokumen_pendukung a')
                        ->join('m_user b', 'a.id_m_user = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->where('a.id', $id)
                        ->get()->row_array();

        $rs['data'] = $this->countTotalDataPendukung($temp['skpd'], $temp['bulan'], $temp['tahun'], 1);

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $rs['code'] = 1;        
            $rs['message'] = 'Terjadi Kesalahan';
        }else{
            $this->db->trans_commit();
        }
        
        return $rs;
    }


    public function getPaguTppUnitKerja($id_unitkerja, $unitkerja){
        $result = null;
        $list_tpp_kelas_jabatan = $this->session->userdata('list_tpp_kelas_jabatan');
        $j = 1;
        foreach($list_tpp_kelas_jabatan as $lt){
            $result[$j]['jft'] = $lt;
            $result[$j]['jfu'] = $lt;
            $result[$j]['eselon_4'] = $lt;
            $result[$j]['kepala_skpd'] = $lt;
            $result[$j]['semua'] = $lt;
            $j++;
        }

        $flag_kec_kel_puskes = 0;
        if(in_array($unitkerja['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_KECAMATAN)){
            $flag_kec_kel_puskes = 1;
        }

        if($flag_kec_kel_puskes == '0'){
            $explode_nama = explode(" ", $unitkerja['nm_unitkerja']);
            if($explode_nama[0] == 'Puskesmas'){
                $flag_kec_kel_puskes = 1;
            }
        }

        $presentase_tpp = $this->db->select('*')
                                ->from('m_presentase_tpp')
                                ->where('id_unitkerja', $id_unitkerja)
                                ->where('flag_active', 1)
                                ->get()->result_array();

        $presentase_semua = $this->db->select('*')
                            ->from('m_presentase_tpp')
                            ->where('id_unitkerja', $id_unitkerja)
                            ->where('kelas_jabatan', 0)
                            ->where('jenis_jabatan', 'semua')
                            ->where('flag_active', 1)
                            ->get()->result_array();

        if($presentase_tpp || $flag_kec_kel_puskes == 1){
            $temp_presentase_tpp = null;

            if($flag_kec_kel_puskes == 1 && !$presentase_tpp){ //jika unit kerja adalah kecamatan / kelurahan / puskesmas
                if(in_array($unitkerja['id_unitkerja'], LIST_UNIT_KERJA_KECAMATAN)){ // kecamatan
                    $presentase_tpp[0]['kelas_jabatan'] = 12;
                    $presentase_tpp[0]['presentase'] = 160;
                    $presentase_tpp[0]['jenis_jabatan'] = 'kepala_skpd';
                } else if(in_array($unitkerja['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_KECAMATAN)) { // kelurahan
                    $presentase_tpp[0]['kelas_jabatan'] = 9;
                    $presentase_tpp[0]['presentase'] = 170;
                    $presentase_tpp[0]['jenis_jabatan'] = 'kepala_skpd';
                } else if($explode_nama[0] == 'Puskesmas'){ //puskesmas
                    $presentase_tpp[0]['kelas_jabatan'] = 9;
                    $presentase_tpp[0]['presentase'] = 290;
                    $presentase_tpp[0]['jenis_jabatan'] = 'kepala_skpd';
                }
            }

            $list_exclude = [];
            if($presentase_semua && (count($presentase_tpp) > 1)){ //jika ada syarat TPP untuk semua pegawai dan syarat TPP lebih dari 1 syarat di unit kerja tersebut
                $j = 1;
                foreach($presentase_tpp as $p){ //exclude jenis jabatan dan kelas jabatan tertentu dari presentase yang mewakili semua pegawai dalam PD
                    if($p['kelas_jabatan'] != '0' && $p['jenis_jabatan'] == 'semua'){
                        $list_exclude[$p['kelas_jabatan']] = ['jft', 'jfu', 'eselon_4', 'kepala_skpd'];
                    } else if($p['kelas_jabatan'] == '0' && $p['jenis_jabatan'] != 'semua'){
                        array_push($list_exclude[0], $p['jenis_jabatan']);
                    } else if($p['kelas_jabatan'] != '0' && $p['jenis_jabatan'] != 'semua'){
                        // $list_exclude[[$p['kelas_jabatan']]] = 1;
                        if(!isset($list_exclude[$p['kelas_jabatan']])){
                            $list_exclude[$p['kelas_jabatan']] = [];
                        }
                        array_push($list_exclude[$p['kelas_jabatan']], $p['jenis_jabatan']);
                    } 
                    $j++;
                }
            }

            foreach($presentase_tpp as $prt){
                if($prt['kelas_jabatan'] == '0' && $prt['jenis_jabatan'] == 'semua'){ // semua pegawai
                    $j = 1;
                    foreach($list_tpp_kelas_jabatan as $ltj){
                        if(!isset($list_exclude[$j])){
                            if(!isset($list_exclude[0]['jft'])){
                                $result[$j]['jft'] = floatval($ltj) * floatval($prt['presentase'] / 100);
                            }
                            if(!isset($list_exclude[0]['jfu'])){
                                $result[$j]['jfu'] = floatval($ltj) * floatval($prt['presentase'] / 100);
                            }
                            if(!isset($list_exclude[0]['eselon_4'])){
                                $result[$j]['eselon_4'] = floatval($ltj) * floatval($prt['presentase'] / 100);
                            }
                            if(!isset($list_exclude[0]['kepala_skpd'])){
                                $result[$j]['kepala_skpd'] = floatval($ltj) * floatval($prt['presentase'] / 100);
                            }
                            $result[$j]['semua'] = floatval($ltj) * floatval($prt['presentase'] / 100);
                        }
                        $j++;
                    }
                } else if($prt['kelas_jabatan'] == '0'){ // semua kelas jabatan
                    $j = 1;
                    foreach($list_tpp_kelas_jabatan as $ltj){
                        $result[$j][$prt['jenis_jabatan']] = floatval($ltj) * floatval($prt['presentase'] / 100);
                        $j++;
                    }
                } else if($prt['jenis_jabatan'] == '0'){// semua jenis jabatan
                    // $j = 1;
                    // foreach($list_tpp_kelas_jabatan as $ltj){
                        $result[$prt['kelas_jabatan']]['jft'] = floatval($list_tpp_kelas_jabatan[$prt['kelas_jabatan']]) * floatval($prt['presentase'] / 100);
                        $result[$prt['kelas_jabatan']]['jfu'] = floatval($list_tpp_kelas_jabatan[$prt['kelas_jabatan']]) * floatval($prt['presentase'] / 100);
                        $result[$prt['kelas_jabatan']]['eselon_4'] = floatval($list_tpp_kelas_jabatan[$prt['kelas_jabatan']]) * floatval($prt['presentase'] / 100);
                        $result[$prt['kelas_jabatan']]['semua'] = floatval($list_tpp_kelas_jabatan[$prt['kelas_jabatan']]) * floatval($prt['presentase'] / 100);
                        $result[$prt['kelas_jabatan']]['kepala_skpd'] = floatval($list_tpp_kelas_jabatan[$prt['kelas_jabatan']]) * floatval($prt['presentase'] / 100);
                        // $j++;
                    // }
                    // if($prt['kelas_jabatan'] == 12){
                    //     dd($result[$prt['kelas_jabatan']]);
                    // }
                } else {
                    $result[$prt['kelas_jabatan']][$prt['jenis_jabatan']] = $list_tpp_kelas_jabatan[$prt['kelas_jabatan']] * ($prt['presentase'] / 100);
                }
            }
        }
        // dd(json_encode($result));
        return $result;
    }

    public function countPaguTpp($data){
        $result = null;

        $unitkerja = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerja', $data['id_unitkerja'])
                            ->get()->row_array();

        $pagu_tpp = $this->getPaguTppUnitKerja($data['id_unitkerja'], $unitkerja);

        $nama_unit_kerja = explode(" ", $unitkerja['nm_unitkerja']);
                            
        $pegawai = $this->db->select('a.nipbaru_ws, a.nama, a.gelar1, a.gelar2, b.nm_pangkat,
                            b.kelas_jabatan_jfu, b.kelas_jabatan_jft, b.id_pangkat, a.statuspeg,
                            (SELECT CONCAT(
                                IF( c.nama_jabatan IS NULL, "", c.nama_jabatan ),
                                    ";",
                                IF( c.kepalaskpd IS NULL, "", c.kepalaskpd ),
                                    ";",
                                IF( aa.jenisjabatan IS NULL, "", aa.jenisjabatan ),
                                    ";",
                                IF( d.id_eselon IS NULL, "", d.id_eselon ) 
                                ) 
                            FROM db_pegawai.pegjabatan aa
                            WHERE aa.id_pegawai = a.id_peg
                            ORDER BY tmtjabatan DESC
                            LIMIT 1) as jabatan')
                            ->from('db_pegawai.pegawai a')
                            ->join('m_pangkat b', 'a.pangkat = b.id_pangkat')
                            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                            ->join('db_pegawai.eselon d', 'c.eselon = d.nm_eselon')
                            ->where('a.skpd', $data['id_unitkerja'])
                            ->order_by('c.eselon, a.nama')
                            ->get()->result_array();
        // dd($pegawai);
        if($pegawai){
            $i = 0;
            foreach($pegawai as $p){
                $result[$i] = $p;
                $result[$i]['kepala_skpd'] = 0;
                $concat = explode(";", $p['jabatan']);
                $nama_jabatan = explode(" ", $concat[0]);
                $result[$i]['kelas_jabatan'] = $p['kelas_jabatan_jfu'];
                $result[$i]['nama_jabatan'] = $concat[0];
                $result[$i]['jenis_jabatan'] = 'jfu';
                // if($p['nipbaru_ws'] == '198701072011021001'){
                //     dd($nama_jabatan);
                //     // dd(
                //     //     (
                //     //         (
                //     //             isset($nama_jabatan[1]) && ($nama_jabatan[1] == 'Kepala')
                //     //         ) &&
                //     //         (
                //     //             isset($nama_jabatan[2]) && ($nama_jabatan[2] == 'Bagian') 
                //     //             || ($nama_jabatan[2] == 'Puskesmas')
                //     //         )
                //     //     )
                //     // );
                // }
                if((isset($concat[2]) && $concat[2] == '00') 
                || ((isset($nama_jabatan[0]) && ($nama_jabatan[0] == 'Kepala'))
                && (isset($nama_jabatan[1]) && ($nama_jabatan[1] == 'Bagian' || $nama_jabatan[1] == 'Puskesmas')))){ // pejabat struktural atau kepala puskesmas
                    if($concat[1] == 1){ // kepala skpd
                        $result[$i]['kepala_skpd'] = 1;
                        $result[$i]['jenis_jabatan'] = 'kepala_skpd';
                        $result[$i]['kelas_jabatan'] = 14;
                        if($data['id_unitkerja'] == 1000001){ //setda
                            $result[$i]['kelas_jabatan'] = 15;
                        } else if($nama_unit_kerja[0] == 'Kelurahan'){ // lurah
                            $result[$i]['kelas_jabatan'] = 9;
                        } else if($nama_unit_kerja[0] == 'Kecamatan'){ // camat
                            $result[$i]['kelas_jabatan'] = 12;
                        } else if($nama_unit_kerja[0] == 'Puskesmas'){ // kepala puskesmas
                            $result[$i]['kelas_jabatan'] = 9;
                        } else if($nama_unit_kerja[0] == 'Bagian'){ // kepala bagian
                            $result[$i]['kelas_jabatan'] = 12;
                        } else if($unitkerja['id_unitkerja'] == '7005020' || $unitkerja['id_unitkerja'] == '7005010'){ // RSUD & RSKDGDM
                            $result[$i]['kelas_jabatan'] = 12;
                        }
                    } else {
                        $eselon_jabatan = explode(" ", $concat[3]);
                        // if($p['nipbaru_ws'] == '197504272000122003'){
                        //     dd($concat);
                        // }
                        if($concat[3] == 6 || $concat[3] == 7){ // pejabat eselon 3
                            if($concat[3] == 6){ // sekretaris, inspektur pembantu
                                $result[$i]['kelas_jabatan'] = 12;
                            } else { //kabag, kabid
                                $result[$i]['kelas_jabatan'] = 11;
                                if($nama_unit_kerja[0] == 'Kecamatan'){ // sekretaris kecamatan 
                                    $result[$i]['kelas_jabatan'] = 11;
                                }
                            }
                            $result[$i]['jenis_jabatan'] = 'semua';
                        } else if($concat[3] == 8 || $concat[3] == 9){ //eselon 4, kasubag, kasubid, seklur
                            $result[$i]['kelas_jabatan'] = 9;
                            if($nama_unit_kerja[0] == 'Kelurahan' || $nama_unit_kerja[0] == 'Kecamatan'){
                                $result[$i]['kelas_jabatan'] = 8;
                            }
                            $result[$i]['jenis_jabatan'] = 'eselon_4';
                        } else if(($concat[3] == 4 || $concat[3] == 5) && $data['id_unitkerja'] == 1000001){ //asisten setda
                            $result[$i]['kelas_jabatan'] = 14;
                        }
                    }
                } else if (isset($concat[2]) && $concat[2] == '10'){ // pejabat fungsional
                    $list_jfu = ['Pelaksana', 'Staff', 'Staf'];
                    $result[$i]['jenis_jabatan'] = 'jfu';
                    // dd($p);
                    if(!in_array($concat[0], $list_jfu)){ // jft
                        $result[$i]['jenis_jabatan'] = 'jft';
                        $result[$i]['kelas_jabatan'] = $p['kelas_jabatan_jft'];
                    }
                }

                unset($result[$i]['kelas_jabatan_jfu']);
                unset($result[$i]['kelas_jabatan_jft']);
                
                $result[$i]['pagu_tpp'] = $pagu_tpp[$result[$i]['kelas_jabatan']][$result[$i]['jenis_jabatan']]; // pasang pagu tpp
                if($result[$i]['statuspeg'] == 1){ //pegawai CPNS
                    $result[$i]['pagu_tpp'] = $result[$i]['pagu_tpp'] * 0.8;
                }

                $i++;
            }
        }

        function comparator($object1, $object2) {
            return $object1['kelas_jabatan'] < $object2['kelas_jabatan'];
        }

        usort($result, 'comparator');
        // dd($result);
        return $result;
    }
}
?>