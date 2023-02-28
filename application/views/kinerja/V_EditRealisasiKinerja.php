
<?php if($realisasi){ ?>
    
	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datetimepicker.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datepicker.css')?>">
  <script src="<?=base_url('assets/js/bootstrap-datetimepicker.js')?>"></script>
  <script src="<?=base_url('assets/js/bootstrap-datepicker.js')?>"></script>

    <form id="form_edit_realisasi_kinerja">
        <input style="display: none;" id="id_kegiatan" name="id_kegiatan" value="<?=$realisasi['id']?>" />
        <div class="row p-3">
            <div class="col-md-12">
             
            </div>
            <div class="col-md-9"></div>
            <div class="col-md-12">
                <label>Rencana Kegiatan</label>
                <!-- <input required autocomplete="off" id="edit_tugas_jabatan"  class="form-control form-control-sm" name="edit_tugas_jabatan" value="<?=$realisasi['tugas_jabatan']?>" readonly/> -->
                <textarea readonly  class="form-control form-control-sm" name="edit_tugas_jabatan" id="edit_tugas_jabatan" cols="30" rows="3"><?=$realisasi['tugas_jabatan']?></textarea>
            </div>

            <div class="col-md-4">
                <label for="exampleFormControlTextarea1">Detail Kegiatan</label>
                <textarea class="form-control" id="edit_deskripsi_kegiatan" name="edit_deskripsi_kegiatan" rows="3" required><?=$realisasi['deskripsi_kegiatan']?></textarea>

                <!-- <input  autocomplete="off" id="edit_deskripsi_kegiatan"  class="form-control form-control-sm" name="edit_deskripsi_kegiatan" value="<?=$realisasi['deskripsi_kegiatan']?>" /> -->
            </div>

            <div class="col-md-4">
                <label>Tanggal Kegiatan</label>
                <!-- <input readonly autocomplete="off"  id="edit_tanggal_kegiatan"  class="form-control form-control-sm " name="edit_tanggal_kegiatan" value="<?= formatDateNamaBulanWT($realisasi['tanggal_kegiatan'])?>" /> -->
                
                <input  class="form-control datetimepickerthis" id="edit_tanggal_kegiatan" name="edit_tanggal_kegiatan"  value="<?= formatDateForEdit($realisasi['tanggal_kegiatan']) ;?>">
   
            
            </div>

          

            <div class="col-md-4">
                <label>Realisasi Target (Kuantitas)</label>
                <input required autocomplete="off" id="edit_realisasi_target_kuantitas"  class="form-control form-control-sm" name="edit_realisasi_target_kuantitas" value="<?=$realisasi['realisasi_target_kuantitas']?>" />
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

        
        })

        $('#form_edit_realisasi_kinerja').on('submit', function(e){
            tanggal = $('#edit_tanggal_kegiatan').val()
            var d = new Date(tanggal);

            var bulan = d.getMonth() + 1;
            var tahun = d.getFullYear();
            // document.getElementById('edit_deskripsi_kegiatan_hidden').value=null;

            // var kegiatan = $('#edit_deskripsi_kegiatan_hiden').val()
            
            // if(kegiatan == ""){
            //     alert(1);
            // } else {
            //     alert(2);
            // }
            // return false;

            e.preventDefault()
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/editRealisasiKinerja")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                   let res = JSON.parse(datares)
                   if(res.code == 0){
                        successtoast('Data Berhasil Disimpan')
            
                            $('#edit_realisasi_kinerja').modal('hide')
                            loadListKegiatan(tahun,bulan)
                   } else {
                       errortoast(res.message)
                   }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })


        $('.datetimepickerthis').datetimepicker({
            format: 'yyyy-mm-dd hh:ii:ss',
            autoclose: true,
            todayHighlight: true,
            todayBtn: true
        })
     

    </script>
<?php } else { ?>
    <div class="col-12 text-center">
        <h6><i class="fa fa-exclamation"></i> Data tidak ditemukan</h6>
    </div>
<?php } ?>    