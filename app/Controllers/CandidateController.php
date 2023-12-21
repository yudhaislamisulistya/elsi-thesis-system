<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelCandidates;
use App\Models\ModelUsers;

class CandidateController extends BaseController
{
    public $ModelCandidates;
    public $ModelUsers;
    public function __construct()
    {
        $this->ModelCandidates = new ModelCandidates();
        $this->ModelUsers = new ModelUsers();
    }
    public function index()
    {
        $data = [
            'title'         => 'Candidates',
            'data' => $this->ModelUsers->where('role', 'CANDIDATE')->orderBy('user_id', 'DESC')->findAll(),
        ];


        return view('role/hrd/candidate', compact('data'));
    }

    public function store()
    {
        try {
            $data = [
                'candidate_code' => $this->request->getPost('kode'),
                'name'         => $this->request->getPost('namaKandidat'),
                'description'      => $this->request->getPost('deskripsi'),
            ];


            $result = $this->ModelCandidates->insert($data);
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
            $result = $this->ModelCandidates->delete($id);
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
                'candidate_code' => $this->request->getPost('editKode'),
                'name'         => $this->request->getPost('editNamaKandidat'),
                'description'      => $this->request->getPost('editDeskripsi'),
            ];

            $result = $this->ModelCandidates->update($id, $data);

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
