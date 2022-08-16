<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\TrainingModel;
use App\Models\DtBaruModel;
use App\Models\JarakModel;
use App\Models\JarakTempModel;
use App\Models\NilaiKModel;

class Testing extends BaseController
{
    protected $AdminModel;
    protected $TrainingModel;
    protected $DtBaruModel;
    protected $JarakModel;
    protected $JarakTempModel;
    protected $NilaiKModel;
    public function __construct()
    {
        $this->AdminModel = new AdminModel;
        $this->TrainingModel = new TrainingModel;
        $this->DtBaruModel = new DtBaruModel;
        $this->JarakModel = new JarakModel;
        $this->JarakTempModel = new JarakTempModel;
        $this->NilaiKModel = new NilaiKModel;
    }

    public function index()
    {
        $username = $this->AdminModel->where(['username' => session()->get('username')])->first();
        $data = [
            'title' => 'Halaman Testing Data',
            'nama' => $username,
        ];

        if ($username == NULL) {
            // jika tanpa login
            echo view('v_test', $data);
        } else {
            // jika login
            echo view('v_testing', $data);
        }
    }

    public function test_jarak()
    {
        $username = $this->AdminModel->where(['username' => session()->get('username')])->first();
        
        // ambil data dari form
        $suhu1 = $this->request->getVar('suhu');
        $kelembaban1 = $this->request->getVar('kelembaban');
        if ($username == NULL) {
            $nilaik = $this->NilaiKModel->orderBy('idk ASC')->limit(1)->first();
            $k = $nilaik['k'];
        } else {
            $k = $this->request->getVar('k');
        }
        // menghilangkan angka
        $suhu2 = preg_replace('/[^0-9,.]/', '', $suhu1);
        $kelembaban2 = preg_replace('/[^0-9,.]/', '', $kelembaban1);
        // mengganti koma dengan titik
        $suhu_br = str_replace(',', '.', $suhu2);
        $kelembaban_br = str_replace(',', '.', $kelembaban2);
        // validasi nilai K
        if ($k == 0) {
            session()->setFlashdata('message', 'notzero');
            return redirect()->to('/testing');
            // validasi nilai suhu dan kelembaban
        } else if ($suhu_br >= 100 || $kelembaban_br >= 100) {
            session()->setFlashdata('message', 'lebihseratus');
            return redirect()->to('/testing');
        } else {
            $data_baru = [
                'suhu_br' => $suhu_br,
                'kelembaban_br' => $kelembaban_br,
                'k' => $k,
            ];
            $this->DtBaruModel->insert($data_baru);

            // ambil data id_br yang baru
            $id = $this->DtBaruModel->select('id_br')->orderBy('id_br DESC')->first();

            // hitung jarak
            $data_training = $this->TrainingModel->findAll();
            foreach ($data_training as $dt_tr) {
                $suhu = $dt_tr['suhu'];
                $kelembaban = $dt_tr['kelembaban'];
                $jarak = sqrt(pow($suhu - $suhu_br, 2) + pow($kelembaban - $kelembaban_br, 2));
                $data_jarak = [
                    'id_br' => $id['id_br'],
                    'id_awal' => $dt_tr['id_awal'],
                    'jarak_temp' => $jarak,
                ];
                // simpan di tabel temporary
                $this->JarakTempModel->insert($data_jarak);
            }
            // ambil hasil hitung dari nilai K n simpan di tabel jarak
            $db = \Config\Database::connect();
            $data_jarak = $db->query("SELECT jarak_temp.id_br, jarak_temp.id_awal, jarak_temp.jarak_temp FROM jarak_temp, data_awal
            WHERE jarak_temp.id_awal = data_awal.id_awal
            ORDER BY jarak_temp.jarak_temp ASC LIMIT $k")->getResultArray();
            foreach ($data_jarak as $dt_jr) {
                $jarak_br = [
                    'id_br' => $dt_jr['id_br'],
                    'id_awal' => $dt_jr['id_awal'],
                    'jarak' => $dt_jr['jarak_temp']
                ];
                $this->JarakModel->insert($jarak_br);
            }

            // hapus data jarak temporary
            $this->JarakTempModel->emptyTable('jarak_temp');

            // hitung kategori terbanyak
            $low = $db->query("SELECT kategori.id_kt FROM jarak, data_awal, kategori
                            WHERE jarak.id_awal = data_awal.id_awal
                            AND data_awal.id_kt = kategori.id_kt
                            AND kategori.id_kt = 1")->getResultArray();
            $medium = $db->query("SELECT kategori.id_kt FROM jarak, data_awal, kategori
                            WHERE jarak.id_awal = data_awal.id_awal
                            AND data_awal.id_kt = kategori.id_kt
                            AND kategori.id_kt = 2")->getResultArray();
            $high = $db->query("SELECT kategori.id_kt FROM jarak, data_awal, kategori
                            WHERE jarak.id_awal = data_awal.id_awal
                            AND data_awal.id_kt = kategori.id_kt
                            AND kategori.id_kt = 3")->getResultArray();
            $loww = count($low);
            $mediumm = count($medium);
            $highh = count($high);
            if ($loww > $mediumm && $loww > $highh) {
                $hasil = 1;
            } else if ($mediumm > $loww && $mediumm > $highh) {
                $hasil = 2;
            } else if ($highh > $mediumm && $highh > $loww) {
                $hasil = 3;
            }
            // ubah data id_kt di tabel data baru
            $data_ubah = [
                'id_br' => $id['id_br'],
                'id_kt' => $hasil,
            ];
            $this->DtBaruModel->save($data_ubah);

            return redirect()->to('/hasil');
        }
    }

    public function hasil()
    {
        $username = $this->AdminModel->where(['username' => session()->get('username')])->first();

        $db = \Config\Database::connect();
        // ambil data id_br yang baru
        $getid = $this->DtBaruModel->select('id_br')->orderBy('id_br DESC')->first();
        $id = $getid['id_br'];
        // tampilkan hasil
        $data_baru = $db->query("SELECT * FROM data_baru ORDER BY id_br DESC LIMIT 1")->getResultArray();
        $data_jarak = $db->query("SELECT jarak.jarak, kategori.nama_kt FROM jarak, data_awal, kategori
                            WHERE jarak.id_awal = data_awal.id_awal
                            AND data_awal.id_kt = kategori.id_kt
                            AND jarak.id_br = $id")->getResultArray();
        $data = [
            'title' => 'Hasil Perhitungan',
            'data_baru' => $data_baru,
            'data_jarak' => $data_jarak,
        ];
        if ($username == NULL) {
            // jika tanpa login
            echo view('v_hasiltest', $data);
        } else {
            // jika login
            echo view('v_hasil', $data);
        }
    }
}
