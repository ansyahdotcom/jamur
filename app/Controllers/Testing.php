<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Testing extends BaseController
{
    protected $AdminModel;
    public function __construct()
    {
        $this->AdminModel = new AdminModel;
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
        $suhu = $this->request->getVar('suhu');
        $kelembaban = $this->request->getVar('kelembaban');
    }

}
