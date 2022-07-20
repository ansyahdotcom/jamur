<?php

namespace App\Models;

use CodeIgniter\Model;

class DtBaruModel extends Model
{
    protected $table = 'data_baru';
    protected $primaryKey = 'id_br';
    protected $useTimestamps = true;
    protected $createdField  = 'created_br';
    protected $updatedField  = 'updated_br';
    protected $allowedFields = ['suhu_br', 'kelembaban_br', 'created_br'];
}
