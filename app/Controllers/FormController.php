<?php

namespace App\Controllers;

use App\Models\Krs as KrsModel;
use App\Models\Mahasiswa;

class FormController extends BaseController
{
    public function index()
    {
        return view('form_krs');
    }

    public function create() 
    {
        if(!$this->validateInput()) {
            return view('form_krs', [
                'validation' => $this->validator
            ]);
        }
        try {
            $data = $this->inputProcess();
            $mhsModel = new Mahasiswa();
            if($image = $this->uploadImage()){
                $data['image'] = $image->getRandomName();
                $image->move(WRITEPATH . '../public/assets/images/', $data['image']);
            }
            $mhsModel->insert($data);
            $mhsId = $mhsModel->getInsertID();

            foreach($data['mata_kuliah'] as $val) {
                $krsModel = new KrsModel();
                $krsModel->insert([
                    'mahasiswa_id'  => $mhsId,
                    'nama_matkul'   => $val
                ]);
            }
        } catch (\Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

        //flash message
        session()->setFlashdata('message', 'Krs Berhasil Disimpan');

        return redirect()->to(base_url('/')); 
    }

    public function update($id) 
    {
        if($_POST){
            $data = $this->inputProcess();
            if(!$this->validateInput()) {
                return redirect()->to(base_url('/')); 
            }
            
            $mhsModel = new Mahasiswa();
            if($image = $this->uploadImage()){
                $data['image'] = $image->getRandomName();
                $image->move(WRITEPATH . '../public/assets/images/', $data['image']);
            }

            $mhsModel->update($id, $data);
            $krsModel = new KrsModel();
            $krsModel->where('mahasiswa_id', $id)->delete();
            try {
                
                foreach($data['mata_kuliah'] as $val) {
                    $krsModel = new KrsModel();
                    $krsModel->insert([
                        'mahasiswa_id'  => $id,
                        'nama_matkul'   => $val
                    ]);
                }
                $mhsModel->db->transCommit();
            } catch (\Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
            //flash message
            session()->setFlashdata('message', 'Krs Berhasil Disimpan');

            return redirect()->to(base_url('/')); 
        }

        $mhsModel = new Mahasiswa();
        $krsModel = new KrsModel();

        return view('form_krs_edit',[
            'mahasiswa' => $mhsModel->getMahasiswa($id),
            'krs'       => json_encode($krsModel->getMataKuliah($id), JSON_PRETTY_PRINT)
        ]);
    }

    private function validateInput()
    {

        //define validation
        $validation = $this->validate([
            'nama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Masukkan Nama Mahasiswa.'
                ]
            ],
            'alamat'    => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Masukkan Alamat.'
                ]
            ],
            'jenisKelamin'    => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Masukkan Alamat.'
                ]
            ]
        ]);

        return $validation;
    }

    private function inputProcess()
    {
        $request = $this->request;

        $nama           = $request->getPost('nama');
        $jenis_kelamin  = $request->getPost('jenisKelamin');
        $alamat         = $request->getPost('alamat');
        $mata_kuliah    = $request->getPost('mataKuliah');
        $file           = $request->getFile('file');

        $data = [
            'nama'          => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat'        => $alamat,
            'mata_kuliah'   => $mata_kuliah,
            'file'   => $file
        ];

        return $data;
    }

    public function uploadImage() {
        if($_FILES){
            $upload = $this->request->getFile('file');
            $validation = $this->validate([
                'file' => 'uploaded[file]|mime_in[file,image/jpg,image/jpeg,image/gif,image/png]|max_size[file,4096]'
            ]);
            if ($validation == FALSE) return false;
            
            return $upload;
        }

        return false;
    }
}
