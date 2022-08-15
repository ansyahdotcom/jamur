<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Profile extends BaseController
{
    protected $AdminModel;
    public function __construct()
    {
        $this->AdminModel = new AdminModel;
    }

    public function index()
    {
        $username = $this->AdminModel->where(['username' => session()->get('username')])->first();
        $db = \Config\Database::connect();
        $admin = $db->query("SELECT * FROM admin WHERE username = '" . $username['username'] . "'")->getResultArray();
        $data = [
            'title' => 'Profil Admin',
            'admin' => $admin,
        ];
        echo view('v_profil', $data);
    }

    public function ubahpassword()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $password_baru = $this->request->getVar('password_baru');
        $password_baru_ulang = $this->request->getVar('password_baru_ulang');

        $user = $this->AdminModel->where(['username' => $username])->first();
        if ($user == NULL) {
            session()->setFlashdata('message', 'wrong_user');
            return redirect()->to('/profile');
        } else {
            if ($password_baru == $password_baru_ulang) {
                $data = [
                    'id_adm' => $user['id_adm'],
                    'password' => password_hash($password_baru, PASSWORD_DEFAULT)
                ];
                $this->AdminModel->save($data);
                session()->setFlashdata('message', 'ubah_passwd');
                return redirect()->to('/profile');
            } else {
                session()->setFlashdata('message', 'wrong_passwd');
                return redirect()->to('/profile');
            }
        }
    }
}
