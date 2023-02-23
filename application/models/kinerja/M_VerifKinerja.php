<?php
	class M_VerifKinerja extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function getListIdPegawaiForVerif($data = null, $return_data_pegawai = false){
            $role = $this->general_library->getRole();
            $vt = $this->db->select('*')
                        ->from('t_verif_tambahan')
                        ->where('id_m_user', $this->general_library->getId())
                        ->where('flag_active', 1)
                        ->get()->result_array();
                        
            $list_user_tambahan = null;
            $list_bidang_tambahan = null;
            if($vt){
                foreach($vt as $v){
                    if($v['id_m_bidang']){
                        $list_bidang_tambahan[] = $v['id_m_bidang'];
                    } else {
                        $list_user_tambahan[] = $v['id_m_user_verif'];
                    }
                }
            }
            
            $this_user = $this->db->select('*')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                // ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                ->where('a.id', $this->general_library->getId())
                                ->where('a.flag_active', 1)
                                ->get()->row_array();

            $list_pegawai = null;
            if($role == 'subkoordinator'){
                //pegawai yang diverif adalah staf pelaksana di sub bidang yang sama
                $list_pegawai = $this->db->select('*, id as id_m_user')
                                        ->from('m_user')
                                        ->where('id_m_bidang', $this_user['id_m_bidang'])
                                        ->where('id !=', $this->general_library->getId())
                                        ->where('flag_active', 1)
                                        ->get()->result_array();
            } else if($role == 'kepalabidang' || $role == 'sekretarisbadan'){
                //pegawai yang diverif adalah subkoordinator di bidang yang sama
                // $subbidang = $this->db->select('*')
                //                         ->from('m_sub_bidang a')
                //                         ->where('a.id', $this_user['id_m_bidang'])
                //                         ->where('a.flag_active', 1)
                //                         ->get()->row_array();
                $list_role = ['subkoordinator', 'staffpelaksana'];

                $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                        ->from('m_user a')
                                        ->join('m_bidang b', 'a.id_m_bidang = b.id')
                                        ->join('m_user_role c', 'a.id = c.id_m_user')
                                        ->join('m_role d', 'c.id_m_role = d.id')
                                        ->where('b.id', $this_user['id_m_bidang'])
                                        ->where_in('d.role_name', $list_role)
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('a.flag_active', 1)
                                        ->where('c.flag_active', 1)
                                        ->get()->result_array();
                $list_pegawai_tambahan = null;
                if($this_user['id_m_bidang'] == 138 || $this_user['id_m_bidang'] == 134){
                    $unitkerjamaster = '8020000';
                    if($this_user['id_m_bidang'] == 134){
                        $unitkerjamaster = '8010000';
                    }
                    $list_role_tambahan = ['kepalasekolah'];
                    $list_pegawai_tambahan = $this->db->select('*, a.id as id_m_user')
                                                        ->from('m_user a')
                                                        // ->join('m_sub_bidang b', 'a.id_m_bidang = b.id')
                                                        ->join('m_user_role c', 'a.id = c.id_m_user')
                                                        ->join('m_role d', 'c.id_m_role = d.id')
                                                        ->join('db_pegawai.pegawai e', 'a.username = e.nipbaru_ws')
                                                        ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
                                                        ->where_in('d.role_name', $list_role_tambahan)
                                                        ->where('f.id_unitkerjamaster', $unitkerjamaster)
                                                        ->where('a.id !=', $this->general_library->getId())
                                                        ->where('a.flag_active', 1)
                                                        ->where('c.flag_active', 1)
                                                        ->get()->result_array();
                    if($list_pegawai_tambahan){
                        $count = count($list_pegawai);
                        foreach($list_pegawai_tambahan as $lpt){
                            $list_pegawai[$count] = $lpt;
                            $count++;
                        }
                    }
                }
            // } else if($role == 'kepalabadan'){
            } else if($this->general_library->isKaban()){
                if($data['filter'] == '0'){
                    $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role d', 'd.id = b.id_m_role')
                                            ->join('m_bidang c', 'c.id = a.id_m_bidang')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('a.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('c.flag_active', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
                } else if($data['filter'] == 'eselon_tiga' || $data['filter'] == 'eselon_empat'){
                    $list_bidang = null;
                    $bidang = $this->db->select('*')
                                    ->from('m_bidang')
                                    ->where('flag_active', 1)
                                    ->where('id_unitkerja', $this_user['skpd'])
                                    ->get()->result_array();
                    if($bidang){
                        foreach($bidang as $b){
                            $list_bidang[] = $b['id'];
                        }
                    }
                    
                    $list_role = ['kepalabidang', 'sekretarisbadan'];
                    if($data['filter'] == 'eselon_empat'){
                        $list_role = ['subkoordinator'];
                    }
                    $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role d', 'd.id = b.id_m_role')
                                            ->join('m_bidang c', 'c.id = a.id_m_bidang')
                                            ->where('a.id !=', $this->general_library->getId())
                                            ->where_in('d.role_name', $list_role)
                                            ->where_in('c.id', $list_bidang)
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('c.flag_active', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
                } else {
                    $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role d', 'd.id = b.id_m_role')
                                            ->join('m_bidang c', 'c.id = a.id_m_bidang')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('c.id', $data['filter'])
                                            ->where('a.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('c.flag_active', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
                }
            } else if($this->general_library->isWalikota() || $this->general_library->isSetda()){
                if($data['filter_walikota'] == 'skpd'){
                    $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->where('d.skpd', $data['filter_skpd'])
                                            ->where('a.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
                } else if($data['filter_walikota'] == 'eselon_dua'){
                    $list_role = ['kepalabadan', 'setda', 'camat', 'asisten'];
                    $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role c', 'c.id = b.id_m_role')
                                            ->where_in('c.role_name', $list_role)
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
                } else if($data['filter_walikota'] == 'pegawai'){
                    $list_role = ['kepalabadan', 'setda'];
                    $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                            ->or_like('b.nipbaru_ws', $data['nama_pegawai'])
                                            ->or_like('b.nipbaru', $data['nama_pegawai'])
                                            ->or_like('b.nama', $data['nama_pegawai'])
                                            ->where('a.flag_active', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
                }
            } else if($this->general_library->isKepalaSekolah()){
                $list_role = ['gurusekolah'];
                $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role c', 'c.id = b.id_m_role')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->where_in('c.role_name', $list_role)
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
            } else if($this->general_library->isLurah()){
                // $list_role = ['gurusekolah'];
                $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role c', 'c.id = b.id_m_role')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
            } else if($this->general_library->isCamat()){
                $list_role = ['lurah'];
                $list_pegawai = $this->db->select('*, a.id as id_m_user')
                                            ->from('m_user a')
                                            ->join('m_user_role b', 'a.id = b.id_m_user')
                                            ->join('m_role c', 'c.id = b.id_m_role')
                                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                                            ->where('d.skpd', $this->general_library->getUnitKerjaPegawai())
                                            ->where('a.flag_active', 1)
                                            ->where('b.flag_active', 1)
                                            ->where('a.flag_active', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
            }
            $list_id_pegawai = array();
            $list_data_pegawai = array();
            // dd($list_pegawai);
            if($list_pegawai){
                foreach($list_pegawai as $lp){
                    $list_id_pegawai[] = $lp['id_m_user'];
                    $list_data_pegawai[] = $lp;
                }
            }

            if($list_user_tambahan){
                foreach($list_user_tambahan as $lut){
                    $list_id_pegawai[] = $lut;
                    $list_data_pegawai[] = $lut;
                }
            }

            if($list_bidang_tambahan){
                $pegawai = $this->db->select('*, a.id as id_m_user')
                                    ->from('m_user a')
                                    ->where_in('a.id_m_bidang', $list_bidang_tambahan)
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();

                if($pegawai){
                    foreach($pegawai as $p){
                        $list_id_pegawai[] = $p['id_m_user'];
                        $list_data_pegawai[] = $p;
                    }
                }
            }
            if($return_data_pegawai){
                return $list_data_pegawai;
            }
            return $list_id_pegawai;
        }


        public function searchVerifKinerja($data){
            $range = explodeRangeDate($data['range_periode']);
            $startDate = explode("-", $range[0]);
            $endDate = explode("-", $range[1]);

            $startDate = $startDate[0].'-'.$startDate[2].'-'.$startDate[1];
            $endDate = $endDate[0].'-'.$endDate[2].'-'.$endDate[1];

            $list_id_pegawai = $this->getListIdPegawaiForVerif($data);
            if(!$list_id_pegawai){
                return null;
            }
            $list_kerja = null;
            $temp = $this->db->select('*, a.id as id_t_kegiatan, a.tanggal_kegiatan as tanggal_kegiatan, a.realisasi_target_kuantitas')
                                ->from('t_kegiatan a')
                                ->join('t_rencana_kinerja b', 'a.id_t_rencana_kinerja = b.id')
                                ->join('m_user c', 'a.id_m_user = c.id')
                                ->where('a.flag_active', 1)
                                ->where_in('a.id_m_user', $list_id_pegawai)
                                ->where('a.tanggal_kegiatan >=', $startDate.' 00:00:00')
                                ->where('a.tanggal_kegiatan <=', $endDate.' 23:59:59')
                                ->order_by('a.tanggal_kegiatan', 'desc')
                                ->group_by('a.id')
                                ->get()->result_array();

            if($temp){
                $urutan = [0, 3, 2, 1];
                foreach($urutan as $u){
                    foreach($temp as $t){
                        if($t['status_verif'] == $u){
                            $list_kerja[] = $t;
                        }
                    }
                }
            }

            return $list_kerja;
        }

        public function checkVerif($status, $id_t_kegiatan){
            $rs['code'] = 0;
            $rs['message'] = '';
            $rs['status'] = $status;

            $this->db->trans_begin();

            $data = $this->input->post();
            $kegiatan = $this->db->select('*')
                                ->from('t_kegiatan')
                                ->where('id', $id_t_kegiatan)
                                ->where('flag_active', 1)
                                ->get()->row_array();
            if($kegiatan){
                if($status == '1' || $status == '2'){
                    //verif bisa ditolak atau diterima hanya jika kegiatan belum diverif atau sudah batal verif
                    if($kegiatan['status_verif'] == '0' || $kegiatan['status_verif'] == '3'){
                        $this->db->where('id', $id_t_kegiatan)
                                ->update('t_kegiatan',
                                [
                                    'status_verif' => $status,
                                    'keterangan_verif' => $data['keterangan_verif'],
                                    'updated_by' => $this->general_library->getId(),
                                    'id_m_user_verif' => $this->general_library->getId(),
                                    'tanggal_verif' => date('Y-m-d H:i:s')
                                ]);
                        
                        $rencana_kegiatan = $this->db->select('a.*, sum(b.realisasi_target_kuantitas) as sum_realisasi')
                                                    ->from('t_rencana_kinerja a')
                                                    ->join('t_kegiatan b', 'a.id = b.id_t_rencana_kinerja')
                                                    ->where('a.flag_active', 1)
                                                    ->where('b.flag_active', 1)
                                                    ->where('b.status_verif', 1)
                                                    ->where('a.id', $kegiatan['id_t_rencana_kinerja'])
                                                    ->get()->row_array();

                        // if(floatval($rencana_kegiatan['sum_realisasi']) > 100){
                        //     $rencana_kegiatan['sum_realisasi'] = 100;
                        // }
                        $this->db->where('id', $rencana_kegiatan['id'])
                                    ->update('t_rencana_kinerja', ['total_realisasi' => floatval($rencana_kegiatan['sum_realisasi'])]);
                        
                    } else {
                        $rs['code'] = 1;
                        $rs['message'] = 'Kegiatan sudah terverifikasi';
                    }
                } else {
                    if($kegiatan['status_verif'] == '1' || $kegiatan['status_verif'] == '2'){
                        //hanya bisa batal verif jika kegiatan sudah diverif (tolak maupun setuju)
                        $this->db->where('id', $id_t_kegiatan)
                                ->update('t_kegiatan',
                                [
                                    'status_verif' => $status,
                                    'keterangan_verif' => "",
                                    'updated_by' => $this->general_library->getId(),
                                    'id_m_user_verif' => $this->general_library->getId(),
                                    'tanggal_verif' => date('Y-m-d H:i:s')
                                ]);

                        $rencana_kegiatan = $this->db->select('a.*, sum(b.realisasi_target_kuantitas) as sum_realisasi')
                                ->from('t_rencana_kinerja a')
                                ->join('t_kegiatan b', 'a.id = b.id_t_rencana_kinerja')
                                ->where('b.flag_active', 1)
                                ->where('a.flag_active', 1)
                                ->where('b.status_verif', 1)
                                ->where('a.id', $kegiatan['id_t_rencana_kinerja'])
                                ->get()->row_array();
                                    
                        // if(floatval($rencana_kegiatan['sum_realisasi']) > 100){
                        //     $rencana_kegiatan['sum_realisasi'] = 100;
                        // }
                        $this->db->where('id', $rencana_kegiatan['id'])
                                ->update('t_rencana_kinerja', ['total_realisasi' => floatval($rencana_kegiatan['sum_realisasi'])]);
                    } else {
                        $rs['code'] = 1;
                        $rs['message'] = 'Kegiatan tidak dapat dibatalkan verifikasinya karena belum dilakukan verifikasi';
                    }
                }
            } else {
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function loadDetailKegiatan($id){
            return $this->db->select('c.nama as nama_pegawai, c.username as nip_pegawai, a.id as id_t_kegiatan, a.created_date as tanggal_kegiatan,
                                    a. deskripsi_kegiatan, a.status_verif, a.realisasi_target_kuantitas, d.nama as nama_pegawai_verif, d.username as nip_pegawai_verif,
                                    b.tugas_jabatan, b.target_kuantitas, b.satuan, a.tanggal_verif, a.keterangan_verif, a.bukti_kegiatan')
                                    ->from('t_kegiatan a')
                                    ->join('t_rencana_kinerja b', 'a.id_t_rencana_kinerja = b.id')
                                    ->join('m_user c', 'a.id_m_user = c.id')
                                    ->join('m_user d', 'a.id_m_user_verif = d.id', 'left')
                                    ->where('a.flag_active', 1)
                                    ->where('a.id', $id)
                                    ->group_by('a.id')
                                    ->get()->row_array();
        }

        public function countTotalProgress($arr){
            $total_progress = 0;
            // dd($arr);
            if(isset($arr['rk']) && $arr['rk']){
                $total = 0;
                foreach($arr['rk'] as $total_progress){
                    $total += $total_progress;
                }
                //total progress = total / jumlah kegiatan;
                $total_progress = (floatval($total)/floatval(count($arr['rk'])));
            }

            return $total_progress;
        }

        public function searchRekapRealisasi($data){
            $rs = null;
            $list_id_pegawai = $this->getListIdPegawaiForVerif($data);
            if($list_id_pegawai){
                foreach($list_id_pegawai as $lid){
                    if($lid){
                        $rs[$lid] = array();
                    }
                }
            }
            
            if($list_id_pegawai){
                $this->db->select('*, a.id as id_t_rencana_kinerja')
                    ->from('t_rencana_kinerja a')
                    ->join('m_user b', 'a.id_m_user = b.id')
                    ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                    ->where('a.flag_active', 1)
                    ->where_in('a.id_m_user', $list_id_pegawai)
                    ->where('a.bulan', $data['bulan'])
                    ->where('a.tahun', $data['tahun'])
                    ->order_by('c.nama', 'asc')
                    ->group_by('a.id');
                if($this->general_library->isWalikota() || $this->general_library->isSetda()){
                    $this->db->join('db_pegawai.pegawai d', 'b.username = d.nipbaru_ws')
                            ->join('db_pegawai.unitkerja e', 'd.skpd = e.id_unitkerja');
                } else {
                    $this->db->join('m_bidang c', 'b.id_m_bidang = c.id');
                }
                $temp = $this->db->get()->result_array();
                if($temp){
                    $tmp_user_id = 0;
                    $count_kegiatan = 0;
                    $i = 0;
                    foreach($temp as $t){
                        if($tmp_user_id == $t['id_m_user']){ //jika masih id sama, jumlah kegiatan di tambah terus
                            $count_kegiatan++;
                        } else { // jika sudah beda, hitung presentase realisasi untuk pegawai sebelumnya
                            if(isset($rs[$tmp_user_id])){
                                $rs[$tmp_user_id]['total_progress'] = $this->countTotalProgress($rs[$tmp_user_id]);
                            }                            

                            $tmp_user_id = $t['id_m_user'];
                            $count_kegiatan = 1;
                        }

                        $rs[$t['id_m_user']]['id_m_user'] = $t['id_m_user'];
                        $rs[$t['id_m_user']]['id_rencana_kinerja'] = $t['id_t_rencana_kinerja'];
                        $rs[$t['id_m_user']]['nama_pegawai'] = $t['nama'];
                        $rs[$t['id_m_user']]['nama'] = $t['nama'];
                        $rs[$t['id_m_user']]['gelar1'] = $t['gelar1'];
                        $rs[$t['id_m_user']]['gelar2'] = $t['gelar2'];
                        $rs[$t['id_m_user']]['nip_pegawai'] = $t['username'];
                        $rs[$t['id_m_user']]['nama_sub_bidang'] = isset($t['nama_sub_bidang']) ? $t['nama_sub_bidang'] : '';
                        $rs[$t['id_m_user']]['nm_unitkerja'] = isset($t['nm_unitkerja']) ? $t['nm_unitkerja'] : '';
                        $rs[$t['id_m_user']]['total_progress'] = 0;
                        // $rs[$t['id_m_user']]['jk'] = $count_kegiatan;
                        $presentase_kegiatan = (floatval($t['total_realisasi'])/floatval($t['target_kuantitas'])) * 100;
                        $rs[$t['id_m_user']]['rk'][] = $presentase_kegiatan;
                        $i++;

                        if($i == count($temp) && isset($rs[$tmp_user_id])){ // cek jika sudah index terakhir
                            $rs[$tmp_user_id]['total_progress'] = $this->countTotalProgress($rs[$tmp_user_id]);
                        }
                    }
                }
            }

            return $rs;
        }

        public function loadDetailRekap($id){
            $periode = $this->session->userdata('periode_search_rekap');
            return $this->db->select('*, a.id as id_t_rencana_kinerja')
                            ->from('t_rencana_kinerja a')
                            ->join('m_user b', 'a.id_m_user = b.id')
                            ->where('b.id', $id)
                            ->where('a.bulan', floatval($periode['bulan']))
                            ->where('a.tahun', floatval($periode['tahun']))
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
        }

        public function loadListKegiatanRencanaKinerja($id){
            return $this->db->select('a.*, b.tugas_jabatan, b.target_kuantitas, b.satuan, b.total_realisasi, a.tanggal_verif, a.keterangan_verif, c.nama as verifikator')
                            ->from('t_kegiatan a')
                            ->join('t_rencana_kinerja b', 'a.id_t_rencana_kinerja = b.id')
                            ->join('m_user c', 'a.id_m_user_verif = c.id', 'left')
                            ->where('b.id', $id)
                            ->where('a.flag_active', 1)
                            ->order_by('a.created_date', 'desc')
                            ->get()->result_array();
        }

        public function loadPegawaiKomponenKinerja($data){
            $result = null;
            $list_id_pegawai = $this->getListIdPegawaiForVerif();
            if($list_id_pegawai){
                $result = $this->db->select('*, a.id as id_m_user')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                ->join('db_pegawai.jabatan c', 'b.jabatan = c.id_jabatanpeg')
                                ->join('m_bidang d', 'a.id_m_bidang = d.id', 'left')
                                ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
                                ->where_in('a.id', $list_id_pegawai)
                                ->get()->result_array();

                if($result){
                    $data_komponen = $this->db->select('*, a.id as id_t_komponen_kinerja')
                                        ->from('t_komponen_kinerja a')
                                        ->join('m_user b', 'a.id_m_user = b.id')
                                        ->where_in('a.id_m_user', $list_id_pegawai)
                                        ->where('a.bulan', $data['bulan'])
                                        ->where('a.tahun', $data['tahun'])
                                        ->where('a.flag_active', 1)
                                        ->get()->result_array();
                    $komponen = [];
                    if($data_komponen){
                        foreach($data_komponen as $k){
                            $komponen[$k['id_m_user']] = $k;
                        }

                        $i = 0;
                        foreach($result as $r){
                            if(isset($komponen[$r['id_m_user']])){
                                $result[$i]['komponen_kinerja'] = $komponen[$r['id_m_user']];
                            }
                            $i++;
                        }
                    }
                }
            }
            return $result;
        }

        public function loadNilaiKomponen($id, $bulan, $tahun){
            $pegawai =  $this->db->select('*, a.id as id_m_user')
                                    ->from('m_user a')
                                    ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                    ->join('db_pegawai.jabatan c', 'b.jabatan = c.id_jabatanpeg')
                                    ->join('m_bidang d', 'a.id_m_bidang = d.id', 'left')
                                    ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
                                    ->where('a.id', $id)
                                    ->get()->row_array();

            $komponen =  $this->db->select('*, a.id as id_t_komponen_kinerja, 
                                               a.berorientasi_pelayanan as perilaku_1,
                                               a.akuntabel as perilaku_2,
                                               a.kompeten as perilaku_3,
                                               a.harmonis as perilaku_4,
                                               a.loyal as perilaku_5,
                                               a.adaptif as perilaku_6,
                                               a.kolaboratif as perilaku_7')
                                    ->from('t_komponen_kinerja a')
                                    ->where('a.id_m_user', $id)
                                    ->where('a.bulan', $bulan)
                                    ->where('a.tahun', $tahun)
                                    ->where('a.flag_active', 1)
                                    ->get()->row_array();
                                    // dd($komponen);
            return [$pegawai, $komponen];
        }

        public function saveNiliKomponenKinerja($data){
            $res['code'] = 0;
            $res['message'] = 'OK';
            $res['data'] = $data;
            $insert_data = null;
            // list($capaian, $bobot) = countNilaiKomponen($data);
         

            if($data['id_t_komponen_kinerja']){
                $id = $data['id_t_komponen_kinerja'];
                unset($data['id_t_komponen_kinerja']);
                $data['updated_by'] = $this->general_library->getId();
                $this->db->where('id', $id)
                        ->update('t_komponen_kinerja', $data);
            } else {
                unset($data['id_t_komponen_kinerja']);
                $insert_data['created_by'] = $this->general_library->getId();
                $insert_data['berorientasi_pelayanan'] = $data['perilaku_1'];
                $insert_data['akuntabel'] = $data['perilaku_2'];
                $insert_data['kompeten'] = $data['perilaku_3'];
                $insert_data['harmonis'] = $data['perilaku_4'];
                $insert_data['loyal'] = $data['perilaku_5'];
                $insert_data['adaptif'] = $data['perilaku_6'];
                $insert_data['kolaboratif'] = $data['perilaku_7'];
                $insert_data['tahun'] = $data['tahun'];
                $insert_data['bulan'] = $data['bulan'];
                $insert_data['id_m_user'] = $data['id_m_user'];
                $this->db->insert('t_komponen_kinerja', $insert_data);
            }

            $res['data']['capaian'] = $capaian;
            $res['data']['bobot'] = $bobot;

            return $res;
        }

        public function deleteNilaiKomponen($id){
            $res['code'] = 0;
            $res['message'] = 'OK';

          
            
            $this->db->where('id_t_komponen_kinerja', $id)
                    ->update('t_komponen_kinerja_new', ['flag_active' => 0]);

            $this->db->where('id', $id)
                    ->update('t_komponen_kinerja', ['flag_active' => 0]);
                    
            if($this->db->trans_status() == FALSE){
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            }

            return $res;
        }

        public function loadPerilakuKerja($id, $data){
           $tahun = $data['tahun'];
            $bulan = $data['bulan'];

            $final_result = null;
            $result =  $this->db->select('*')
                                    ->from('m_perilaku_kerja a')
                                    ->where('a.flag_active', 1)
                                    ->get()->result_array();

                                    if($result){
                                        $detail = $this->db->select('a.id, a.nama_sub_perilaku_kerja, a.id_m_perilaku_kerja, a.id_m_perilaku_kerja, a.name_id, a.id,
                                        (select nilai from t_komponen_kinerja_new where id_m_user = '.$id.' and tahun = '.$tahun.' and bulan = '.$bulan.' and flag_active = 1 and id_m_sub_perilaku_kerja = a.id limit 1) as nilai')
                                                        ->from('m_sub_perilaku_kerja a')
                                                        ->where('a.flag_active', 1)
                                                        // ->where('a.id_m_perilaku_kerja', $result[0]['id'])
                                                        ->group_by('a.id')
                                                        ->get()->result_array();
                                
                                        if($detail){
                                            $i = 0;
                                            foreach($result as $rs){
                                                $final_result[$rs['id']]['id_m_perilaku_kerja'] = $rs['id'];
                                                $final_result[$rs['id']]['nama_perilaku_kerja'] = $rs['nama_perilaku_kerja'];
                                                $final_result[$rs['id']]['name_id'] = $rs['name_id'];
                                            }
                                            $j = 0;
                                            foreach($detail as $d){
                                                $final_result[$d['id_m_perilaku_kerja']]['sub_perilaku_kerja'][$j]['nama_sub_perilaku_kerja'] = $d['nama_sub_perilaku_kerja'];
                                                $final_result[$d['id_m_perilaku_kerja']]['sub_perilaku_kerja'][$j]['name_id'] = $d['name_id'];
                                                $final_result[$d['id_m_perilaku_kerja']]['sub_perilaku_kerja'][$j]['id_m_sub_perilaku_kerja'] = $d['id'];
                                                $final_result[$d['id_m_perilaku_kerja']]['sub_perilaku_kerja'][$j]['nilai'] = $d['nilai'];
                                                $j++;
                                            }
                      
                                        }
                                    }

            return $final_result;
        }

        public function createNilaiKomponenKinerja(){
           
            $res['code'] = 0;
            $res['message'] = 'OK';
            $res['data'] = $_POST;
            $insert_data = null;

            $exist = $this->db->select('*')
            ->from('t_komponen_kinerja a')
            ->where('a.flag_active', 1)
            ->where('a.id_m_user', $_POST['id_m_user'])
            ->where('a.tahun', $_POST['tahun'])
            ->where('a.bulan', $_POST['bulan'])
            ->group_by('a.id')
            ->get()->result_array();
          
            if($exist){

                // for ($count = 0; $count < count($_POST['id_m_sub_perilaku_kerja']); $count++) {
                    // $id_m_sub_perilaku_kerja = $_POST['id_m_sub_perilaku_kerja'][$count];
                    // $nilai = $_POST['nilai'][$count];         
                   

                    // $data_update['nilai'] = $nilai;
                    $data_update['capaian'] = $_POST['nilai_capaian'];
                    $data_update['bobot'] = $_POST['nilai_bobot'];

                    $data_update2['berorientasi_pelayanan'] = $_POST['perilaku_1'];
                    $data_update2['akuntabel'] = $_POST['perilaku_2'];
                    $data_update2['kompeten'] = $_POST['perilaku_3'];
                    $data_update2['harmonis'] = $_POST['perilaku_4'];
                    $data_update2['loyal'] = $_POST['perilaku_5'];
                    $data_update2['adaptif'] = $_POST['perilaku_6'];
                    $data_update2['kolaboratif'] = $_POST['perilaku_7'];
                    // dd($data_update2);
                   
            
                    // $this->db->where('id_m_user', $_POST['id_m_user'])
                    //          ->where('tahun', $_POST['tahun'])
                    //          ->where('bulan', $_POST['bulan'])
                    //          ->where('id_m_sub_perilaku_kerja', $id_m_sub_perilaku_kerja)
                    //         ->update('t_komponen_kinerja_new', $data_update);

                    $this->db->where('id_m_user', $_POST['id_m_user'])
                            ->where('tahun', $_POST['tahun'])
                            ->where('bulan', $_POST['bulan'])
                           ->update('t_komponen_kinerja', $data_update2);
                
                // }
                return $res;

            } else {

                $insert_data2['created_by'] = $this->general_library->getId();
                $insert_data2['berorientasi_pelayanan'] = $_POST['perilaku_1'];
                $insert_data2['akuntabel'] = $_POST['perilaku_2'];
                $insert_data2['kompeten'] = $_POST['perilaku_3'];
                $insert_data2['harmonis'] = $_POST['perilaku_4'];
                $insert_data2['loyal'] = $_POST['perilaku_5'];
                $insert_data2['adaptif'] = $_POST['perilaku_6'];
                $insert_data2['kolaboratif'] = $_POST['perilaku_7'];
                $insert_data2['tahun'] = $_POST['tahun'];
                $insert_data2['bulan'] = $_POST['bulan'];
                $insert_data2['id_m_user'] = $_POST['id_m_user'];
                $this->db->insert('t_komponen_kinerja', $insert_data2);
                $id_t_komponen_kinerja = $this->db->insert_id();
             
                // for ($count = 0; $count < count($_POST['id_m_sub_perilaku_kerja']); $count++) {
                   
                //     $id_m_sub_perilaku_kerja = $_POST['id_m_sub_perilaku_kerja'][$count];
                //     $nilai = $_POST['nilai'][$count];         
                //     $insert_data['tahun'] = $_POST['tahun'];
                //     $insert_data['bulan'] = $_POST['bulan'];
                //     $insert_data['id_m_user'] = $_POST['id_m_user'];
                //     $insert_data['id_m_sub_perilaku_kerja'] = $id_m_sub_perilaku_kerja;
                //     $insert_data['nilai'] = $nilai;
                //     $insert_data['capaian'] = $_POST['nilai_capaian'];
                //     $insert_data['bobot'] = $_POST['nilai_bobot'];
                //     $insert_data['id_t_komponen_kinerja'] =  $id_t_komponen_kinerja;
                //     $this->db->insert('t_komponen_kinerja_new', $insert_data);

                // }
                
                return $res;

            }

    
            

            // list($capaian, $bobot) = countNilaiKomponen($data);
               

            // if($data['id_t_komponen_kinerja']){
            //     $id = $data['id_t_komponen_kinerja'];
            //     unset($data['id_t_komponen_kinerja']);
            //     $data['updated_by'] = $this->general_library->getId();
            //     $this->db->where('id', $id)
            //             ->update('t_komponen_kinerja', $data);
            // } else {
            //     unset($data['id_t_komponen_kinerja']);
            //     $insert_data['created_by'] = $this->general_library->getId();
            //     $insert_data['berorientasi_pelayanan'] = $data['perilaku_1'];
            //     $insert_data['akuntabel'] = $data['perilaku_2'];
            //     $insert_data['kompeten'] = $data['perilaku_3'];
            //     $insert_data['harmonis'] = $data['perilaku_4'];
            //     $insert_data['loyal'] = $data['perilaku_5'];
            //     $insert_data['adaptif'] = $data['perilaku_6'];
            //     $insert_data['kolaboratif'] = $data['perilaku_7'];
            //     $insert_data['tahun'] = $data['tahun'];
            //     $insert_data['bulan'] = $data['bulan'];
            //     $insert_data['id_m_user'] = $data['id_m_user'];
            //     $this->db->insert('t_komponen_kinerja', $insert_data);
            // }

            // $res['data']['capaian'] = $capaian;
            // $res['data']['bobot'] = $bobot;

            return $res;
        }
	}
?>