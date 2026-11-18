<?php
$sql = $koneksi->query("SELECT * FROM tb_peserta_pi ORDER BY CAST(no_dada AS UNSIGNED) ASC, no_dada ASC");
$rows = [];
while ($r = $sql->fetch_assoc()) $rows[] = $r;
?>
<!-- TAMPILAN DESKTOP: TABEL STANDAR -->
<div class="container content-section desktop-table-view">
    <div class="card">
        <style>
            .table thead th {
                text-align: center !important;
                vertical-align: middle !important;
            }
        </style>
        <div class="header bg-purple">
            <h2>PESERTA BARUNG PUTRI</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nomor Dada</th>
                            <th>Nama Pangkalan</th>
                            <th>Nama Pembina</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $i => $data): ?>
                        <tr>
                            <td align="center"><?= $i + 1 ?></td>
                            <td align="center"><?= htmlspecialchars($data['no_dada']) ?></td>
                            <td><?= htmlspecialchars($data['pangkalan']) ?></td>
                            <td><?= htmlspecialchars($data['pembina']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- TAMPILAN MOBILE: KARTU INDAH TANPA GESER KANAN KIRI -->
<div class="container mobile-card-view" style="padding-top: 15px;">
    <!-- Search Box Mobile -->
    <div style="margin-bottom: 12px; position: relative;">
        <i class="material-icons" style="position: absolute; left: 12px; top: 10px; font-size: 20px; color: #94a3b8;">search</i>
        <input type="text" id="searchPesertaPi" class="form-control" placeholder="Cari nama pangkalan, pembina, no dada..." 
               style="height: 42px; padding-left: 40px; padding-right: 36px; border-radius: 12px; border: 1px solid #cbd5e1; box-shadow: 0 2px 6px rgba(0,0,0,0.03); font-size: 13px;"
               onkeyup="filterPeserta('searchPesertaPi', 'mob-card-peserta-pi')">
        <button type="button" id="btnClearSearchPi" onclick="clearPeserta('searchPesertaPi', 'mob-card-peserta-pi')" 
                style="position: absolute; right: 8px; top: 8px; border: none; background: transparent; color: #94a3b8; width: 26px; height: 26px; display: none; align-items: center; justify-content: center; cursor: pointer;">
            <i class="material-icons" style="font-size: 18px;">close</i>
        </button>
    </div>
    <div id="searchPesertaPi-nodata" style="display: none; text-align: center; padding: 25px 15px; color: #94a3b8; font-size: 13px;">
        <i class="material-icons" style="font-size: 36px; display: block; margin-bottom: 6px; color: #cbd5e1;">search_off</i>
        Data peserta tidak ditemukan.
    </div>

    <div style="font-size:13px; font-weight:700; color:#c2185b; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
        <i class="material-icons" style="font-size:18px;">local_florist</i> Peserta Barung Putri
    </div>
    <?php if (empty($rows)): ?>
        <div class="mob-card-item" style="text-align:center; color:#78909c;">Belum ada data peserta putri.</div>
    <?php endif; ?>
    <?php foreach ($rows as $i => $data): ?>
    <div class="mob-card-item mob-card-peserta-pi" style="border-left: 4px solid #c2185b;" data-search="<?= htmlspecialchars(strtolower($data['pangkalan'].' '.$data['no_dada'].' '.$data['pembina'])) ?>">
        <div class="mob-card-header">
            <div class="mob-card-badge" style="background:#c2185b; font-size:11px; padding:0 4px;">
                #<?= htmlspecialchars($data['no_dada']) ?>
            </div>
            <div class="mob-card-title"><?= htmlspecialchars($data['pangkalan']) ?></div>
        </div>
        <div class="mob-card-row">
            <span class="label-text">Nomor Urut:</span>
            <span class="value-text"><?= $i + 1 ?></span>
        </div>
        <div class="mob-card-row">
            <span class="label-text">Pembina:</span>
            <span class="value-text"><?= htmlspecialchars($data['pembina'] ?: '-') ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
    function filterPeserta(inputId, cardClass) {
        var inputEl = document.getElementById(inputId);
        var query = inputEl.value.toLowerCase().trim();
        var cards = document.getElementsByClassName(cardClass);
        var wrap = inputEl.parentElement;
        var clearBtn = wrap ? wrap.querySelector('button') : null;
        if (clearBtn) {
            clearBtn.style.display = query.length > 0 ? 'inline-flex' : 'none';
        }
        var found = 0;
        for (var i = 0; i < cards.length; i++) {
            var term = cards[i].getAttribute('data-search') || cards[i].innerText.toLowerCase();
            if (term.indexOf(query) > -1) {
                cards[i].style.display = '';
                found++;
            } else {
                cards[i].style.display = 'none';
            }
        }
        var noData = document.getElementById(inputId + '-nodata');
        if (noData) {
            noData.style.display = (found === 0) ? 'block' : 'none';
        }
    }
    function clearPeserta(inputId, cardClass) {
        var inp = document.getElementById(inputId);
        if (inp) {
            inp.value = '';
            filterPeserta(inputId, cardClass);
            inp.focus();
        }
    }
</script>
