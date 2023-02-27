<style>
    
/* .modal-fullscreen */
#myModalLabel {
  text-align: center;
  padding-top: 50px;
  margin-bottom: 50px;
}

.center-content {
				text-align:center;
				margin-top: 50px;
			}

			.content-wrapper {
				height: 100%;
				
				.content {
					line-height: 1.5em;
					
					font-weight: 300;
					color: $gray;
				}
				.l-content-help{
					margin: 50px 50px;
				}
				.l-text-indent {
					text-indent: -1.1em;
				}
				.large-text{
					font-size: 1.5em;
					// margin-top: -20px;
					
				}
				.btn-large {
					font-size: 1.3em;
					font-weight: 300;
					letter-spacing: 1px;
					// border-color: #624E7A;
				}

				
				.fa {
					color: $purple-dark;
					// border-color: #624E7A;
					border-color: $purple-dark;
				}
				i.fa.fa-lg.fa-download {
					color: $gray !important;
				}
			}
		}
.modal-fullscreen {
  /*background: transparent;*/
}
.modal-fullscreen .modal-content {
  background: transparent;
  border: 0;
  -webkit-box-shadow: none;
  box-shadow: none;
}
.modal-backdrop.modal-backdrop-fullscreen {
  background: #ffffff;
}
.modal-backdrop.modal-backdrop-fullscreen.in {
  /*opacity: .97;
  filter: alpha(opacity=97);*/
}

/* .modal-fullscreen size: we use Bootstrap media query breakpoints */

.modal-fullscreen .modal-dialog {
  margin: 0;
  margin-right: auto;
  margin-left: auto;
  width: 100%;
}
@media (min-width: 768px) {
  .modal-fullscreen .modal-dialog {
    width: 100%;
  }
}
@media (min-width: 992px) {
  .modal-fullscreen .modal-dialog {
    width: 100%;
  }
}
@media (min-width: 1200px) {
  .modal-fullscreen .modal-dialog {
    width: 100%;
  }
}


