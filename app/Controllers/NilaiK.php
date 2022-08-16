<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\NilaiKModel;

class NilaiK extends BaseController
{
    protected $AdminModel;
    protected $NilaiKModel;
    public function __construct()
    {
        $this->AdminModel = new AdminModel;
        $this->NilaiKModel = new NilaiKModel;
    }

    public function index()
    {
        $username = $this->AdminModel->where(['username' => session()->get('username')])->first();
        $nilai = $this->NilaiKModel->orderBy('idk ASC')->limit(1)->first();
        $data = [
            'title' => 'Halaman Konfigurasi Nilai K',
            'idk' => $nilai['idk'],
            'k' => $nilai['k']
        ];
        if ($username == NULL) {
            return redirect()->to('/');
        } else {
            echo view('v_nilaik', $data);
        }
    }

    public function ubah()
    {
        $data = [
            'idk' => $this->request->getVar('idk'),
            'k' => $this->request->getVar('k')
        ];
        $this->NilaiKModel->save($data);
        session()->setFlashdata('message', 'edit');
        return redirect()->to('nilaik');
    }
}