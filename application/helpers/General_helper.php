<?php

function dd($var)
{
    die(var_dump($var));
}

function render($pageContent, $parent_active, $active, $data)
{
    $CI = &get_instance();
    $data['page_content'] = $pageContent;
    $data['parent_active'] = $parent_active;
    $data['active'] = $active;
    $CI->load->view('base/V_BaseLayout', $data);
}

function formatNip($nip){
    $str = strlen($nip);
    $formatted_nip = '';
    $nip_split = str_split($nip);
    for($i = 0; $i < $str; $i++) {
        $formatted_nip .= $nip_split[$i];
        if($i == 7 || $i == 13 || $i == 14){
            $formatted_nip .= " ";
        }
    }
    return $formatted_nip;
}

function generateNorm($last_norm){
    if($last_norm){
        $cur_count_norm = ltrim($last_norm, '0');
        $cur_count_norm = floatval($cur_count_norm) + 1;
    } else {
        $cur_count_norm = 1;
    }
    return str_pad($cur_count_norm, 7, '0', STR_PAD_LEFT);
}

function countNilaiKomponen($data){
    $capaian = floatval($data['berorientasi_pelayanan']) +
                floatval($data['akuntabel']) +
                floatval($data['kompeten']) +
                floatval($data['harmonis']) +
                floatval($data['loyal']) +
                floatval($data['adaptif']) +
                floatval($data['kolaboratif']);
    // $capaian = floatval($data['perilaku_1']) +
    // floatval($data['perilaku_2']) +
    // floatval($data['perilaku_3']) +
    // floatval($data['perilaku_4']) +
    // floatval($data['perilaku_5']) +
    // floatval($data['perilaku_6']) +
    // floatval($data['perilaku_7']);
    $bobot = 30;
    if($capaian < 350){
        $bobot = 0;
    } else if ($capaian > 350 && $capaian < 679){
        $bobot = ($capaian / 700) * floatval(BOBOT_NILAI_KOMPONEN_KINERJA);
        $bobot = $bobot * 100;
    }
    
    return [$capaian, $bobot];
}

function countNilaiSkp($data){
    $result['capaian'] = 0;
    $result['bobot'] = 0;
    if($data){
        $akumulasi_nilai_capaian = 0;
        foreach($data as $d){
            $nilai_capaian = 0;
            if(floatval($d['total_realisasi']) > 0){
                $nilai_capaian = (floatval($d['total_realisasi']) / floatval($d['target_kuantitas'])) * 100;
            }
            if($nilai_capaian > 100){
                $nilai_capaian = 100;
            }
            $akumulasi_nilai_capaian += $nilai_capaian;
            // echo $nilai_capaian.';<br>';
        }
        // dd($akumulasi_nilai_capaian);
        if(count($data) != 0){
            $result['capaian'] = floatval($akumulasi_nilai_capaian) / count($data);
        }
        $result['bobot'] = $result['capaian'] * floatval(BOBOT_NILAI_SKBP);
        if($result['bobot'] > 30){
            $result['bobot'] = 30;
        }
        if($result['capaian'] > 100){
            $result['capaian'] = 100;
        }
    }
    return $result;
}

function getDateBetweenDates($startDate, $endDate){
        $rangArray = [];
            
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
             
        for ($currentDate = $startDate; $currentDate <= $endDate; 
                                        $currentDate += (86400)) {
                                                
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }
  
        return $rangArray;
    }

function explodeRangeDate($date){
    $tanggal = explode("-", $date);
    $awal = explode("/", $tanggal[0]);    
    $akhir = explode("/", $tanggal[1]);
    
    $start_date = trim($awal[2]).'-'.trim($awal[1]).'-'.trim($awal[0]);
    $end_date = trim($akhir[2]).'-'.trim($akhir[1]).'-'.trim($akhir[0]);
    return [$start_date, $end_date];
}

function explodeRangeDateNew($date){
    $tanggal = explode("-", $date);
    $awal = explode("/", $tanggal[0]);    
    $akhir = explode("/", $tanggal[1]);

    $start_date = trim($awal[2]).'-'.trim($awal[0]).'-'.trim($awal[1]);
    $end_date = trim($akhir[2]).'-'.trim($akhir[0]).'-'.trim($akhir[1]);

    return [$start_date, $end_date];
}

