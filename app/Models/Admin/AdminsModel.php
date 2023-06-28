<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class AdminsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'active'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // get all admins
    public function getAllAdmins()
    {
        $builder = $this->db->table('users');
        $builder->join('auth_identities', 'auth_identities.user_id=users.id');
        $results = $builder->get()->getResult();
        return $results;
    }

}
