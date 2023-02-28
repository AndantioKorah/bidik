<?php if($result){ ?>
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
    <hr>
    <div  class="col-12 table-responsive">
    <table border=0 class="table table-striped" id="table_list_kegiatan_detail_rekap">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Tanggal Kegiatan</th>
            <th class="text-center">Kegiatan</th>
            <th class="text-center">Realisasi</th>
            <th class="text-center">Bukti Realisasi</th>
            <th class="text-center">Verifikasi</th>
        </thead>
        <tbody>
            <?php $no=1; foreach($result as $rs){
                $status_verif = '<span style="font-weight: bold; color: white; padding: 5px; background-color: grey;"><i class="fa fa-dot-circle"></i> Belum Verif</span>';
                if($rs['status_verif'] == 1){
                    $status_verif = '<span style="font-weight: bold; color: white; padding: 5px; background-color: green;"><i class="fa fa-check-circle"></i> Diterima</span>';
                } else if($rs['status_verif'] == 2){
                    $status_verif = '<span style="font-weight: bold; color: white; padding: 5px; background-color: red;"><i class="fa fa-times-circle"></i> Ditolak</span>';
                } else if($rs['status_verif'] == 3){
                    $status_verif = '<span style="font-weight: bold; color: black; padding: 5px; background-color: yellow;"><i class="fa fa-minus-circle"></i> Verifikasi Dibatalkan</span>';
                }
            ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-center"><?=formatDateOnly($rs['tanggal_kegiatan']);?></td>
                    <td><?=$rs['deskripsi_kegiatan'];?></td>
                    <td class="text-center"><?=$rs['realisasi_target_kuantitas'].' '.$rs['satuan']?></td>
                    <td class="text-center">
                    <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-file"></i> Lihat File
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php 
                                $file = json_decode($rs['bukti_kegiatan']);
                                $nomor = 1;
                                if($file) {
                                foreach($file as $file_name)
                                    {
                                         $data = $file_name;    
                                  $ekstension = substr($data, strpos($data, ".") + 1); 
                                        if($file_name == null){
                                            echo "<a class='dropdown-item' >Tidak Ada File</a>";
                                        } else {
                                            // echo "<a class='dropdown-item' href=".base_url('assets/bukti_kegiatan/'.$file_name.'')." target='_blank'>Dokumen ".$nomor."</a>";
                                            echo "<a class='dropdown-item'  href='javascript:;' data-id='".$rs['id']."'  data-gambar='".$file_name."' data-toggle='modal' data-target='#edit-data'>Dokumen ".$nomor."</a>";
                                        }
                                    $nomor++;
                                    } 
                                  } else {
                                    echo "<a class='dropdown-item' >Tidak Ada File</a>";
                                  }
                                ?>
    
                            </div>
                    </td>
                    <td>
                        <?=$status_verif?><br>
                        <?php if($rs['status_verif'] != 0){ ?>
                            <?=$rs['keterangan_verif'] ? "<strong>(".$rs['keterangan_verif'].")</strong>" : '-'?><br>
                            oleh <strong><?=$rs['verifikator']?></strong><br>
                            pada <strong><?=formatDate($rs['tanggal_verif'])?></strong>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
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
            <style>
                .alignleft {
                    float: left;
                }
                .alignright {
                    float: right;
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
        $(function(){
            $('#table_list_kegiatan_detail_rekap').dataTable()
        })

     


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
    </script>
<?php } else { ?>
    <center><b>Belum Diverifikasi Pimpinan<b></center>
<?php } ?>