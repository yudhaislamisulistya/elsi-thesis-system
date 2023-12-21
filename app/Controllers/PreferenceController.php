<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPreferences;
use App\Models\ModelSubParameters;

class PreferenceController extends BaseController
{
    public $ModelPreferences;
    public $ModelSubParameters;
    function __construct()
    {
        $this->ModelPreferences = new ModelPreferences();
        $this->ModelSubParameters = new ModelSubParameters();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Tipe Preferensi',
            'data' => $this->ModelPreferences->orderBy('preference_id', 'DESC')->findAll(),
            'subParameterData' => $this->ModelSubParameters->orderBy('sub_parameter_id', 'DESC')->findAll(),
        ];

        return view('role/hrd/preference', compact('data'));
    }

    public function store()
    {
        try {
            $data = [
                'sub_parameter_code' => $this->request->getPost('kodeSubParameter'),
                'sub_parameter_weight' => get_sub_parameter_by_code($this->request->getPost('kodeSubParameter'))['absolute_weight'],
                'sub_parameter_type' => $this->request->getPost('tipePreferensi'),
                'preference_target_value' => $this->request->getPost('target'),
                'start_bound_q' => $this->request->getPost('nilaiBatasAwal'),
                'end_bound_p' => $this->request->getPost('nilaiBatasAkhir'),
            ];

            if ($this->ModelPreferences->insert($data)) {
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

    public function update()
    {
        try {
            $editId = $this->request->getPost('editId');
            $data = [
                'sub_parameter_code' => $this->request->getPost('editKodeSubParameter'),
                'sub_parameter_weight' => get_sub_parameter_by_code($this->request->getPost('editKodeSubParameter'))['absolute_weight'],
                'sub_parameter_type' => $this->request->getPost('editTipePreferensi'),
                'preference_target_value' => $this->request->getPost('editTarget'),
                'start_bound_q' => $this->request->getPost('editNilaiBatasAwal'),
                'end_bound_p' => $this->request->getPost('editNilaiBatasAkhir'),
            ];

            if ($this->ModelPreferences->update($editId, $data)) {
                session()->setFlashdata('success', 'Data berhasil diubah');
                return redirect()->back();
            } else {
                session()->setFlashdata('error', 'Data gagal diubah');
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
            if ($this->ModelPreferences->delete($id)) {
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
}
