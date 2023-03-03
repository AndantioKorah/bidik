<?php if(isset($skpd)){ ?>
    <html>
        <head>
         
        </head>
        <?php
            if(isset($flag_print) && $flag_print == 1){
                $filename = $nama_file;
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\""); 
            }
        ?>
        <body>
                <center>
                <h5 style="font-size: 20px;">
                    REKAP ABSENSI <?=strtoupper($skpd)?><br>
                    <?=strtoupper($periode)?>
                </h5>
                <?php if(isset($flag_print) && $flag_print == 0){ ?>
                    <form target="blank" action="<?=base_url('rekap/C_Rekap/downloadAbsensiNew')?>">
                        <button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-download"></i> Download as Excel</button>
                    </form>
                    <br>

                   
                    <span style="font-size: 14px; font-weight: bold;">Jadwal Jam Kerja <?=$jam_kerja['nama_jam_kerja']?></span>
                    <table style="width: 50%; margin-bottom: 10px;" border=1>
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

                    <?php if(isset($jam_kerja_event)){ ?>
                        <br>
                        <span style="font-size: 14px; font-weight: bold;">Jadwal Jam Kerja <?=$jam_kerja_event['nama_jam_kerja']?></span><br>
                        <span style="font-size: 14px; font-weight: normal;"><?='Berlaku dari '.formatDateNamaBulan($jam_kerja_event['berlaku_dari']).' - '.formatDateNamaBulan($jam_kerja_event['berlaku_sampai'])?></span>
                        <table style="width: 50%; margin-bottom: 10px;" border=1>
                            <thead>
                                <th style="text-align: center; font-size: 14px;">Hari</th>
                                <th style="text-align: center; font-size: 14px;">Jam Masuk</th>
                                <th style="text-align: center; font-size: 14px;">Jam Pulang</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-size: 14px; text-align: center;">Senin - Kamis</td>
                                    <td style="text-align: center; font-size: 14px;"><?=$jam_kerja_event['wfo_masuk']?></td>
                                    <td style="text-align: center; font-size: 14px;"><?=$jam_kerja_event['wfo_pulang']?></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; text-align: center;">Jumat</td>
                                    <td style="text-align: center; font-size: 14px;"><?=$jam_kerja_event['wfoj_masuk']?></td>
                                    <td style="text-align: center; font-size: 14px;"><?=$jam_kerja_event['wfoj_pulang']?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                <?php } ?>
                </center>
               
                <br>

                <!-- tes  -->
   

    <br /><br />
    <?php if(isset($flag_print) && $flag_print == 0){ ?>
        <input type="text" class="cd-search table-filter" data-table="rekap-table" placeholder="Cari Pegawai" />
    <?php } ?>
    <div class="div_maintb">
    <table class="rekap-table table"  border="1" id="table_rekap_absenx">
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
    </div>

                <!-- tutup tes  -->
               
                
                <br>
                <center>
                <span style="font-size: 12px;">printed by: </span><span style="font-size: 12px; font-weight: bold;"><?=$this->general_library->getNamaUser()?></span>
                <br>
                <span style="font-size: 12px;">date: </span><span style="font-size: 12px; font-weight: bold;"><?=date('d/m/Y H:i:s')?></span>
                                  </center>
        </body>
    </html>
<?php } else { ?>
    <div class="row">
        <div class="col-lg-12 text-center">Data Tidak Ditemukan <i class="fa fa-exclamation"></i></div>
    </div>
<?php } ?>
<script>
   $(function(){
    fixedHeaderTable()
    })

    $('#table_rekap_absen').DataTable({
    "ordering": false
     });
    
</script>