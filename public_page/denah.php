<div class="container content-section">
    <div class="row">
        <div class="col-md-12">
             <div class="card">
                <div class="header bg-green">
                    <h2><i class="glyphicon glyphicon-map-marker"></i> DENAH LOKASI</h2>
                </div>
                <div class="body">
                    <?php if (!empty($data_panitia['denah_lokasi'])): ?>
                        <div style="text-align: center;">
                            <img src="assets/images/<?= $data_panitia['denah_lokasi'] ?>" alt="Denah Lokasi" class="img-responsive" style="margin: 0 auto; max-width: 100%; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            <h4>Mohon Maaf</h4>
                            <p>Denah Lokasi belum tersedia.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>