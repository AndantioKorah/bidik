<?php if($list_rekap_kinerja){ ?>
    <div class="col-12 table-responsive">
    <table border="2"  class="table table-hover table-striped" id="table_rekap_kinerja">
    <tbody><tr height="20" style="height:15.0pt">
    <th rowspan="2" class="table-danger" height="40" >No</th>
    <th rowspan="2" class="table-danger">Uraian Tugas</th>
    <th rowspan="2" class="table-danger">Sasaran Kerja</th>
    <th rowspan="2" class="table-danger">Tahun</th>
    <th rowspan="2" class="table-danger">Bulan</th>
    <th colspan="3" class="text-center table-danger" width="265" style="border-left:none;width:199pt">Target<span style="mso-spacerun:yes">&nbsp;</span></th>
    <th colspan="3" class="text-center table-danger" width="192" style="border-left:none;width:144pt">Realisasi</th>
    </tr>
    <tr height="20" style="height:15.0pt">
    <td height="20" class="xl67 table-danger" style="height:15.0pt;border-top:none;border-left:
    none"> <b>Kuantitas</b></td>
    <td class="xl67 table-danger" style="border-top:none;border-left:none"><b>Satuan</b></td>
    <td class="xl67 table-danger" style="border-top:none;border-left:none"><b>Capaian</b></td>
    <td class="xl67 table-danger" style="border-top:none;border-left:none"><b>Kuantitas</b></td>
    <td class="xl67 table-danger" style="border-top:none;border-left:none"><b>Satuan</b></td>
    <td class="xl67 table-danger" style="border-top:none;border-left:none;width:144pt"><b>Capaian</b></td>
    </tr>
  
    <!--[if supportMisalignedColumns]-->
    <?php $no=1; 
           
            foreach($list_rekap_kinerja as $lp){ ?>
            
                <?php
                
                // $realisasi_kualitas = $lp['realisasi_target_kuantitas']/$lp['target_kuantitas'] * 100;
                $progress = (floatval($lp['realisasi_target_kuantitas'])/floatval($lp['target_kuantitas'])) * 100;
                if($progress > 100){
                    $progress = 100;
                }
                $progress = formatTwoMaxDecimal($progress);
                ?>
                    <tr onclick="openListKegiatan('<?=$lp['id']?>')">
                        <td class="text-left"><?=$no++;?></td>
                        <td class="text-left"><?=$lp['tugas_jabatan']?></td>
                        <td class="text-left"><?=$lp['sasaran_kerja']?></td>
                        <td class="text-left"><?=$lp['tahun']?></td>
                        <td class="text-left"><?= getNamaBulan($lp['bulan'])?></td>
                        <td class="text-left"><?=$lp['target_kuantitas']?></td>                       
                        <td class="text-left"><?=$lp['satuan']?></td>
                        <td class="text-left"><?=$lp['target_kualitas']?>%</td>
                        <td class="text-left">
                            <?=$lp['realisasi_target_kuantitas'] == '' ? '0' : $lp['realisasi_target_kuantitas']?></td>
                        <td class="text-left"><?=$lp['satuan']?></td>
                        <td class="text-left">
                        <div class="progress progress-sm">
                            <div class="progress-bar" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress.'%'?>; background-color: <?=getProgressBarColor($progress)?>;">
                            </div>
                        </div>
                        <small style="font-size: 90% !important; font-weight: bold !important;">
                            <?=$progress.' % selesai'?>
                        </small>
                        <!-- 
                        <div class="text-center" style="border: 2px solid #80808082; border-radius: 5px; width: 100%; height: 30px; padding-bottom: 27px;">
                                        <div class="text-center" style="border-radius: 3px; background-color: <?=getProgressBarColor($progress)?>; overflow: show; white-space: nowrap; width: <?=$progress.'%'?>; height: 27px;">
                                            <strong style="font-size: 18px; color: <?=$progress == 25 || $progress == 100 ? 'white' : 'black'?>;"><?=$progress.' %';?></td></strong>
                                        </div>
                                    </div> -->
                        </td>
                    </tr>
                <?php } ?>
 <!--[endif]-->
</tbody></table>


       
    </div>
    <div class="col-12" id="list_kegiatan" style="display: none;">
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-12">
            <h5 style="text-center">DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
        </div>
    </div>
<?php } ?>
        </div>
    </div>

    <script>
         function openListKegiatan(id){
            $('.tr_rekap_realisasi').removeClass('tr_rekap_active')
            $('#tr_rekap_'+id).addClass('tr_rekap_active')

            $('#list_kegiatan').show()
            $('#list_kegiatan').html('')
            $('#list_kegiatan').append(divLoaderNavy)
            $('#list_kegiatan').load('<?=base_url("kinerja/C_VerifKinerja/loadListKegiatanRencanaKinerja")?>'+'/'+id, function(){
                $('#loader').hide()
            })
        } 
    </script>