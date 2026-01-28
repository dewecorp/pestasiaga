<?php
// Ensure connection is available
if (!isset($koneksi)) {
    // If included from index.php, connection should be there.
    // If accessed directly, we might need to include it, but this page is usually included.
}

$id = @$_GET['id'];

$sql_taman = $koneksi->query("SELECT * FROM tb_taman WHERE nama_taman LIKE '%PUTRI%' ORDER BY id_taman ASC");
if (!$sql_taman) {
    echo "Query Taman Error: " . $koneksi->error; // Changed die to echo to avoid killing the whole page
}

$data_taman = [];
if ($sql_taman) {
    while ($t = $sql_taman->fetch_assoc()) {
        $data_taman[] = $t;
    }
}

if (!function_exists('map_column_putri')) {
    function map_column_putri($nama) {
        $nama = strtolower(trim($nama));
        
        if (strpos($nama, 'scout') !== false) return 'scout_skill';
        if (strpos($nama, 'kim') !== false) return 'kim';
        if (strpos($nama, 'bumbung') !== false) return 'bumbung';
        if (strpos($nama, 'ketakwaan') !== false) return 'ketakwaan';
        if (strpos($nama, 'toleransi') !== false) return 'toleransi';
        if (strpos($nama, 'tanda') !== false) return 'tanda_pengenal';
        if (strpos($nama, 'ranking') !== false || strpos($nama, 'rangking') !== false) return 'rangking';
        if (strpos($nama, 'lbb') !== false) return 'lbb';
        if (strpos($nama, 'seni') !== false) return 'seni_budaya';
        if (strpos($nama, 'lempar') !== false) return 'lempar_bola';
        if (strpos($nama, 'kereta') !== false) return 'kereta_bola';
        
        // Fallback: Remove ' putra' or ' putri' and snake_case
        $nama = str_replace([' putra', ' putri'], '', $nama);
        return str_replace(' ', '_', $nama);
    }
}
?>

