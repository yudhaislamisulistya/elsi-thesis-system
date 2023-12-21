<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelParameters;

class ParameterController extends BaseController
{
    public $ModelParameters;
    public function __construct()
    {
        $this->ModelParameters = new ModelParameters();
    }
    public function index()
    {
        $data = [
            'title'         => 'Parameters',
            'data' => $this->ModelParameters->orderBy('parameter_id', 'desc')->findAll()
        ];

        $totalWeight = 0;
        foreach ($data['data'] as $key => $value) {
            $totalWeight += $value['weight'];
        }
        $data['totalWeight'] = $totalWeight;

        return view('role/hrd/parameter', compact('data'));
    }

    public function store()
    {
        try {
            $parametersData = $this->ModelParameters->findAll();
            $totalWeight = 0;
            foreach ($parametersData as $key => $value) {
                $totalWeight += $value['weight'];
            }
            $normalization = $totalWeight != 0 ? $this->request->getPost('bobot') / $totalWeight : $this->request->getPost('bobot') / $this->request->getPost('bobot');

            $data = [
                'parameter_code' => $this->request->getPost('kode'),
                'name'         => $this->request->getPost('namaParameter'),
                'weight'      => $this->request->getPost('bobot'),
                'normalized_weight' => $normalization
            ];


            $result = $this->ModelParameters->insert($data);
            if ($result) {
                $parametersData = $this->ModelParameters->findAll();
                $totalWeight = 0;
                foreach ($parametersData as $key => $value) {
                    $totalWeight += $value['weight'];
                }
                foreach ($parametersData as $key => $value) {
                    $normalization = $totalWeight != 0 ? $value['weight'] / $totalWeight : $value['weight'] / $value['weight'];
                    $this->ModelParameters->update($value['parameter_id'], ['normalized_weight' => $normalization]);
                }
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
            $result = $this->ModelParameters->delete($id);
            if ($result) {
                $parametersData = $this->ModelParameters->findAll();
                $totalWeight = 0;
                foreach ($parametersData as $key => $value) {
                    $totalWeight += $value['weight'];
                }
                foreach ($parametersData as $key => $value) {
                    $normalization = $totalWeight != 0 ? $value['weight'] / $totalWeight : $value['weight'] / $value['weight'];
                    $this->ModelParameters->update($value['parameter_id'], ['normalized_weight' => $normalization]);
                }
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
                'parameter_code' => $this->request->getPost('editKode'),
                'name'         => $this->request->getPost('editNamaParameter'),
                'weight'      => $this->request->getPost('editBobot'),
            ];

            $result = $this->ModelParameters->update($id, $data);

            if ($result) {
                $parametersData = $this->ModelParameters->findAll();
                $totalWeight = 0;
                foreach ($parametersData as $key => $value) {
                    $totalWeight += $value['weight'];
                }
                foreach ($parametersData as $key => $value) {
                    $normalization = $totalWeight != 0 ? $value['weight'] / $totalWeight : $value['weight'] / $value['weight'];
                    $this->ModelParameters->update($value['parameter_id'], ['normalized_weight' => $normalization]);
                }
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
