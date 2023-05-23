<?php

namespace App\Controllers;

use App\Models\Mahasiswa;
use App\Models\Krs;

class MahasiswaController extends BaseController
{
    public function index()
    {
        $mahasiswa = new Mahasiswa();
        $data = $mahasiswa->getListMahasiswa();

        return view('mahasiswa', [
            'data' => json_encode($data)
        ]);
    }

    public function delete($id)
    {
        $krs = new Krs();
        $mahasiswa = new Mahasiswa();
        $krs->where('mahasiswa_id', $id)->delete();
        $mahasiswa->delete($id);

        echo 'success';
    }

    public function search()
    {
        $string = $this->request->getGet('query');
        $mahasiswa = new Mahasiswa();
        $data = $mahasiswa->search($string);

        echo json_encode($data);
    }
}
