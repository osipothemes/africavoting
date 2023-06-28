<?php

namespace App\Models\Web;

use CodeIgniter\Model;

class BoostsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'boosts';
    protected $primaryKey       = 'boosts';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['trans_id', 'contestant_ref', 'contestants_names', 'boost_amount', 'boost_email', 'boost_status', 'boost_dates'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
