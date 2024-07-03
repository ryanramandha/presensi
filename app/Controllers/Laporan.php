<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\PegawaiModel;
use App\Models\PenggunaModel;
use App\Models\PresensiModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends BaseController
{
    protected $pegawai;
    protected $presensi;
    protected $absensi;

    public function __construct()
    {
        $this->pegawai = new PegawaiModel();
        $this->presensi = new PresensiModel();
        $this->absensi = new AbsensiModel();
    }

    public function index()
    {
        $data['bulan'] = $this->request->getGet('bulan') ?? date('m');
        $data['tahun'] = $this->request->getGet('tahun') ?? date('Y');

        // Ambil data pegawai
        $data['pegawai'] = $this->pegawai->findAll();

        // Hitung jumlah hadir, off, alfa, sakit, izin, dan cuti
        foreach ($data['pegawai'] as &$pegawai) {
            $pegawai['hadir'] = $this->getHadirCount($pegawai['id_pegawai'], $data['bulan'], $data['tahun']);
            $pegawai['off'] = $this->getAbsensiCount($pegawai['id_pegawai'], 'Off', $data['bulan'], $data['tahun']);
            $pegawai['alfa'] = $this->getAbsensiCount($pegawai['id_pegawai'], 'Alfa', $data['bulan'], $data['tahun']);
            $pegawai['sakit'] = $this->getAbsensiCount($pegawai['id_pegawai'], 'Sakit', $data['bulan'], $data['tahun']);
            $pegawai['izin'] = $this->getAbsensiCount($pegawai['id_pegawai'], 'Izin', $data['bulan'], $data['tahun']);
            $pegawai['cuti'] = $this->getAbsensiCount($pegawai['id_pegawai'], 'Cuti', $data['bulan'], $data['tahun']);
        }

        return view('laporan/index', $data);
    }

    // cetak laporan
    public function cetak($bulan, $tahun)
    {
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        // Ambil data pegawai
        $data['pegawai'] = $this->pegawai->findAll();

        // Hitung jumlah hadir, off, alfa, sakit, izin, dan cuti
        foreach ($data['pegawai'] as &$pegawai) {
            $pegawai['hadir'] = $this->getHadirCount($pegawai['id_pegawai'], $data['bulan'], $data['tahun']);
            $pegawai['off'] = $this->getAbsensiCount($pegawai['id_pegawai'], 'Off', $data['bulan'], $data['tahun']);
            $pegawai['alfa'] = $this->getAbsensiCount($pegawai['id_pegawai'], 'Alfa', $data['bulan'], $data['tahun']);
            $pegawai['sakit'] = $this->getAbsensiCount($pegawai['id_pegawai'], 'Sakit', $data['bulan'], $data['tahun']);
            $pegawai['izin'] = $this->getAbsensiCount($pegawai['id_pegawai'], 'Izin', $data['bulan'], $data['tahun']);
            $pegawai['cuti'] = $this->getAbsensiCount($pegawai['id_pegawai'], 'Cuti', $data['bulan'], $data['tahun']);
        }

        $pengguna_m = new PenggunaModel();
        $pengguna = $pengguna_m->where('level', 'Kepala Cabang')->first();
        $data['kepala_cabang'] = $pengguna['nama_lengkap'] ?? '';
        $pengguna = $pengguna_m->where('level', 'Admin')->first();
        $data['admin'] = $pengguna['nama_lengkap'] ?? '';

        // Absolute path to the image
        $imagePath = FCPATH . 'assets/images/logo2.png';

        // Check if the file exists
        if (!file_exists($imagePath)) {
            return "Image file not found.";
        }

        // Read the image file
        $imageData = file_get_contents($imagePath);
        if ($imageData === false) {
            return "Failed to read image file.";
        }

        // Encode the image data to base64
        $base64String = base64_encode($imageData);
        $data['base64Image'] = 'data:image/png;base64,' . $base64String;

        $html = view('laporan/cetak', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan-rekap.pdf', ['Attachment' => false]);
    }

    // fungsi untuk menghitung jumlah hadir
    public function getHadirCount($id_pegawai, $bulan, $tahun)
    {
        return $this->presensi->where('id_pegawai', $id_pegawai)
            ->where('jam_masuk IS NOT NULL')
            ->where('jam_pulang IS NOT NULL')
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->where('status', 1)
            ->countAllResults();
    }

    // fungsi untuk menghitung jumlah absensi berdasarkan keterangan
    public function getAbsensiCount($id_pegawai, $keterangan, $bulan, $tahun)
    {
        return $this->absensi->where('id_pegawai', $id_pegawai)
            ->where('keterangan', $keterangan)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();
    }
}
