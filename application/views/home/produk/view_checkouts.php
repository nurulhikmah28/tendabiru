<form action='' method='POST'>
    <div class="row">
        <?php
        $total = $this->db->query("SELECT sum((a.harga_jual*a.jumlah)-(b.diskon*a.jumlah)) as total, sum(b.berat*a.jumlah) as total_berat FROM `tb_toko_penjualantemp` a JOIN tb_toko_produk b ON a.id_produk=b.id_produk where a.session='" . $this->session->idp . "'")->row_array();

        ?>
        <div class="col-md-4">
            <div class="card w-100 shadow mb-2 bg-white rounded">
                <div class="card-body">
                    <h6 class="float-left">Alamat Pengiriman</h6>
                    <a class="float-right" href="<?= base_url('members/edit_alamat') ?>" title="Ubah Alamat"><i class="fas fa-edit"></i></a>
                    <table class="table table-borderless">
                        <tr>
                            <td>
                                <small>Tanggal Pernikahan</small><br>
                                <input type="date" name='dateMarried' class="form-control" onchange="onInputField()">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>Nama</small><br>
                                <input type="text" name='nama_pem' class="form-control" value="<?= $rows['nama_lengkap'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>Nomor telepon</small><br>
                                <input type="text" name='telp_pem' class="form-control" value="<?= $rows['no_telp'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>Kota</small><br>


                                <select name="kota_pem" id='kota_pem' class='form-control select2'>
                                    <option value="Pilih kota"></option>
                                    <?php $qkota = $this->db->get('tb_kota');
                                    foreach ($qkota->result_array() as $kota) {
                                        if ($kota['kota_id'] == $rows['kota_id']) {
                                    ?>
                                            <option value="<?= $kota['kota_id'] ?>" selected><?= $kota['nama_kota'] ?></option>

                                        <?php } else { ?>
                                            <option value="<?= $kota['kota_id'] ?>"><?= $kota['nama_kota'] ?></option>
                                    <?php }
                                    } ?>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>Kecamatan</small><br>
                                <input type="text" name='kec_pem' class="form-control" value="<?= $rows['kecamatan'] ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <small>Alamat Lengkap</small><br>
                                <textarea name='alamat_pem' class="form-control"><?= $rows['alamat'] ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <small>Kode Pos</small><br>
                                <input type="text" name='pos_pem' class="form-control" value="<?= $rows['kode_pos'] ?>">
                            </td>
                        </tr>


                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card w-100 shadow mb-2 bg-white rounded">
                <div class="card-body">
                    <h6>Detail Belanja</h6>
                    <table class="table table-borderless" style="width: 100%">
                        <?php
                        $no = 1;
                        $total_diskon = 0;
                        foreach ($record->result_array() as $row) {
                            $sub_total = (($row['harga_jual'] - $row['diskon']) * $row['jumlah']);
                            if ($row['diskon'] != '0') {
                                $diskon = "<del style='color:red'>" . rupiah($row['harga_jual']) . "</del>";
                            } else {
                                $diskon = "";
                            }
                            $diskon_total = $diskon_total + $row['diskon'] * $row['jumlah'];
                        ?>

                            <tr>
                                <td style="width: 5%"><?= $no++ ?></td>
                                <td style="width: 55%">
                                    <a href="<?= base_url('produk/detail/') . $row['produk_seo']; ?>"> <?= $row['nama_produk']; ?></a>
                                    &times;
                                    <?= $row['jumlah']; ?>
                                </td>
                                <td style="width: 35%">
                                    Rp <span class="float-right"><?= rupiah($sub_total) ?></span>
                                </td>
                                <td style="width: 5%">
                                    <a href="<?= base_url() . "keranjang/delete2/" . encrypt_url($row['id_penjualan_detail']);  ?>">
                                        <button type="button" class="dropcart__product-remove btn btn-light btn-sm btn-svg-icon">
                                            <svg width="10px" height="10px">
                                                <use xlink:href="<?= base_url('assets/template/tema/') ?>images/sprite.svg#cross-10"></use>
                                            </svg>
                                        </button>
                                    </a>
                                </td>
                            </tr>

                        <?php } ?>
                    </table>

                    <input type="hidden" name="total" id="total" value="<?= $total['total']; ?>" />
                    <input type="hidden" name="downPayment" class="downPayment" value="<?= ($total['total'] * 50) / 100; ?>" />
                    <input type="hidden" name="amount" id="amount" />

                    <div class="row">
                        <div class="col-3">
                            <h6>Notes :</h6>
                        </div>
                        <div class="col-9">
                            <textarea name="note" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mt-2" id="kuririnfo" style="display: none">
                        <div class="col-3"></div>
                        <div class="col-9 pt-2" id="kurirserviceinfo">

                        </div>
                    </div>

                </div>
            </div>
        </div>



        <div class="col-md-3">
            <div class="card w-100 shadow mb-2 bg-white rounded">
                <div class="card-body">
                    <h6>Ringkasan Belanja</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td>
                                <small>Total Harga</small><br>
                                <strong>Rp <?= rupiah($total['total']) ?></strong>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <small>Pembayaran</small><br>
                                <strong class="downPayment"></strong>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>Full Payment ?</small><br/><input type="checkbox" id="onCheckfullPayment" name="fullPayment" /> Yes
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>Bayar</small><br>
                                <strong id="bayar"></strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type='submit' name='submit' id='oksimpan' class='btn btn-success btn-block btn-sm' style='display:none'>
                                    Bayar
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</form>

<script>
    $(document).ready(function() {
        hitung();
    });

    function onInputField(){
        show2();
    }

    function show2() {
        $("#oksimpan").show();
    }

    function hitung() {
        var fullPayment = $('#total').val();
        var downPayment = $('.downPayment').val();
        $(".downPayment").html(toDuit(downPayment)).append('<hr/>');
        $("#bayar").html(toDuit(downPayment));
        $('#amount').val(downPayment)
        $("#onCheckfullPayment").change(function() {
            if(this.checked) {
                $("#bayar").html(toDuit(fullPayment));
                $('#amount').val(fullPayment)
            }else{
                $("#bayar").html(toDuit(downPayment));
                $('#amount').val(downPayment)
            }
        });
    }
</script>