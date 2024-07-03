<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\PegawaiModel;
use App\Models\PresensiModel;
use Dompdf\Dompdf;

class History extends BaseController
{
    // deklarasi variabel
    protected $pegawai;
    protected $presensi;
    protected $absensi;
    protected $validation;

    // fungsi construct untuk inisialisasi model yang digunakan
    public function __construct()
    {
        // helper form
        helper('form');
        // inisialisasi model yang digunakan
        $this->pegawai = new PegawaiModel();
        $this->presensi = new PresensiModel();
        $this->absensi = new AbsensiModel();
        // inisialisasi form validation
        $this->validation = service('validation');
    }

    public function index()
    {
        if (session()->get('level') == 'Kepala Cabang' || session()->get('level') == 'Admin') {
            $data['pegawai'] = $this->pegawai->findAll();
        } else {
            $data['pegawai'] = $this->pegawai->where('id_pengguna', session()->get('id_pengguna'))->findAll();
        }

        return view('history/data', $data);
    }

    public function show($id)
    {
        $data['bulan'] = $this->request->getGet('bulan') ?? date('m');
        $data['tahun'] = $this->request->getGet('tahun') ?? date('Y');
        $data['jenis'] = $this->request->getGet('jenis') ?? 'presensi';

        $data['pegawai'] = $this->pegawai->find($id);

        if ($data['jenis'] == 'presensi') {
            $data['presensi'] = $this->presensi->where('id_pegawai', $id)
                ->where('MONTH(tanggal)', $data['bulan'])
                ->where('YEAR(tanggal)', $data['tahun'])
                ->where('status', 1)
                ->findAll();
        } elseif ($data['jenis'] == 'absensi') {
            $data['absensi'] = $this->absensi->where('id_pegawai', $id)
                ->where('MONTH(tanggal)', $data['bulan'])
                ->where('YEAR(tanggal)', $data['tahun'])
                ->findAll();
        }

        return view('history/show', $data);
    }

    public function cetak($id, $bulan, $tahun, $jenis)
    {
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['jenis'] = $jenis;

        $data['pegawai'] = $this->pegawai->find($id);

        if ($jenis == 'presensi') {
            $data['presensi'] = $this->presensi->where('id_pegawai', $id)
                ->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun)
                ->where('status', 1)
                ->findAll();

            $html = view('history/cetak_presensi', $data);
        } elseif ($jenis == 'absensi') {
            $data['absensi'] = $this->absensi->where('id_pegawai', $id)
                ->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun)
                ->findAll();

            $html = view('history/cetak_absensi', $data);
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('history-' . $jenis . '.pdf', ['Attachment' => false]);
    }
}
