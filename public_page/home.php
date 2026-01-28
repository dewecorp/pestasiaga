<div class="jumbotron hero bg-light-brown">
    <div class="container">
        <h1>Selamat Datang</h1>
        <h2><?= $data_panitia['nama_kegiatan'] ?></h2>
        <p class="lead"><?= nl2br($data_panitia['pesan_beranda'] ?? '') ?></p>
    </div>
</div>
<div class="container content-section">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header bg-purple">
                    <h2><i class="glyphicon glyphicon-bullhorn"></i> Informasi Terkini</h2>
                </div>
                <div class="body">
                    <p>Selamat datang di <?= $data_panitia['nama_kegiatan'] ?>. Gunakan menu di atas untuk melihat informasi seputar kegiatan, taman, juri, peserta, dan rekapitulasi nilai.</p>
                </div>
            </div>
        </div>
    </div>
</div>