<?php

namespace App\Models\Organizer;

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
    public function getAllParticipants($id)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->join('0l3m5ccavrkqywj', '0l3m5ccavrkqywj.edref=vuzpq4kzjwmgblc.cedition');
        $builder->join('countries', 'countries.shortname=vuzpq4kzjwmgblc.ccountry');
        $builder->where('cauthor', $id);
        $builder->orderBy('cid', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }
    
    public function getParticipantDetails($id)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->join('0l3m5ccavrkqywj', '0l3m5ccavrkqywj.edref=vuzpq4kzjwmgblc.cedition');
        $builder->join('countries', 'countries.shortname=vuzpq4kzjwmgblc.ccountry');
        $builder->where('cid', $id);
        $results = $builder->get()->getRow();
        return $results;
    }

    // Filter Contestants
    public function filterAllParticipants($id, $date, $project)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->join('0l3m5ccavrkqywj', '0l3m5ccavrkqywj.edref=vuzpq4kzjwmgblc.cedition');
        $builder->join('countries', 'countries.shortname=vuzpq4kzjwmgblc.ccountry');
        $builder->where(['cauthor' => $id, 'cyear' => $date, 'cedition' => $project]);
        $builder->orderBy('cvotes', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }
    
    // Get Editions
    public function getAllEditions($id)
    {
        $builder = $this->db->table('0l3m5ccavrkqywj');
        $builder->where(['edauthor' => $id]);
        $builder->orderBy('edid', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }
}
