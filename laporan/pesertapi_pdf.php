<?php
// $koneksi = new mysqli("localhost", "root", "", "pestasiaga");
include"../config/koneksi.php";
$content = '
<page>
	<style type="text/css">
	.table{padding: 40px 100px; border-collapse: collapse;}
	.table th{padding: 8px 8px; background-color: #cccccc;}
	.table td{padding: 8px 8px;}
	</style>
	';
    $content .= '
	<h2 align="center">Peserta Barung Putri</h2>
	<h2 align="center">Pesta Siaga Kwarran Kedung '.date('Y').'</h2>
	<table border="1" class="table">
		<tr>
			<th style="padding: 8px 8px;">No.</th>
			<th style="padding: 8px 8px;">Nomor Dada</th>
			<th style="padding: 8px 8px;">Nama Pangkalan</th>
			<th style="padding: 8px 8px;">Nama Pembina</th>
			
		</tr>';
        $no = 1;
        $sql = $koneksi->query("SELECT * FROM tb_peserta_pi ORDER BY no_dada ASC") or die($koneksi->error);
        while ($data = $sql->fetch_assoc()) {
            $filename = "pesertapi-".date('d-m-Y').".pdf";
            $content.= '
		<tr>
			<td>'.$no++.'</td>
			<td>'.$data['no_dada'].'</td>
			<td>'.$data['pangkalan'].'</td>
			<td>'.$data['pembina'].'</td>
			
		</tr>
		';
        }
        $content.='
	</table>
</page>
';
require '../assets/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf('P', 'F4', 'EN');
$html2pdf->writeHTML($content);
$html2pdf->output($filename);
