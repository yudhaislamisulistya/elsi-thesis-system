

<?php

use App\Models\ModelCandidateRankings;
use App\Models\ModelGradeSubParameters;
use App\Models\ModelSubParameterCandidates;
use App\Models\ModelSubParameters;
use App\Models\ModelUsers;

function get_sub_parameter_by_code($code_sub_parameter)
{
    $ModelSubParameters = new ModelSubParameters();
    $data = $ModelSubParameters->where('sub_parameter_code', $code_sub_parameter)->first();

    if ($data) {
        return $data;
    } else {
        return false;
    }
}

function check_history_ranking_by_batch_code($batch_code)
{
    $ModelCandidateRankings = new ModelCandidateRankings();
    $data = $ModelCandidateRankings->where('batch_code', $batch_code)->first();

    if ($data) {
        return true;
    } else {
        return false;
    }
}

function check_grade_sub_parameter($code_sub_parameter)
{
    $ModelSubParameters = new ModelGradeSubParameters();
    $data = $ModelSubParameters->where('sub_parameter_code', $code_sub_parameter)->first();

    if ($data) {
        return true;
    } else {
        return false;
    }
}

function get_user_by_candidate_code($candidate_code)
{
    $ModelUsers = new ModelUsers();
    $data = $ModelUsers->where('code', $candidate_code)->first();

    if ($data) {
        return $data;
    } else {
        return false;
    }
}

function get_value_pm_sub_parameter_candidate($candidate_code, $batch_code, $sub_parameter_code)
{
    $ModelSubParameterCandidates = new ModelSubParameterCandidates();
    $data = $ModelSubParameterCandidates->where([
        'candidate_code' => $candidate_code,
        'batch_code' => $batch_code,
        'sub_parameter_code' => $sub_parameter_code
    ])->first();

    if ($data) {
        return $data['valuePM'];
    } else {
        return 0;
    }
}

function get_value_grade_sub_parameter_candidate($candidate_code, $batch_code, $sub_parameter_code)
{
    $ModelSubParameterCandidates = new ModelSubParameterCandidates();
    $data = $ModelSubParameterCandidates->where([
        'candidate_code' => $candidate_code,
        'batch_code' => $batch_code,
        'sub_parameter_code' => $sub_parameter_code
    ])->first();

    if ($data) {
        return $data['value'];
    } else {
        return 0;
    }
}

function calculate_gap_sub_parameter($candidate_code, $batch_code, $sub_parameter_code)
{
    $ModelSubParameterCandidates = new ModelSubParameterCandidates();
    $data = $ModelSubParameterCandidates->where([
        'candidate_code' => $candidate_code,
        'batch_code' => $batch_code,
        'sub_parameter_code' => $sub_parameter_code
    ])->first();

    if ($data) {
        $ModelGradeSubParameters = new ModelGradeSubParameters();
        $ModelSubParameters = new ModelSubParameters();
        $subParameter = $ModelSubParameters->where('sub_parameter_code', $sub_parameter_code)->first();

        $subParameterCalculation = $subParameter['calculation'];
        $subParameterTarget = $subParameter['target'];
        if ($subParameterCalculation == 'Rating dan Profile Matching') {
            $gap = $ModelGradeSubParameters->where('description', $subParameterTarget)->first();
            $gap = $gap['value'];
            return $data['value'] - $gap;
        } else if ($subParameterCalculation == 'Profile Matching') {
            $batasBawah = trim(explode('-', $subParameterTarget)[0]);
            $batasAtas = trim(explode('-', $subParameterTarget)[1]);
            $batasAtas = str_replace(' Tahun', '', $batasAtas);
            if ($data['value'] < $batasBawah) {
                $result = $data['value'] - $batasBawah;
            } elseif ($data['value'] > $batasAtas) {
                $result = $data['value'] - $batasAtas;
            } else {
                $result = 0;
            }
            return $result;
        } else if ($subParameterCalculation == 'Benefit') {
            return $data['value'];
        } else if ($subParameterCalculation == 'Cost') {
            return $data['value'];
        } else {
            return $data['value'];
        }
    } else {
        return 0;
    }
}

function get_user_by_id($user_id)
{
    $ModelUsers = new \App\Models\ModelUsers();
    $data = $ModelUsers->where('user_id', $user_id)->first();

    if ($data) {
        return $data;
    } else {
        return false;
    }
}

function calculateMaxMinPerColumn($columnValues)
{
    $maxValues = $minValues = [];

    foreach ($columnValues as $subParameterCode => $values) {
        $maxValues[$subParameterCode] = max($values);
        $minValues[$subParameterCode] = min($values);
    }

    return ['maxValues' => $maxValues, 'minValues' => $minValues];
}

function check_except_sub_parameter($sub_parameter_code)
{
    $ModelSubParameters = new ModelSubParameters();
    $data = $ModelSubParameters->where('sub_parameter_code', $sub_parameter_code)->first();

    if ($data) {
        if ($data['calculation'] != 'Rating') {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function check_sub_parameter_target_is_range($sub_parameter_code)
{
    $ModelSubParameters = new ModelSubParameters();
    $data = $ModelSubParameters->where('sub_parameter_code', $sub_parameter_code)->first();
    return $data && strpos($data['target'], '-') !== false;
}

function calculate_scoring($candidate_code, $batch_code, $sub_parameter_code, $current_value, $max, $min)
{
    $ModelSubParameterCandidates = new ModelSubParameterCandidates();
    $data = $ModelSubParameterCandidates->where([
        'candidate_code' => $candidate_code,
        'batch_code' => $batch_code,
        'sub_parameter_code' => $sub_parameter_code
    ])->first();

    $totalDistinctSubParameterCode = $ModelSubParameterCandidates->select('sub_parameter_code')->distinct()->where('batch_code', $batch_code)->countAllResults();
    $totalDisctinctCandidateCode = $ModelSubParameterCandidates->select('candidate_code')->distinct()->where('batch_code', $batch_code)->countAllResults();

    if ($data) {
        $ModelSubParameters = new ModelSubParameters();
        $subParameter = $ModelSubParameters->where('sub_parameter_code', $sub_parameter_code)->first();

        $subParameterCalculation = $subParameter['calculation'];
        if ($subParameterCalculation == 'Rating dan Profile Matching') {
            if ($current_value >= 0) {
                return round($totalDisctinctCandidateCode, 4);
            } else {
                if ($max === $min) {
                    return null;
                }
                return round((($current_value - $min) * ($totalDisctinctCandidateCode - 1) / ($max - $min)) + 1, 4);
            }
        } else if ($subParameterCalculation == 'Profile Matching') {
            if ($current_value === 0) {
                return round($totalDisctinctCandidateCode, 4);
            } else if ($current_value < 0) {
                if ($max === 0) {
                    return null;
                }
                return (($current_value + $max) * ($totalDisctinctCandidateCode - 1) / $max) + 1;
            } else {
                if ($max === 0) {
                    return null;
                }
                return (($current_value * (1 - $totalDisctinctCandidateCode) / $max) + $totalDisctinctCandidateCode);
            }
        } else if ($subParameterCalculation == 'Benefit') {
            if ($max === $min) {
                return null;
            }
            return round((($current_value - $min) * ($totalDisctinctCandidateCode - 1) / ($max - $min)) + 1, 4);
        } else if ($subParameterCalculation == 'Cost') {
            $result = (($current_value - $min) * (1 - $totalDisctinctCandidateCode) / ($max - $min)) + $totalDisctinctCandidateCode;

            return round($result, 4);
        } else {
            return round($current_value, 4);
        }
    } else {
        return 0;
    }
}




?>