<div class="modal-body">
    <form id="form_input">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <label>Pilih Pegawai</label>
                <select required multiple="multiple" class="form-control select2-navy" style="width: 100%"
                    id="pegawai" data-dropdown-css-class="select2-navy" name="pegawai[]">
                    <?php foreach($pegawai as $p){ ?>
                        <option value="<?=$p['id_m_user']?>"><?=getNamaPegawaiFull($p)?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-12 col-md-12 mt-3">
                <label>Pilih Periode</label>  
                <input class="form-control form-control-sm" id="range_periode" readonly name="range_periode"/>
            </div>
            <div class="col-lg-12 col-md-12 mt-3">
                <label>Pilih Jenis Disiplin</label>  
                <select class="form-control select2-navy" style="width: 100%"
                    id="jenis_disiplin" data-dropdown-css-class="select2-navy" name="jenis_disiplin">
                    <?php foreach($jenis_disiplin as $j){ ?>
                        <option value="<?=$j['id'].';'.$j['nama_jenis_disiplin_kerja'].';'.$j['pengurangan']?>"><?=$j['nama_jenis_disiplin_kerja']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-12 col-md-12 mt-3">
                <label>Dokumen Pendukung</label>  
                <input class="form-control" type="file" id="image_file" name="files[]" multiple="multiple" />
            </div>
            <div class="col-lg-12 col-md-12 mt-3" style="margin-top: 28px;">
                <button id="btn_tambah" type="submit" class="btn btn-block btn-navy"><i class="fa fa-input"></i> Tambah</button>
                <button style="display: none;" id="btn_loading" disabled type="button" class="btn btn-block btn-navy"><i class="fa fa-spin fa-spinner"></i> Loading....</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(function(){
        $('#pegawai').select2()
        $('#jenis_disiplin').select2()
        $("#range_periode").daterangepicker({
            showDropdowns: true
        });

    })

    // function tambahData(){
    //     $('#tambah_data_disiplin_kerja_content').html('')
    //     $('#tambah_data_disiplin_kerja_content').append(divLoaderNavy)
    //     $('#tambah_data_disiplin_kerja_content').load('<?=base_url("")?>', function(){
    //         $('#loader').hide()
    //     })
    // }

    $('#form_input').submit(function(e){
        $('#btn_tambah').hide()
        $('#btn_loading').show()
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/insertDisiplinKerja")?>',
            method: 'post',
            data: new FormData($('#form_input')[0]),
            contentType: false,  
            cache: false,  
            processData:false,
            success: function(data){
                $('#btn_tambah').show()
                $('#btn_loading').hide()
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    successtoast('Berhasil Menambahkan Data Disiplin Kerja')
                    $('#form_search_disiplin_kerja').submit()
                } else {
                    errortoast(rs.message)
                }
            }, error: function(e){
                $('#btn_tambah').show()
                $('#btn_loading').hide()
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>