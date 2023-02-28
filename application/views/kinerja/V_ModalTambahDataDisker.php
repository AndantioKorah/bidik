<div class="row">
    <div class="col-lg-12 p-4">
        <form id="form_tambah_data_dikser">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <label>Unit Kerja</label>
                    <select class="form-control form-control-sm select2-navy" style="width: 100%"
                        id="id_unitkerjamodal" data-dropdown-css-class="select2-navy" name="id_unitkerjamodal">
                        <?php foreach($unitkerja as $s){ ?>
                            <option value="<?=$s['id_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-6 col-md-12">
                    <label>Pegawai</label>
                    <select class="form-control form-control-sm select2-navy" style="width: 100%"
                        id="id_pegawaimodal" data-dropdown-css-class="select2-navy" name="id_pegawaimodal">
                        <option disabled value="-">(Pilih Unit Kerja)</option>
                    </select>
                </div>
                <div class="col-lg-6 col-md-12">
                    <label>Jenis Disiplin Kerja</label>
                    <select class="form-control form-control-sm select2-navy" style="width: 100%"
                        id="jenis_diskermodal" data-dropdown-css-class="select2-navy" name="jenis_diskermodal">
                        <?php foreach($disker as $dk){ ?>
                            <option value="<?=$dk['id']?>"><?=$dk['nama_disiplin_kerja']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-6 col-md-12">
                    <label>Pilih Bulan</label>  
                    <select class="form-control form-control-sm select2-navy" style="width: 100%"
                        id="bulanmodal" data-dropdown-css-class="select2-navy" name="bulanmodal">
                        <option <?=date('m') == '01' ? 'selected' : ''?> value="01">Januari</option>
                        <option <?=date('m') == '02' ? 'selected' : ''?> value="02">Feburari</option>
                        <option <?=date('m') == '03' ? 'selected' : ''?> value="03">Maret</option>
                        <option <?=date('m') == '04' ? 'selected' : ''?> value="04">April</option>
                        <option <?=date('m') == '05' ? 'selected' : ''?> value="05">Mei</option>
                        <option <?=date('m') == '06' ? 'selected' : ''?> value="06">Juni</option>
                        <option <?=date('m') == '07' ? 'selected' : ''?> value="07">Juli</option>
                        <option <?=date('m') == '08' ? 'selected' : ''?> value="08">Agustus</option>
                        <option <?=date('m') == '09' ? 'selected' : ''?> value="09">September</option>
                        <option <?=date('m') == '10' ? 'selected' : ''?> value="10">Oktober</option>
                        <option <?=date('m') == '11' ? 'selected' : ''?> value="11">November</option>
                        <option <?=date('m') == '12' ? 'selected' : ''?> value="12">Desember</option>
                    </select>
                </div>
                <div class="col-lg-6 col-md-12">
                    <label>Pilih Tahun</label>  
                    <input readonly autocomplete="off" class="form-control form-control-sm datepicker" id="tahunmodal" name="tahunmodal" value="<?=date('Y')?>" />
                </div>
                <div class="col-lg-6 col-md-12" style="margin-top: 28px;">
                    <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>    

<script>
    $(function(){
        $('#id_unitkerjamodal').select2()
        $('#bulanmodal').select2()
        $('#id_pegawaimodal').select2()
        $('#jenis_diskermodal').select2()
        refreshListPegawaiModal()
        $('#tahunmodal').datepicker({
            format: 'yyyy',
            viewMode: "years", 
            minViewMode: "years",
            orientation: 'bottom',
            autoclose: true
        });
    })

    $('#id_unitkerjamodal').on('change', function(){
        refreshListPegawaiModal()
    })

    function refreshListPegawaiModal(){
        $('#id_pegawaimodal').empty()
        let listpegawai;
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/getListPegawaiByUnitKerja/")?>'+$('#id_unitkerjamodal').val(),
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                listpegawai = JSON.parse(data);
                console.log(listpegawai)
                if(listpegawai != null){
                    $('#id_pegawaimodal').append('<option value="0">Semua</option>');
                    for (let i = 0; i < listpegawai.length; ++i) {
                        nmpegawai = listpegawai[i].gelar1+' '+listpegawai[i].nama+' '+listpegawai[i].gelar2
                        $('#id_pegawaimodal').append('<option value="'+listpegawai[i].nipbaru_ws+'">'+nmpegawai+'</option>');
                    }
                } else {
                    errortoast('Data Tidak Ditemukan')
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    $('#form_tambah_data_dikser').on('submit', function(e){
        e.preventDefault()
        $('#div_result_list_pegawai').show()
        $('#div_result_list_pegawai').html('')
        $('#div_result_list_pegawai').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/countPaguTpp")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#div_result_list_pegawai').html('')
                $('#div_result_list_pegawai').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

</script>