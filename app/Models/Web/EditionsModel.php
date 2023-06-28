<?php

namespace App\Models\Web;

use CodeIgniter\Model;

class EditionsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = '0l3m5ccavrkqywj';
    protected $primaryKey       = 'edid';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    
}
