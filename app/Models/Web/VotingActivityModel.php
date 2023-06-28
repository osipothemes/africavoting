<?php

namespace App\Models\Web;

use CodeIgniter\Model;

class VotingActivityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = '0z2aay19hqmgsf4';
    protected $primaryKey       = 'votingid';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['voting_ref', 'voted_participant', 'voter_email', 'voted_project', 'voted_edition', 'vote_date'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';

    // Check if user already voted today
    public function checkIfVoted($email, $project, $edition)
    {
        $builder = $this->db->table('0z2aay19hqmgsf4');
        $builder->where(['voter_email' => $email, 'voted_project' => $project, 'voted_edition' => $edition, 'vote_date' => date('Y-m-d')]);
        $results = $builder->countAllResults();
        return $results;
    }
}
