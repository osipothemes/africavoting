<?php

namespace App\Models\Admin;

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
    protected $allowedFields    = ['edref', 'edname', 'edproject', 'edslug', 'edbanner', 'edsimage', 'edvenues', 'edstart', 'edend', 'edvotingend', 'edauthor', 'edvotes', 'edviews', 'edboosts', 'edstatus'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'edcreated_at';
    protected $updatedField  = 'edupdated_at';

    // Get All Projects
    public function getAllEditions()
    {
        $builder = $this->db->table('0l3m5ccavrkqywj');
        $builder->orderBy('edid', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }

    // Get Running Editions
    public function getRunningEditions($date)
    {
        $builder = $this->db->table('0l3m5ccavrkqywj');
        $builder->where('edend >=', $date);
        $builder->orderBy('edid', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }

    // Get All Ended Editions
    public function getEndedEditions($date)
    {
        $builder = $this->db->table('0l3m5ccavrkqywj');
        $builder->where('edend <=', $date);
        $builder->orderBy('edid', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }

    // Get Project Details
    public function getEditionsDetails($id)
    {
        $builder = $this->db->table('0l3m5ccavrkqywj');
        $builder->join('afrv_organ_projects', 'afrv_organ_projects.pref=0l3m5ccavrkqywj.edproject');
        $builder->join('pomar3h6kso5ild', 'pomar3h6kso5ild.or_id=0l3m5ccavrkqywj.edauthor');
        $builder->where('edid', $id);
        $results = $builder->get()->getRow();
        return $results;
    }
}
