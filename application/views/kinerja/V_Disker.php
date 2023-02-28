<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">DISIPLIN KERJA</h3>
    </div>
    <div class="card-body">
        <form id="form_pagu_tpp">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <button type="button" data-toggle="modal" id="tambah_data_disker" href="#modalTambahDataDisker" onclick="loadModalTambahDataDisker()"
                    class="btn btn-sm btn-navy" style="margin-bottom: 10px;">Tambah Data <i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <label>Unit Kerja</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                        <?php foreach($unitkerja as $s){ ?>
                            <option value="<?=$s['id_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-4 col-md-12">
                    <label>Pegawai</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="id_pegawai" data-dropdown-css-class="select2-navy" name="id_pegawai">
                        <option disabled value="-">(Pilih Unit Kerja)</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-12">
                    <label>Jenis Disiplin Kerja</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="jenis_disker" data-dropdown-css-class="select2-navy" name="jenis_disker">
                        <?php foreach($disker as $dk){ ?>
                            <option value="<?=$dk['id']?>"><?=$dk['nama_disiplin_kerja']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg col-md-12">
                    <label>Pilih Bulan</label>  
                    <select class="form-control select2-navy" style="width: 100%"
                        id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
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
                <div class="col-lg col-md-12">
                    <label>Pilih Tahun</label>  
                    <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                </div>
                <div class="col-lg col-md-12" style="margin-top: 28px;">
                    <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-search"></i> Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST PEGAWAI</h3>
    </div>
    <div class="card-body">
        <div id="div_result_list_pegawai" class="row">
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahDataDisker" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">TAMBAH DATA DISIPLIN KERJA</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modalTambahDataDiskerContent">
          </div>
      </div>
  </div>
</div>
<script>
    $(function(){
        $('#id_unitkerja').select2()
        $('#bulan').select2()
        $('#id_pegawai').select2()
        $('#jenis_disker').select2()
        refreshListPegawai()
    })

    function loadModalTambahDataDisker(){
        $('#modalTambahDataDiskerContent').html('')
        $('#modalTambahDataDiskerContent').append(divLoaderNavy)
        $('#modalTambahDataDiskerContent').load("<?=base_url('kinerja/C_Kinerja/loadModalTambahDataDisker')?>", function(){
            $('#loader').hide()
        })
    }

    $('#id_unitkerja').on('change', function(){
        refreshListPegawai()
    })

    function refreshListPegawai(){
        $('#id_pegawai').empty()
        let listpegawai;
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/getListPegawaiByUnitKerja/")?>'+$('#id_unitkerja').val(),
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                listpegawai = JSON.parse(data);
                console.log(listpegawai)
                if(listpegawai != null){
                    $('#id_pegawai').append('<option value="0">Semua</option>');
                    for (let i = 0; i < listpegawai.length; ++i) {
                        nmpegawai = listpegawai[i].gelar1+' '+listpegawai[i].nama+' '+listpegawai[i].gelar2
                        $('#id_pegawai').append('<option value="'+listpegawai[i].nipbaru_ws+'">'+nmpegawai+'</option>');
                    }
                } else {
                    errortoast('Data Tidak Ditemukan')
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    $('#form_pagu_tpp').on('submit', function(e){
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