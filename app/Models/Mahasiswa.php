<?php

namespace App\Models;

use CodeIgniter\Model;

class Mahasiswa extends Model
{
    protected $table            = 'mahasiswa';
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama', 'alamat', 'jenis_kelamin', 'image'];

    public function getMahasiswa($id)
    {
        $query = $this->db->query("SELECT * FROM mahasiswa WHERE id = {$id}");
        return $query->getRowArray();
    }

    public function search($queryString)
    {
        $db = db_connect();
        $q = "
            SELECT mhs.id, nama, alamat, jenis_kelamin, mahasiswa_id, COUNT(*) AS jumlah_matkul FROM mahasiswa mhs
            LEFT JOIN mata_kuliah mk
            ON mhs.id = mk.mahasiswa_id
            WHERE 
            nama LIKE '%{$db->escapeLikeString($queryString)}%'
            OR jenis_kelamin LIKE '%{$db->escapeLikeString($queryString)}%'
            OR alamat LIKE '%{$db->escapeLikeString($queryString)}%' 
            GROUP BY id, nama, alamat, jenis_kelamin, mahasiswa_id;
            ";
        $query = $this->db->query($q);

        return $query->getResultArray();
    }

    public function getListMahasiswa()
    {
        $q = "
        SELECT mhs.id, nama, alamat, jenis_kelamin, mahasiswa_id, COUNT(*) AS jumlah_matkul FROM mahasiswa mhs
            LEFT JOIN mata_kuliah mk
                ON mhs.id = mk.mahasiswa_id
                GROUP BY id, nama, alamat, jenis_kelamin, mahasiswa_id;";
        $query = $this->db->query($q);

        return $query->getResultArray();
    }
}