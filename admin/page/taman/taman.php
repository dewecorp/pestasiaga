
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-green">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">domain</i> Taman-taman</li>
        </ol>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        TAMAN-TAMAN
                    </h2>
                </div>
                <div class="body">
                    <div class=" pull-right">
                        <a href="../laporan/taman_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Export to Excel</a>
                        <a href="../laporan/taman_pdf.php" target="_blank" class="btn btn-danger btn-sm waves-effect"><i class="fa fa-print"></i> Export to PDF</a>
                        <button type="button" class="btn btn-info btn-sm waves-effect" data-toggle="modal" data-target="#modal_tambah"><i class="fa fa-plus"></i> Tambah
                        </button>
                    </div>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th style="text-align: center;">Nama Taman</th>
                                    <th style="text-align: center;">Lokasi</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									$no = 1;
									$sql = $koneksi->query("SELECT * FROM tb_taman ORDER BY nama_taman ASC");
									while ($data = $sql->fetch_assoc()) {
									?>
                                <tr>
                                    <td><?=$no++."."; ?></td>
                                    <td><?=$data['nama_taman']; ?></td>
                                    <td><?=$data['lokasi']; ?></td>
                                    <td align="center">
                                        <a data-toggle="modal" data-target="#modal_edit<?=$data['id_taman']; ?>"><button class="btn btn-warning btn-xs waves-effect"><i class="material-icons">edit</i><span>Edit</span></button>
                                        </a>
                                        <button class="btn btn-danger btn-xs waves-effect btn-delete-taman" data-id="<?=$data['id_taman']; ?>" data-name="<?= $data['nama_taman']; ?>"><i class="material-icons">delete</i><span>Hapus</span></button>
                                        <!-- <a href="?page=taman&aksi=hapus&id=<?=$data['id_taman']; ?>"
												onclick="return confirm('Yakin Menghapus Data?')"
												class="btn btn-danger btn-xs waves-effect" id="btn-hapus"><i
												class="material-icons">delete</i><span>Hapus</span>
											</a> -->

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
    var buttons = document.querySelectorAll('.btn-delete-taman');
    buttons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var name = this.getAttribute('data-name');
            Swal.fire({
                title: 'Hapus Taman?',
                html: 'Taman <b>'+name+'</b> akan dihapus dan tidak dapat dipulihkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href='?page=taman&aksi=hapus&id='+id;
                }
            });
        });
    });
});
</script>
