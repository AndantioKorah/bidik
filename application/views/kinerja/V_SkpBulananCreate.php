<?php
    $data['pegawai'] = $pegawai; 
    $data['atasan_pegawai'] = $atasan_pegawai; 
    $data['flag_komponen_kinerja'] = false;
    $data['kepala_pd'] = $kepala_pd;
?>

<!-- VIEW PENETAPAN SASARAN KERJA -->
<div class="card card-default p-3">
    <center>
        <span style="font-weight: bold; font-size: 16px;">PENETAPAN SASARAN KERJA BULANAN PEGAWAI</span><br>
        <span style="font-weight: bold; font-size: 16px;"><?=strtoupper($pegawai['nm_unitkerja'])?></span><br>
        <span style="font-weight: bold; font-size: 14px;">BULAN <?=strtoupper(getNamaBulan($periode['bulan']))?> TAHUN <?=$periode['tahun']?></span>
    </center>
    <div id="header_skp">
        <?php $data['width'] = '100'; $this->load->view('kinerja/V_HeaderSkpBulanan', $data); ?>
    </div>
    <div class="mt-4" id="konten_skp">
        <table border=1 style="width: 100%;">
            <tr>
                <td style="padding: 5px; font-weight: bold; width: 5%" class="text-center" rowspan=2>No</td>
                <td style="padding: 5px; font-weight: bold; width: 45%" class="text-center" rowspan=2>Uraian Tugas</td>
                <td style="padding: 5px; font-weight: bold; width: 30%" class="text-center" rowspan=2>Sasaran Kerja</td>
                <td style="padding: 5px; font-weight: bold; width: 15%" class="text-center" rowspan=1 colspan=2>Target</td>
            </tr>
            <tr>
                <td style="padding: 5px; font-weight: bold; width: 5%" class="text-center" rowspan=1>Kuantitas</td>
                <td style="padding: 5px; font-weight: bold; width: 5%" class="text-center" rowspan=1>Output</td>
            </tr>
            <?php $no=1; if($rencana_kinerja){ foreach($rencana_kinerja as $rk){ ?>
                <tr>
                    <td style="padding: 5px;" class="text-center"><?=$no++;?></td>
                    <td style="padding: 5px;"><?=$rk['tugas_jabatan']?></td>
                    <td style="padding: 5px;"><?=$rk['sasaran_kerja']?></td>
                    <td style="padding: 5px;" class="text-center"><?=$rk['target_kuantitas']?></td>
                    <td style="padding: 5px;" class="text-center"><?=$rk['satuan']?></td>
                </tr>
            <?php } } ?>
            <tr>
            </tr>
        </table>
    </div>
    <div class="mt-4" id="footer_skp">
        <?php $data['width'] = '100'; $this->load->view('kinerja/V_FooterSkpBulanan', $data); ?>
    </div>
