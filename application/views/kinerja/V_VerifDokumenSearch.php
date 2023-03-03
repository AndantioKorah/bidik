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
        $('#result_data').load('<?=base_url('kinerja/C_Kinerja/loadSearchVerifDokumen')?>'+'/'+status+'/'+$('#bulan').val()+'/'+$('#tahun').val()+'/'+$('#id_unitkerja').val(), function(){
            $('#loader').hide()
        })
    }
    
</script>