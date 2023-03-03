<?php if($result){ ?>
    <table border=1 class="table table-hover" id="table_disiplin_kerja_result_data">
        <thead>
            <th class="text-center">No</th>
            <th class="text-left">Nama Pegawai</th>
            <th class="text-left">NIP</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Tanggal Usul</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Dokumen</th>
            <th class="text-center">Keterangan Verif</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $r){ ?>
                <tr id="tr_<?=$r['id']?>">
                    <td class="text-center"><?=$no?></td>
                    <td class="text-left"><?=getNamaPegawaiFull($r)?></td>
                    <td class="text-left"><?=formatNip($r['nip'])?></td>
                    <?php
                        // $bulan = $r['bulan'] < 10 ? '0'.$r['bulan'] : $r['bulan'];
                        // $tanggal = $r['tanggal'] < 10 ? '0'.$r['tanggal'] : $r['tanggal'];
                    ?>
                    <!-- <td class="text-center"><?= formatDateNamaBulan($r['tahun'].'-'.$bulan.'-'.$tanggal) ?></td> -->
                    <td class="text-center"><?= formatDateNamaBulan($r['dari_tanggal']).' - '.formatDateNamaBulan($r['sampai_tanggal']) ?></td>
                    <td class="text-center"><?= formatDateNamaBulanWT($r['created_date']) ?></td>
                    <td class="text-center"><?= ($r['keterangan']) ?></td>
                    <td class="text-center">
                        <?php if($r['dokumen_pendukung']) { $dokpen = json_decode($r['dokumen_pendukung']); if($dokpen[0] != "") { $nodok = 1; ?>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-navy btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <?php foreach($dokpen as $dk){ ?>
                                        <a class="dropdown-item" target="_blank" href="<?=base_url(DOKUMEN_PENDUKUNG_DISIPLIN_KERJA.'/'.$dk)?>">Dokumen <?=$nodok++;?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            -
                        <?php } } ?>
                    </td>
                    <td>
                        <?php if($status == 2 || $status == 3){ ?>
                            <span><strong><?=$r['keterangan_verif']?></strong></span><br>
                            <!-- <span style="font-size: 14px;"><?='(oleh '.$r['nama_verif'].' pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span> -->
                            <span style="font-size: 14px;"><?='(pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span>
                        <?php } else if($status == 1) { ?> 
                            <input class="form-control" id="ket_verif_<?=$r['id']?>" />
                        <?php } else if($status == 4){ ?>
                            <input class="form-control" id="ket_verif_<?=$r['id']?>" />
                            <span style="font-size: 14px;"><?='(DIBATALKAN pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(2, '<?=$r['id']?>')" style="display: <?=$status == 1 || $status == 4 ? 'block' : 'none'?>" class="btn_verif_<?=$r['id']?> btn btn-sm btn-success" title="Terima"><i class="fa fa-check"></i></button>
                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(3, '<?=$r['id']?>')" style="display: <?=$status == 1 || $status == 4 ? 'block' : 'none'?>" class="btn_verif_<?=$r['id']?> btn btn-sm btn-danger" title="Tolak"><i class="fa fa-times"></i></button>
                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(4, '<?=$r['id']?>')" style="display: <?=$status == 1 || $status == 4 ? 'none' : 'block'?>" class="btn_verif_<?=$r['id']?> btn btn-sm btn-warning" title="Batal"><i class="fa fa-trash"></i></button>
                            <button disabled style="display: none;" id="btn_loading_<?=$r['id']?>" class="btn btn-sm btn-info"><i class="fa fa-spin fa-spinner"></i></button>
                        </div>
                    </td>
                </tr>
            <?php $no++; } ?>
        </tbody>
    </table>
<?php } else { ?>
    <div class="col-12 text-center">
        <h6>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h6>
    </div>
<?php } ?>
<script>
    $(function(){
        $('#count_pengajuan').html('<?=$count['pengajuan']?>')
        $('#count_diterima').html('<?=$count['diterima']?>')
        $('#count_ditolak').html('<?=$count['ditolak']?>')
        $('#count_batal').html('<?=$count['batal']?>')

        $('#table_disiplin_kerja_result_data').dataTable()
    })

    function verifDokumen(status, id){
        $('.btn_verif_'+id).hide()
        $('#btn_loading_'+id).show()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/verifDokumen/")?>'+'/'+id+'/'+status,
            method: 'post',
            data: {
                list_id : $('.btn_verif_'+id).data('list_id'),
                keterangan: $('#ket_verif_'+id).val()
            },
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    // successtoast('Data Berhasil Diverifikasi')
                    // openListData(active_status)
                    $('#count_pengajuan').html(rs.data.pengajuan)
                    $('#count_diterima').html(rs.data.diterima)
                    $('#count_ditolak').html(rs.data.ditolak)
                    $('#count_batal').html(rs.data.batal)
                    $('#tr_'+id).hide();
                } else {
                    errortoast(rs.message)
                }
                $('.btn_verif_'+id).show()
                $('#btn_loading_'+id).hide()
            }, error: function(e){
                $('.btn_verif_'+id).show()
                $('#btn_loading_'+id).hide()
                errortoast('Terjadi Kesalahan')
            }
        })
    }
</script>