function getStatusTransaksi($status){
    switch($status){
        case 1:
            return 'Aktif'; break;
        case 2:
            return 'Lunas'; break;
        case 3:
            return 'Belum Lunas'; break;
        default:
            return '';
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandomNumber($length = 10) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getPphByIdPangkat($id_pangkat){
    if(in_array($id_pangkat, [31, 32, 33, 34])){
        return 5;
    } else if(in_array($id_pangkat, [41, 42, 43, 44, 45])){
        return 15;
    }
    return 0;
}

function clearString($str){
    return str_replace('.', '', preg_replace('/[^0-9.\.]+/', '', (trim($str))));
}

function formatCurrency($data)
{
    return "Rp " . number_format($data, 0, ",", ".");
}

function formatCurrencyWithoutRp($data)
{
    return number_format($data, 0, ",", ".");
}

function formatDateOnly($data)
{
    $date1 = strtr($data, '/', '-');
    return date("d/m/Y", strtotime($date1));
}

function formatDateOnlyForEdit2($data)
{
    $date1 = strtr($data, '/', '-');
    return date("d-m-Y", strtotime($date1));
}

function formatDate($data)
{
    $date1 = strtr($data, '/', '-');
    return date("d/m/Y H:i:s", strtotime($date1));
}

function formatDateOnlyForEdit($data)
{
    return date("Y-m-d", strtotime($data));
}

function formatDateForEdit($data)
{
    return date("Y-m-d H:i:s", strtotime($data));
}

function array_flatten($array) { 
    if (!is_array($array)) { 
      return false; 
    } 
    $result = array(); 
    foreach ($array as $key => $value) { 
      if (is_array($value)) { 
        $result = array_merge($result, array_flatten($value)); 
      } else { 
        $result = array_merge($result, array($key => $value));
      } 
    } 
    return $result; 
}

function getProgressBarColor($progress, $use_important = true){
    $bgcolor = '#ff0000 !important';
    if($progress > 25 && $progress <= 50){
        $bgcolor = '#ff7100 !important';
    } else if($progress > 50 && $progress <= 65){
        $bgcolor = '#ffcf00 !important';
    } else if($progress > 65 && $progress <= 85){
        $bgcolor = '#5bff00 !important';
    } else if($progress > 85 && $progress <= 99){
        $bgcolor = '#41b302 !important';
    } else if($progress >= 100){
        $bgcolor = '#006600 !important';
    }
    if(!$use_important){
        $arr = explode(" ", $bgcolor);
        $bgcolor = $arr[0];
    }
    return $bgcolor;
}

function formatTwoMaxDecimal($data){
    $dt = explode(".", $data);
    $rs = $dt[0];
    if(isset($dt[1])){
        $rs .= ".";
        $dtsplit = str_split($dt[1]);
        $rs = $rs.$dtsplit[0];
        if(isset($dtsplit[1])){
            $rs = $rs.$dtsplit[1];
        } else {
            $rs = $rs.'0';
        }
    } else {
        $rs .= ".00";
    }
    // if($rs > 100){
    //     $rs = 100;
    // }
    return $rs;
}

function formatDateNamaBulan($data){
    $date_only = formatDateOnly($data);
    $explode = explode('/', $date_only);
    return $explode[0].' '.getNamaBulan($explode[1]).' '.$explode[2];
}

function formatDateNamaBulanWT($data){
    $date_only = formatDate($data);
    $explode = explode('/', $date_only);
    return $explode[0].' '.getNamaBulan($explode[1]).' '.$explode[2];
}

function getNamaPegawaiFull($pegawai){
    return trim($pegawai['gelar1']).' '.trim($pegawai['nama']).' '.trim($pegawai['gelar2']);
}

function sortArrayObjectValue($object1, $object2, $value) {
    return $object1->$value > $object2->$value;
}

function getNamaBulan($bulan){
    $bulan = floatval($bulan);
    switch($bulan){
        case 1 : return 'Januari'; break;
        case 2 : return 'Februari'; break;
        case 3 : return 'Maret'; break;
        case 4 : return 'April'; break;
        case 5 : return 'Mei'; break;
        case 6 : return 'Juni'; break;
        case 7 : return 'Juli'; break;
        case 8 : return 'Agustus'; break;
        case 9 : return 'September'; break;
        case 10 : return 'Oktober'; break;
        case 11 : return 'November'; break;
        case 12 : return 'Desember'; break;
        default: return '';
    }
}

function getJumlahHariDalamBulan($m, $y){
    $kalendar = CAL_GREGORIAN;
    return cal_days_in_month($kalendar, $m, $y);
}

function getNamaHariFromNumber($hari){
    switch($hari){
        case 0 : return 'Minggu'; break;
        case 1 : return 'Senin'; break;
        case 2 : return 'Selasa'; break;
        case 3 : return 'Rabu'; break;
        case 4 : return 'Kamis'; break;
        case 5 : return 'Jumat'; break;
        case 6 : return 'Sabtu'; break;
        default: return 'invalid';
    }
}

function getNamaHari($date){
    $dayofweek = date('w', strtotime($date));
    return getNamaHariFromNumber($dayofweek);
}

function countDiffDateLengkap($date1, $date2, $params = ''){
    $total_waktu = "";
    $tahun = 0;
    $bulan = 0;
    $hari = 0;
    $jam = 0;
    $menit = 0;
    $detik = 0;

    $date1 = strtotime($date1);
    $date2 = strtotime($date2);
    $diff = abs($date2 - $date1);

    $tahun = floor($diff / (365*60*60*24));
    $bulan = floor(($diff - $tahun * 365*60*60*24)/(30*60*60*24));
    $hari = floor(($diff - $tahun * 365*60*60*24 -  $bulan*30*60*60*24)/ (60*60*24)); 
    $jam = $hours = floor(($diff - $tahun * 365*60*60*24 - $bulan*30*60*60*24 - $hari*60*60*24) / (60*60));
    $menit = floor(($diff - $tahun * 365*60*60*24 - $bulan*30*60*60*24 - $hari*60*60*24 - $jam*60*60)/ 60);
    $detik = floor(($diff - $tahun * 365*60*60*24 - $bulan*30*60*60*24 - $hari*60*60*24 - $jam*60*60 - $menit*60)); 
    
    if($tahun != '0' && in_array('tahun', $params)){
        $total_waktu = $total_waktu.' '.$tahun.' tahun';
    } 
    if($bulan != '0' && in_array('bulan', $params)){
        $total_waktu = $total_waktu.' '.$bulan.' bulan';
    } 
    if($hari != '0' && in_array('hari', $params)){
        $total_waktu = $total_waktu.' '.$hari.' hari';
    } 
    if($jam != '0' && in_array('jam', $params)){
        $total_waktu = $total_waktu.' '.$jam.' jam';
    } 
    if($menit != '0' && in_array('menit', $params)){
        $total_waktu = $total_waktu.' '.$menit.' menit';
    } 
    if($detik != '0' && in_array('detik', $params)){
        $total_waktu = $total_waktu.' '.$detik.' detik';
    }
    if(strlen($total_waktu) == 0){
        $total_waktu = 'Hari Ini';
    }
    return $total_waktu;
}

function terbilang($x){
    $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");

    if ($x < 12)
    return " " . $abil[$x];

    elseif ($x < 20)
    return terbilang($x - 10) . " Belas";
    elseif ($x < 100)
    return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
    elseif ($x < 200)
    return " Seratus" . terbilang($x - 100);
    elseif ($x < 1000)
    return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
    elseif ($x < 2000)
    return " Seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
    return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
    return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
    else
    return terbilang($x / 1000000000). " Miliar ". terbilang($x % 1000000000);
}

function isValidTokenHeader($token, $kode_merchant){
    return $token == encrypt('nikita', $kode_merchant);
}

function logErrorTelegram($data){
    $this->general_library->logErrorTelegram($data);
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function encrypt($string1, $string2){
    $key = 'nikitalab'.DEVELOPER;
    $userKey = substr($string1, -3);
    $passKey = substr($string2, -3);
    $generatedForHash = strtoupper($userKey).$string1.$key.strtoupper($passKey).$string2;
    return md5($generatedForHash);
    // return $this->general_library->encrypt($string1, $string2);
}

function encrypt_custom($pure_string) {
    $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
    
    $key_size =  strlen($key);
    
    $plaintext = $pure_string;

    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    
    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
                                 $plaintext, MCRYPT_MODE_CBC, $iv);

    $ciphertext = $iv . $ciphertext;
    
    $ciphertext_base64 = base64_encode($ciphertext);
    
    return $ciphertext_base64;
}

function decrypt_custom($encrypted_string) {
    $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

    $ciphertext_dec = base64_decode($encrypted_string);
    
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    
    # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
    
    # retrieves the cipher text (everything except the $iv_size in the front)
    $ciphertext_dec = substr($ciphertext_dec, $iv_size);

    # may remove 00h valued characters from end of plain text
    $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                                    $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);

    return $plaintext_dec;
}