</style>

    <div class="card-header">
        <h3 class="card-title">List Realisasi Kerja</h3>
    </div>
    <div class="card-body">
    <div class="col-12">
    <form class="form-inline" method="post">
  <div class="form-group">
    <label for="email" class="mr-2">Tahun  </label>
    <input  class="form-control datepicker" id="tahun" name="tahun" value="<?=$tahun != null ? $tahun : date('Y');?>">
  </div>
  <div class="form-group">
    <label for="pwd" class="mr-2 ml-3"> Bulan</label>
    <select class="form-control select2-navy" 
                 id="bulan" data-dropdown-css-class="select2-navy" name="bulan" required>
                 <option <?=$bulan == 1 ? 'selected' : '';?> value="1">Januari</option>
                 <option <?=$bulan == 2 ? 'selected' : '';?> value="2">Februari</option>
                 <option <?=$bulan == 3 ? 'selected' : '';?> value="3">Maret</option>
                 <option <?=$bulan == 4 ? 'selected' : '';?> value="4">April</option>
                 <option <?=$bulan == 5 ? 'selected' : '';?> value="5">Mei</option>
                 <option <?=$bulan == 6 ? 'selected' : '';?> value="6">Juni</option>
                 <option <?=$bulan == 7 ? 'selected' : '';?> value="7">Juli</option>
                 <option <?=$bulan == 8 ? 'selected' : '';?> value="8">Agustus</option>
                 <option <?=$bulan == 9 ? 'selected' : '';?> value="9">September</option>
                 <option <?=$bulan == 10 ? 'selected' : '';?> value="10">Oktober</option>
                 <option <?=$bulan == 11 ? 'selected' : '';?> value="11">November</option>
                 <option <?=$bulan == 12 ? 'selected' : '';?> value="12">Desember</option>
                 </select>
         </div>
        <!-- <button type="button" onclick="searchListKegiatan()" class="btn btn-primary ml-3">Cari</button> -->
        </form>
     <br>
    </div>
        <div id="" class="row">
        <?php if($list_kegiatan){ ?>
        <div class="col-12 tableFixHead">
        <table  class="table table-striped table-bordered" id="table_realisasi_kinerja" width="100%">
            <thead>
                <th class="text-center table-success">No</th>
                <th class="text-left table-success">Uraian Tugas</th>
                <th class="text-left table-success">Tanggal Kegiatan</th>
                <th class="text-left table-success">Detail Kegiatan</th>
                <th class="text-left table-success">Realisasi Target (Kuantitas)</th>
                <th class="text-left table-success">Satuan</th>
                <th class="text-center table-success">Status</th>
                <th class="text-center table-success">Dokumen Bukti Kegiatan</th>
               
                <th class="table-success"></th>
            </thead>
            <tbody>
            <?php $no=1; foreach($list_kegiatan as $lp){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$lp['tugas_jabatan']?></td>
                        <td class="text-left"><?= formatDateNamaBulanWT($lp['tanggal_kegiatan'])?></td>                       
                        <td class="text-left"><?=$lp['deskripsi_kegiatan']?></td>
                        <td class="text-left" style="width:10%;"><?=$lp['realisasi_target_kuantitas']?></td>
                        <td class="text-left"><?=$lp['satuan']?></td>
                        <td class="text-left">
                        <button class="btn btn-<?php if($lp['id_status_verif'] == 0) echo  "warning";
                                                    else if($lp['id_status_verif'] == 1) echo "success";
                                                    else if($lp['id_status_verif'] == 2) echo "danger";
                                                    else if($lp['id_status_verif'] == 3) echo "warning";   ?> btn-sm" type="button" >
                        <?= $lp['status_verif'];?>
                            </button></td>
                        <td class="text-center">  
                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-file"></i> Lihat File
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php 
                            
                            $file = json_decode($lp['bukti_kegiatan']);
                            $nodok = 1;
                            
                            foreach($file as $file_name)
                                {
                                  $data = $file_name;    
                                  $ekstension = substr($data, strpos($data, ".") + 1);    

                                  
                                    if($file_name == null){
                                        echo "<a class='dropdown-item' >Tidak Ada File</a>";
                                    } else {
                                      if($ekstension == "png" || $ekstension == "jpg"){
                                        // echo "<a class='dropdown-item' href=".base_url('assets/bukti_kegiatan/'.$file_name.'')." target='_blank'>Dokumen ".$nodok."</a>";
                                        echo "<a class='dropdown-item'  href='javascript:;' data-id='".$lp['id']."'  data-gambar='".$file_name."' data-toggle='modal' data-target='#edit-data'>Dokumen ".$nodok."</a>";

                                      } else {
                                        echo "<a class='dropdown-item' href=".base_url('assets/bukti_kegiatan/'.$file_name.'')." target='_blank'>Dokumen ".$nodok."</a>";
                                        // echo "<a class='dropdown-item'  href='javascript:;' data-id='".$lp['id']."'  data-gambar='".$file_name."' data-toggle='modal' data-target='#edit-data'>Dokumen ".$nodok."</a>";
                                      }
                                    }
                                   $nodok++;
                                } 
                            ?>
   
                        </div>
                           
                        </td>
                        
                        <td class="text-center">
                      
                       
                        <?php if($lp['id_status_verif'] != 1){ ?>
                            <span href="#edit_realisasi_kinerja" data-toggle="modal" >
                            <button href="#edit_realisasi_kinerja" data-toggle="tooltip" class="btn btn-sm btn-navy" data-placement="top" title="Edit" 
                             onclick="openModalEditRealisasiKinerja('<?=$lp['id']?>')"><i class="fa fa-edit"></i> </button>
                                 </span>  
                            <button onclick="deleteKegiatan('<?=$lp['id']?>','<?=$lp['tanggal_kegiatan']?>')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-trash" ></i></button>
                            <?php } ?>
                        </td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
        </div>
    </div>


    


   
<?php } else { ?>
    <div class="row">
        <div class="col-12">
            <h5 style="text-center">DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
        </div>
    </div>
<?php } ?>



<div aria-hidden="true" aria-labelledby="myLargeModalLabel" role="dialog" tabindex="-1" id="edit-data" class="modal modal-fullscreen fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
          
            <div class="modal-body">
           
              <style>
                .button_wrapper {
                  width: 33%;
                  float: left;
              }

              .button {
                  display: inline-block;
                  /* background-color: yellow; */
              }
              </style>
               <div class="button_wrapper">
            <div class="button">
              
            <button onClick="rotateImgLeft()"   type="button" class="next btn btn-info alignleft" value=""> <i class="fa fa-undo" aria-hidden="true"></i> </button>
            </div>
            </div>
            <div class="button_wrapper" style="text-align: center;">
                <div class="button">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-window-close" aria-hidden="true"></i>
                </button>
                </div>
            </div>
            <div class="button_wrapper" style="text-align: right;">
                <div class="button">
            <button onClick="rotateImgRight()"  type="button" class="next btn btn-info alignright" value=""> <i class="fa fa-redo" aria-hidden="true"></i> </button>

                </div>
            </div>

            <div id="textbox">
            <!-- <button onClick="rotateImgLeft()"   type="button" class="next btn btn-info alignleft" value=""> <i class="fa fa-undo" aria-hidden="true"></i> </button>
            <button onClick="rotateImgRight()"  type="button" class="next btn btn-info alignright" value=""> <i class="fa fa-redo" aria-hidden="true"></i> </button> -->
           
            </div>
            <style>
                .alignleft {
                    float: left;
                }
                .alignright {
                    text-align: right;
                }
                .aligncenter {
                  text-align: center;
                    display: inline-block;
                }
            </style>

           
                <center>
                        <div class="container" style="margin-top:50px;">
                        <div id="gambar_lama"></div>
                        </div>
                 </center>      
         </div>
                
         

            </div>
        </div>
    </div>
</div>


<script>


// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
// img.onclick = function(){
//   modal.style.display = "block";
//   modalImg.src = this.src;
//   captionText.innerHTML = this.alt;
// }

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
// span.onclick = function() { 
//   modal.style.display = "none";
// }
</script>
<script>
    let rotation = 0;
    function rotateImgRight() {
      rotation += 90; // add 90 degrees, you can change this as you want
      if (rotation === 360) { 
        // 360 means rotate back to 0
        rotation = 0;
      }
      document.querySelector("#img").style.transform = `rotate(${rotation}deg)`;
    }

    function rotateImgLeft() {
      // let rotation = 0;
      rotation += -90; // add 90 degrees, you can change this as you want
      if (rotation === 360) { 
        // 360 means rotate back to 0
        rotation = 0;
      }
      document.querySelector("#img").style.transform = `rotate(${rotation}deg)`;
    }

    function closeModal() {
      $('#edit-data').modal('hide');
    }

   
  </script>

<script>
           $('#edit-data').on('show.bs.modal', function (event) {
            $('#gambar_lama').html('');
          
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal          = $(this)
           
            // Isi nilai pada field
            modal.find('#id').attr("value",div.data('id'));

            modal.find('#img2').attr("src","http://placekitten.com/120/120/");
            // console.log(div.data('gambar'))
            $('#gambar_lama').append('<img id="img" class="img-fluid" alt="Responsive image"  src="<?php echo base_url();?>/assets/bukti_kegiatan/'+div.data('gambar')+'?=t'+new Date().getTime()+'" class="thumb">');
            
        });
</script>

<script>
        // $(document).ready(function () {
        // $('#table_realisasi_kinerja').DataTable({
        // "scrollX": true
        // });
        // $('.dataTables_length').addClass('bs-select');
        // });

        function deleteKegiatan(id,tgl){
           
           var d = new Date(tgl);

            var bulan = d.getMonth() + 1;
            var tahun = d.getFullYear();

            // $('[data-toggle="tooltip"]').tooltip({
            //     trigger : 'hover'
            // })
            // $('[data-toggle="tooltip"]').tooltip('hide');
          
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
   
                $.ajax({
                    url: '<?=base_url("kinerja/C_Kinerja/deleteKegiatan/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        successtoast('Data sudah terhapus')
                        loadListKegiatan(tahun,bulan)
                        $('[data-toggle="tooltip"]').tooltip({
                trigger : 'hover'
            })
            $('[data-toggle="tooltip"]').tooltip('hide');
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
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
                        var html = '<option>- Pilih Uraian Tugas -</option>';
                        for(i=0; i<data.length; i++){
                       
                            html += '<option value='+data[i].id+'>'+data[i].tugas_jabatan+'</option>';
                        }
                        $('#tugas_jabatan').html(html);
 
                    }
                });
                return false;
            }); 

            $('#bulan').on('change', function(){
                       searchListKegiatan()
                 })

              $('#tahun').on('change', function(){
                 searchListKegiatan()
            })

    function searchListKegiatan(){
        if($('#bulan').val() == '')  
        {  
        errortoast(" Pilih Bulan terlebih dahulu");  
        return false
        } 
        var tahun = $('#tahun').val(); 
        var bulan = $('#bulan').val();
        $('#list_kegiatan').html(' ')
        $('#list_kegiatan').append(divLoaderNavy)
        $('#list_kegiatan').load('<?=base_url('kinerja/C_Kinerja/loadKegiatan/')?>'+tahun+'/'+bulan+'', function(){
            $('#loader').hide()
           
        })
    }

    $('.datepicker').datepicker({
    format: 'yyyy',
    startView: "years", 
    orientation: 'bottom',
    autoclose: true,
    todayBtn: true,
    viewMode: "years",
    minViewMode: "years"
});
        
    </script>
<script>
    $('#table_realisasi_kinerja').DataTable({
    "ordering": false
     } );
    
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })
</script>