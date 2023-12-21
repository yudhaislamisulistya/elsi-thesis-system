<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelGradeSubParameters;
use App\Models\ModelSubParameterCandidates;
use App\Models\ModelSubParameters;
use App\Models\ModelUsers;

class FormController extends BaseController
{
    public $ModelSubParamaterCandidates;
    public $ModelSubParameters;
    public $ModelGradeSubParameters;
    public $ModelUsers;

    public function __construct()
    {
        $this->ModelSubParamaterCandidates = new ModelSubParameterCandidates();
        $this->ModelSubParameters = new ModelSubParameters();
        $this->ModelGradeSubParameters = new ModelGradeSubParameters();
        $this->ModelUsers = new ModelUsers();
    }

    public function index($code)
    {
        $subParametersData = $this->ModelSubParameters->findAll();
        $gradeSubParametersData = $this->ModelGradeSubParameters->orderBy('grade_sub_parameter_id', 'asc')->findAll();
        $data = [
            'code' => $code,
            'subParametersData' => $subParametersData,
            'gradeSubParametersData' => $gradeSubParametersData,
            'title' => 'Form',
        ];

        return view('role/candidate/form', compact('data'));
    }

    public function store()
    {
        try {
            $subParameterCodes = $this->request->getVar('sub_parameter_code');
            $batchCode = $this->request->getVar('batch_code');
            $candidateCode = $this->ModelUsers->where('user_id', session()->get('user_id'))->first()['code'];

            foreach ($subParameterCodes as $code => $value) {
                $existingRecord = $this->ModelSubParamaterCandidates->where([
                    'batch_code' => $batchCode,
                    'candidate_code' => $candidateCode,
                    'sub_parameter_code' => $code
                ])->first();

                $data = [
                    'user_id' => session()->get('user_id'),
                    'batch_code' => $batchCode,
                    'candidate_code' => $candidateCode,
                    'sub_parameter_code' => $code,
                    'value' => $value,
                ];

                if ($existingRecord) {
                    $this->ModelSubParamaterCandidates->where('sub_parameter_candidate_id', $existingRecord['sub_parameter_candidate_id'])->update(null, $data);
                } else {
                    $this->ModelSubParamaterCandidates->insert($data);
                }
            }

            session()->setFlashdata('success', 'Data successfully added or updated.');
            return redirect()->to(base_url('candidate/form/' . $batchCode));
        } catch (\Exception $th) {
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }
}
