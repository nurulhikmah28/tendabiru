<div class="content-wrapper mt-3">
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">


              <?php
              if ($total['proses'] == '0') {
                $proses = '<i class="text-danger">Pending</i>';
                $color = 'danger';
                $text = 'Pending';
              } elseif ($total['proses'] == '1') {
                $proses = '<i class="text-warning">Konfirmasi</i>';
                $color = 'warning';
                $text = 'Konfirmasi';
              } elseif ($total['proses'] == '2') {
                $proses = '<i class="text-primary">Proses</i>';
                $color = 'primary';
                $text = 'Proses';
              } elseif ($total['proses'] == '3') {
                $proses = '<i class="text-success">Close Order</i>';
                $color = 'success';
                $text = 'Close Order';
              }
              ?>

              <h3 class="card-title">Detail Pesanan Masuk</h3><br>

              <div class="float-sm-right ">


                <div class='btn-group'>
                  <button style='width:100px' type='button' class='btn btn-<?= $color ?> btn-sm'><?= $text ?></button>

                  <button type='button' class='btn btn-<?= $color ?> btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> <span class='caret'></span> <span class='sr-only'>Toggle Dropdown</span> </button>
                  <div class='dropdown-menu' style='border:1px solid #cecece;'>
                    <a class='dropdown-item' href='<?= base_url('admin/pesanan_status2/') . $total['id_penjualan'] ?>/0/<?= $this->uri->segment(3) ?>' onclick="return confirm('Apa anda yakin untuk ubah status jadi Pending ?')"> Pending</a>
                    <a class='dropdown-item' href='<?= base_url('admin/pesanan_status2/') . $total['id_penjualan'] ?>/1/<?= $this->uri->segment(3) ?>' onclick="return confirm('Apa anda yakin untuk ubah status jadi Konfirmasi ?')"> Konfirmasi</a>
                    <a class='dropdown-item' href='<?= base_url('admin/pesanan_status2/') . $total['id_penjualan'] ?>/2/<?= $this->uri->segment(3) ?>' onclick="return confirm('Apa anda yakin untuk ubah status jadi Proses ?')"> Proses</a>
                    <a class='dropdown-item' href='<?= base_url('admin/pesanan_dikirim2/') . $total['id_penjualan'] ?>/3/<?= $this->uri->segment(3) ?>' onclick="return confirm('Apa anda yakin untuk ubah status jadi Close Order ?')"> Close Order</a>
                  </div>
                </div>

                <a class='btn btn-primary btn-sm' href='<?php echo base_url('admin/pesanan'); ?>'>Kembali</a>
              </div>
            </div>

            <div class="card-body">
              <div class="row">


                <div class="col-md-6">
                  <table class="table table-sm table-borderless" style="width: 100%">
                    <tr>
                      <td style="width:120px;"><small>Nama</small></td>
                      <td><?= $rows['nama_lengkap']; ?></td>
                    </tr>
                    <tr>
                      <td><small>No. Telepon</small></td>
                      <td><?= $rows['no_telp']; ?></td>
                    </tr>
                    <tr>
                      <td><small>Alamat</small></td>
                      <td>
                        <?= $rows['alamat']; ?><br>
                        Kec. <?= $rows['kecamatan']; ?><br>
                        <?= $rows['nama_kota']; ?><?= $rows['kode_pos']; ?>
                      </td>
                    </tr>
                  </table>

                </div>
                <div class="col-md-6">

                  <table class="table table-sm table-borderless" style="width: 100%">
                    <tr>
                      <td style="width:120px;"><small>Total Bayar</small></td>
                      <td>Rp <?= rupiah($total['total']); ?></td>
                    </tr>
                    <tr>
                      <td><small>Status</small></td>
                      <td><?= $proses ?></td>
                    </tr>

                  </table>
                </div>

              </div>
              <div class="row">

                <div class="col-md-12">
                <table style="width: 100%; margin-top:20px">
    <thead>
      <tr style="background-color:#ddd">
        <th width='40%' style="text-align: left">Nama Produk</th>
        <th style="text-align: left">Harga</th>
        <th style="text-align: left">Jumlah</th>
        <th style="text-align: left">Total</th>
      </tr>
    </thead>
    <tbody>

      <?php

      $no = 1;
      foreach ($record->result_array() as $row) {
        $sub_total = $row['harga_jual']*$row['jumlah'];
        if (trim($row['gambar']) == '') {
          $foto_produk = 'no-image.png';
        } else {
          $foto_produk = $row['gambar'];
        }
      ?>
        <tr>
          <td><?= $row['nama_produk'] ?></td>
          <td>Rp <?= rupiah($row['harga_jual']) ?>
          </td>
          <td><?= $row['jumlah'] ?></td>
          <td>Rp
            <span class="float-right">
              <?= rupiah($sub_total) ?>
            </span>
          </td>
        </tr>
      <?php
        $no++;
      }
      ?>

      <tr>
        <td colspan='3'><b>Grand Total </b></td>
        <td>Rp
            <span class="float-right">
              <?= rupiah($total['total']) ?>
            </span>
        </td>
      </tr>
      <?php 
        $i =1;
        $totalDownPayment = 0;
        foreach($downPayment as $downPayment){
      ?>
        <tr>
        <td colspan='3'><b>Pembayaran <?= $i ?> </b></td>
        <td>Rp
            <span class="float-right">
              <?= rupiah($downPayment['total_transfer']);
                $totalDownPayment += $downPayment['total_transfer']; 
              ?>
            </span>
        </td>
      </tr>
      <?php
        $i++;
        }
      ?>
      <tr>
        <td colspan='3'><b>Outstanding Payment</b></td>
        <td class="border border-dark"><b>Rp
            <span class="float-right">
              <?php
                if(!$totalDownPayment){
                  $totalDownPayment = $total['total']; 
                }else{
                  $totalDownPayment = $totalDownPayment;
                }
                echo rupiah($total['total'] - $totalDownPayment); 
              ?>
            </span>
          </b>
        <td>
      </tr>



      <!-- Total berat 
        <tr>
          <td colspan='4'><b>Berat</b></td>
          <td><b> <?= //$total['total_berat']
                    '' ?> Gram</b></td>
        </tr>
        -->

    </tbody>
  </table><br>
                </div>

              </div>

              <div class="row">
                <div class="col-md-12">
                  <?php

                  $cek_konfirmasi = $this->db->get_where('tb_toko_konfirmasi', array('id_penjualan' => $total['id_penjualan']));
                  if ($cek_konfirmasi->num_rows() >= 1) {
                    echo "<div class='alert alert-primary' style='border-radius:0px; padding:5px'>Konfirmasi Pembayaran dari Pembeli : </div>";
                    $konfirmasi = $this->model_app->view_join_where('tb_toko_konfirmasi', 'tb_toko_rekening', 'id_rekening', array('id_penjualan' => $total['id_penjualan']), 'id_konfirmasi_pembayaran', 'DESC');
                    foreach ($konfirmasi as $r) {
                  ?>
                      <div class='col-md-12'>
                        <table class="table table-sm table-borderless">
                          <tr>
                            <td style="width:140px;">Nama Pengirim</td>

                            <td><?= $r['nama_pengirim'] ?></td>
                          </tr>

                          <tr>
                            <td>Total Transfer</td>

                            <td><?= $r['total_transfer'] ?></td>
                          </tr>

                          <tr>
                            <td>Tanggal Transfer</td>

                            <td><?= tgl_indo($r['tanggal_transfer']) ?></td>
                          </tr>

                          <tr>
                            <td>Bukti Transfer</td>

                            <td><a href='<?= base_url('admin/download_file/') . $r['bukti_transfer'] ?>'>Download File</a></td>
                          </tr>

                          <tr>
                            <td>Rekening Tujuan</td>

                            <td><?= $r['nama_bank'] ?> - <?= $r['no_rekening'] ?> - <?= $r['pemilik_rekening'] ?></td>
                          </tr>

                          <tr>
                            <td>Waktu Konfirmasi</td>

                            <td><?= $r['waktu_konfirmasi'] ?></td>
                          </tr>


                        </table>
                      </div>

                      <hr>
                  <?php
                    }
                  }
                  ?>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>