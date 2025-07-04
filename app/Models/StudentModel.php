<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{

    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'course', 'created_at'];
}
