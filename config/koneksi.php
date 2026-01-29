<?php
// Matikan error reporting untuk production
error_reporting(0);
mysqli_report(MYSQLI_REPORT_OFF);

$koneksi = mysqli_connect("localhost","root","","pestasiaga");

// Check connection
if (mysqli_connect_errno()){
	// Jangan tampilkan detail error database ke user
	die("Koneksi database gagal.");
}
