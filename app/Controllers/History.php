<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\DtBaruModel;
use App\Models\JarakModel;

class History extends BaseController
{
    protected $AdminModel;
    protected $DtBaruModel;
    protected $JarakModel;
    public function __construct()
    {
        $this->AdminModel = new AdminModel;
        $this->DtBaruModel = new DtBaruModel;
        $this->JarakModel = new JarakModel;
    }

    public function index()
    {
        $username = $this->AdminModel->where(['username' => session()->get('username')])->first();
        $data = [
            'title' => 'Halaman Riwayat Testing Data',
            'data_baru' => $this->DtBaruModel->orderBy('id_br DESC')->findAll()
        ];
        if ($username == NULL) {
            return redirect()->to('/');
        } else {
            echo view('v_history', $data);
        }
    }

    public function hapus()
    {
        $id_br = $this->request->getVar('id_br');
        $this->DtBaruModel->delete(['id_br' => $id_br]);
        $db = \Config\Database::connect();
        $db->query("DELETE FROM jarak WHERE id_br = $id_br");
        session()->setFlashdata('message', 'delete');
        return redirect()->to('history');
    }
}