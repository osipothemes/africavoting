<?php

namespace App\Models\Organizer;

use CodeIgniter\Model;

class HomeModel extends Model
{
    protected $DBGroup          = 'default';

    // Get country info
    public function getCountryInfo($id)
    {
        $builder = $this->db->table('countries');
        $builder->where('shortname', $id);
        return $builder->get()->getRow();
    }

    // Get Organizer projects
    public function getOrganizerProjects($id)
    {
        // $builder = $this->db->table('projects');
        $builder = $this->db->table('afrv_organ_projects');
        $builder->where('pauthor', $id);
        return $builder->get()->getResult();
    }

    // Count Projects
    public function getCountProjects($id)
    {
        // $builder = $this->db->table('projects');
        $builder = $this->db->table('afrv_organ_projects');
        $builder->where('pauthor', $id);
        return $builder->countAllResults();
    }

    public function getCountViews($id)
    {
        $builder = $this->db->table('0l3m5ccavrkqywj');
        $builder->selectSum('edviews');
        $builder->where('edauthor', $id);
        return $builder->get()->getRow();
    }

    public function getCountParticipants($id)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->where('cauthor', $id);
        return $builder->countAllResults();
    }

    public function sumBoosts($id)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->selectSum('cboost');
        $builder->where('cauthor', $id);
        return $builder->get()->getRow();
    }

    // Get All Participants
    public function getRecentParticipants($id)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->join('0l3m5ccavrkqywj', '0l3m5ccavrkqywj.edref=vuzpq4kzjwmgblc.cedition');
        $builder->join('countries', 'countries.shortname=vuzpq4kzjwmgblc.ccountry');
        $builder->where(['cauthor' => $id]);
        $builder->orderBy('cvotes', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }
}
