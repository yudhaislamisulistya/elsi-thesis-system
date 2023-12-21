<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSubParameterCandidates;

class DetailProfileMatchingController extends BaseController
{
    public $ModelSubParameterCandidates;
    public function __construct()
    {
        $this->ModelSubParameterCandidates = new ModelSubParameterCandidates();
    }

    public function index($batch_code)
    {
        $uniqueCandidateCodeFromSubParameterCandidates = $this->ModelSubParameterCandidates
                                                            ->select('candidate_code')
                                                            ->distinct()
                                                            ->where('batch_code', $batch_code)
                                                            ->orderBy('CAST(candidate_code AS UNSIGNED)', 'ASC')
                                                            ->findAll();
        $uniqueSubParameterCodeFromSubParameterCandidates = $this->ModelSubParameterCandidates
                                                                ->select('sub_parameter_code')
                                                                ->distinct()
                                                                ->where('batch_code', $batch_code)
                                                                ->orderBy('CAST(sub_parameter_code AS UNSIGNED)', 'ASC')
                                                                ->findAll();



        $data = [
            "title" => "Detail Profile Matching",
            "batch_code" => $batch_code,
            "uniqueCandidateCodeFromSubParameterCandidates" => $uniqueCandidateCodeFromSubParameterCandidates,
            "uniqueSubParameterCodeFromSubParameterCandidates" => $uniqueSubParameterCodeFromSubParameterCandidates,
        ];

        return view('role/hrd/detail_profile_matching', compact('data'));
    }

    public function update(){
        try {
            $data = [
                "batch_code" => $this->request->getPost('batch_code'),
                "scores" => $this->request->getPost('scores'),
            ];


            foreach ($data['scores'] as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    $this->ModelSubParameterCandidates->where('batch_code', $data['batch_code'])
                                                        ->where('candidate_code', $key)
                                                        ->where('sub_parameter_code', $key2)
                                                        ->set(['valuePM' => $value2])
                                                        ->update();
                }
            }

            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->back();

        } catch (\Exception $th) {
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }
}
