<?php

namespace App\Controllers;
use App\Models\Categoria;
use App\Models\Jusbaires;
use \Config\Services;

class Abm extends BaseController
{
    public function __construct()
    {
        $this->categoria = new Categoria;
        $this->request = Services::request();
    }
    
    public function index()
    {
        return view("abm/listado", [
            "categorias" => $this->categoria->findAll()
        ]);
    }

    public function alta()
    {
        return view("abm/alta");
    }

    public function insertar()
    {
        $this->categoria->insert(
            $this->request->getVar("nombre"),
            $this->request->getVar("color"),
            $this->request->getVar("fondo")
        );
        return redirect()->to('/abm');
    }

    public function editar($id)
    {
        return view("abm/editar", [
            "categoria" => $this->categoria->find($id)
        ]);
    }

    public function actualizar()
    {
        $this->categoria->update(
            $this->request->getVar("id"),
            $this->request->getVar("nombre"),
            $this->request->getVar("color"),
            $this->request->getVar("fondo")
        );
        return redirect()->to('/abm');
    }
    
    public function eliminar($id)
    {
        $this->categoria->delete($id);
        return redirect()->to('/abm');
    }
}