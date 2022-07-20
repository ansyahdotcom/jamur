<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Dashboard extends BaseController
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
            'title' => 'Dashboard',
            'nama' => $username,
        ];

        if ($username == NULL) {
            return redirect()->to('/auth');
        } else {
            echo view('v_dashboard', $data);
        }
    }

}
