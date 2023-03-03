<style>
    .nav-tabs .nav-link .active{
        color: var(--navy) !important;
        font-weight: bold !important;
    }
</style>

<div class="card card-default">
    <div class="card-header">
        <h5>Data Dokumen Pendukung</h5>
    </div>
    <div class="mt-3">
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" onclick="openListData(1)" id="custom-content-below-pengajuan-tab" data-toggle="pill" 
                href="#custom-content-below-pengajuan" role="tab" aria-controls="custom-content-below-pengajuan" aria-selected="true">Pengajuan (<span id="count_pengajuan"></span>)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="openListData(2)" id="custom-content-below-diterima-tab" data-toggle="pill" 
                href="#custom-content-below-diterima" role="tab" aria-controls="custom-content-below-diterima" aria-selected="false">Diterima (<span id="count_diterima"></span>)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="openListData(3)" id="custom-content-below-ditolak-tab" data-toggle="pill" 
                href="#custom-content-below-ditolak" role="tab" aria-controls="custom-content-below-ditolak" aria-selected="false">Ditolak (<span id="count_ditolak"></span>)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="openListData(4)" id="custom-content-below-batal-tab" data-toggle="pill" 
                href="#custom-content-below-batal" role="tab" aria-controls="custom-content-below-batal" aria-selected="false">Dibatalkan (<span id="count_batal"></span>)</a>
            </li>
        </ul>
        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade show active" id="custom-content-below-pengajuan" role="tabpanel" aria-labelledby="custom-content-below-pengajuan-tab">
            </div>
            <div class="tab-pane fade" id="custom-content-below-diterima" role="tabpanel" aria-labelledby="custom-content-below-diterima-tab">
            </div>
            <div class="tab-pane fade" id="custom-content-below-ditolak" role="tabpanel" aria-labelledby="custom-content-below-ditolak-tab">
            </div>
            <div class="tab-pane fade" id="custom-content-below-batal" role="tabpanel" aria-labelledby="custom-content-below-batal-tab">
            </div>
        </div>
    </div>
    <div id="result_data" class="p-3">
        
    </div>
</div>
<div class="modal fade" id="detailModalDataDisiplinKerja" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content" id="detailModalDataDisiplinKerjaContent">
      </div>
  </div>
</div>

<script>
    $(function(){
        openListData(1)
        $('#table_disiplin_kerja_result').dataTable()

        // $('#count_pengajuan').html('<?=count($result['pengajuan'])?>')
        // $('#count_diterima').html('<?=count($result['diterima'])?>')
        // $('#count_ditolak').html('<?=count($result['ditolak'])?>')
        // $('#count_batal').html('<?=count($result['batal'])?>')
    })

    function openListData(status){
        active_status = status
        $('#result_data').html('')
        $('#result_data').append(divLoaderNavy)
        $('#result_data').load('<?=base_url('kinerja/C_Kinerja/loadDataPendukungByStatus')?>'+'/'+status+'/'+$('#bulan').val()+'/'+$('#tahun').val(), function(){
            $('#loader').hide()
        })
    }

    function deleteDataDisiplinKerjaById(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            $('#btn_delete_detail_'+id).hide()
            $('#btn_loading_detail_'+id).show()
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/deleteDataDisiplinKerja")?>'+'/'+id,
                method: 'post',
                data: {
                    list_id : $('#btn_delete_detail_'+id).data('list_id')
                },
                success: function(data){
                    let rs = JSON.parse(data)
                    console.log(rs)
                    if(rs.code == 0){
                        successtoast('Berhasil Menghapus Data Disiplin Kerja')
                        // $('#form_search_disiplin_kerja').submit()
                        openListData(active_status)
                        $('#count_pengajuan').html(rs.data.pengajuan)
                        $('#count_diterima').html(rs.data.diterima)
                        $('#count_ditolak').html(rs.data.ditolak)
                    } else {
                        errortoast(rs.message)
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }

    // function deleteDisiplinKerjaByIdUser(id){
    //     if(confirm('Apakah Anda yakin ingin menghapus data?')){
    //         $('#btn_delete_'+id).hide()
    //         $('#btn_loading_'+id).show()
    //         $.ajax({
    //             url: '<?=base_url("kinerja/C_Kinerja/deleteDataDisiplinKerjaByIdUser")?>',
    //             method: 'post',
    //             data: {
    //                 id_m_user: id,
    //                 bulan: $('#bulan').val() ,
    //                 tahun: $('#tahun').val() 
    //             },
    //             success: function(data){
    //                 successtoast('Berhasil Menghapus Data Disiplin Kerja')
    //                 $('#form_search_disiplin_kerja').submit()
    //             }, error: function(e){
    //                 errortoast('Terjadi Kesalahan')
    //             }
    //         })
    //     }
    // }

    function openDetailModalDataDisiplinKerja(id){
        var bulan = $('#bulan').val() 
        var tahun = $('#tahun').val() 
        $('#detailModalDataDisiplinKerjaContent').html('')
        $('#detailModalDataDisiplinKerjaContent').append(divLoaderNavy)
        $('#detailModalDataDisiplinKerjaContent').load('<?=base_url("kinerja/C_Kinerja/openModalDetailDisiplinKerja")?>'+'/'+id+'/'+bulan+'/'+tahun, function(){
            $('#loader').hide()
        })
    }
    
</script>