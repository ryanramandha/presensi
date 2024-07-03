<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use chillerlan\QRCode\QRCode;
use Dompdf\Dompdf;

class Qr_code extends BaseController
{
    public function index()
    {
        // data yang akan disimpan di qr code
        $data_qr = base_url(route_to('presensi.proses'));
        // generate qr code
        $qr_code = (new QRCode)->render($data_qr);

        $data['qr_code'] = $qr_code;

        return view('qr_code/index', $data);
    }

    public function cetak()
    {
        // data yang akan disimpan di qr code
        $data_qr = base_url(route_to('presensi.proses'));
        // generate qr code
        $qr_code = (new QRCode)->render($data_qr);

        $data['qr_code'] = $qr_code;

        $html = view('qr_code/pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('qrcode.pdf', ['Attachment' => false]);
    }
}
