<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelGradeSubParameters;

class GradeSubParameterController extends BaseController
{
    protected $ModelGradeSubParameters;
    public function __construct()
    {
        $this->ModelGradeSubParameters = new ModelGradeSubParameters();
    }

    public function store(){
        try {
            $data = [
                'sub_parameter_code' => $this->request->getPost('kodeSubParameter'),
                'description' => $this->request->getPost('deskripsi'),
                'value' => $this->request->getPost('value'),
            ];

            if ($this->ModelGradeSubParameters->insert($data)){
                session()->setFlashdata('success', 'Data berhasil ditambahkan');
                return redirect()->back();
            }else{
                session()->setFlashdata('error', 'Data gagal ditambahkan');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id){
        try {
            if ($this->ModelGradeSubParameters->delete($id)){
                session()->setFlashdata('success', 'Data berhasil dihapus');
                return redirect()->back();
            }else{
                session()->setFlashdata('error', 'Data gagal dihapus');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(){
        try {
            $data = [
                'sub_parameter_code' => $this->request->getPost('editKodeSubParameterOther'),
                'description' => $this->request->getPost('editDeskripsi'),
                'value' => $this->request->getPost('editValue'),
            ];

            if ($this->ModelGradeSubParameters->update($this->request->getPost('editGradeId'), $data)){
                session()->setFlashdata('success', 'Data berhasil diubah');
                return redirect()->back();
            }else{
                session()->setFlashdata('error', 'Data gagal diubah');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
