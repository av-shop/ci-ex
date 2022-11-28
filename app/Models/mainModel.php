<?php 
namespace App\Models;

use CodeIgniter\Model;

class mainModel extends Model{
    protected $table      = 'ci_users';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['name','email','registration_date','avatar'];
}