<style type="text/css">
.thumb{
  margin: 24px 5px 20px 0;
  width: 150px;
  float: left;
}
#blah {
  border: 2px solid;
  display: block;
  background-color: white;
  border-radius: 5px;
}
</style>
<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">Realisasi Kinerja Pegawai</h3>
    </div>
    <div class="card-body" style="display: block;">
    <form method="post" id="upload_form" enctype="multipart/form-data">
    <div class="form-group" >
    <label for="exampleFormControlInput1">Tanggal Kegiatan</label>
    <input oncanges="" class="form-control datetimepickerthis" id="tanggal_kegiatan" name="tanggal_kegiatan" readonly value="<?= date('Y-m-d H:i:s') ;?>">
  </div>
    <div class="form-group">
         <label class="bmd-label-floating">Kegiatan Tugas Jabatan </label>
         <select class="form-control select2-navy" name="tugas_jabatan" id="tugas_jabatan" onchange="getSatuan()" required>
         <option value="0" selected>- Pilih Tugas Jabatan -</option>
         </select>
             <!-- <select class="form-control select2-navy" style="width: 100%" onchange="getSatuan()"
                 id="tugas_jabatan" data-dropdown-css-class="select2-navy" name="tugas_jabatan" required>
                 <option value="" selected>- Pilih Tugas Jabatan -</option>
                 <?php if($list_rencana_kinerja){
                                foreach($list_rencana_kinerja as $ljp){
                                ?>
                                <option value="<?=$ljp['id']?>">
                                    <?=$ljp['tugas_jabatan']?>
                                </option>
                            <?php } } ?>
                 </select> -->
        </div>


  <div class="form-group">
    <label for="exampleFormControlTextarea1">Detail Kegiatan</label>
    <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="3" required></textarea>
  </div>

   <div class="form-group">
    <label>Realisasi Target (Kuantitas)</label>
    <input  class="form-control" type="number" autocomplete="off" id="target_kuantitas" name="target_kuantitas" required/>
  </div>
  
  <div class="form-group">
    <label>Satuan</label>
    <input class="form-control" type="text" id="satuan" name="satuan"  readonly/>
  </div>



  <div class="form-group">
    <label>Dokumen Bukti Kegiatan</label>
    <!-- <input class="form-control" type="file" id="image_file" multiple="multiple" /> -->
    <input onclick="getDok()" class="form-control" type="file" id="image_file" name="files[]" multiple="multiple" />
    <br>
      <div id="uploadPreview"></div>
  </div>
  <div class="form-group">
     <button class="btn btn-block btn-navy" id="btn_upload"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 

    </div>
</div>

<div class="card card-default" id="list_kegiatan">
   
</div>

<div class="modal fade" id="edit_realisasi_kinerja" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">EDIT REALISASI KINERJA</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="edit_realisasi_kinerja_content">
          </div>
      </div>
  </div>
</div>



