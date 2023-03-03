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
            <?php if($status != 1){ ?>
                <th class="text-center">Verifikator</th>
            <?php } ?>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $r){ ?>
                <tr>
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
                                    Lihat Dokumen
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
                    <?php if($status != 1){ ?>
                        <td class="text-left">
                        <!-- <span style="font-size: 14px;"><?='<strong>'.$r['keterangan_verif'].'</strong><br>(oleh '.$r['nama_verif'].' pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span> -->
                        <span style="font-size: 14px;"><?='<strong>'.$r['keterangan_verif'].'</strong><br>(pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span>
                        </td>
                    <?php } ?>
                    <td class="text-center">
                            <!-- <button data-toggle="modal" onclick="openDetailModalDataDisiplinKerja('<?=$r['id_m_user']?>')" href="#detailModalDataDisiplinKerja" type="button" class="btn btn-navy btn-sm"><i class="fa fa-list"></i> Detail</button>
                            <button onclick="deleteDisiplinKerjaByIdUser('<?=$r['id_m_user']?>')" type="button" id="btn_delete_<?=$r['id_m_user']?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                            <button type="button" disabled style="display: none;" id="btn_loading_<?=$r['id_m_user']?>" class="btn btn-danger btn-sm"><i class="fa fa-spin fa-spinner"></i> Loading....</button> -->

                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="deleteDataDisiplinKerjaById('<?=$r['id']?>')" type="button" id="btn_delete_detail_<?=$r['id']?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                            <button type="button" disabled style="display: none;" id="btn_loading_detail_<?=$r['id']?>" class="btn btn-danger btn-sm"><i class="fa fa-spin fa-spinner"></i> Loading....</button>
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
</script>