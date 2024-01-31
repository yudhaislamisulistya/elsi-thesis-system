<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBatchs;
use App\Models\ModelCandidateRankings;
use App\Models\ModelPreferences;
use App\Models\ModelSubParameterCandidates;
use App\Models\ModelSubParameters;
use Exception;

set_time_limit(360); // Mengatur batas waktu eksekusi menjadi 120 detik
ini_set('memory_limit', '512M'); // Mengatur batas memori menjadi 512 MB

class PrometheeController extends BaseController
{
    public $ModelBatchs;
    public $ModelSubParameterCandidates;
    public $ModelPreferences;
    public $ModelCandidateRankings;
    public function __construct()
    {
        $this->ModelBatchs = new ModelBatchs();
        $this->ModelSubParameterCandidates = new ModelSubParameterCandidates();
        $this->ModelPreferences = new ModelPreferences();
        $this->ModelCandidateRankings = new ModelCandidateRankings();
    }
    public function index()
    {
        $data = [
            'title'         => 'Promethee',
            'data' => $this->ModelBatchs->orderBy('id', 'desc')->findAll()
        ];


        return view('role/hrd/promethee', compact('data'));
    }

    public function save_ranking()
    {
        try {
            $batchCode = $this->request->getPost('batch_code');
            $candidatesData = $this->request->getPost('candidates');

            foreach ($candidatesData as $candidateCode => $candidateData) {
                $dataToSave = [
                    'batch_code' => $batchCode,
                    'candidate_code' => $candidateCode,
                    'ranking' => $candidateData['rank'],
                    'leaving_flow' => $candidateData['leaving_flow'],
                    'entering_flow' => $candidateData['entering_flow'],
                    'net_flow' => $candidateData['net_flow']
                ];

                $this->ModelCandidateRankings->insertOrUpdate($dataToSave);
            }

            session()->setFlashdata('success', 'Berhasil menyimpan ranking');
            return redirect()->back();
        } catch (\Exception $th) {
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function detail($batch_code)
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

        $arraySubParameterCode = [];
        foreach ($uniqueSubParameterCodeFromSubParameterCandidates as $key => $value) {
            $arraySubParameterCode[] = $value['sub_parameter_code'];
        }

        $prometheeData = [];
        // Menghitung standar deviasi untuk setiap sub parameter
        $standarDeviasiData = [];
        foreach ($arraySubParameterCode as $subParameterCode) {
            $sumValuePM = 0;
            foreach ($uniqueCandidateCodeFromSubParameterCandidates as $candidateA) {
                foreach ($uniqueCandidateCodeFromSubParameterCandidates as $candidateB) {
                    if ($candidateA['candidate_code'] !== $candidateB['candidate_code']) {
                        $valuePM = $this->calculatePreferenceValue($candidateA['candidate_code'], $candidateB['candidate_code'], $subParameterCode);
                        $sumValuePM += $valuePM;
                    }
                }
            }
            // Asumsikan Anda memiliki jumlah data untuk setiap subParameterCode yang akan dibagi untuk menemukan rata-rata
            $averageValuePM = $sumValuePM / (count($uniqueCandidateCodeFromSubParameterCandidates) * (count($uniqueCandidateCodeFromSubParameterCandidates) - 1));
            // Menyimpan standar deviasi untuk subParameterCode
            $standarDeviasiData[$subParameterCode] = $averageValuePM;
        }

        // Sekarang kita mempunyai standar deviasi, perbarui loop untuk menggunakan standar deviasi ini
        foreach ($arraySubParameterCode as $subParameterCode) {
            foreach ($uniqueCandidateCodeFromSubParameterCandidates as $candidateA) {
                foreach ($uniqueCandidateCodeFromSubParameterCandidates as $candidateB) {
                    if ($candidateA['candidate_code'] !== $candidateB['candidate_code']) {
                        $valuePM = $this->calculatePreferenceValue($candidateA['candidate_code'], $candidateB['candidate_code'], $subParameterCode);
                        // Mengambil standar deviasi untuk subParameterCode yang bersangkutan
                        $standarDeviasi = $standarDeviasiData[$subParameterCode];
                        $d = $this->calculateD($valuePM, $subParameterCode, $standarDeviasi);
                        $preferenceIndex = $this->calculatePreferenceIndex($d, $subParameterCode);

                        $prometheeData[$subParameterCode][$candidateA['candidate_code']][$candidateB['candidate_code']] = [
                            'valuePM' => $valuePM,
                            'd' => $d,
                            'preferenceIndex' => $preferenceIndex
                        ];
                    }
                }
            }
        }


        $totalPreferenceIndices = [];

        foreach ($uniqueCandidateCodeFromSubParameterCandidates as $candidateA) {
            foreach ($uniqueCandidateCodeFromSubParameterCandidates as $candidateB) {
                if ($candidateA['candidate_code'] !== $candidateB['candidate_code']) {
                    $totalIndex = 0;
                    foreach ($arraySubParameterCode as $subParameterCode) {
                        if (isset($prometheeData[$subParameterCode][$candidateA['candidate_code']][$candidateB['candidate_code']]['preferenceIndex'])) {
                            $totalIndex += $prometheeData[$subParameterCode][$candidateA['candidate_code']][$candidateB['candidate_code']]['preferenceIndex'];
                        }
                    }
                    $totalPreferenceIndices[$candidateA['candidate_code']][$candidateB['candidate_code']] = $totalIndex;
                }
            }
        }

        $leavingFlow = [];
        $numberOfCandidates = count($uniqueCandidateCodeFromSubParameterCandidates);

        foreach ($uniqueCandidateCodeFromSubParameterCandidates as $candidateA) {
            $sumPreferenceIndices = 0;
            foreach ($uniqueCandidateCodeFromSubParameterCandidates as $candidateB) {
                if ($candidateA['candidate_code'] !== $candidateB['candidate_code']) {
                    $sumPreferenceIndices += $totalPreferenceIndices[$candidateA['candidate_code']][$candidateB['candidate_code']] ?? 0;
                }
            }
            $leavingFlow[$candidateA['candidate_code']] = $sumPreferenceIndices / ($numberOfCandidates - 1);
        }

        $enteringFlow = [];

        foreach ($uniqueCandidateCodeFromSubParameterCandidates as $candidateB) {
            $sumPreferenceIndices = 0;
            foreach ($uniqueCandidateCodeFromSubParameterCandidates as $candidateA) {
                if ($candidateA['candidate_code'] !== $candidateB['candidate_code']) {
                    $sumPreferenceIndices += $totalPreferenceIndices[$candidateA['candidate_code']][$candidateB['candidate_code']] ?? 0;
                }
            }
            $enteringFlow[$candidateB['candidate_code']] = $sumPreferenceIndices / ($numberOfCandidates - 1);
        }

        $netFlow = [];

        foreach ($uniqueCandidateCodeFromSubParameterCandidates as $candidate) {
            $netFlow[$candidate['candidate_code']] = $leavingFlow[$candidate['candidate_code']] - $enteringFlow[$candidate['candidate_code']];
        }

        $netFlowRanking = [];
        foreach ($netFlow as $candidateCode => $flow) {
            $netFlowRanking[$candidateCode] = $flow;
        }

        arsort($netFlowRanking);


        $data = [
            'batch_code' => $batch_code,
            'title'         => 'Detail Promethee',
            'uniqueCandidateCodeFromSubParameterCandidates' => $uniqueCandidateCodeFromSubParameterCandidates,
            'uniqueSubParameterCodeFromSubParameterCandidates' => $uniqueSubParameterCodeFromSubParameterCandidates,
            'dataPreferences' => $this->ModelPreferences->findAll(),
            'dataPromethee' => $prometheeData,
            'totalPreferenceIndices' => $totalPreferenceIndices,
            'leavingFlow' => $leavingFlow,
            'enteringFlow' => $enteringFlow,
            'netFlow' => $netFlow,
            'netFlowRanking' => $netFlowRanking
        ];


        return view('role/hrd/detail_promethee', compact('data'));
    }

    private function calculatePreferenceValue($candidateA, $candidateB, $subParameterCode)
    {
        $valueA = $this->getValue($candidateA, $subParameterCode);
        $valueB = $this->getValue($candidateB, $subParameterCode);

        return $valueA - $valueB;
    }

    private function getValue($candidateCode, $subParameterCode)
    {
        $ModelSubParameterCandidates = new ModelSubParameterCandidates();
        $data = $ModelSubParameterCandidates->where([
            'candidate_code' => $candidateCode,
            'sub_parameter_code' => $subParameterCode
        ])->first();

        return $data['valuePM'];
    }

    private function calculateD($valuePM, $subParameterCode)
    {
        $ModelPreferences = new ModelPreferences();
        $data = $ModelPreferences->where('sub_parameter_code', $subParameterCode)->first();
        $q = $data['start_bound_q'];
        $p = $data['end_bound_p'];


        if ($data['sub_parameter_type'] == 'Kriteria Linier') {
            if ($valuePM <= 0) {
                $d = 0;
            } elseif ($valuePM <= $p) {
                $d = $valuePM / $p;
            } else {
                $d = 1;
            }
        } else if ($data['sub_parameter_type'] == 'Kriteria Level') {
            if ($valuePM <= $q) {
                $d = 0;
            } elseif ($valuePM <= $p) {
                $d = 0.5;
            } else {
                $d = 1;
            }
        } else if ($data['sub_parameter_type'] == 'Kriteria Biasa') {
            $d = ($valuePM <= 0) ? 0 : 1;
        } else if ($data['sub_parameter_type'] == 'Kriteria Quasi') {
            $d = ($valuePM <= $q) ? 0 : 1;
        } else if ($data['sub_parameter_type'] == 'Kriteria Linier & Area Indifference') {
            if ($valuePM <= $q) {
                $d = 0;
            } elseif ($valuePM <= $p) {
                $d = ($valuePM - $q) / ($p - $q);
            } else {
                $d = 1;
            }
        } else if ($data['sub_parameter_type'] == 'Kriteria Gaussian') {
            if ($valuePM <= 0) {
                $d = 0;
            } else {
                if ($data['standar_deviasi'] == 0) {
                    $data['standar_deviasi'] = 7.1518;
                }

                $d = 1 - exp(-pow($valuePM, 2) / (2 * pow($data['standar_deviasi'], 2)));
            }
        }
        return $d;
    }

    private function calculatePreferenceIndex($d, $subParameterCode)
    {
        $ModelSubParameters = new ModelSubParameters();
        $data = $ModelSubParameters->where('sub_parameter_code', $subParameterCode)->first();
        $absoluteWeight = $data['absolute_weight'];

        return $d * $absoluteWeight;
    }
}
