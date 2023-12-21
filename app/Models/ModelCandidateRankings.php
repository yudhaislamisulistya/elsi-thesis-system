<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCandidateRankings extends Model
{
    protected $table            = 'candidate_rankings';
    protected $primaryKey       = 'candidate_ranking_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "candidate_code",
        "ranking",
        "leaving_flow",
        "entering_flow",
        "net_flow",
        "batch_code"
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function insertOrUpdate($data)
    {
        $existingRecord = $this->where('batch_code', $data['batch_code'])
            ->where('candidate_code', $data['candidate_code'])
            ->first();

        if ($existingRecord) {
            return $this->update($existingRecord['candidate_ranking_id'], $data);
        } else {
            return $this->insert($data);
        }
    }
}
