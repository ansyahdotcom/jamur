<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiKModel extends Model
{
    protected $table = 'nilai_k';
    protected $primaryKey = 'idk';
    protected $useTimestamps = true;
    protected $createdField  = 'created_k';
    protected $updatedField  = 'updated_k';
    protected $allowedFields = ['k', 'created_k'];
}
