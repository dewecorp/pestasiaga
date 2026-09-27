<?php
require_once __DIR__ . '/../assets/vendor/tecnickcom/tcpdf/tcpdf_barcodes_2d.php';

function generate_qr_base64($text)
{
    $barcode = new TCPDF2DBarcode($text, 'QRCODE,M');
    $png = $barcode->getBarcodePngData(3, 3, [0, 0, 0]);
    return 'data:image/png;base64,' . base64_encode($png);
}
