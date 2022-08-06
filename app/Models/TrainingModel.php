<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingModel extends Model
{
    protected $table = 'data_awal';
    protected $primaryKey = 'id_awal';
    protected $useTimestamps = true;
    protected $createdField  = 'created_awal';
    protected $updatedField  = 'updated_awal';
    protected $allowedFields = ['id_kt', 'suhu', 'kelembaban', 'produksi', 'created_awal'];

    public function add($insert)
    {
        $this->db->table('data_awal')->insert($insert);
    }
}
