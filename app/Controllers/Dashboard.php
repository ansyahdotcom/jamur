<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\DtBaruModel;

class Dashboard extends BaseController
{
    protected $AdminModel;
    protected $DtBaruModel;
    public function __construct()
    {
        $this->AdminModel = new AdminModel;
        $this->DtBaruModel = new DtBaruModel;
    }

    public function index()
    {
        // get session login
        $username = $this->AdminModel->where(['username' => session()->get('username')])->first();
        $db = \Config\Database::connect();
        // ambil data id_br yang baru
        $getid = $this->DtBaruModel->select('id_br')->orderBy('id_br DESC')->first();
        if ($getid == NULL) {
            $data = [
                'title' => 'Dashboard'
            ];
        } else {
            $id = $getid['id_br'];
            // tampilkan di v_hasil
            $data_baru = $db->query("SELECT * FROM data_baru ORDER BY id_br DESC LIMIT 1")->getResultArray();
            $data_jarak = $db->query("SELECT jarak.jarak, kategori.nama_kt FROM jarak, data_awal, kategori
                            WHERE jarak.id_awal = data_awal.id_awal
                            AND data_awal.id_kt = kategori.id_kt
                            AND jarak.id_br = $id")->getResultArray();
            $data = [
                'title' => 'Dashboard',
                'data_baru' => $data_baru,
                'data_jarak' => $data_jarak,
            ];
        }

        if ($username == NULL) {
            return redirect()->to('/');
        } else {
            echo view('v_dashboard', $data);
        }
    }
}
