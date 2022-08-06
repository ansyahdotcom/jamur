<?php

namespace App\Models;

use CodeIgniter\Model;

class JarakTempModel extends Model
{
    protected $table = 'jarak_temp';
    protected $primaryKey = 'id_temp';
    protected $useTimestamps = true;
    protected $createdField  = 'created_temp';
    protected $updatedField  = 'updated_temp';
    protected $allowedFields = ['id_br', 'id_awal', 'jarak_temp', 'created_temp'];
}
