<?php
if ($total['proses'] == '0') {
  $proses = 'Pending';
} elseif ($total['proses'] == '1') {
  $proses = 'konfirmasi';
} elseif ($total['proses'] == '2') {
  $proses = 'Proses';
} elseif ($total['proses'] == '3') {
  $proses = 'Dikirim';
}
?>
<div class="wrapper w-100 mx-auto">
  <div class="font-weight-bold mt-2 mb-4">
    <h5 class=""><?= $title; ?> - <?= $rows['kode_transaksi'] ?></h5>
  </div>
  <!-- Row -->
  <div class="row">
    <div class='col-lg-8 col-md-6'>
      <table class="table table-borderless table-sm">
        <tr>
          <td width="140px;"><small>Nama</small></td>
          <td class="text-left"><?= $rows['nama_lengkap']; ?></td>
        </tr>
        <tr>
          <td><small>No. Telpon</small></td>
          <td><?= $rows['no_telp']; ?></td>
        </tr>

        <tr>
          <td><small>Alamat</small></td>
          <td>
            <?= $rows['alamat'] ?><br>
            Kecamatan <?= $rows['kecamatan']; ?> <br>
            <?= $rows['nama_kota']; ?>, <?= $rows['kode_pos']; ?>
          </td>
        </tr>
      </table>
    </div>

    <div class='col-lg-4 col-md-6'>
      <table class="table table-borderless table-sm">
        <tr>
          <td width="140px;"><small>Total Bayar</small></td>
          <td class="text-left">Rp <?= rupiah($total['total']); ?></td>
        </tr>

        <tr>
          <td><small>Status</small></td>
          <td><?= $proses ?></td>
        </tr>

        <?php if ($total['proses'] == '3') { ?>

          <tr>
            <td><small>No. Resi</small></td>
            <td><?= $total['resi']; ?></td>
          </tr>

        <?php } ?>

      </table>
    </div>


  </div>

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

  <p class="text-center"> Silahkan transfer ke salah satu pilihan rekening bank dibawah ini:</p>
  <table class="table table-borderless table-sm w-75 mx-auto" id='tablemodul1'>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Bank</th>
        <th>No Rekening</th>
        <th>Atas Nama</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $rekening = $this->model_app->view('tb_toko_rekening');
      foreach ($rekening->result_array() as $row) {
      ?>
        <tr>
          <td><?= $no ?></td>
          <td><?= $row['nama_bank']; ?></td>
          <td><?= $row['no_rekening']; ?></td>
          <td><?= $row['pemilik_rekening']; ?></td>
        </tr>
      <?php
        $no++;
      }
      ?>
    </tbody>
  </table>
  <hr>
</div>