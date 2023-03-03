<div class="card-header">
        <h3 class="card-title">List Sasaran Kerja</h3>
    </div>
    <div class="card-body">
    <div class="col-12">
    <form class="form-inline" method="post">
  <div class="form-group">
    <label for="email" class="mr-2">Tahun  </label>
    <input  class="form-control datepicker" id="search_tahun" name="search_tahun" value="<?=$tahun != null ? $tahun : date('Y');?>">
  </div>
  <div class="form-group">
    <label for="pwd" class="mr-2 ml-3"> Bulan</label>
    <select class="form-control select2-navy" 
                 id="search_bulan" data-dropdown-css-class="select2-navy" name="search_bulan" required>
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
  


<?php if($list_rencana_kinerja){ ?>
    <div class="col-12 tableFixHead">
        <table class="table table-striped table-bordered" id="table_rencana_kinerja">
            <thead>
                <th class="text-center table-success">No</th>
                <th class="text-left table-success">Uraian Tugas</th>
                <th class="text-left table-success">Sasaran Kerja</th>
                <th class="text-left table-success">Tahun</th>
                <th class="text-left table-success">Bulan</th>
                <th class="text-left table-success">Target Kuantitas</th>
                <th class="text-left table-success">Satuan</th>
                <th class="text-left table-success">Target Kualitas (%)</th>
                <th class="table-success"></th>
            </thead>
            <tbody>
            <?php $no=1; foreach($list_rencana_kinerja as $lp){ ?>
                
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$lp['tugas_jabatan']?></td>
                        <td class="text-left"><?=$lp['sasaran_kerja']?></td>
                        <td class="text-left"><?=$lp['tahun']?></td>                       
                        <td class="text-left"><?= getNamaBulan($lp['bulan'])?></td>
                        <td class="text-left"><?=$lp['target_kuantitas']?></td>
                        <td class="text-left"><?=$lp['satuan']?></td>
                        <td class="text-left"><?=$lp['target_kualitas']?></td>                        
                        <td class="text-center">
                        <?php if($lp['count'] != 0 ){ ?>
                            <?php } else { ?>
                                <button onclick="deleteRencanaKinerja('<?=$lp['id']?>','<?=$lp['bulan']?>', '<?=$lp['tahun']?>')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i> </button>
                            <?php } ?>
                            <span href="#edit_rencana_kinerja" data-toggle="modal"  >
                                <button href="#edit_rencana_kinerja" data-toggle="tooltip" class="btn btn-sm btn-navy"  data-placement="top" title="Edit" 
                                 onclick="openModalEditRencanaKinerja('<?=$lp['id']?>')"><i class="fa fa-edit"></i> </button>
                                 </span>
                        </td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
   

   
<?php } else { ?>
    <div class="row" style="margin-left:10px;">
        <div class="col-12">
            <h5 style="text-center">DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
        </div>
    </div>
<?php } ?>



    <script>

        function deleteRencanaKinerja(id,bulan,tahun){
           
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("kinerja/C_Kinerja/deleteRencanaKinerja/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        successtoast('Data sudah terhapus')
                        loadRencanaKinerja(bulan,tahun)
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }
    </script>

<script>

$('#table_rencana_kinerja').DataTable({
    "ordering": false
     });
    

    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

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