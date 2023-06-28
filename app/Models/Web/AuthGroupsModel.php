<?php

namespace App\Models\Web;

use CodeIgniter\Model;

class AuthGroupsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'auth_groups_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'group'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
}
