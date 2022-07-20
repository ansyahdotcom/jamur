<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingModel extends Model
{
    protected $table = 'data_awal';
    protected $primaryKey = 'id_tr';
    protected $useTimestamps = true;
    protected $createdField  = 'created_tr';
    protected $updatedField  = 'updated_tr';
    protected $allowedFields = ['suhu', 'kelembaban', 'produksi', 'created_tr'];

    public function add($insert)
    {
        $this->db->table('data_awal')->insert($insert);
    }
}
