<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ContestantsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'vuzpq4kzjwmgblc';
    protected $primaryKey       = 'cid';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['cref', 'cnames', 'cslug', 'ccountry', 'cimage', 'cvotes', 'cviews', 'cboost', 'cproject', 'cedition', 'cyear', 'cauthor'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'ccreated_at';
    protected $updatedField  = 'cupdated_at';

    // Get All Participants
    public function getAllParticipants()
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->join('0l3m5ccavrkqywj', '0l3m5ccavrkqywj.edref=vuzpq4kzjwmgblc.cedition');
        $builder->join('countries', 'countries.shortname=vuzpq4kzjwmgblc.ccountry');
        $builder->orderBy('cid', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }
    
    public function getParticipantDetails($id)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->join('0l3m5ccavrkqywj', '0l3m5ccavrkqywj.edref=vuzpq4kzjwmgblc.cedition');
        $builder->join('countries', 'countries.shortname=vuzpq4kzjwmgblc.ccountry');
        $builder->join('pomar3h6kso5ild', 'pomar3h6kso5ild.or_id=vuzpq4kzjwmgblc.cauthor');
        $builder->where('cid', $id);
        $results = $builder->get()->getRow();
        return $results;
    }

    // Get Participant Organizer
    public function getOrganizers()
    {
        $builder = $this->db->table('pomar3h6kso5ild');
        $builder->orderBy('info_id', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }
}
