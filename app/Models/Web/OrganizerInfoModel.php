<?php

namespace App\Models\Web;

use CodeIgniter\Model;

class OrganizerInfoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pomar3h6kso5ild';
    protected $primaryKey       = 'info_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['or_id', 'or_firstname', 'or_lastname', 'or_company_name', 'or_company_address', 'or_company_email', 'or_company_phone', 'or_country', 'or_website', 'or_twitter', 'or_instagram', 'or_company_desc'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'or_created_at';
    protected $updatedField  = 'or_updated_at';

    // Get user profile info
    public function getProfileInfo($id){
        $builder = $this->db->table('pomar3h6kso5ild');
        $builder->join('users', 'users.id=pomar3h6kso5ild.or_id');
        $builder->join('countries', 'countries.shortname=pomar3h6kso5ild.or_country');
        $builder->where(['info_id' => $id]);
        return $builder->get()->getRow();
    }

    // Get Countries
    public function getCountries(){
        $builder = $this->db->table('countries');
        $builder->orderBy('country_name', 'ASC');
        return $builder->get()->getResult();
    }

    // Get user security settings
    public function getUserSettings($id){
        $builder = $this->db->table('auth_identities');
        $builder->where(['user_id' => $id]);
        return $builder->get()->getRow();
    }

}
