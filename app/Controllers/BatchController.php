<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBatchs;

class BatchController extends BaseController
{
    public $ModelBatchs;
    public function __construct()
    {
        $this->ModelBatchs = new ModelBatchs();
    }
    public function index()
    {
        $data = [
            'title'         => 'Batchs',
            'data' => $this->ModelBatchs->orderBy('id', 'desc')->findAll()
        ];


        return view('role/hrd/batch', compact('data'));
    }

    public function store()
    {
        try {
            $data = [
                'code' => uniqid(),
                'description' => $this->request->getPost('deskripsi'),
                'name'         => $this->request->getPost('namaBatch'),
                'start_period'      => $this->request->getPost('periodeMulai'),
                'end_period'    => $this->request->getPost('periodeSelesai'),
            ];


            $result = $this->ModelBatchs->insert($data);
            if ($result) {
                session()->setFlashdata('success', 'Data berhasil ditambahkan');
                return redirect()->back();
            } else {
                session()->setFlashdata('error', 'Data gagal ditambahkan');
                return redirect()->back();
            }
        } catch (\Exception $th) {
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->ModelBatchs->delete($id);
            if ($result) {
                session()->setFlashdata('success', 'Data berhasil dihapus');
                return redirect()->back();
            } else {
                session()->setFlashdata('error', 'Data gagal dihapus');
                return redirect()->back();
            }
        } catch (\Exception $th) {
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function update()
    {
        try {
            $id = $this->request->getPost('editId');
            $data = [
                'name'         => $this->request->getPost('editNamaBatch'),
                'description' => $this->request->getPost('editDeskripsi'),
                'start_period'      => $this->request->getPost('editPeriodeMulai'),
                'end_period'    => $this->request->getPost('editPeriodeSelesai'),
            ];

            $result = $this->ModelBatchs->update($id, $data);

            if ($result) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->back();
            } else {
                session()->setFlashdata('error', 'Data gagal diupdate');
                return redirect()->back();
            }
        } catch (\Exception $th) {
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }
}
