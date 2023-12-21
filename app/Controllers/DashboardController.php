<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBatchs;
use App\Models\ModelParameters;
use App\Models\ModelSubParameters;
use App\Models\ModelUsers;

class DashboardController extends BaseController
{
    public $ModelUsers;
    public $ModelParameters;
    public $ModelSubParameters;
    public $ModelBatchs;
    public function __construct()
    {
        $this->ModelUsers = new ModelUsers();
        $this->ModelParameters = new ModelParameters();
        $this->ModelSubParameters = new ModelSubParameters();
        $this->ModelBatchs = new ModelBatchs();
    }

    public function dashboard_hrd()
    {
        $userRole = session()->get('role');

        if ($userRole !== 'HRD') {
            return redirect()->to(base_url('candidate/dashboard'));
        } else {
            $data = [
                'title' => 'Dashboard HRD',
                'totalCandidate' => $this->ModelUsers->where('role', 'CANDIDATE')->countAllResults(),
                'totalParameter' => $this->ModelParameters->countAllResults(),
                'totalSubParameter' => $this->ModelSubParameters->countAllResults(),
                'totalBatch' => $this->ModelBatchs->countAllResults(),
                'fiveLatestCandidate' => $this->ModelUsers->where('role', 'CANDIDATE')->orderBy('user_id', 'DESC')->findAll(5),
            ];

            return view('role/hrd/dashboard', compact('data'));
        }
    }

    public function dashboard_candidate()
    {
        $userRole = session()->get('role');

        if ($userRole !== 'CANDIDATE') {
            return redirect()->to(base_url('hrd/dashboard'));
        } else {
            $data = [
                'title' => 'Dashboard HRD',
                'totalCandidate' => $this->ModelUsers->where('role', 'CANDIDATE')->countAllResults(),
                'totalParameter' => $this->ModelParameters->countAllResults(),
                'totalSubParameter' => $this->ModelSubParameters->countAllResults(),
                'totalBatch' => $this->ModelBatchs->countAllResults(),
                'fiveLatestCandidate' => $this->ModelUsers->where('role', 'CANDIDATE')->orderBy('user_id', 'DESC')->findAll(5),
            ];

            return view('role/candidate/dashboard', compact('data'));
        }
    }
}