<style>
    .table-responsive {
        overflow-x: auto;
        max-height: 70vh; /* Add vertical scroll */
        overflow-y: auto;
        position: relative;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    /* Standard Header (Sticky Top) */
    table.dataTable thead th {
        position: sticky;
        top: 0;
        z-index: 20; /* Above normal cells */
        background-color: #fff;
        box-shadow: 0 2px 2px -1px rgba(0,0,0,0.2);
    }

    /* Sticky Column 1: No */
    table.dataTable th:nth-child(1),
    table.dataTable td:nth-child(1) {
        position: sticky;
        left: 0;
        width: 50px;
        min-width: 50px;
        z-index: 10; /* Above normal cells */
        border-right: 1px solid #ddd;
    }

    /* Sticky Column 2: No Dada */
    table.dataTable th:nth-child(2),
    table.dataTable td:nth-child(2) {
        position: sticky;
        left: 50px;
        width: 80px;
        min-width: 80px;
        z-index: 10;
        border-right: 1px solid #ddd;
    }

    /* Sticky Column 3: Pangkalan */
    table.dataTable th:nth-child(3),
    table.dataTable td:nth-child(3) {
        position: sticky;
        left: 130px;
        width: 200px;
        min-width: 200px;
        z-index: 10;
        border-right: 2px solid #aaa; /* Stronger border to separate */
        box-shadow: 2px 0 5px -2px rgba(0,0,0,0.3); /* Shadow for depth */
    }

    /* Intersection (Top-Left Headers) - Highest Priority */
    table.dataTable thead th:nth-child(1),
    table.dataTable thead th:nth-child(2),
    table.dataTable thead th:nth-child(3) {
        z-index: 30 !important; /* Above everything */
        background-color: #f0f0f0; /* Slightly distinct color */
    }

    /* Handle striped rows background for sticky columns */
    table.table-striped tbody tr:nth-of-type(odd) td:nth-child(1),
    table.table-striped tbody tr:nth-of-type(odd) td:nth-child(2),
    table.table-striped tbody tr:nth-of-type(odd) td:nth-child(3) {
        background-color: #f9f9f9;
    }

    table.table-striped tbody tr:nth-of-type(even) td:nth-child(1),
    table.table-striped tbody tr:nth-of-type(even) td:nth-child(2),
    table.table-striped tbody tr:nth-of-type(even) td:nth-child(3) {
        background-color: #fff;
    }

    .input-nilai {
        width: 70px;
        text-align: center;
        border: 1px solid #ddd;
        background: transparent;
        padding: 4px;
    }
    .input-nilai:disabled {
        background: transparent;
        border: none;
        color: black;
    }
    .input-nilai:not(:disabled) {
        background: #fff;
        border: 1px solid #aaa;
    }
</style>

<div class="body">
    <ol class="breadcrumb breadcrumb-bg-green">
        <li><a href="index.php"><i class="material-icons">dashboard</i> Dashboard</a></li>
        <li class="active"><i class="material-icons">list</i> Rekap Nilai Barung Putri</li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-green">
                <h2>
                    REKAP NILAI BARUNG PUTRI
                </h2>
            </div>
            <div class="body">
                <div class=" pull-right">
                    <a href="../laporan/rekappi_pdf.php" target="_blank" class="btn btn-info btn-sm waves-effect"><i class="fa fa-print"></i>
                        PDF</a>
                    <a href="../laporan/rekappi_excel.php" target="_blank" class="btn btn-success btn-sm waves-effect"><i class="fa fa-download"></i> Excel</a>
                </div>
                <br><br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th style="width: 5px;">No.</th>
                                <th style="width: 20px;">No. Dada</th>
                                <th style="width: 100px;">Pangkalan</th>
                                <?php foreach ($data_taman as $t) { ?>
                                    <th style="text-align: center;"><?= $t['nama_taman']; ?></th>
                                <?php } ?>
                                <th>NA</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $query_str = "SELECT * FROM tb_rekap_pi RIGHT JOIN tb_peserta_pi ON tb_rekap_pi.id_pi = tb_peserta_pi.id_pi ORDER BY no_dada ASC";
                                $sql = $koneksi->query($query_str);

                                if (!$sql) {
                                    echo "<tr><td colspan='100%'>Query Error: " . $koneksi->error . "</td></tr>";
                                } else {
                                    while ($data = $sql->fetch_assoc()) {
                                        if ($data['nilai_akhir_pi'] == "" || $data['nilai_akhir_pi'] == null) {
                                            $nilai = "<span class='badge bg-red'>0</span>";
                                        } else {
                                            $nilai = $data['nilai_akhir_pi'];
                                        } ?>
                            <tr data-id="<?=$data['id_rekap_pi']; ?>" data-peserta-id="<?=$data['id_pi']; ?>">
                                <td align="center"><?=$no++."."; ?></td>
                                <td align="center"><?=$data['no_dada']; ?></td>
                                <td><?=$data['pangkalan']; ?></td>
                                <?php foreach ($data_taman as $t) {
                                    $col = map_column_putri($t['nama_taman']);
                                    $val = isset($data[$col]) ? $data[$col] : 0;
                                ?>
                                    <td align="center">
                                        <input type="number" class="input-nilai" data-column="<?=$col?>" value="<?=$val?>" min="0" max="100" disabled>
                                    </td>
                                <?php } ?>
                                <td align="center" class="cell-total"><?=$nilai?></td>
                                <td align="center">
                                    <button class="btn bg-orange btn-xs waves-effect btn-edit" title="Edit"><i class="material-icons">edit</i></button>
                                    <button class="btn bg-blue btn-xs waves-effect btn-simpan" title="Simpan" style="display:none;"><i class="material-icons">save</i></button>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    var $ = window.jQuery;
    
    // Ensure SweetAlert2 is available, otherwise fallback
    var Swal = window.Swal;

    // Unbind previous events to prevent duplicates
    $(document).off('click', '.btn-edit');
    $(document).off('click', '.btn-simpan');
    $(document).off('input', '.input-nilai');
    
    // Edit button handler
    $(document).on('click', '.btn-edit', function() {
        var tr = $(this).closest('tr');
        tr.find('.input-nilai').prop('disabled', false);
        $(this).hide();
        tr.find('.btn-simpan').show();
    });

    // Save button handler
    $(document).on('click', '.btn-simpan', function() {
        var tr = $(this).closest('tr');
        var id = tr.data('id');
        var peserta_id = tr.data('peserta-id');
        var values = {};
        var isValid = true;
        
        tr.find('.input-nilai').each(function() {
            var col = $(this).data('column');
            var val = $(this).val();
            
            // Validation
            if (parseInt(val) > 100) {
                if (Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Nilai tidak boleh lebih dari 100!'
                    });
                } else {
                    alert('Nilai tidak boleh lebih dari 100!');
                }
                $(this).focus();
                isValid = false;
                return false; // Break loop
            }
            if (parseInt(val) < 0) {
                if (Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Nilai tidak boleh kurang dari 0!'
                    });
                } else {
                    alert('Nilai tidak boleh kurang dari 0!');
                }
                $(this).focus();
                isValid = false;
                return false; // Break loop
            }
            
            values[col] = val;
        });

        if (!isValid) return;

        $.ajax({
            url: 'ajax/update_nilai.php',
            type: 'POST',
            data: {
                type: 'putri',
                id: id,
                peserta_id: peserta_id,
                values: values
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    if (response.new_id) {
                        tr.data('id', response.new_id);
                    }
                    tr.find('.input-nilai').prop('disabled', true);
                    tr.find('.btn-simpan').hide();
                    tr.find('.btn-edit').show();
                    
                    // Update total
                    tr.find('.cell-total').text(response.total);
                    
                    if (Swal) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Nilai berhasil disimpan!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        alert('Nilai berhasil disimpan!');
                    }
                } else {
                    if (Swal) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menyimpan: ' + response.message
                        });
                    } else {
                        alert('Gagal menyimpan: ' + response.message);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                if (Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Error: ' + error
                    });
                } else {
                    alert('Terjadi kesalahan: ' + error);
                }
            }
        });
    });
    
    // Input validation on type
    $(document).on('input', '.input-nilai', function() {
        var val = parseInt($(this).val());
        if (val > 100) {
            $(this).val(100);
            if (Swal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Nilai maksimal 100'
                });
            } else {
                alert('Nilai maksimal 100');
            }
        }
    });
});
</script>
