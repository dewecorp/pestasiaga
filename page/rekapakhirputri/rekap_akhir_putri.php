<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_prestasi_pi WHERE id_prestasi_pi='$id'");
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Barung Berprestasi</title>
      <link rel="stylesheet" href="">
   </head>
   <body>
      <div class="body">
         <ol class="breadcrumb breadcrumb-bg-blue">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">thumb_up</i> Barung Berprestasi Putri</a></li>
         </ol>
      </div>
      <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
               <div class="header bg-green">
                  <h2>
                  BARUNG BERPRESTASI PUTRI
                  </h2>
               </div>
               <div class="body">
                  <div class=" pull-right">
                     <a href="laporan/prestasipi_pdf.php" target="_blank" class="btn btn-default btn-sm waves-effect"><i
                        class="fa fa-print"></i>
                     PDF</a>
                     <a href="laporan/prestasipi_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i
                     class="fa fa-download"></i> Excel</a>
                  </div>
                  <br><br>
                  <div class="table-responsive">
                     <table
                        class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                        <thead>
                           <tr>
                              <th style="width: 5px;">No.</th>
                              <th>Nomor Dada</th>
                              <th>Pangkalan</th>
                              <th>Total Nilai</th>
                              <th>Predikat</th>
                              <!--  <th>Aksi</th> -->
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $no = 1;
                           $sql = $koneksi->query("SELECT * FROM tb_prestasi_pi
                           JOIN tb_rekap_pi ON tb_prestasi_pi.id_rekap_pi = tb_rekap_pi.id_rekap_pi
                           RIGHT JOIN tb_peserta_pi ON tb_prestasi_pi.id_pi = tb_prestasi_pi.id_pi ORDER BY nilai_akhir_pi DESC LIMIT 3");
                           while ($data = $sql->fetch_assoc()) {
                           ?>
                           <tr>
                              <td><?=$no++."."; ?></td>
                              <td><?=$data['no_dada']; ?></td>
                              <td><?=$data['pangkalan']; ?></td>
                              <td><?=$data['nilai_akhir_pi']; ?></td>
                              <td>
                                 <span class="badge bg-green">Tergiat I</span>
                                 <span class="badge bg-orange">Tergiat II</span>
                                 <span class="badge bg-red">Tergiat III</span>
                              </td>
                              <!-- <td align="center">
                                 <a href="?page=rekapakhirputri&aksi=hapus&id=<?=$data['id_prestasi_pi']; ?>"
                                    onclick="return confirm('Yakin Menghapus Data?')"
                                    class="btn btn-danger btn-xs waves-effect"><i
                                    class="material-icons">delete</i><span>Hapus</span></a>
                                 </td> -->
                              </tr>
                              <?php
                              }
                              ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </body>
   </html>