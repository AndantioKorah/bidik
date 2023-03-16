<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">Penetapan Sasaran Kerja</h3>
    </div>
    <div class="card-body" style="display: block;">
    
    <form method="post" id="form_tambah_rencana_kinerja">
    
  <div class="form-group" >
    <label for="exampleFormControlInput1">Uraian Tugas</label>
    <!-- <input required class="form-control " id="tugas_jabatan" name="tugas_jabatan" autocomplete="off"> -->
    <input class="form-control"  type="text" list="tugasjabatan" id="tugas_jabatan" name="tugas_jabatan" autocomplete="off" required/>
      <datalist id="tugasjabatan">
      <?php if($list_rencana_kinerja){
                                foreach($list_rencana_kinerja as $ls){
                                ?>
                                <option value="<?=$ls['tugas_jabatan']?>">
                                    <?=$ls['tugas_jabatan']?>
                                </option>
                                <?php } } ?>
      </datalist>
  </div>

  <div class="form-group" >
    <label for="exampleFormControlInput1">Sasaran Kerja</label>
    <input required class="form-control" list="sasarankerja"  id="sasaran_kerja" name="sasaran_kerja" autocomplete="off">
    <datalist id="sasarankerja">
      <?php if($list_sasaran_kerja){
                                foreach($list_sasaran_kerja as $ls){
                                ?>
                                <option value="<?=$ls['sasaran_kerja']?>">
                                    <?=$ls['sasaran_kerja']?>
                                </option>
                                <?php } } ?>
      </datalist>
        </div>

    <div class="form-group" >
    <label for="exampleFormControlInput1">Tahun</label>
    <input  class="form-control datepicker" id="tahun" name="tahun" value="<?= date('Y');?>">
  </div>

    <div class="form-group" >
    <label for="exampleFormControlInput1">Bulan</label>
    <select class="form-control select2-navy" style="width: 100%"
                 id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                 <option selected>- Pilih Bulan -</option>
                 <option <?=date('m') == 1 ? 'selected' : '';?> value="1">Januari</option>
                 <option <?=date('m') == 2 ? 'selected' : '';?> value="2">Feburari</option>
                 <option <?=date('m') == 3 ? 'selected' : '';?> value="3">Maret</option>
                 <option <?=date('m') == 4 ? 'selected' : '';?> value="4">April</option>
                 <option <?=date('m') == 5 ? 'selected' : '';?> value="5">Mei</option>
                 <option <?=date('m') == 6 ? 'selected' : '';?> value="6">Juni</option>
                 <option <?=date('m') == 7 ? 'selected' : '';?> value="7">Juli</option>
                 <option <?=date('m') == 8 ? 'selected' : '';?> value="8">Agustus</option>
                 <option <?=date('m') == 9 ? 'selected' : '';?> value="9">September</option>
                 <option <?=date('m') == 10 ? 'selected' : '';?> value="10">Oktober</option>
                 <option <?=date('m') == 11 ? 'selected' : '';?> value="11">November</option>
                 <option <?=date('m') == 12 ? 'selected' : '';?> value="12">Desember</option>
                 </select>
  </div>

      
 <div class="form-group" >
    <div class="row">
    <div class="col">
    <label >Target Kuantitas</label>
      <input onkeyup="cekKuantitas()" required type="number" class="form-control" name="target_kuantitas" id="target_kuantitas" autocomplete="off">
    </div>

    <div class="col">
    <label >Satuan</label>
      <input required type="text" class="form-control" name="satuan" id="satuan" autocomplete="off" list="sat" >
      <datalist id="sat">
        <option >Dokumen</option>
        <option >Data</option>
        <option >Pegawai</option>
        <option >SKPD</option>
        <option >Hari</option>
        <option >Tugas</option>
      </datalist>
   
    </div>
  </div>
  </div>

  <div class="form-group">
    <label>Target Kualitas (%)</label>
    <input  class="form-control" type="text" id="target_kualitas" name="target_kualitas" value="100" readonly/>
  </div>
  <div class="form-group">
     <button class="btn btn-block btn-navy" id="btn_upload"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 

    </div>
</div>

<div class="card card-default" id="list_rencana_kinerja">
    
</div>

<div class="modal fade" id="edit_rencana_kinerja" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">EDIT SASARAN KERJA</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="edit_rencana_kinerja_content">
          </div>
      </div>
  </div>
</div>




<script>

    $(function(){
      var tahun = '<?=date("Y")?>'
         var bulan = '<?=date("m")?>'
        loadRencanaKinerja(bulan,tahun)
    })

    function loadRencanaKinerja(bulan,tahun){
      

        $('#list_rencana_kinerja').html('')
        $('#list_rencana_kinerja').append(divLoaderNavy)
        $('#list_rencana_kinerja').load('<?=base_url("kinerja/C_kinerja/loadRencanaKinerja")?>'+'/'+bulan+'/'+tahun, function(){
            $('#loader').hide()
        })
    }

    $('#search_bulan').on('change', function(){
      searchListRencanaKinerja()
    })

    $('#search_tahun').on('change', function(){
        searchListRencanaKinerja()
    })

    function searchListRencanaKinerja(){
        if($('#search_bulan').val() == '')  
        {  
        errortoast(" Pilih Bulan terlebih dahulu");  
        return false
        } 
        var tahun = $('#search_tahun').val(); 
        var bulan = $('#search_bulan').val();
        $('#list_rencana_kinerja').html(' ')
        $('#list_rencana_kinerja').append(divLoaderNavy)
        $('#list_rencana_kinerja').load('<?=base_url('kinerja/C_Kinerja/loadRencanaKinerja/')?>'+bulan+'/'+tahun+'', function(){
            $('#loader').hide()
           
        })
    }


    // $('#search_bulan').on('change', function(){
    //     loadRencanaKinerja($('#search_bulan').val(), $('#search_tahun').val())
    // })

    // $('#search_tahun').on('changeDate', function(){
    //     loadRencanaKinerja($('#search_bulan').val(), $('#search_tahun').val())
    // })

    $('#form_tambah_rencana_kinerja').on('submit', function(e){
      document.getElementById('btn_upload').disabled = true;
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/createRencanaKinerja")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
              document.getElementById('btn_upload').disabled = false;
                successtoast('Data berhasil ditambahkan')
                loadRencanaKinerja($('#bulan').val(), $('#tahun').val())
                document.getElementById("form_tambah_rencana_kinerja").reset();
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })



    function openModalEditRencanaKinerja(id = 0){
    $('#edit_rencana_kinerja_content').html('')
    $('#edit_rencana_kinerja_content').append(divLoaderNavy)
    $('#edit_rencana_kinerja_content').load('<?=base_url("kinerja/C_Kinerja/loadEditRencanaKinerja")?>'+'/'+id, function(){
      $('#loader').hide()
    })
  }


  function cekKuantitas(){
        var kuantitas = $('#target_kuantitas').val()
        if(kuantitas == 0){
         errortoast('Target Kuantitas tidak boleh 0')
         $('#target_kuantitas').val('')
        }
      }

</script>

