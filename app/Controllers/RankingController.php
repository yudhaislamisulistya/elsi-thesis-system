<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBatchs;
use App\Models\ModelCandidateRankings;

class RankingController extends BaseController
{
    public $ModelCandidateRankings;
    public $ModelBatchs;
    public function __construct()
    {
        $this->ModelCandidateRankings = new ModelCandidateRankings();
        $this->ModelBatchs = new ModelBatchs();
    }
    public function index()
    {
        $data = [
            'title'         => 'Ranking',
            'data' => $this->ModelBatchs->orderBy('id', 'desc')->findAll()
        ];

        return view('role/hrd/ranking', compact('data'));
    }

    public function detail($batch_code)
    {
        $data = [
            'title'         => 'Ranking',
            'data' => $this->ModelCandidateRankings->where('batch_code', $batch_code)->findAll()
        ];

        return view('role/hrd/detail_ranking', compact('data'));
    }
}
