<?php if($rencana){ ?>
    <form id="form_edit_rencana_kinerja">
        <input style="display: none;" id="id_kegiatan" name="id_rencana_kinerja" value="<?=$rencana['id']?>" />
        <div class="row p-3">
            <div class="col-md-12">
             
            </div>
            <div class="col-md-9"></div>
            <div class="col-md-12">
                <label>Uraian Tugas</label>
                <!-- <input required autocomplete="off" id="edit_tugas_jabatan"  class="form-control form-control-sm" name="edit_tugas_jabatan" value="<?=$rencana['tugas_jabatan']?>" readonly/> -->
          <textarea readonly  class="form-control form-control-sm" name="edit_tugas_jabatan" id="edit_tugas_jabatan" cols="30" rows="3"><?=$rencana['tugas_jabatan']?></textarea>
            </div>

            <div class="col-md-12">
                <label>Sasaran Kerja</label>
                <!-- <input required autocomplete="off" id="edit_sasaran_kerja"  class="form-control form-control-sm" name="edit_sasaran_kerja" value="<?=$rencana['sasaran_kerja']?>" readonly/> -->
                <textarea  class="form-control form-control-sm" name="edit_sasaran_kerja" id="edit_sasaran_kerja" cols="30" rows="3"><?=$rencana['sasaran_kerja']?></textarea>
            </div>

            <div class="col-md-4">
                <label>Tahun</label>
                <input autocomplete="off"  id="edit_tahun"  class="form-control form-control-sm" name="edit_tahun" value="<?= $rencana['tahun']?>" readonly/>
            </div>

            <div class="col-md-4">
                <label>Bulan</label>
                <input type="hidden" autocomplete="off" id="edit_bulan_angka"  class="form-control form-control-sm" name="edit_bulan_angka" value="<?= $rencana['bulan']?>" Readonly/>
                <input autocomplete="off" id="edit_bulan"  class="form-control form-control-sm" name="edit_bulan" value="<?= getNamaBulan($rencana['bulan'])?>" Readonly/>
            </div>

            <div class="col-md-4">
                <label>Target (Kuantitas)</label>
                <input type="hidden" autocomplete="off" id="edit_target_kuantitas_awal"  class="form-control form-control-sm" name="edit_target_kuantitas_awal" value="<?=$rencana['target_kuantitas']?>" />

                <input required autocomplete="off" id="edit_target_kuantitas"  class="form-control form-control-sm" name="edit_target_kuantitas" value="<?=$rencana['target_kuantitas']?>" />
            </div>

            <div class="col-md-6">
                <label>Satuan</label>
                <input required autocomplete="off" id="edit_satuan"  class="form-control form-control-sm" name="edit_satuan" value="<?=$rencana['satuan']?>" />
            </div>


            <div class="col-md-6">
                <label>Target (Kualitas)</label>
                <input required autocomplete="off" id="edit_realisasi_target_kuantitas"  class="form-control form-control-sm" name="edit_realisasi_target_kuantitas" value="100%" Readonly/>
            </div>

            <div class="col-md-12"><hr></div>
            <div class="col-md-12 text-right">
                <button type="submit" id="btn_simpan_edit" accesskey="s" class="btn btn-block btn-navy"><i class="fa fa-save"></i> <u>S</u>IMPAN</button>
            </div>
        </div>
    </form>
    <script>
        $(function(){
            $('.select2_this').select2()

            $("#tanggal_lahir").inputmask("99-99-9999", {
                placeholder: "hh-bb-tttt"
            });
        })

        $('#form_edit_rencana_kinerja').on('submit', function(e){
           

            var bulan = $('#edit_bulan_angka').val()
            var tahun = $('#edit_tahun').val()
            var targetAwal = parseInt($('#edit_target_kuantitas_awal').val());
            var targetBaru = parseInt($('#edit_target_kuantitas').val());

            if(targetBaru < targetAwal){
            errortoast('Tidak bisa kurang dari target sebelumnya');
            $('#edit_target_kuantitas').val(targetAwal);
            return false;
            } 
            
            e.preventDefault()
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/editRencanaKinerja")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                   let res = JSON.parse(datares)
                   if(res.code == 0){
                        successtoast('Data Berhasil Disimpan')
            
                            $('#edit_rencana_kinerja').modal('hide')
                            loadRencanaKinerja(bulan,tahun)
                   } else {
                       errortoast(res.message)
                   }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })

        $('.datepicker').datepicker({
    format: 'yyyy',
    viewMode: "years", 
    minViewMode: "years",
    orientation: 'bottom',
    autoclose: true
});
    </script>
<?php } else { ?>
    <div class="col-12 text-center">
        <h6><i class="fa fa-exclamation"></i> Data tidak ditemukan</h6>
    </div>
<?php } ?>    