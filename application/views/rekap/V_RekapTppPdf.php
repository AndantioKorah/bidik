<?php if(isset($skpd)){ ?>
<html>
        <head>
         <style>
           .center {
            margin-left: auto;
            margin-right: auto;
            }
            @media print {
            .new-page {
                page-break-before: always;
            }
            }
            table, th, td {
            
            }
         </style>
        </head>

        <body>
       
        <!-- Absensi -->
        <h4 style="text-align: center;">
            REKAP ABSENSI <?=strtoupper($skpd)?><br>
            <?=strtoupper($periode)?>
        </h4>
        
        
        
            <h4 style="font-size: 14px; font-weight: bold; text-align: center;">Jadwal Jam Kerja <?=$jam_kerja['nama_jam_kerja']?></h4>
            <table style="width: 50%; margin-bottom: 10px; border: 1px solid black; border-collapse: collapse;" border=1  class="center">
                <thead>
                    <th style="text-align: center; font-size: 14px;">Hari</th>
                    <th style="text-align: center; font-size: 14px;">Jam Masuk</th>
                    <th style="text-align: center; font-size: 14px;">Jam Pulang</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-size: 14px; text-align: center;">Senin - Kamis</td>
                        <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfo_masuk']?></td>
                        <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfo_pulang']?></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px; text-align: center;">Jumat</td>
                        <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfoj_masuk']?></td>
                        <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfoj_pulang']?></td>
                    </tr>
                </tbody>
            </table>
        
        <br>
        <table class="rekap-table table"  border="1" style="border: 1px solid black; border-collapse: collapse;">
        <thead>
        <tr> 
                <?php $i=0; 
                $list_dk = null;
                if($disiplin_kerja){
                    foreach($disiplin_kerja as $dk){
                        if($dk['keterangan']){
                            $list_dk[] = $dk['keterangan'];
                        }
                    }
                }
               
                foreach($header[0] as $h){
                    $val = $h;
                    $rowspan = 1;
                    if($i !=0 || $i != 1){
                        $val = $val.'<br>'.$header[1][$i];
                    }
                    if(strlen($val) >= 5){
                ?>  
                <th  style="text-align: center; "><?= $val?></th>
                <?php $i++; } }?>
                <th style="text-align: center; ">JHK</th>
                <th style="text-align: center; ">Hadir</th>
                <!-- <th style="text-align: center; ">Alpa</th> -->
                <th style="text-align: center; ">TMK 1</th>
                <th style="text-align: center; ">TMK 2</th>
                <th style="text-align: center; ">TMK 3</th>
                <th style="text-align: center; ">PKSW 1</th>
                <th style="text-align: center; ">PKSW 2</th>
                <th style="text-align: center; ">PKSW 3</th>
                <?php
                    if($list_dk){
                        foreach($list_dk as $ldk){
                ?>
                    <th style="text-align: center; "><?=$ldk?></th>
                <?php } } ?>
        </tr> 
        </thead>
        <tbody>
        <?php  $no = 1; foreach($result as $rs){
                  
                  if(isset($rs['absen'])){
                  $bgtr = fmod($no, 2) == 0 ? "tr_even" : "tr_odd";
                  ?>
                      <tr class="<?=$bgtr?>">
                          <td style="text-align: center; "><?=$no++;?></td>
                          <td scope="row" style=" text-align: left;"><a><?=$rs['nama_pegawai']?></a></td>
                          <td style=""><a><?=isset($flag_print) && $flag_print == 1 ? '`' : '';?><?=$rs['nip']?></a></td>
                          <?php
                          foreach($rs['absen'] as $a){
                              $bgcolor = '';
                              $textcolor = 'black';
                              $txtcolormasuk = 'black';
                              $txtcolorpulang = 'black';
                              $txtcolordisker = '#05ada5';
        
                              if($a['ket'] == "A"){
                                  // $bgcolor = 'a3f0ec';
                                  $textcolor = '#05ada5';
                              } else if(in_array($a['ket'], $list_dk)){
                                  // $bgcolor = 'a3f0ec';
                                  $txtcolordisker = '#05ada5';
                              } else if($a['ket_masuk'] == 'tmk1'){
                                  $txtcolormasuk = '#d3b700';
                              } else if($a['ket_masuk'] == 'tmk2'){
                                  $txtcolormasuk = '#d37c00';
                              } else if($a['ket_masuk'] == 'tmk3'){
                                  $txtcolormasuk = '#ff0000';
                              }
        
                              if($a['ket_pulang'] == 'pksw1'){
                                  $txtcolorpulang = '#d3b700';
                              } else if($a['ket_pulang'] == 'pksw2'){
                                  $txtcolorpulang = '#d37c00';
                              } else if($a['ket_pulang'] == 'pksw3'){
                                  $txtcolorpulang = '#ff0000';
                              }
                          ?>
                          <td class="content_table" bgcolor="<?=$bgcolor?>">
                              <?php if($a['ket'] == "A"){ ?>
                                  <span style="color: <?=$textcolor?>;"><?=$a['ket']?></span>
                              <?php } else if(in_array($a['ket'], $list_dk)){ ?>
                                  <span style="color: <?=$txtcolordisker?>;"><?=$a['ket']?></span>
                              <?php } else { ?>
                                  <span style="color: <?=$txtcolormasuk?>"><?=$a['jam_masuk']?></span> - <span style="color: <?=$txtcolorpulang?>"><?=$a['jam_pulang']?></span>
                              <?php } ?>
                          </td>
                          <?php } ?>
                          <td style=" text-align: center; font-weight: bold;"><?=$rs['rekap']['jhk']?></td>
                          <td style=" text-align: center; font-weight: bold;"><?=$rs['rekap']['hadir']?></td>
                          <!-- <td style=" text-align: center; color: <?= $rs['rekap']['alpa'] > 0 ? 'red;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['alpa']?></td> -->
                          <td style=" text-align: center; color: <?= $rs['rekap']['tmk1'] > 0 ? '#d3b700;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['tmk1']?></td>
                          <td style=" text-align: center; color: <?= $rs['rekap']['tmk2'] > 0 ? '#d37c00;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['tmk2']?></td>
                          <td style=" text-align: center; color: <?= $rs['rekap']['tmk3'] > 0 ? '#ff0000;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['tmk3']?></td>
                          <td style=" text-align: center; color: <?= $rs['rekap']['pksw1'] > 0 ? '#d3b700;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['pksw1']?></td>
                          <td style=" text-align: center; color: <?= $rs['rekap']['pksw2'] > 0 ? '#d37c00;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['pksw2']?></td>
                          <td style=" text-align: center; color: <?= $rs['rekap']['pksw3'] > 0 ? '#ff0000;' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap']['pksw3']?></td>
                          <?php foreach($list_dk as $l){ ?>
                              <td style=" text-align: center; color: <?= $rs['rekap'][$l] > 0 ? $txtcolordisker.';' : '#aaaeb3;' ?> font-weight: bold;"><?=$rs['rekap'][$l]?></td>
                          <?php } ?>
                      </tr>
                  <?php } } ?>
        
        </tbody>
        </table>
        <!-- tutup absensi  -->
        <!-- produktivitas  -->
        <?php $skpd = explode(";",$parameter['skpd']);?>            
            <h4 class="new-page" style="text-align: center;"><strong>REKAPITULASI PENILAIAN PRODUKTIVITAS KERJA</strong></h4>
        <?php  $skpd = explode(";",$parameter['skpd']);;?>
            <table style="width: 100%;">
                <tr>
                    <td>SKPD</td>
                    <td>:</td>
                    <td><?=$skpd[1]?></td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>:</td>
                    <td><?=getNamaBulan($parameter['bulan']).' '.$parameter['tahun']?></td>
                </tr>
            </table>
        
        
        <table class="cd-table rekap-table table" border="1" style="border: 1px solid black; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align: center; width: 10px;" rowspan="2">No</th>
                <th style="text-align: center;z-index: 400;" rowspan="2">Nama Pegawai</th>
                <th style="text-align: center;" rowspan="2">Target Bobot Produktivitas Kerja</th>
                <th style="text-align: center;" rowspan="1" colspan="2">Penilaian Sasaran Kerja Bulanan Pegawai</th>
                <th style="text-align: center;" rowspan="1" colspan="9">Penilaian Komponen Kinerja</th>
                <th style="text-align: center;" rowspan="2">Capaian Bobot Produktivitas Kerja</th>
            </tr>
            <tr>
                <th style="text-align: center;" rowspan="1" colspan="1">% Capaian</th>
                <th style="text-align: center;" rowspan="1" colspan="1">Bobot</th>
                <th style="text-align: center;" rowspan="1" colspan="1">Berorientasi Pelayanan</th>
                <th style="text-align: center;" rowspan="1" colspan="1">Akuntabel</th>
                <th style="text-align: center;" rowspan="1" colspan="1">Kompeten</th>
                <th style="text-align: center;" rowspan="1" colspan="1">Harmonis</th>
                <th style="text-align: center;" rowspan="1" colspan="1">Loyal</th>
                <th style="text-align: center;" rowspan="1" colspan="1">Adaptif</th>
                <th style="text-align: center;" rowspan="1" colspan="1">Kolaboratif</th>
                <th style="text-align: center;" rowspan="1" colspan="1">Nilai Capaian</th>
                <th style="text-align: center;" rowspan="1" colspan="1">Bobot</th>
            </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($penilaian as $rs){ ?>
                    <tr >
                        <td  style="text-align: center;"><?=$no++;?></td>
                        <td scope="row" style="padding-top: 5px; padding-bottom: 5px;">
                            <?=$rs['nama_pegawai']?><br>
                            NIP. <?=$rs['nip']?>
                        </td>
                        <td style="width: 6%; text-align: center;"><?=TARGET_BOBOT_PRODUKTIVITAS_KERJA.'%'?></td>
                        <td style="width: 6%; text-align: center;"><?=$rs['kinerja'] ? formatTwoMaxDecimal($rs['nilai_skp']['capaian']) : 0;?>%</td>
                        <td style="width: 6%; text-align: center;"><?=$rs['kinerja'] ? formatTwoMaxDecimal($rs['nilai_skp']['bobot']) : 0;?>%</td>
                        <td style="width: 6%; text-align: center;"><?=$rs['komponen_kinerja'] ? $rs['komponen_kinerja']['berorientasi_pelayanan'] : 0;?></td>
                        <td style="width: 6%; text-align: center;"><?=$rs['komponen_kinerja'] ? $rs['komponen_kinerja']['akuntabel'] : 0;?></td>
                        <td style="width: 6%; text-align: center;"><?=$rs['komponen_kinerja'] ? $rs['komponen_kinerja']['kompeten'] : 0;?></td>
                        <td style="width: 6%; text-align: center;"><?=$rs['komponen_kinerja'] ? $rs['komponen_kinerja']['harmonis'] : 0;?></td>
                        <td style="width: 6%; text-align: center;"><?=$rs['komponen_kinerja'] ? $rs['komponen_kinerja']['loyal'] : 0;?></td>
                        <td style="width: 6%; text-align: center;"><?=$rs['komponen_kinerja'] ? $rs['komponen_kinerja']['adaptif'] : 0;?></td>
                        <td style="width: 6%; text-align: center;"><?=$rs['komponen_kinerja'] ? $rs['komponen_kinerja']['kolaboratif'] : 0;?></td>
                        <td style="width: 6%; text-align: center;"><?=$rs['komponen_kinerja'] ? ($rs['komponen_kinerja']['capaian']) : 0;?></td>
                        <td style="width: 6%; text-align: center;"><?=$rs['komponen_kinerja'] ? formatTwoMaxDecimal($rs['komponen_kinerja']['bobot']) : 0;?>%</td>
                        <td style="width: 6%; text-align: center;"><?=formatTwoMaxDecimal($rs['bobot_capaian_produktivitas_kerja'])?>%</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- tutup produktifitas   -->
                   <!-- disiplin -->
 <h4 class="new-page" style="text-align: center;"><strong>REKAPITULASI PENILAIAN DISIPLIN KERJA</strong></h4>
                            <table style="width: 100%; position: relative;">
                                <tr>
                                    <td>SKPD</td>
                                    <td>:</td>
                                    <td><?=$skpd[1]?></td>
                                </tr>
                                <tr>
                                    <td>Periode</td>
                                    <td>:</td>
                                    <td><?=getNamaBulan($bulan).' '.$tahun?></td>
                                </tr>
                            </table>
                    
                        <table class="cd-table rekap-table table" style="border: 1px solid black; border-collapse: collapse;" border="1" id="table_rekap_penilaianx">
                                <thead>
                                    <tr >
                                        <th style="text-align: center;  width: 3%;" rowspan="2">No</th>
                                        <th style="text-align: center;  z-index: 400; width: 20%;" rowspan="2">Nama Pegawai</td>
                                        <th style="text-align: center;  width: 3%;" rowspan="2">JHK</td>
                                        <th style="text-align: center;  width: 8%;" rowspan="2">TARGET CAP. PEN. DISIPLIN KERJA</th>
                                        <th style="text-align: center; " rowspan="1" colspan="<?=count($disiplin['mdisker'])?>">Keterangan</th>
                                        <th style="text-align: center;  width: 8%;" rowspan="2">CAPAIAN PENILAIAN DISIPLIN KERJA</th>
                                        <th style="text-align: center;  width: 8%;" rowspan="2">CAPAIAN BOBOT PENILAIAN DISIPLIN KERJA</td>
                                    </tr>
                                    <tr >
                                        <?php foreach($disiplin['mdisker'] as $m){ ?>
                                            <th style="text-align: center; " rowspan="1" colspan="1"><?=STRTOUPPER($m['keterangan'])?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($disiplin['result'] as $rs){
                                        $capaian = 0;
                                        $capaian_bobot = 0;
                                    ?>
                                        <tr>
                                            <td style="text-align: center;"><?=$no++;?></td>
                                            <td style="padding-top: 5px; padding: 5px;">
                                                <span style=""><?=$rs['nama_pegawai']?></span><br>
                                                <span style="">NIP. <?=$rs['nip']?></span>
                                            </td>
                                            <td style="width: 6%; text-align: center;"><?=$rs['rekap']['jhk']?></td>
                                            <td style="width: 6%; text-align: center;"><?=TARGET_PENILAIAN_DISIPLIN_KERJA.'%'?></td>
                                            <?php $temp_capaian = 0; foreach($disiplin['mdisker'] as $md){
                                                $color = '000000';
                                                if($rs['rekap'][$md['keterangan']]['pengurangan'] == 0){
                                                    $color = '#dfe2e5';
                                                }
                                            ?>
                                                <td style="text-align: center; color: <?=$color?>" rowspan="1" colspan="1"><?=$rs['rekap'][$md['keterangan']]['pengurangan'].'%'?></td>
                                            <?php } ?>
                                            <td style="text-align: center;"><?=$rs['rekap']['capaian_disiplin_kerja'].'%'?></td>
                                            <td style="text-align: center;"><?=$rs['rekap']['capaian_bobot_disiplin_kerja'].'%'?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <!-- tutup disiplin  -->
              <!-- perhitungan tpp  -->
  <h4 class="new-page" style="text-align: center;"><strong>DAFTAR PERHITUNGAN TPP</strong></h4>
        <?php  $skpd = explode(";",$parameter['skpd']);;?>
            <table style="width: 100%;">
                <tr>
                    <td>SKPD</td>
                    <td>:</td>
                    <td><?=$skpd[1]?></td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>:</td>
                    <td><?=getNamaBulan($parameter['bulan']).' '.$parameter['tahun']?></td>
                </tr>
            </table>
                <table border=1 class="table table-hover table-striped rekap-table" style="border: 1px solid black; border-collapse: collapse;">
        <thead>
            <tr>
                <th rowspan=2 class="text-center">No</th>
                <th rowspan=2 class="text-center">Pegawai</th>
                <th rowspan=2 class="text-center">Kelas Jabatan</th>
                <th rowspan=2 class="text-center">Besaran Pagu TPP (Rp)</th>
                <th rowspan=2 class="text-center">% Capaian Produktivitas Kerja</th>
                <th rowspan=2 class="text-center">% Capaian Disiplin Kerja Kerja</th>
                <th rowspan=2 class="text-center">% Penilaian TPP</th>
                <th rowspan=2 class="text-center">Capaian TPP (Rp)</th>
                <th rowspan=1 colspan=2 class="text-center">Potongan PPh</th>
                <th rowspan=2 class="text-center">Jumlah TPP Diterima (Rp)</th>
            </tr>
            <tr>
                <th rowspan=1 colspan=1 class="text-center">%</th>
                <th rowspan=1 colspan=1 class="text-center">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($perhitungan_tpp as $r){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left">
                        <span style="font-size: 14px; font-weight: bold"><?=$r['nama_pegawai']?></span><br>
                        <span class="text-data-pegawai">NIP. <?=formatNip($r['nip'])?></span><br>
                        <!-- <span class="text-data-pegawai"><?=$r['pangkat']?></span><br>
                        <span class="font-weight-bold text-data-pegawai"><?=$r['nama_jabatan']?></span> -->
                    </td>
                    <td class="align-middle text-center"><?=$r['kelas_jabatan']?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['pagu_tpp'])?></td>
                    <td class="align-middle text-center"><?=formatTwoMaxDecimal($r['bobot_produktivitas_kerja'])?> %</td>
                    <td class="align-middle text-center"><?=formatTwoMaxDecimal($r['bobot_disiplin_kerja'])?> %</td>
                    <td class="align-middle text-center"><?=formatTwoMaxDecimal($r['presentase_tpp'])?> %</td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['besaran_tpp'])?></td>
                    <td class="align-middle text-center">
                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                    </td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['nominal_pph'])?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['tpp_diterima'])?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
                <!-- tutup perhitungan tpp  -->
                <!-- permintaan tpp  -->
                <h4 class="new-page" style="text-align: center;"><strong>DAFTAR PERMINTAAN TPP</strong></h4>
        <?php  $skpd = explode(";",$parameter['skpd']);;?>
            <table style="width: 100%;">
                <tr>
                    <td>SKPD</td>
                    <td>:</td>
                    <td><?=$skpd[1]?></td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>:</td>
                    <td><?=getNamaBulan($parameter['bulan']).' '.$parameter['tahun']?></td>
                </tr>
            </table>
            <table border=1 class="table table-hover table-striped" style="border: 1px solid black; border-collapse: collapse;">
        <thead>
            <tr>
                <th rowspan=2 class="text-center">No</th>
                <th rowspan=2 class="text-center">Nama / NIP</th>
                <th rowspan=2 class="text-center">Gol / Rg</th>
                <th rowspan=2 class="text-center">Jabatan</th>
                <th rowspan=2 class="text-center">Kls. Jab.</th>
                <th rowspan=2 class="text-center">Ess</th>
                <th rowspan=2 class="text-center">Jumlah Capaian TPP (Rp)</th>
                <th rowspan=1 colspan=2 class="text-center">Potongan PPh</th>
                <th rowspan=2 class="text-center">Jumlah Setelah Dipotong PPh (Rp)</th>
            </tr>
            <tr>
                <th rowspan=1 colspan=1 class="text-center">%</th>
                <th rowspan=1 colspan=1 class="text-center">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($perhitungan_tpp as $r){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left">
                        <span style="font-size: 14px; font-weight: bold"><?=$r['nama_pegawai']?></span><br>
                        <span class="text-data-pegawai"><?=formatNip($r['nip'])?></span><br>
                        <!-- <span class="text-data-pegawai"><?=$r['pangkat']?></span><br>
                        <span class="font-weight-bold text-data-pegawai"><?=$r['nama_jabatan']?></span> -->
                    </td>
                    <td class="align-middle text-center"><?=$r['nomor_golongan']?></td>
                    <td class="align-middle text-center"><?=$r['nama_jabatan']?></td>
                    <td class="align-middle text-center"><?=$r['kelas_jabatan']?></td>
                    <td class="align-middle text-center"><?=$r['eselon']?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['besaran_tpp'])?></td>
                    <td class="align-middle text-center">
                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                    </td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['nominal_pph'])?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['tpp_diterima'])?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
                <!-- tutup permintaan tpp  -->
                <!-- pembayaran tpp  -->
                <h4 class="new-page" style="text-align: center;"><strong>DAFTAR PEMBAYARAN TPP</strong></h4>
        <?php  $skpd = explode(";",$parameter['skpd']);;?>
            <table style="width: 100%;">
                <tr>
                    <td>SKPD</td>
                    <td>:</td>
                    <td><?=$skpd[1]?></td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>:</td>
                    <td><?=getNamaBulan($parameter['bulan']).' '.$parameter['tahun']?></td>
                </tr>
            </table>
                <table border=1 class="table table-hover table-striped" style="border: 1px solid black; border-collapse: collapse;">
        <thead>
            <tr>
                <th rowspan=2 class="text-center">No</th>
                <th rowspan=2 class="text-center">Nama / NIP</th>
                <th rowspan=2 class="text-center">Kls. Jab.</th>
                <th rowspan=2 class="text-center">Ess</th>
                <th rowspan=2 class="text-center">Jumlah TPP yang dicapai (Rp)</th>
                <th rowspan=1 colspan=2 class="text-center">Potongan PPh</th>
                <th rowspan=2 class="text-center">Jumlah Setelah Dipotong PPh (Rp)</th>
            </tr>
            <tr>
                <th rowspan=1 colspan=1 class="text-center">%</th>
                <th rowspan=1 colspan=1 class="text-center">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($perhitungan_tpp as $r){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left">
                        <span style="font-size: 14px; font-weight: bold"><?=$r['nama_pegawai']?></span><br>
                        <span class="text-data-pegawai"><?=formatNip($r['nip'])?></span><br>
                        <!-- <span class="text-data-pegawai"><?=$r['pangkat']?></span><br>
                        <span class="font-weight-bold text-data-pegawai"><?=$r['nama_jabatan']?></span> -->
                    </td>
                    <td class="align-middle text-center"><?=$r['kelas_jabatan']?></td>
                    <td class="align-middle text-center"><?=$r['eselon']?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['besaran_tpp'])?></td>
                    <td class="align-middle text-center">
                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                    </td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['nominal_pph'])?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['tpp_diterima'])?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
                <!-- tutup pembayaran tpp  -->
                <?php } else { ?>
    <div class="row">
        <div class="col-lg-12 text-center">Data Tidak Ditemukan <i class="fa fa-exclamation"></i></div>
    </div>
<?php } ?>
        </body>
    </html>
