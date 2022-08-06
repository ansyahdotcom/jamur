<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\TrainingModel;
use App\Models\DtBaruModel;
use App\Models\JarakModel;
use App\Models\JarakTempModel;

class Testing extends BaseController
{
    protected $AdminModel;
    protected $TrainingModel;
    protected $DtBaruModel;
    protected $JarakModel;
    protected $JarakTempModel;
    public function __construct()
    {
        $this->AdminModel = new AdminModel;
        $this->TrainingModel = new TrainingModel;
        $this->DtBaruModel = new DtBaruModel;
        $this->JarakModel = new JarakModel;
        $this->JarakTempModel = new JarakTempModel;
    }

    public function index()
    {
        $username = $this->AdminModel->where(['username' => session()->get('username')])->first();
        $data = [
            'title' => 'Halaman Data Testing',
            'nama' => $username,
        ];

        if ($username == NULL) {
            return redirect()->to('/auth');
        } else {
            echo view('v_testing', $data);
        }
    }

    public function test_jarak()
    {
        $suhu_br = $this->request->getVar('suhu');
        $kelembaban_br = $this->request->getVar('kelembaban');
        $k = $this->request->getVar('k');
        $data_baru = [
            'suhu_br' => $suhu_br,
            'kelembaban_br' => $kelembaban_br,
        ];
        // $this->DtBaruModel->insert($data_baru);

        $id = $this->DtBaruModel->select('id_br')->orderBy('id_br DESC')->first();

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
            // $this->JarakTempModel->insert($data_jarak);
        }
        $db = \Config\Database::connect();
        $data_jarak = $db->query("SELECT jarak_temp.id_br, jarak_temp.id_awal, jarak_temp.jarak_temp, data_awal.id_kt FROM jarak_temp, data_awal
        WHERE jarak_temp.id_awal = data_awal.id_awal
        ORDER BY jarak_temp.jarak_temp ASC LIMIT $k")->getResultArray();
        foreach ($data_jarak as $dt_jr) {
            $jarak_br = [
                'id_br' => $dt_jr['id_br'],
                'id_awal' => $dt_jr['id_awal'],
                'id_kt' => $dt_jr['id_kt'],
                'jarak' => $dt_jr['jarak_temp']
            ];
            // $this->JarakModel->insert($jarak_br);
        }
        $db = \Config\Database::connect();
        $low = $db->query("SELECT id_kt FROM jarak WHERE id_kt = 1")->getResultArray();
        $medium = $db->query("SELECT id_kt FROM jarak WHERE id_kt = 2")->getResultArray();
        $high = $db->query("SELECT id_kt FROM jarak WHERE id_kt = 3")->getResultArray();
        $loww = count($low);
        $mediumm = count($medium);
        $highh = count($high);
        if ($loww < $mediumm && $loww < $highh) {
            $hasil = 'Low';
        } else if ($mediumm > $loww && $mediumm < $highh) {
            $hasil = 'Medium';
        } else if ($highh > $mediumm && $highh > $loww) {
            $hasil = 'High';
        } else {
            $hasil = 'Tidak Diketahui';
        }

        echo view('v_hasil');
    }
}
