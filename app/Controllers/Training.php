<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\TrainingModel;

class Training extends BaseController
{
    protected $AdminModel;
    protected $TrainingModel;
    public function __construct()
    {
        $this->AdminModel = new AdminModel;
        $this->TrainingModel = new TrainingModel;
    }

    public function index()
    {
        $username = $this->AdminModel->where(['username' => session()->get('username')])->first();
        $db = \Config\Database::connect();
        $train = $db->query("SELECT * FROM data_awal, kategori WHERE data_awal.id_kt = kategori.id_kt
                                ORDER BY data_awal.id_awal ASC")->getResultArray();
        $data = [
            'title' => 'Halaman Data Training',
            'train' => $train,
        ];

        if ($username == NULL) {
            return redirect()->to('/');
        } else {
            echo view('v_training', $data);
        }
    }

    // tambah data training
    public function import()
    {
        $file = $this->request->getFile('filecsv');
        $ext = $file->getClientExtension();
        // cek ekstensi file
        if ('csv' == $ext) {
            $excelreader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ('xlsx' == $ext) {
            $excelreader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else if ('xls' == $ext) {
            $excelreader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else if ('csv' != $ext || 'xlsx' != $ext || 'xls' != $ext) {
            session()->setFlashdata('message', 'wrongext');
            return redirect()->back();
        }
        // dihapus dulu karena proses import jadi 1 paket saat tambah data
        $this->TrainingModel->emptyTable('data_awal');
        //baca file
        $spreadsheet = $excelreader->load($file);
        //ambil sheet active
        $sheet    = $spreadsheet->getActiveSheet()->toArray();
        $i = 0;
        //looping untuk mengambil data
        foreach ($sheet as $data) {
            if ($data[3] == 'low') {
                $kategori = 1;
            } else if ($data[3] == 'medium') {
                $kategori = 2;
            } else if ($data[3] == 'high') {
                $kategori = 3;
            } else {
                $kategori = 0;
            }
            if ($i >= 1) {

                $insert = [
                    'suhu' => $data[0],
                    'kelembaban' => $data[1],
                    'produksi' => $data[2],
                    'id_kt' => $kategori,
                ];
                // dd($insert);
                $this->TrainingModel->add($insert);
            }
            $i++;
        }
        session()->setFlashdata('message', 'save');
        return redirect()->back();
    }

    // ubah data training
    public function ubah()
    {
        $id_awal = $this->request->getVar('id_awal');
        $suhu = $this->request->getVar('suhu');
        $kelembaban = $this->request->getVar('kelembaban');
        $produksi = $this->request->getVar('produksi');
        $data = [
            'id_awal' => $id_awal,
            'suhu' => $suhu,
            'kelembaban' => $kelembaban,
            'produksi' => $produksi
        ];
        $this->TrainingModel->save($data);
        session()->setFlashdata('message', 'edit');
        return redirect()->back();
    }

    // hapus data training
    public function hapus()
    {
        $id_awal = $this->request->getVar('id_awal');
        $hapus = $this->TrainingModel->delete($id_awal);
        if ($hapus) {
            session()->setFlashdata('message', 'delete');
            return redirect()->back();
        } else {
            session()->setFlashdata('message', 'notdelete');
            return redirect()->back();
        }
    }

    // hapus semua data training
    public function hapus_semua()
    {
        $hapus = $this->TrainingModel->emptyTable('data_awal');
        if ($hapus) {
            session()->setFlashdata('message', 'delete');
            return redirect()->back();
        } else {
            session()->setFlashdata('message', 'notdelete');
            return redirect()->back();
        }
    }
}
