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

        $data = [
            'title' => 'Halaman Data Training',
            'train' => $this->TrainingModel->findAll(),
        ];

        if ($username == NULL) {
            return redirect()->to('/auth');
        } else {
            echo view('v_training', $data);
        }
    }

    public function import()
    {
        $file = $this->request->getFile('filecsv');
        $ext = $file->getClientExtension();
        if ('csv' == $ext) {
            $excelreader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ('xlsx' == $ext) {
            $excelreader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else {
            $excelreader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }
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

    public function hapus_semua()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('data_awal');
        $hapus = $builder->emptyTable('data_awal');
        if ($hapus) {
            session()->setFlashdata('message', 'delete');
            return redirect()->back();
        } else {
            session()->setFlashdata('message', 'notdelete');
            return redirect()->back();
        }
    }
}
