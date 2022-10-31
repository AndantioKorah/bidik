<div class="row">
    <div class="col-12">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td style="font-weight: bold;"><?=getNamaPegawaiFull($pegawai)?></td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td style="font-weight: bold;"><?=formatNip($pegawai['nipbaru'])?></td>
                </tr>
                <tr>
                    <td>Pangkat</td>
                    <td>:</td>
                    <td style="font-weight: bold;"><?=$pegawai['nm_pangkat']?></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td style="font-weight: bold;"><?=$pegawai['nama_jabatan']?></td>
                </tr>
            </thead>
        </table>
        <hr>
        <?php if($result) { ?><?php } ?>
        <form id="form_nilai_komponen">
            <input style="display: none;" name="id_m_user" value="<?=$pegawai['id_m_user']?>" />
            <input style="display: none;" name="tahun" value="<?=$tahun?>" />
            <input style="display: none;" name="bulan" value="<?=$bulan?>" />
            <input style="display: none;" name="id_t_komponen_kinerja" value="<?=$result ? $result['id_t_komponen_kinerja'] : null ?>" />

            <table border=="1" style="width: 100%;" class="table table-hover table-striped">
            <tr>
                    <td style="padding: 5px; font-weight: bold; width: 5%; text-align: center;">NO</td>
                    <td style="padding: 5px; font-weight: bold; width: 70%; text-align: center;">KOMPONEN KINERJA</td>
                    <td style="padding: 5px; font-weight: bold; width: 25%; text-align: center;">NILAI</td>
                </tr>
            <!-- baru -->
             <?php $no=1; 
           foreach($list_perilaku_kerja as $lp){ ?>
            <tr>
                    <td style="text-align: center; padding: 5px;"><b><?=$no++;?></b></td>
                    <td style="padding: 5px;"><b><?=$lp['nama_perilaku_kerja']?></b>
                    <td><input readonly type="number" id="<?=$lp['name_id'];?>" class="form-control form-control-sm" name="<?=$lp['name_id'];?>" max="100"  /></td>
                     <?php foreach($lp['sub_perilaku_kerja'] as $sp){ ?>
                        <tr rowspan="3">
                            <td></td>
                            <td><?=$sp['nama_sub_perilaku_kerja'];?></td>
                            <td><input  oninput="countNilaiKomponen()" type="number" id="<?=$sp['name_id'];?>" class="form-control form-control-sm" name="<?=$sp['name_id'];?>" max="100"  /></td>
                        </tr>
                        <?php } ?> 
             
                    </td>
                    
                 
                  
                </tr>
            <?php } ?> 
            <!-- baru -->

                <!-- <tr>
                    <td style="text-align: center; padding: 5px;">1</td>
                    <td style="padding: 5px;">Efektivitas</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="efektivitas_input" class="form-control form-control-sm"
                    name="efektivitas" max="100" value="<?=$result['efektivitas'] ? $result['efektivitas'] : 97;?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">2</td>
                    <td style="padding: 5px;">Efisiensi</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="efisiensi_input" class="form-control form-control-sm"
                    name="efisiensi" max="100" value="<?=$result['efisiensi'] ? $result['efisiensi'] : 97;?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">3</td>
                    <td style="padding: 5px;">Inovasi</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="inovasi_input" class="form-control form-control-sm"
                    name="inovasi" max="100" value="<?=$result['inovasi'] ? $result['inovasi'] : 97;?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">4</td>
                    <td style="padding: 5px;">Kerjasama</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="kerjasama_input" class="form-control form-control-sm"
                    name="kerjasama" max="100" value="<?=$result['kerjasama'] ? $result['kerjasama'] : 97;?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">5</td>
                    <td style="padding: 5px;">Kecepatan</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="kecepatan_input" class="form-control form-control-sm"
                    name="kecepatan" max="100" value="<?=$result['kecepatan'] ? $result['kecepatan'] : 97;?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">6</td>
                    <td style="padding: 5px;">Tanggung jawab</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="tanggungjawab_input" class="form-control form-control-sm"
                    name="tanggungjawab" max="100" value="<?=$result['tanggungjawab'] ? $result['tanggungjawab'] : 97;?>" /></td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 5px;">7</td>
                    <td style="padding: 5px;">Ketaatan</td>
                    <td oninput="countNilaiKomponen()" style="padding: 5px;"><input type="number" id="ketaatan_input" class="form-control form-control-sm"
                    name="ketaatan" value="<?=$result['ketaatan'] ? $result['ketaatan'] : 97;?>" /></td>
                </tr>  -->
                <tr>
                    <td colspan=2 style="padding: 5px; text-align: right;"><strong>JUMLAH NILAI CAPAIAN</strong></td>
                    <td class="text-center" style="padding: 5px;"><span style="font-weight:bold; font-size: 20px;" id="capaian"></span></td>
                </tr>
                <tr>
                    <td colspan=2 style="padding: 5px; text-align: right;"><i>HASIL PEMBOBOTAN</i></td>
                    <td class="text-center" style="padding: 5px;"><i><span style="font-weight:bold; font-size: 18px;" id="bobot"></span></i></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php if($result){ ?>
                            <button type="button" id="btn_delete" onclick="deleteNilai('<?=$result['id']?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus Nilai Komponen</button>
                            <button id="btn_loading_delete" style="display: none;" disabled class="btn btn-sm btn-danger"><i class="fa fa-spin fa-spinner"></i> Menyimpan....</button>
                        <?php } ?>
                        <button id="btn_submit" type="submit" class="float-right text-right btn btn-sm btn-navy"><i class="fa fa-save"></i> Simpan Nilai Komponen</button>
                        <button id="btn_loading" style="display: none;" disabled class="float-right text-right btn btn-sm btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan....</button>
                    </td>
                </tr>
            </table>
        </form>  
    </div>
