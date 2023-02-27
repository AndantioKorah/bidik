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
        <h3 class="card-title">Realisasi Kerja</h3>
    </div>
    
    <div class="card-body" style="display: block;">
    <!-- <img id="img" src="http://placekitten.com/120/120/" />
  <button onClick="rotateImg()">Rotate Image</button>
  <script>
    let rotation = 0;
    function rotateImg() {
      rotation += 90; // add 90 degrees, you can change this as you want
      if (rotation === 360) { 
        // 360 means rotate back to 0
        rotation = 0;
      }
      document.querySelector("#img").style.transform = `rotate(${rotation}deg)`;
    }
  </script> -->
    <div class="card" id="bar-progress-realisaasi" style="display: none;">
    
  <div class="card-body">



    <?php $progress = 60;?>
                      <center>
                      <small style="font-size: 90% !important; font-weight: bold !important;" id="ket_tugas_jabatan">
                        </small>
                  
                        </center>
    <div class="progress progress-sm" style="height:30px;">
            <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="" aria-valuemax="100"  style="height:50px; width: 0%; background-color: #000000;">
                            </div>
                        </div>
                        <center>
                        <small style="font-size: 90% !important; font-weight: bold !important;" id="ket_proogress">
                        </small>
                        <!-- <br>
                        <small style="font-size: 90% !important; font-weight: bold !important;" id="ket_target">
                        </small>
                        <br>
                        <small style="font-size: 90% !important; font-weight: bold !important;" id="ket_sudah_verif">
                        </small>
                        <br>
                        <small style="font-size: 90% !important; font-weight: bold !important;" id="ket_belum_verif">
                        </small> -->
                        </center>
  </div>
  </div>

    <form method="post" id="upload_form" enctype="multipart/form-data">
    <div class="form-group" >
    <label for="exampleFormControlInput1">Tanggal Kegiatan</label>
    <input  class="form-control datetimepickerthis" id="tanggal_kegiatan" name="tanggal_kegiatan" readonly value="<?= date('Y-m-d H:i:s') ;?>">
    </div>
    <div class="form-group">
         <label class="bmd-label-floating">Uraian Tugas </label>
         <select class="form-control select2-navy" name="tugas_jabatan" id="tugas_jabatan" onchange="getSatuan()" required>
         <option value="" selected>- Pilih Uraian Tugas -</option>
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
    <label>Dokumen Bukti Kegiatan (Format PNG/JPG)</label>
    <!-- <input onclick="getDok()" class="form-control" type="file" id="image_file" name="files[]" multiple="multiple" /> -->
    <!-- <input  class="form-control" type="file" id="image_file" name="files[]" multiple="multiple" /> -->
    <input class="form-control my-image-field" type="file" id="image_file" name="files[]"  multiple="multiple" />

    
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
              <h6 class="modal-title">EDIT REALISASI KERJA</h6>
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
                        var html = '<option>- Pilih Uraian Tugas -</option>';
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
      
        if($('#tugas_jabatan').val() == "- Pilih Uraian Tugas -")  
        {  
        errortoast("   Pilih uraian tugas  terlebih dulu");  
        $('#btn_upload').html('<i class="fa fa-save"></i>  SIMPAN')
        document.getElementById('btn_upload').disabled = false;
        return false
        }  

        var formvalue = $('#upload_form');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('image_file').files.length;
      
        $.ajax({  
        url:"<?=base_url("kinerja/C_Kinerja/insertLaporanKegiatan")?>",
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
                document.getElementById('btn_upload').disabled = false;
                $('#btn_upload').html('<i class="fa fa-save"></i>  SIMPAN')
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
        var prosesBar = $('.progress-bar');
        var prosesAngka = 0;

      
         if($('#tugas_jabatan').val() == "- Pilih Tugas Jabatan -"){  
          $('#ket_proogress').html('0% selesai');
          $("#bar-progress-realisaasi").hide('fast');
            prosesBar.css('width',  '0%');
             prosesBar.attr('aria-valuenow', 0);
         return false
         } 

     
        $.ajax({
        type : "POST",
        url  : base_url + '/kinerja/C_Kinerja/getSatuan',
        dataType : "JSON",
        data : {id_t_rencana_kinerja:id_t_rencana_kinerja},
        success: function(data){
            console.log(data)
            if (data.length === 0) { 
              $("#bar-progress-realisaasi").hide('fast');
            } else {
              var satuan = data[0].satuan;
            var total_realisasi_kuantitas = data[0].total_realisasi_kuantitas;
            var tugas_jabatan = data[0].tugas_jabatan;
            var total_progress =  (data[0].total_realisasi_kuantitas/data[0].target_kuantitas) * 100;
            if(total_progress > 100){
              var total_progress = 100;
            }
            var nilai_pembulatan = (Math.floor(total_progress * 100) / 100).toFixed(2);
            var target_kuantitas = data[0].target_kuantitas;
            var sudah_verif = data[0].total_realisasi_kuantitas;
            var belum_verif = data[0].total_belum_verif;
            // var nilai_pembulatan =total_progress;

            var bgcolor = '#ff0000 !important';
            if(nilai_pembulatan > 25 && nilai_pembulatan <= 50){
             bgcolor = '#ff7100 !important';
            } else if(nilai_pembulatan > 50 && nilai_pembulatan <= 65){
             bgcolor = '#ffcf00 !important';
            } else if(nilai_pembulatan > 65 && nilai_pembulatan <= 85){
             bgcolor = '#5bff00 !important';
            } else if(nilai_pembulatan > 85 && nilai_pembulatan <= 99){
             bgcolor = '#41b302 !important';
            } else if(nilai_pembulatan >= 100){
             bgcolor = '#006600 !important';
             }

             if(sudah_verif == null){
              sudah_verif = 0;
             }
             if(belum_verif == null){
               belum_verif = 0;
             }


             $("#bar-progress-realisaasi").show('fast');
             $('[name="satuan"]').val(satuan);
             $('#ket_tugas_jabatan').html(tugas_jabatan);
             $('#ket_proogress').html('Capaian '+nilai_pembulatan+'% selesai');
            //  $('#ket_target').html('Target Kuantitas : '+target_kuantitas+' '+satuan);
            //  $('#ket_sudah_verif').html('Laporan diverifikasi : '+sudah_verif);
            //  $('#ket_belum_verif').html('Laporan belum diverifikasi :'+belum_verif);
             prosesBar.css('width', total_progress + '%');
             prosesBar.css('background-color', bgcolor);
             prosesBar.attr('aria-valuenow', total_progress);
            }
           
         }
        });
        return false;
        
       
      
        }

        function readImage(file) {
        document.getElementById('btn_upload').disabled = true;
        $('#btn_upload').html('<i class="fas fa-spinner fa-spin"></i>')
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
        document.getElementById('btn_upload').disabled = false;
        $('#btn_upload').html('<i class="fa fa-save"></i>  SIMPAN')
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
        // var F = this.files;
        // if (F && F[0]) {
        // for (var i = 0; i < F.length; i++) {
          
        // readImage(F[i]);
        // }
        // }
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


    const compressImage = async (file, { quality = 1, type = file.type }) => {
      
        // Get as image data
        const imageBitmap = await createImageBitmap(file);

        // Draw to canvas
        const canvas = document.createElement('canvas');
        canvas.width = imageBitmap.width;
        canvas.height = imageBitmap.height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(imageBitmap, 0, 0);

        // Turn into Blob
        const blob = await new Promise((resolve) =>
            canvas.toBlob(resolve, type, quality)
        );

        // Turn Blob into File
        return new File([blob], file.name, {
            type: blob.type,
        });
    };

    // Get the selected file from the file input
    const input = document.querySelector('.my-image-field');
    input.addEventListener('change', async (e) => {
        // Get the files
        // console.log(e.target)
        const { files } = e.target;

        // No files selected
        if (!files.length) return;

        // We'll store the files in this data transfer object
        const dataTransfer = new DataTransfer();


        // For every file in the files list
        for (const file of files) {
          // alert()
            // We don't have to compress files that aren't images
            if (!file.type.startsWith('image')) {
                // Ignore this file, but do add it to our result
                dataTransfer.items.add(file);
                continue;
            }

            // We compress the file by 50%
            console.log(file)
            const compressedFile = await compressImage(file, {
                quality: 0.5,
                type: 'image/jpeg',
            });
            console.log(compressedFile)
            // Save back the compressed file instead of the original file
            dataTransfer.items.add(compressedFile);
            // alert()
        }

        var F = files;
        if (F && F[0]) {
        for (var i = 0; i < F.length; i++) {
          
        readImage(F[i]);
        }
        }

        // Set value of the file input to our new files list
        e.target.files = dataTransfer.files;
    });
</script>