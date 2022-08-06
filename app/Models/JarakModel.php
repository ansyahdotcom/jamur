<?php

namespace App\Models;

use CodeIgniter\Model;

class JarakModel extends Model
{
    protected $table = 'jarak';
    protected $primaryKey = 'id_jr';
    protected $useTimestamps = true;
    protected $createdField  = 'created_jr';
    protected $updatedField  = 'updated_jr';
    protected $allowedFields = ['id_br', 'id_awal', 'id_kt', 'jarak', 'created_jr'];
}
