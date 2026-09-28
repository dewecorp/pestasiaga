<div class="modal fade" id="modal_impor" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" style="color: white; font-weight: bold;"><i class="fa fa-file-excel-o"></i> IMPOR DATA PESERTA BARUNG PUTRI</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" style="border-radius: 8px; margin-bottom: 20px;">
                    <strong>Petunjuk Impor:</strong>
                    <ol style="margin-bottom: 0; padding-left: 20px;">
                        <li>Unduh template Excel terlebih dahulu melalui tombol di bawah.</li>
                        <li>Isi data <b>Nama Pangkalan</b> dan <b>Nama Pembina</b>.</li>
                        <li><b>Nomor dada tidak perlu diisi</b> (nomor dada akan dibuat otomatis secara berurutan oleh sistem).</li>
                        <li>Pilih file Excel / CSV yang telah diisi, lalu klik <b>Mulai Impor</b>.</li>
                    </ol>
                </div>
                <div style="margin-bottom: 18px;">
                    <a href="../laporan/template_impor_peserta.php?jenis=pi" target="_blank" class="btn btn-primary btn-sm waves-effect">
                        <i class="fa fa-download"></i> Unduh Template Excel (.xls)
                    </a>
                </div>
                <div class="form-group">
                    <div class="form-line">
                        <label for="excel_file_pi">Pilih File Excel / CSV (.xlsx, .xls, .csv)</label>
                        <input type="file" id="excel_file_pi" accept=".xlsx, .xls, .csv" class="form-control" />
                    </div>
                </div>

                <!-- Progress Bar Container -->
                <div id="import_progress_container_pi" style="display: none; margin-top: 20px;">
                    <label>Proses Impor Data:</label>
                    <div class="progress" style="height: 24px; margin-bottom: 6px; border-radius: 6px; overflow: hidden; background-color: #e0e0e0;">
                        <div id="import_progress_bar_pi" class="progress-bar progress-bar-striped active bg-orange" role="progressbar" style="width: 0%; line-height: 24px; font-weight: bold; font-size: 13px;">
                            0%
                        </div>
                    </div>
                    <small id="import_status_text_pi" class="text-muted">Mempersiapkan data...</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_do_import_pi" class="btn btn-warning waves-effect"><i class="fa fa-upload"></i> Mulai Impor</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var btnImport = document.getElementById('btn_do_import_pi');
    if (!btnImport) return;

    btnImport.addEventListener('click', function() {
        var fileInput = document.getElementById('excel_file_pi');
        var file = fileInput.files[0];
        
        if (!file) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih file Excel / CSV terlebih dahulu!'
            });
            return;
        }

        var progressContainer = document.getElementById('import_progress_container_pi');
        var progressBar = document.getElementById('import_progress_bar_pi');
        var progressStatus = document.getElementById('import_status_text_pi');

        btnImport.disabled = true;
        progressContainer.style.display = 'block';
        progressBar.style.width = '10%';
        progressBar.textContent = '10%';
        progressStatus.textContent = 'Membaca file...';

        var reader = new FileReader();

        reader.onload = function(e) {
            try {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, { type: 'array' });

                progressBar.style.width = '30%';
                progressBar.textContent = '30%';
                progressStatus.textContent = 'Memproses baris data...';

                var firstSheetName = workbook.SheetNames[0];
                var worksheet = workbook.Sheets[firstSheetName];
                var jsonRows = XLSX.utils.sheet_to_json(worksheet, { header: 1, raw: false });

                if (!jsonRows || jsonRows.length === 0) {
                    throw new Error('File excel kosong.');
                }

                // Header mapping
                var pangkalanIdx = -1;
                var pembinaIdx = -1;

                var startRow = 0;
                for (var r = 0; r < Math.min(jsonRows.length, 5); r++) {
                    var row = jsonRows[r];
                    if (!row) continue;
                    for (var c = 0; c < row.length; c++) {
                        var cellVal = (row[c] || '').toString().toLowerCase().trim();
                        if (cellVal.indexOf('pangkalan') !== -1) {
                            pangkalanIdx = c;
                            startRow = r + 1;
                        }
                        if (cellVal.indexOf('pembina') !== -1) {
                            pembinaIdx = c;
                            startRow = r + 1;
                        }
                    }
                    if (pangkalanIdx !== -1) break;
                }

                if (pangkalanIdx === -1) pangkalanIdx = 1;
                if (pembinaIdx === -1) pembinaIdx = 2;

                var rowsToImport = [];
                for (var i = startRow; i < jsonRows.length; i++) {
                    var rData = jsonRows[i];
                    if (!rData || rData.length === 0) continue;

                    var pangkalanVal = (rData[pangkalanIdx] || '').toString().trim();
                    var pembinaVal   = (rData[pembinaIdx] || (rData[pangkalanIdx + 1] || '')).toString().trim();

                    if (!pangkalanVal && rData[0]) {
                        var firstColVal = (rData[0] || '').toString().trim();
                        if (isNaN(firstColVal) && firstColVal.toLowerCase().indexOf('template') === -1 && firstColVal.toLowerCase().indexOf('catatan') === -1) {
                            pangkalanVal = firstColVal;
                            pembinaVal = (rData[1] || '').toString().trim();
                        }
                    }

                    if (pangkalanVal && pangkalanVal.toLowerCase().indexOf('nama pangkalan') === -1 && pangkalanVal.toLowerCase().indexOf('template') === -1 && pangkalanVal.toLowerCase().indexOf('catatan') === -1) {
                        rowsToImport.push({
                            pangkalan: pangkalanVal,
                            pembina: pembinaVal
                        });
                    }
                }

                if (rowsToImport.length === 0) {
                    throw new Error('Tidak ada data peserta valid yang ditemukan dalam file excel.');
                }

                progressBar.style.width = '60%';
                progressBar.textContent = '60%';
                progressStatus.textContent = 'Mengirim ' + rowsToImport.length + ' data ke server...';

                var formData = new FormData();
                formData.append('csrf_token', '<?= csrf_token() ?>');
                formData.append('jenis', 'pi');
                formData.append('rows', JSON.stringify(rowsToImport));

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'ajax/impor_peserta.php', true);

                xhr.upload.onprogress = function(event) {
                    if (event.lengthComputable) {
                        var percent = Math.round(60 + ((event.loaded / event.total) * 35));
                        progressBar.style.width = percent + '%';
                        progressBar.textContent = percent + '%';
                    }
                };

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        progressBar.style.width = '100%';
                        progressBar.textContent = '100%';
                        progressStatus.textContent = 'Selesai!';

                        try {
                            var resp = JSON.parse(xhr.responseText);
                            if (resp.status === 'success') {
                                $('#modal_impor').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Impor Berhasil!',
                                    text: resp.message,
                                    confirmButtonText: 'OK'
                                }).then(function() {
                                    window.location.reload();
                                });
                            } else {
                                btnImport.disabled = false;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Impor Gagal',
                                    text: resp.message || 'Terjadi kesalahan saat menyimpan data.'
                                });
                            }
                        } catch (err) {
                            btnImport.disabled = false;
                            Swal.fire({
                                icon: 'error',
                                title: 'Impor Gagal',
                                text: 'Respon server tidak valid.'
                            });
                        }
                    } else {
                        btnImport.disabled = false;
                        Swal.fire({
                            icon: 'error',
                            title: 'Impor Gagal',
                            text: 'Gagal terhubung ke server (HTTP ' + xhr.status + ').'
                        });
                    }
                };

                xhr.onerror = function() {
                    btnImport.disabled = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Impor Gagal',
                        text: 'Terjadi kesalahan jaringan.'
                    });
                };

                xhr.send(formData);

            } catch (err) {
                btnImport.disabled = false;
                progressBar.style.width = '0%';
                progressContainer.style.display = 'none';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengolah File',
                    text: err.message || 'File excel tidak dapat dibaca.'
                });
            }
        };

        reader.onerror = function() {
            btnImport.disabled = false;
            progressBar.style.width = '0%';
            progressContainer.style.display = 'none';
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Tidak dapat membaca file.'
            });
        };

        reader.readAsArrayBuffer(file);
    });
});
</script>
