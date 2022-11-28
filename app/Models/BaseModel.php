<?php
namespace App\Models;


use CodeIgniter\Model;

class BaseModel extends Model
{
    /**
     * Permite un metodo alternativo de llamar al update
     * En luhar de update($id, ['campo' => $valor])
     * Se pued eusar update($id, $valor)
     * EL orden de los campos es el mismo de allowedFields
     */
    public function update($id = null, $data = null) : bool
    {
        if($id and !is_array($data))
        {
            $values = func_get_args();
            $id = array_shift($values);
            return parent::update($id, array_combine($this->allowedFields, $values));
        }
        else
        {
            return parent::update($id, $data);
        }
    }
    
    /**
     * Permite un metodo alternativo de llamar al update
     * En luhar de insert(['campo' => $valor])
     * Se pued eusar insert($valor)
     * EL orden de los campos es el mismo de allowedFields
     */
    public function insert($data =null, $returnId = true) 
    {
        if(!is_array($data))
        {
            $values = func_get_args();
            return parent::insert(array_combine($this->allowedFields, $values));
        }
        else
        {
            return parent::insert($data);
        }
    }
    
    /**
     * Devuelve un objeto en lugar de un array asociativo por que es un GOMAZO
     * 
     */
    public function find($id = null)
    {
        return (object) parent::find($id);
    }
    
    /**
     * Devuelve un listado de objetos en lugar de un array asociativo por que es un GOMAZO
     * 
     */
    public function findAll($limit = 0, $offset = 0)
    {
        return array_map(function($o) { return (object) $o; }, parent::findAll($limit, $offset));
    }
}
