<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class AuthIdentitiesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'auth_identities';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'type', 'name', 'secret', 'secret2', 'force_reset' ,'last_used_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
}