</div>
<!-- VIEW PENGUKURAN SASARAN KERJA -->
<div class="card card-default p-3 mt-3">
    <center>
        <span style="font-weight: bold; font-size: 16px;">PENGUKURAN SASARAN KERJA BULANAN PEGAWAI</span><br>
        <span style="font-weight: bold; font-size: 16px;"><?=strtoupper($pegawai['nm_unitkerja'])?></span><br>
        <span style="font-weight: bold; font-size: 14px;">BULAN <?=strtoupper(getNamaBulan($periode['bulan']))?> TAHUN <?=$periode['tahun']?></span>
    </center>
    <div id="header_skp">
        <?php $data['width'] = '100'; $this->load->view('kinerja/V_HeaderSkpBulanan', $data); ?>
    </div>
    <div class="mt-4" id="konten_skp">
        <table border=1 style="width: 100%;">
            <tr>
                <td style="padding: 5px; font-weight: bold; width: 5%" class="text-center" rowspan=2>No</td>
                <td style="padding: 5px; font-weight: bold; width: 30%" class="text-center" rowspan=2>Uraian Tugas</td>
                <td style="padding: 5px; font-weight: bold; width: 35%" class="text-center" rowspan=2>Sasaran Kerja</td>
                <td style="padding: 5px; font-weight: bold; width: 10%" class="text-center" rowspan=1 colspan=2>Target</td>
                <td style="padding: 5px; font-weight: bold; width: 10%" class="text-center" rowspan=1 colspan=2>Realisasi</td>
                <td style="padding: 5px; font-weight: bold; width: 10%" class="text-center" rowspan=2>Nilai Capaian</td>
            </tr>
            <tr>
                <td style="padding: 5px; font-weight: bold; width: 5%" class="text-center" rowspan=1>Kuantitas</td>
                <td style="padding: 5px; font-weight: bold; width: 5%" class="text-center" rowspan=1>Output</td>
                <td style="padding: 5px; font-weight: bold; width: 5%" class="text-center" rowspan=1>Kuantitas</td>
                <td style="padding: 5px; font-weight: bold; width: 5%" class="text-center" rowspan=1>Output</td>
            </tr>
            <?php $no=1; $akumulasi_nilai_capaian = 0; if($rencana_kinerja){ foreach($rencana_kinerja as $rk){
                $nilai_capaian = 0;    
                if(floatval($rk['total_realisasi']) > 0){
                    $nilai_capaian = (floatval($rk['total_realisasi']) / floatval($rk['target_kuantitas'])) * 100;
                }
                if($nilai_capaian > 100){
                    $nilai_capaian = 100;
                }
                $akumulasi_nilai_capaian += $nilai_capaian;
             
            ?>
                <tr>
                    <td style="padding: 5px;" class="text-center"><?=$no++;?></td>
                    <td style="padding: 5px;"><?=$rk['tugas_jabatan']?></td>
                    <td style="padding: 5px;"><?=$rk['sasaran_kerja']?></td>
                    <td style="padding: 5px;" class="text-center"><?=$rk['target_kuantitas']?></td>
                    <td style="padding: 5px;" class="text-center"><?=$rk['satuan']?></td>
                    <td style="padding: 5px;" class="text-center"><?=$rk['total_realisasi'] ? $rk['total_realisasi'] : 0; ?></td>
                    <td style="padding: 5px;" class="text-center"><?=$rk['satuan']?></td>
                    <td style="padding: 5px;" class="text-center"><?=formatTwoMaxDecimal($nilai_capaian)?>%</td>
                </tr>
            <?php } }
                // $rata_rata = 0;
                // if(count($rencana_kinerja) != 0){
                //     $rata_rata = floatval($akumulasi_nilai_capaian) / count($rencana_kinerja);
                // }
                // $bobot = $rata_rata * 0.3;
                // if($bobot > 30){
                //     $bobot = 30;
                // }
                $kinerja = countNilaiSkp($rencana_kinerja);
            ?>
            <tr>
                <td style="padding: 5px; text-align: right;" class="text-right;" colspan=7>CAPAIAN SASARAN KINERJA RATA-RATA</td>
                <td style="padding: 5px; text-align: center;" class="text-center;" colspan=1><strong><?=formatTwoMaxDecimal($kinerja['capaian'])?>%</strong></td>
            </tr>
            <tr>
                <td style="padding: 5px; text-align: right;" class="text-right;" colspan=7>BOBOT CAPAIAN</td>
                <td style="padding: 5px; text-align: center;" class="text-center;" colspan=1><strong><?=formatTwoMaxDecimal($kinerja['bobot'])?>%</strong></td>
            </tr>
        </table>
    </div>
    <div class="mt-4" id="footer_skp">
        <?php $data['width'] = '100'; $this->load->view('kinerja/V_FooterSkpBulanan', $data); ?>
    </div>
