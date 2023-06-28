<?php

namespace App\Models\Web;

use CodeIgniter\Model;

class HomeModel extends Model
{
    protected $DBGroup          = 'default';

    // Get All Editions
    public function getAllEditions()
    {
        $builder = $this->db->table('0l3m5ccavrkqywj');
        $builder->orderBy('edid', 'DESC');
        $builder->limit(3);
        $results = $builder->get()->getResult();
        return $results;
    }

    public function getExpiredEditions($date)
    {
        $builder = $this->db->table('0l3m5ccavrkqywj');
        // $builder->join('org_projects', 'org_projects.pref=editions.edproject');
        $builder->join('afrv_organ_projects', 'afrv_organ_projects.pref=0l3m5ccavrkqywj.edproject');
        $builder->where('edstatus', 3);
        $builder->orderBy('edid', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }

    // Get Edition Details
    public function getEditionDetails($id)
    {
        $builder = $this->db->table('0l3m5ccavrkqywj');
        // $builder->join('org_projects', 'org_projects.pref=editions.edproject');
        $builder->join('afrv_organ_projects', 'afrv_organ_projects.pref=0l3m5ccavrkqywj.edproject');
        $builder->where('edref', $id);
        $results = $builder->get()->getRow();
        return $results;
    }

    public function getEditionCountries($id)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->join('countries', 'countries.shortname=vuzpq4kzjwmgblc.ccountry');
        $builder->where('cedition', $id);
        $builder->groupBy('ccountry');
        $results = $builder->get()->getResult();
        return $results;
    }

    public function getEditionParticipants($id)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->join('countries', 'countries.shortname=vuzpq4kzjwmgblc.ccountry');
        $builder->join('0l3m5ccavrkqywj', '0l3m5ccavrkqywj.edref=vuzpq4kzjwmgblc.cedition');
        $builder->where('cedition', $id);
        $builder->orderBy('cvotes', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }

    public function getEditionRanking($id)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->join('countries', 'countries.shortname=vuzpq4kzjwmgblc.ccountry');
        $builder->join('0l3m5ccavrkqywj', '0l3m5ccavrkqywj.edref=vuzpq4kzjwmgblc.cedition');
        $builder->where('cedition', $id);
        $builder->orderBy('cvotes', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }

    // Get participant details
    public function getParticipantsDetails($id)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->join('countries', 'countries.shortname=vuzpq4kzjwmgblc.ccountry');
        $builder->join('0l3m5ccavrkqywj', '0l3m5ccavrkqywj.edref=vuzpq4kzjwmgblc.cedition');
        // $builder->join('org_projects', 'org_projects.pref=vuzpq4kzjwmgblc.cproject');
        $builder->join('afrv_organ_projects', 'afrv_organ_projects.pref=vuzpq4kzjwmgblc.cproject');
        $builder->where('cref', $id);
        $results = $builder->get()->getRow();
        return $results;
    }

    // Sum Votes
    public function getTotalVotes($id)
    {
        $builder = $this->db->table('vuzpq4kzjwmgblc');
        $builder->selectSum('cvotes');
        $builder->where('cedition', $id);
        return $builder->get()->getRow();
    }

    // Search Data
    public function getSearchData($data)
    {
        $builder = $this->db->table('0l3m5ccavrkqywj');
        $builder->select('*');
        $builder->like($data);
        $builder->orderBy('edid', 'DESC');
        return $builder->get()->getResult();
    }

    // Get all countries
    public function getAllCountris()
    {
        $builder = $this->db->table('countries');
        $builder->orderBy('country_name', 'DESC');
        $results = $builder->get()->getResult();
        return $results;
    }
}
