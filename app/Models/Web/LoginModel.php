<?php

namespace App\Models\Web;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $DBGroup          = 'default';

    // Check google user
    public function google_user_exists($email)
    {
        $builder = $this->db->table('auth_identities');
        $builder->where('secret', $email);
        if ($builder->countAllResults() == 1) {
            return true;
        } else {
            return false;
        }
    }

    // Update Users table
    public function updateUsersTable($data, $id)
    {
        $builder = $this->db->table('users');
        $builder->where('id', $id);
        $builder->update($data);
        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    // Update google user
    public function updateGoogleUser($data, $email)
    {
        $builder = $this->db->table('auth_identities');
        $builder->where('secret', $email);
        $builder->update($data);
        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    // Create google user
    public function create_google_user($data)
    {
        $builder = $this->db->table('auth_identities');
        $res = $builder->insert($data);
        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }
}
