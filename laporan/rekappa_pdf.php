<?php
ob_start();
// $koneksi = new mysqli("localhost", "root", "", "pestasiaga");
include"../config/koneksi.php";
$sql_panitia = $koneksi->query("SELECT nama_kegiatan FROM tb_panitia LIMIT 1");
$data_panitia = $sql_panitia->fetch_assoc();
$nama_kegiatan = isset($data_panitia['nama_kegiatan']) ? $data_panitia['nama_kegiatan'] : 'Pesta Siaga Kwarran Kedung ' . date('Y');
$content = '
<page>
	<style type="text/css">
	.table{padding-left: 40px; padding-top: 10px; border-collapse: collapse;}
	.table th{padding: 8px 5px; background-color: #cccccc;}
	.table td{padding: 8px 5px;}
	</style>
	';
    $content .= '
	
	<h4 align="center">Rekap Nilai Barung Putra</h4>
	<h4 align="center">'.$nama_kegiatan.'</h4>
	<table border="1" class="table">
		<tr>
			
			<th style="width: 6px;">No.</th>
			<th align="center">No. Dada</th>
			<th align="center">Nama Pangkalan</th>
			<th>Ketakwaan</th>
			<th>Toleransi</th>
			<th>Tanda Pengenal</th>
			<th>Rangking 1</th>
			<th>KIM</th>
			<th>Scout</th>
			<th>LBB</th>
			<th>Kereta Bola</th>
			<th>Seni Budaya</th>
			<th>Bumbung</th>
			<th>Nilai Akhir</th>
			
		</tr>';
        $no = 1;
        
        $sql = $koneksi->query("SELECT * FROM tb_rekap
		RIGHT JOIN tb_peserta_pa ON tb_rekap.id_pa = tb_peserta_pa.id_pa ORDER BY no_dada ASC") or die($koneksi->error);
        while ($data = $sql->fetch_assoc()) {
            $filename = "rekappa-".date('d-m-Y').".pdf";
            $content.= '
		<tr>
			<td>'.$no++.'</td>
			<td align="center">'.$data['no_dada'].'</td>
			<td>'.$data['pangkalan'].'</td>
			<td align="center">'.$data['ketakwaan'].'</td>
			<td align="center">'.$data['toleransi'].'</td>
			<td align="center">'.$data['tanda_pengenal'].'</td>
			<td align="center">'.$data['rangking'].'</td>
			<td align="center">'.$data['kim'].'</td>
			<td align="center">'.$data['scout_skill'].'</td>
			<td align="center">'.$data['lbb'].'</td>
			<td align="center">'.$data['kereta_bola'].'</td>
			<td align="center">'.$data['seni_budaya'].'</td>
			<td align="center">'.$data['bumbung'].'</td>
			<td align="center">'.$data['nilai_akhir_pa'].'</td>
		</tr>
		';
        }
        $content.='
	</table>
</page>
';
require '../assets/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf('L', 'F4', 'EN');
$html2pdf->writeHTML($content);
ob_end_clean();
$html2pdf->output($filename, 'I');
