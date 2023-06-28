<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class HomeModel extends Model
{
    protected $DBGroup          = 'default';
    
    // Get active organizers
    public function getActiveOrganiers(){
        $builder = $this->db->table('pomar3h6kso5ild');
        $builder->join('auth_identities', 'auth_identities.user_id=pomar3h6kso5ild.or_id');
        $builder->join('users', 'users.id=pomar3h6kso5ild.or_id');
        $builder->join('countries', 'countries.shortname=pomar3h6kso5ild.or_country');
        $builder->where('or_active', 1);
        $builder->orderBy('info_id', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }

    // Get pending organizers
    public function getPendingOrganiers(){
        $builder = $this->db->table('pomar3h6kso5ild');
        $builder->join('auth_identities', 'auth_identities.user_id=pomar3h6kso5ild.or_id');
        $builder->join('users', 'users.id=pomar3h6kso5ild.or_id');
        $builder->join('countries', 'countries.shortname=pomar3h6kso5ild.or_country');
        $builder->where('or_active', 0);
        $builder->orderBy('info_id', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }

    // Activate
    public function getOrganierDetails($id){
        $builder = $this->db->table('pomar3h6kso5ild');
        $builder->join('auth_identities', 'auth_identities.user_id=pomar3h6kso5ild.or_id');
        $builder->join('users', 'users.id=pomar3h6kso5ild.or_id');
        $builder->join('countries', 'countries.shortname=pomar3h6kso5ild.or_country');
        $builder->where('or_id', $id);
        $results = $builder->get()->getRow();
        return $results;
    }
    
    // Count Projects
    public function countProjects(){
        $builder = $this->db->table('afrv_organ_projects');
        return $builder->countAllResults();
    }

    // Count Editions
    public function countEditions(){
        $builder = $this->db->table('0l3m5ccavrkqywj');
        return $builder->countAllResults();
    }

    // Count Organizers
    public function countOrganizers(){
        $builder = $this->db->table('pomar3h6kso5ild');
        return $builder->countAllResults();
    }

    // Count Users
    public function countUsers(){
        $builder = $this->db->table('auth_groups_users');
        $builder->where('group', 'user');
        return $builder->countAllResults();
    }

    // Sum Boosts
    public function sumBoosts(){
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->selectSum('cboost');
        return $builder->get()->getRow();
    }

    // Sum Votes
    public function sumVotes(){
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->selectSum('cvotes');
        return $builder->get()->getRow();
    }

    // Sum Views
    public function sumViews(){
        $builder = $this->db->table('0l3m5ccavrkqywj');
        $builder->selectSum('edviews');
        return $builder->get()->getRow();
    }

}
