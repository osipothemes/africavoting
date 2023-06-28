<?php

namespace App\Models\Web;

use CodeIgniter\Model;

class BoostingActivityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'boosting_activity';
    protected $primaryKey       = 'boostingid';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['boosting_ref', 'boosted_participant', 'booster_email', 'boosted_project', 'boosted_edition', 'boosted_date', 'boostedamount', 'boostmethod'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
}
