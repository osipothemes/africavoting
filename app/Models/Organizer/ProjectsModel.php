<?php

namespace App\Models\Organizer;

use CodeIgniter\Model;

class ProjectsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'afrv_organ_projects';
    protected $primaryKey       = 'pid';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['pref', 'pname', 'peditions', 'pdescription', 'pslug', 'pauthor', 'pcreators'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'pcreated_at';
    protected $updatedField  = 'pupdated_at';

    // Get All Projects
    public function getAllProjects()
    {
        $builder = $this->db->table('afrv_organ_projects');
        $builder->orderBy('pid', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }

    // Get Project Details
    public function getProjectDetails($id)
    {
        $builder = $this->db->table('afrv_organ_projects');
        $builder->where('pid', $id);
        $results = $builder->get()->getRow();
        return $results;
    }
}
