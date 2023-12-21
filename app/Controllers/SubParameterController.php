<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelGradeSubParameters;
use App\Models\ModelParameters;
use App\Models\ModelSubParameters;

class SubParameterController extends BaseController
{
    protected $ModelSubParameters;
    protected $ModelParameters;
    protected $ModelGradeSubParameters;

    public function __construct()
    {
        $this->ModelSubParameters = new ModelSubParameters();
        $this->ModelParameters = new ModelParameters();
        $this->ModelGradeSubParameters = new ModelGradeSubParameters();
    }

    public function index()
    {
        // $this->recalculateAbsoluteWeight();
        // $this->recalculateNormalizedWeights();
        $subParametersData = $this->ModelSubParameters->orderBy('sub_parameter_id', 'desc')->findAll();
        $parametersData = $this->ModelParameters->distinct()->findAll();
        $gradeSubParametersData = $this->ModelGradeSubParameters->orderBy('grade_sub_parameter_id', 'desc')->findAll();

        $totalWeightByCode = [];
        foreach ($subParametersData as $subParameter) {
            $parameterCode = $subParameter['parameter_code'];
            $weight = $subParameter['weight'];
            $totalWeightByCode[$parameterCode] = $totalWeightByCode[$parameterCode] ?? 0;
            $totalWeightByCode[$parameterCode] += $weight;
        }

        $data = [
            'title' => 'Sub Parameters',
            'data' => $subParametersData,
            'gradeSubParametersData' => $gradeSubParametersData,
            'parametersData' => $parametersData,
            'totalWeightByCode' => $totalWeightByCode,
        ];

        return view('role/hrd/sub_parameter', compact('data'));
    }

    public function store()
    {
        try {
            $parameterCode = $this->request->getPost('kodeParameter');
            $totalWeight = $this->calculateTotalWeightByParameterCode($parameterCode);
            $normalization = $this->request->getPost('bobot') / ($totalWeight + $this->request->getPost('bobot') ?: 1);

            $data = [
                'sub_parameter_code' => $this->request->getPost('kodeSubParameter'),
                'parameter_code' => $this->request->getPost('kodeParameter'),
                'name' => $this->request->getPost('namaSubParameter'),
                'weight' => $this->request->getPost('bobot'),
                'normalized_weight' => $normalization,
                'calculation' => $this->request->getPost('perhitungan'),
                'target' => $this->request->getPost('target'),
            ];

            if ($this->ModelSubParameters->insert($data)) {
                session()->setFlashdata('success', 'Data berhasil ditambahkan');
            } else {
                session()->setFlashdata('error', 'Data gagal ditambahkan');
            }
            return redirect()->back();
        } catch (\Exception $th) {
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            if ($this->ModelSubParameters->delete($id)) {
                session()->setFlashdata('success', 'Data berhasil dihapus');
            } else {
                session()->setFlashdata('error', 'Data gagal dihapus');
            }
            return redirect()->back();
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
                'sub_parameter_code' => $this->request->getPost('editKodeSubParameter'),
                'parameter_code' => $this->request->getPost('editKodeParameter'),
                'name' => $this->request->getPost('editNamaSubParameter'),
                'weight' => $this->request->getPost('editBobot'),
                'calculation' => $this->request->getPost('editPerhitungan'),
                'target' => $this->request->getPost('editTarget'),
            ];

            if ($this->ModelSubParameters->update($id, $data)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
            } else {
                session()->setFlashdata('error', 'Data gagal diupdate');
            }
            return redirect()->back();
        } catch (\Exception $th) {
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }

    private function recalculateNormalizedWeights()
    {
        $parameterCodes = $this->ModelSubParameters->select('parameter_code')->distinct()->findAll();


        foreach ($parameterCodes as $code) {
            $subParametersData = $this->ModelSubParameters->where('parameter_code', $code["parameter_code"])->findAll();
            $totalWeight = array_sum(array_column($subParametersData, 'weight'));

            foreach ($subParametersData as $subParameter) {
                $normalization = $totalWeight != 0 ? $subParameter['weight'] / $totalWeight : 0;
                $this->ModelSubParameters->update($subParameter['sub_parameter_id'], ['normalized_weight' => $normalization]);
            }
        }
    }

    private function calculateTotalWeightByParameterCode($parameterCode)
    {
        $subParametersData = $this->ModelSubParameters->where('parameter_code', $parameterCode)->findAll();
        return array_sum(array_column($subParametersData, 'weight'));
    }

    private function recalculateAbsoluteWeight(){
        $subParametersData = $this->ModelSubParameters->findAll();
        $totalWeightByCode = [];
        foreach ($subParametersData as $subParameter) {
            $parameterCode = $subParameter['parameter_code'];
            $weight = $subParameter['weight'];
            $totalWeightByCode[$parameterCode] = $totalWeightByCode[$parameterCode] ?? 0;
            $totalWeightByCode[$parameterCode] += $weight;
        }

        foreach ($subParametersData as $subParameter) {
            $parameterCode = $subParameter['parameter_code'];
            $weight = $subParameter['weight'];
            $absoluteWeight = $weight / $totalWeightByCode[$parameterCode];
            $absoluteWeight = $absoluteWeight * $this->ModelParameters->where('parameter_code', $parameterCode)->find()[0]["normalized_weight"];
            $absoluteWeight = round($absoluteWeight, 2);
            $this->ModelSubParameters->update($subParameter['sub_parameter_id'], ['absolute_weight' => $absoluteWeight]);
        }
    }
}
