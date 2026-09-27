<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title" id="largeModalLabel" align="center">TAMBAH DATA TAMAN</h5>
			</div>
			<form action="#" method="POST">
				<?= csrf_field() ?>
				<div class="modal-body">
					<div class="form-group">
						<div class="form-line">
							<label for="taman">Nama Taman</label>
							<input type="text" name="taman" id="taman" class="form-control" placeholder="Nama Taman" required autofocus>
						</div>
					</div>
					<div class="form-group">
						<div class="form-line">
							<label for="lokasi">Lokasi</label>
							<input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Lokasi" required>
						</div>
					</div>
					<div class="modal-footer">
						<input type="submit" name="simpan" class="btn btn-success waves-effect" value="Simpan">
						<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
if (isset($_POST['simpan'])) {
	csrf_verify();
	$taman  = trim($_POST['taman'] ?? '');
	$lokasi = trim($_POST['lokasi'] ?? '');
	
	$stmt = db_exec($koneksi, "INSERT INTO tb_taman (nama_taman, lokasi) VALUES (?, ?)", [$taman, $lokasi]);
	if ($stmt) {
?>
<script>
Swal.fire({
	position: 'top-center',
	icon: 'success',
	title: '<?= e($taman); ?>',
	text: 'Berhasil Ditambahkan',
	showConfirmButton: true,
	timer: 3000
});
window.setTimeout(function(){
	document.location.href = '?page=taman';
}, 1500);
</script>
	<?php
	}
}
?>
