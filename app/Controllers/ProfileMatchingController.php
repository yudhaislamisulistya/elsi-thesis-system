<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBatchs;

class ProfileMatchingController extends BaseController
{
    public $ModelBatchs;
    public function __construct()
    {
        $this->ModelBatchs = new ModelBatchs();
    }
    public function index()
    {
        $data = [
            'title'         => 'Profile Matching',
            'data' => $this->ModelBatchs->orderBy('id', 'desc')->findAll()
        ];
        return view('role/hrd/profile_matching', compact('data'));
    }
}
