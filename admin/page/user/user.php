<?php
$id = @$_GET['id'];
$sql = $koneksi->query("SELECT * FROM tb_user WHERE id ='$id'");
?>
    <div class="body">
        <ol class="breadcrumb breadcrumb-bg-green">
            <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><i class="material-icons">person</i> Pengguna</li>
        </ol>
    </div>
    <div class="row clearfix js-sweatalert">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        DATA USER
                    </h2>
                </div>
                <div class="body">
                    <div class=" pull-right">
                        <a href="../laporan/user_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Excel</a>
                        <button type="button" class="btn btn-info btn-sm waves-effect" data-toggle="modal" data-target="#modal_tambah"><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No.</th>
                                    <th>Foto</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Nama</th>
                                    <th>Level</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $sql = $koneksi->query("SELECT * FROM tb_user");
                                while ($data = $sql->fetch_assoc()) {
                                $level = ($data['level'] == 'admin') ? "Admin" : "User"; ?>
                                <tr>
                                    <td><?=$no++."."; ?></td>
                                    <td>
                                        <?php
                                        $foto = isset($data['foto']) ? $data['foto'] : '';
                                        if ($foto) {
                                            echo '<img src="../assets/images/'.$foto.'" alt="Foto" style="height:40px;width:40px;object-fit:cover;border-radius:50%;">';
                                        } else {
                                            $initial = strtoupper(substr($data['nama'],0,1));
                                            echo '<span style="display:inline-flex;align-items:center;justify-content:center;height:40px;width:40px;border-radius:50%;background:#e0e0e0;color:#333;font-weight:bold;">'.$initial.'</span>';
                                        }
                                        ?>
                                    </td>
                                    <td><?=$data['username']; ?></td>
                                    <td><?=$data['password']; ?></td>
                                    <td><?=$data['nama']; ?></td>
                                    <td><?=$level?></td>
                                    <td align="center">
                                        <a data-toggle="modal" data-target="#modal_edit<?=$data['id']; ?>"><button class="btn btn-warning btn-xs waves-effect"><i class="material-icons">edit</i><span>Edit</span></button>
                                        </a>
                                        <button class="btn btn-danger btn-xs waves-effect btn-delete-user" data-id="<?=$data['id']; ?>" data-name="<?=$data['nama']; ?>"><i class="material-icons">delete</i><span>Hapus</span></button>
                                        <!-- <a href="?page=user&aksi=hapus&id=<?=$data['id']; ?>"
                                            onclick="return confirm('Yakin Menghapus Data?')"
                                            class="btn btn-danger btn-xs waves-effect"><i
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
    </div>
<?php
include "modal_tambah.php";
include "modal_edit.php";
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.btn-delete-user');
    buttons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var name = this.getAttribute('data-name');
            Swal.fire({
                title: 'Hapus User?',
                html: 'Data atas nama <b>'+name+'</b> akan dihapus dan tidak dapat dipulihkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href='?page=user&aksi=hapus&id='+id;
                }
            });
        });
    });
});
</script>
