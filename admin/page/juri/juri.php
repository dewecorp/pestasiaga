<?php
$id = (int)($_GET['id'] ?? 0);
?>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-green">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">visibility</i> Dewan Juri</li>
        </ol>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        DEWAN JURI
                    </h2>
                </div>
                <div class="body">
                    <div class="pull-right">
                        <a href="../laporan/juri_pdf.php" target="_blank" class="btn btn-danger btn-sm waves-effect"><i class="fa fa-print"></i> PDF</a>
                        <a href="../laporan/juri_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Excel</a>
                        <button type="button" class="btn btn-info btn-sm waves-effect" data-toggle="modal" data-target="#modal_tambah"><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th>Nama Juri</th>
                                    <th>Pangkalan</th>
                                    <th>Koordinator Taman</th>
                                    <th>No HP/WA</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    $juris = db_all($koneksi, "SELECT * FROM tb_juri
                                    JOIN tb_taman ON tb_juri.id_taman = tb_taman.id_taman
                                    JOIN tb_peserta_pa ON tb_juri.id_pa = tb_peserta_pa.id_pa");
                                    foreach ($juris as $data) {
                                    ?>
                                <tr>
                                    <td><?= $no++ . "."; ?></td>
                                    <td><?= e($data['nama_juri']); ?></td>
                                    <td><?= e($data['pangkalan']); ?></td>
                                    <td><?= e($data['nama_taman']); ?></td>
                                    <td><?= e($data['no_hp']); ?></td>
                                    <td align="center">
                                        <a data-toggle="modal" data-target="#modal_edit<?= (int)$data['id_juri']; ?>"><button class="btn btn-warning btn-xs waves-effect" title="Edit"><i class="material-icons">edit</i></button></a>
                                        <button class="btn btn-danger btn-xs waves-effect btn-delete-juri" data-id="<?= (int)$data['id_juri']; ?>" data-name="<?= e($data['nama_juri']); ?>" title="Hapus"><i class="material-icons">delete</i></button>
                                    </td>
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
<?php
include "modal_tambah.php";
include "modal_edit.php";
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.btn-delete-juri');
    buttons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var name = this.getAttribute('data-name');
            Swal.fire({
                title: 'Hapus Juri?',
                html: 'Data juri <b>'+name+'</b> akan dihapus dan tidak dapat dipulihkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?page=juri&aksi=hapus&id=' + id + '&<?= csrf_query() ?>';
                }
            });
        });
    });
});
</script>