</div>
<script>
    $(function(){
        countNilaiKomponen()
    })

    function countNilaiKomponen(){
      
        let perilaku1 = parseInt($('#sub_perilaku_1').val())
                    + parseInt($('#sub_perilaku_2').val())
                    + parseInt($('#sub_perilaku_3').val())
        let total_perilaku1 = perilaku1 / 3;
        let perilaku_1 = total_perilaku1.toFixed(2) 
        $('#perilaku_1').val(perilaku_1)

        let perilaku2 = parseInt($('#sub_perilaku_4').val())
                    + parseInt($('#sub_perilaku_5').val())
                    + parseInt($('#sub_perilaku_6').val())
        let total_perilaku2 = perilaku2 / 3;
        let perilaku_2 = total_perilaku2.toFixed(2) 
        $('#perilaku_2').val(perilaku_2)

        let perilaku3 = parseInt($('#sub_perilaku_7').val())
                    + parseInt($('#sub_perilaku_8').val())
                    + parseInt($('#sub_perilaku_9').val())
        let total_perilaku3 = perilaku3 / 3;
        let perilaku_3 = total_perilaku3.toFixed(2) 
        $('#perilaku_3').val(perilaku_2)

        let perilaku4 = parseInt($('#sub_perilaku_10').val())
                    + parseInt($('#sub_perilaku_11').val())
                    + parseInt($('#sub_perilaku_12').val())
        let total_perilaku4 = perilaku4 / 3;
        let perilaku_4 = total_perilaku4.toFixed(2) 
        $('#perilaku_4').val(perilaku_4)

        let perilaku5 = parseInt($('#sub_perilaku_13').val())
                    + parseInt($('#sub_perilaku_14').val())
                    + parseInt($('#sub_perilaku_15').val())
        let total_perilaku5 = perilaku5 / 3;
        let perilaku_5 = total_perilaku5.toFixed(2) 
        $('#perilaku_5').val(perilaku_5)

        let perilaku6 = parseInt($('#sub_perilaku_16').val())
                    + parseInt($('#sub_perilaku_17').val())
                    + parseInt($('#sub_perilaku_18').val())
        let total_perilaku6 = perilaku6 / 3;
        let perilaku_6 = total_perilaku6.toFixed(2) 
        $('#perilaku_6').val(perilaku_6)

        let perilaku7 = parseInt($('#sub_perilaku_19').val())
                    + parseInt($('#sub_perilaku_20').val())
                    + parseInt($('#sub_perilaku_21').val())
        let total_perilaku7 = perilaku7 / 3;
        let perilaku_7 = total_perilaku7.toFixed(2) 
        $('#perilaku_7').val(perilaku_7)

        let capaian = parseInt($('#perilaku_1').val())
                    + parseInt($('#perilaku_2').val())
                    + parseInt($('#perilaku_3').val())
                    + parseInt($('#perilaku_4').val())
                    + parseInt($('#perilaku_5').val())
                    + parseInt($('#perilaku_6').val())
                    + parseInt($('#perilaku_7').val())

        $('#capaian').html(capaian)
        $('#bobot').html(countBobotNilaiKomponenKinerja(capaian).toFixed(2)+'%')
    }

    function deleteNilai(id){
        if (confirm('Apakah Anda yakin ingin menghapus data?')){
            $('#btn_delete').hide()
            $('#btn_loading_delete').show()
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/deleteNilaiKomponen")?>'+'/'+id,
                method: 'post',
                data: null,
                success: function(data){
                    let res = JSON.parse(data)
                    if(res.code != 0){
                        errortoast(res.message)
                    } else {
                        successtoast('Data berhasil dihapus')
                        $('#capaian_<?=$pegawai['id_m_user']?>').html('')
                        $('#pembobotan_<?=$pegawai['id_m_user']?>').html('')
                        $('#btn_delete_'+id).hide()
                        $('#btn_loading_delete').hide()
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }

    $('#form_nilai_komponen').on('submit', function(e){
        $('#btn_submit').hide()
        $('#btn_loading').show()
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/saveNilaiKomponenKinerja")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let res = JSON.parse(data)
                if(res.code != 0){
                    errortoast(res.message)
                } else {
                    successtoast('Data berhasil disimpan')
                    $('#capaian_<?=$pegawai['id_m_user']?>').html(res.data.capaian)
                    $('#pembobotan_<?=$pegawai['id_m_user']?>').html(countBobotNilaiKomponenKinerja(res.data.capaian).toFixed(2)+'%')
                    $('#btn_submit').show()
                    $('#btn_loading').hide()
                    $('#modal_edit_data_nilai').modal('hide')
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>