<script type="text/javascript">


    $(function(){
      var tahun = '<?=date("Y")?>'
         var bulan = '<?=date("m")?>'
        loadListKegiatan(tahun,bulan)
        loadListTugasJabatan()
    })

     function loadListKegiatan(tahun,bulan){
       
 
        $('#list_kegiatan').html('')
        $('#list_kegiatan').append(divLoaderNavy)
        $('#list_kegiatan').load('<?=base_url("kinerja/C_Kinerja/loadKegiatan/")?>'+tahun+'/'+bulan+'', function(){
            $('#loader').hide()
        })
    }

    // $('#bulan').on('change', function(){
    //     searchListKegiatan()
    // })

    // $('#tahun').on('change', function(){
    //     searchListKegiatan()
    // })

    
     function getDok(){
        document.getElementById("uploadPreview").reset();
     }
     function loadListTugasJabatan(){
      
           var bulan = new Date().getMonth()+1;
           var tahun=new Date().getFullYear();
           
                $.ajax({
                    url : "<?php echo site_url('kinerja/C_Kinerja/getRencanaKerja');?>",
                    method : "POST",
                    data : {tahun: tahun, bulan:bulan},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                         
                        
                        var i;
                        var html = '<option>- Pilih Tugas Jabatan -</option>';
                        for(i=0; i<data.length; i++){
                            
                            html += '<option value='+data[i].id+'>'+data[i].tugas_jabatan+'</option>';
                        }
                        $('#tugas_jabatan').html(html);
 
                    }
                });
                return false;
    }

           $('#tanggal_kegiatan').change(function(){ 
            var tanggal=$(this).val();
            var date = new Date(tanggal);

            var bulan = date.getMonth()+1;
            var tahun = date.getFullYear();
         
           
                $.ajax({
                    url : "<?php echo site_url('kinerja/C_Kinerja/getRencanaKerja');?>",
                    method : "POST",
                    data : {tahun: tahun, bulan:bulan},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                         
                     
                        var i;
                        var html = '<option>- Pilih Tugas Jabatan -</option>';
                        for(i=0; i<data.length; i++){
                       
                            html += '<option value='+data[i].id+'>'+data[i].tugas_jabatan+'</option>';
                        }
                        $('#tugas_jabatan').html(html);
 
                    }
                });
                return false;
            }); 


    
        $('#upload_form').on('submit', function(e){  
        document.getElementById('btn_upload').disabled = true;
        $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var tanggal = $('#tanggal_kegiatan').val()
        var d = new Date(tanggal);

        var bulan = d.getMonth() + 1;
        var tahun = d.getFullYear();
      
      
        if($('#tugas_jabatan').val() == "- Pilih Tugas Jabatan -")  
        {  
        errortoast(" Pilih tugas jabatan terlebih dulu");  
        return false
        }  

        var formvalue = $('#upload_form');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('image_file').files.length;
      
        $.ajax({  
        url:"<?=base_url("kinerja/C_Kinerja/multipleImageStore")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        // dataType: "json",
        success:function(res){ 
            var result = JSON.parse(res); 
            console.log(result);
            // console.log(result.msg);
            // return false;
            
              if(result.success == true){
                document.getElementById('btn_upload').disabled = true;
                successtoast(result.msg)
                loadListKegiatan(tahun,bulan)
              } else {
                errortoast(result.msg)
                return false;
              }
                
                document.getElementById("upload_form").reset();
                $('#uploadPreview').html('');
                $('#btn_upload').html('<i class="fa fa-save"></i>  SIMPAN')
                document.getElementById('btn_upload').disabled = false;
        }  
        });  
          
        }); 


    $("#submit").submit(function(e){
    e.preventDefault();
    $.ajax({
    url:"<?=base_url("kinerja/C_Kinerja/createLaporanKegiatan")?>",
    type:'POST',
    data:new FormData(this),
    processData:false,
    contentType:false,
    cache:false,
    async:false,
    success:function(data){
        successtoast("Data berhasil disimpan")
        loadListKegiatan()
        document.getElementById("submit").reset();
    } , error: function(e){
                errortoast('Terjadi Kesalahan')
    }
})
})



 function getSatuan() {
        var id_t_rencana_kinerja = $('#tugas_jabatan').val(); 
        var base_url = "<?=base_url()?>";
     
        $.ajax({
        type : "POST",
        url  : base_url + '/kinerja/C_Kinerja/getSatuan',
        dataType : "JSON",
        data : {id_t_rencana_kinerja:id_t_rencana_kinerja},
        success: function(data){
            var satuan = data[0].satuan;
            $('[name="satuan"]').val(satuan);
         }
        });
        return false;
        
       
      
        }

        function readImage(file) {
        $('#uploadPreview').html('');
        var reader = new FileReader();
        var image  = new Image();
        reader.readAsDataURL(file);  
        reader.onload = function(_file) {
        image.src = _file.target.result; // url.createObjectURL(file);
        image.onload = function() {
        var w = this.width,
        h = this.height,
        t = file.type, // ext only: // file.type.split('/')[1],
        n = file.name,
        s = ~~(file.size/1024) +'KB';
        $('#uploadPreview').append('<img src="' + this.src + '" class="thumb">');
        };
        // image.onerror= function() {
        // alert('Invalid file type: '+ file.type);
        // };      
        };
        }
        $("#image_file").change(function (e) {
        if(this.disabled) {
        return alert('File upload not supported!');
        }
        var F = this.files;
        if (F && F[0]) {
        for (var i = 0; i < F.length; i++) {
        readImage(F[i]);
        }
        }
        });

      

    // function searchListKegiatan(){
    //     if($('#bulan').val() == '')  
    //     {  
    //     errortoast(" Pilih Bulan terlebih dahulu");  
    //     return false
    //     } 
    //     var tahun = $('#tahun').val(); 
    //     var bulan = $('#bulan').val();
    //     $('#list_kegiatan').html(' ')
    //     $('#list_kegiatan').append(divLoaderNavy)
    //     $('#list_kegiatan').load('<?=base_url('kinerja/C_Kinerja/loadKegiatan/')?>'+tahun+'/'+bulan+'', function(){
    //         $('#loader').hide()
           
    //     })
    // }

    function openModalEditRealisasiKinerja(id = 0){
    $('#edit_realisasi_kinerja_content').html('')
    $('#edit_realisasi_kinerja_content').append(divLoaderNavy)
    $('#edit_realisasi_kinerja_content').load('<?=base_url("kinerja/C_Kinerja/loadEditRealisasiKinerja")?>'+'/'+id, function(){
      $('#loader').hide()
    })
  }

</script>