</div>
<!-- VIEW PENILAIAN KOMPONEN KERJA  -->
<div class="card card-default p-3 mt-3">
    <center>
        <span style="font-weight: bold; font-size: 16px;">PENILAIAN KOMPONEN KINERJA DARI PEJABAT PENILAI</span><br>
        <span style="font-weight: bold; font-size: 16px;"><?=strtoupper($pegawai['nm_unitkerja'])?></span><br>
        <span style="font-weight: bold; font-size: 14px;">BULAN <?=strtoupper(getNamaBulan($periode['bulan']))?> TAHUN <?=$periode['tahun']?></span>
    </center>
    <div id="header_skp">
        <?php $data['width'] = '100'; $this->load->view('kinerja/V_HeaderSkpBulanan', $data); ?>
    </div>
    <div class="mt-4" id="konten_skp">
        <table border=1 style="width: 100%;">
        <!-- <?php $no=1; 
           foreach($list_perilaku_kerja as $lp){ ?>
            <tr>
                    <td style="text-align: center; padding: 5px;"><b><?=$no++;?></b></td>
                    <td style="padding: 5px;"><b><?=$lp['nama_perilaku_kerja']?></b>
                    <td class="text-center">
                    <span style="font-weight:bold; " id="<?=$lp['name_id'];?>"></span>
                        </td>
                     <?php foreach($lp['sub_perilaku_kerja'] as $sp){ ?>
                        <tr rowspan="3">
                            <td></td>
                            <td><?=$sp['nama_sub_perilaku_kerja'];?></td>
                            <td style="padding: 5px; text-align: center;" class="text-center;">
                            <input  type="hidden" class="form-control form-control-sm" name="id_m_sub_perilaku_kerja[]" value="<?=$sp['id_m_sub_perilaku_kerja'];?>"  /> 
                                <input  oninput="countNilaiKomponen()" type="hidden" id="<?=$sp['name_id'];?>" class="form-control form-control-sm hsl" name="nilai[]" max="100"  value="<?=$sp['nilai'] ? $sp['nilai'] : '' ?>"/> <?=$sp['nilai'] ? $sp['nilai'] : '' ?> </td>
                        </tr>
                        <?php } ?> 
             
                    </td>
                    
                 
                  
                </tr>
            <?php } ?>  -->
            <tr>
                <td style="padding: 5px; font-weight: bold; width: 5%; text-align: center;">NO</td>
                <td style="padding: 5px; font-weight: bold; width: 70%; text-align: center;">KOMPONEN KINERJA</td>
                <td style="padding: 5px; font-weight: bold; width: 25%; text-align: center;">NILAI</td>
            </tr>
            <tr>
                <td style="text-align: center; padding: 5px;">1</td>
                <td style="padding: 5px;">Berorientasi Pelayanan</td>
                <td class="text-center" style="padding: 5px;"><?=$nilai_komponen ? $nilai_komponen['berorientasi_pelayanan'] : ''?></td>
            </tr>
            <tr>
                <td style="text-align: center; padding: 5px;">2</td>
                <td style="padding: 5px;">Akuntabel</td>
                <td class="text-center" style="padding: 5px;"><?=$nilai_komponen ? $nilai_komponen['akuntabel'] : ''?></td>
            </tr>
            <tr>
                <td style="text-align: center; padding: 5px;">3</td>
                <td style="padding: 5px;">Kompeten</td>
                <td class="text-center" style="padding: 5px;"><?=$nilai_komponen ? $nilai_komponen['kompeten'] : ''?></td>
            </tr>
            <tr>
                <td style="text-align: center; padding: 5px;">4</td>
                <td style="padding: 5px;">Harmonis</td>
                <td class="text-center" style="padding: 5px;"><?=$nilai_komponen ? $nilai_komponen['harmonis'] : ''?></td>
            </tr>
            <tr>
                <td style="text-align: center; padding: 5px;">5</td>
                <td style="padding: 5px;">Loyal</td>
                <td class="text-center" style="padding: 5px;"><?=$nilai_komponen ? $nilai_komponen['loyal'] : ''?></td>
            </tr>
            <tr>
                <td style="text-align: center; padding: 5px;">6</td>
                <td style="padding: 5px;">Adaptif</td>
                <td class="text-center" style="padding: 5px;"><?=$nilai_komponen ? $nilai_komponen['adaptif'] : ''?></td>
            </tr>
            <tr>
                <td style="text-align: center; padding: 5px;">7</td>
                <td style="padding: 5px;">Kolaboratif</td>
                <td class="text-center" style="padding: 5px;"><?=$nilai_komponen ? $nilai_komponen['kolaboratif'] : ''?></td>
            </tr>
            <?php
                $capaian = null;
                $pembobotan = null;
                if($nilai_komponen){
                    // dd($nilai_komponen);
                    list($capaian, $pembobotan) = countNilaiKomponen($nilai_komponen);
                    // $pembobotan = $pembobotan * 100;
                    // dd($p['created_by']);
                    // dd($this->general_library->getId());
                    $pembobotan = (formatTwoMaxDecimal($pembobotan)).'%';
                    
                }
            ?>
            <tr>
                <td colspan=2 style="padding: 5px; text-align: right;"><strong>JUMLAH NILAI CAPAIAN</strong></td>
                <td class="text-center" style="padding: 5px; font-size: 18px; font-weight: bold;"><span><?=$capaian;?></span></td>
            </tr>
            <tr>
                <td colspan=2 style="padding: 5px; text-align: right;"><i>HASIL PEMBOBOTAN</i></td>
                <td class="text-center" style="padding: 5px; font-size: 18px; font-weight: bold;"><i><span><?=$pembobotan;?></span></td>
            </tr>
        </table>
    </div>
    <div class="mt-4" id="footer_skp">
        <?php $data['width'] = '100'; $data['flag_komponen_kinerja'] = true; $this->load->view('kinerja/V_FooterSkpBulanan', $data); ?>
    </div>
