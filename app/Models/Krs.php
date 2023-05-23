<?php

namespace App\Models;

use CodeIgniter\Model;

class Krs extends Model
{
    protected $table            = 'mata_kuliah';
    protected $allowedFields    = ['mahasiswa_id', 'nama_matkul'];
    protected $primaryKey       = 'id';

    public function getMataKuliah($id)
    {
        $query = $this->db->query("SELECT * FROM mata_kuliah WHERE mahasiswa_id = {$id}");
        return $query->getResult();
    }
}