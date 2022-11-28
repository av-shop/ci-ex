<?php

namespace App\Models;

class Categoria extends BaseModel
{
    protected $table = 'categorias';
    protected $createdField  = 'mtime';
    protected $updatedField  = 'mtime';
    protected $useTimestamps = true;
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['nombre', 'color', 'fondo'];
}