</div>
<script>
     $(function(){
        countNilaiKomponen()
    })

    function countNilaiKomponen(){
      
        let perilaku1 = parseInt($('#sub_perilaku_1').val())
                    + parseInt($('#sub_perilaku_2').val())
                    + parseInt($('#sub_perilaku_3').val())
        let total_perilaku1 = perilaku1 / 3;
        let perilaku_1 = total_perilaku1.toFixed(2) 
        if(isNaN(parseFloat(perilaku_1)) == true) {
            perilaku_1 = "";
        }
        $('#perilaku_1').html(perilaku_1)

        let perilaku2 = parseInt($('#sub_perilaku_4').val())
                    + parseInt($('#sub_perilaku_5').val())
                    + parseInt($('#sub_perilaku_6').val())
        let total_perilaku2 = perilaku2 / 3;
        let perilaku_2 = total_perilaku2.toFixed(2) 
        if(isNaN(parseFloat(perilaku_2)) == true) {
            perilaku_2 = "";
        }
        $('#perilaku_2').html(perilaku_2)

        let perilaku3 = parseInt($('#sub_perilaku_7').val())
                    + parseInt($('#sub_perilaku_8').val())
                    + parseInt($('#sub_perilaku_9').val())
        let total_perilaku3 = perilaku3 / 3;
        let perilaku_3 = total_perilaku3.toFixed(2) 
        if(isNaN(parseFloat(perilaku_3)) == true) {
            perilaku_3 = "";
        }
        $('#perilaku_3').html(perilaku_3)

        let perilaku4 = parseInt($('#sub_perilaku_10').val())
                    + parseInt($('#sub_perilaku_11').val())
                    + parseInt($('#sub_perilaku_12').val())
        let total_perilaku4 = perilaku4 / 3;
        let perilaku_4 = total_perilaku4.toFixed(2) 
        if(isNaN(parseFloat(perilaku_4)) == true) {
            perilaku_4 = "";
        }
        $('#perilaku_4').html(perilaku_4)

        let perilaku5 = parseInt($('#sub_perilaku_13').val())
                    + parseInt($('#sub_perilaku_14').val())
                    + parseInt($('#sub_perilaku_15').val())
        let total_perilaku5 = perilaku5 / 3;
        let perilaku_5 = total_perilaku5.toFixed(2) 
        if(isNaN(parseFloat(perilaku_5)) == true) {
            perilaku_5 = "";
        }
        $('#perilaku_5').html(perilaku_5)

        let perilaku6 = parseInt($('#sub_perilaku_16').val())
                    + parseInt($('#sub_perilaku_17').val())
                    + parseInt($('#sub_perilaku_18').val())
        let total_perilaku6 = perilaku6 / 3;
        let perilaku_6 = total_perilaku6.toFixed(2) 
        if(isNaN(parseFloat(perilaku_6)) == true) {
            perilaku_6 = "";
        }
        $('#perilaku_6').html(perilaku_6)

        let perilaku7 = parseInt($('#sub_perilaku_19').val())
                    + parseInt($('#sub_perilaku_20').val())
                    + parseInt($('#sub_perilaku_21').val())
        let total_perilaku7 = perilaku7 / 3;
        let perilaku_7 = total_perilaku7.toFixed(2) 
        if(isNaN(parseFloat(perilaku_7)) == true) {
            perilaku_7 = "";
        }
        $('#perilaku_7').html(perilaku_7)

        let capaian = parseInt(perilaku_1)
                    + parseInt(perilaku_2)
                    + parseInt(perilaku_3)
                    + parseInt(perilaku_4)
                    + parseInt(perilaku_5)
                    + parseInt(perilaku_6)
                    + parseInt(perilaku_7)

        $('#capaian').html(capaian)
        $('#nilai_capaian').val(capaian)
        if(isNaN(parseFloat(capaian)) == true) {
            capaian = "";
        }
        $('#nilai_bobot').val(countBobotNilaiKomponenKinerja(capaian).toFixed(2))
        $('#bobot').html(countBobotNilaiKomponenKinerja(capaian).toFixed(2)+'%')
    }
</script>