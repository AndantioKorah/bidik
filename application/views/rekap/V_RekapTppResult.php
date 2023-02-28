
<?php if(isset($skpd)) { ?>
    <?php if(isset($json_result)) { ?>
<form target="blank" action="<?=base_url('rekap/C_Rekap/downloadPdf')?>" enctype="multipart/form-data" method="post">
<input type="hidden" autocomplete="off" class="form-control" id="skpd" name="skpd" value="<?= $data_serach['skpd']; ?>" />
<input type="hidden" autocomplete="off" class="form-control" id="tahun" name="tahun" value="<?= $data_serach['tahun']; ?>" />
<input type="hidden" autocomplete="off" class="form-control" id="bulan" name="bulan" value="<?= $data_serach['bulan']; ?>" />
<button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-download"></i> Download as PDF</button>
                    </form>
<?php } ?>
        <div class="col-lg-12" style="width: 100%;">
            <form action="<?=base_url('rekap/C_Rekap/rekapPenilaianSearch/1')?>" method="post" target="_blank">
                <!-- <center><h5><strong>REKAPITULASI PENILAIAN DISIPLIN KERJA</strong></h5></center> -->
                <br>
                
                <table style="width: 100%; position: relative;">
                    <tr>
                        <td>SKPD</td>
                        <td>:</td>
                        <td><?=$skpd?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>:</td>
                        <td><?=getNamaBulan($bulan).' '.$tahun?></td>
                    </tr>
                    <tr>
                        <td>Jenis File</td>
                        <td>:</td>
                        <td>
                            <select class="form-control select2-navy" style="width: 100%"
                                id="jenis_file" data-dropdown-css-class="select2-navy" name="jenis_file">
                                <option selected value="absen">Rekap Absensi</option>
                                <option value="produktivitas_kerja">Rekap Produktivitas Kerja</option>
                                <option value="penilaian_disiplin_kerja">Rekap Penilaian Disiplin Kerja</option>
                                <option value="daftar_perhitungan_tpp">Daftar Perhitungan TPP</option>
                                <option value="daftar_permintaan">Daftar Permintaan</option>
                                <option value="daftar_pembayaran">Daftar Pembayaran</option>
                            </select>    
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="col-lg-12 table-responsive mt-3" style="width: 100%; height: 70vh; overflow: auto;" id="result_rekap_div">
        
        </div>
        <script>
            $(function(){
                $('#jenis_file').select2()
                loadViewByJenisFile()
            })

            $('#jenis_file').on('change', function(){
                loadViewByJenisFile()
            })

            function loadViewByJenisFile(){
                $('#result_rekap_div').html('')
                $('#result_rekap_div').append(divLoaderNavy)
                $('#result_rekap_div').load('<?=base_url("rekap/C_Rekap/loadViewByJenisFile/")?>'+$('#jenis_file').val(), function(){
                    $('#loader').hide()
                })
            }
        </script>
<?php } else { ?>
    <h5>Data Absen Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
<?php } ?>