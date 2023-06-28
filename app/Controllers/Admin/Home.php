<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;
use App\Models\Admin\ProjectsModel;
use App\Models\Admin\EditionsModel;
use App\Models\Admin\ContestantsModel;
use App\Models\Admin\AuthIdentitiesModel;
use App\Models\Admin\AuthGroupsModel;
use App\Models\Admin\HomeModel;
use App\Models\Admin\AdminsModel;

class Home extends BaseController
{
    public $projects;
    public $editions;
    public $participants;
    protected $auth;
	protected $config;
    public $email;
    public $home;
    public $admins;
    public $identity;
    public $groups;
    public $db;

    public function __construct()
    {
        $this->projects = new ProjectsModel();
        $this->editions = new EditionsModel();
        $this->participants = new ContestantsModel();
        $this->home = new HomeModel();
        $this->admins = new AdminsModel();
        $this->identity = new AuthIdentitiesModel();
        $this->groups = new AuthGroupsModel();
        $this->config = config('Auth');
		$this->auth = service('authentication');
        $this->db = \Config\Database::connect();
        $this->email = \Config\Services::email();
        $this->session = session();
    }

    public function index()
    {
        $data = [
            'page_title' => 'Dashboard',
            'projects' => $this->home->countProjects(),
            'editions' => $this->home->countEditions(),
            'organizers' => $this->home->countOrganizers(),
            'users' => $this->home->countUsers(),
            'sumBoosts' => $this->home->sumBoosts(),
            'sumViews' => $this->home->sumViews(),
            'sumVotes' => $this->home->sumVotes()
        ];

        return view("admin/index", $data);
    }

    // Active organizers
    public function active_organizers(){
        $data = [
            'page_title' => 'Organizers',
            'organizers' => $this->home->getActiveOrganiers()
        ];

        return view("admin/organizers/active", $data);
    }

    // Pending Organizers
    public function pending_organizers(){
        $data = [
            'page_title' => 'Organizers',
            'organizers' => $this->home->getPendingOrganiers()
        ];

        return view("admin/organizers/pending", $data);
    }

    // Activate Organizer
    public function activate_organizer($id){

        if ($this->request->getMethod() == 'post') {

            $userQuery = $this->db->query("SELECT * FROM users WHERE id=".$this->db->escape($id)."")->getRow();

            if($userQuery->active == 0){

                $result = $this->db->query("UPDATE users SET active=".$this->db->escape(1)." WHERE id=".$this->db->escape($id)."");

                if($result){

                    $config = config('Auth');

                    if (
                        (defined('PASSWORD_ARGON2I') && $config->hashAlgorithm == PASSWORD_ARGON2I)
                        ||
                        (defined('PASSWORD_ARGON2ID') && $config->hashAlgorithm == PASSWORD_ARGON2ID)
                    )
                    {
                        $hashOptions = [
                            'memory_cost' => $config->hashMemoryCost,
                            'time_cost'   => $config->hashTimeCost,
                            'threads'     => $config->hashThreads,
                        ];
                    }
                    else
                    {
                        $hashOptions = [
                            'cost' => $config->hashCost,
                        ];
                    }

                    $password = random_string('alnum', 8);
                    $passwordHash = password_hash(self::preparePassword($password),$this->config->hashAlgorithm,$hashOptions);

                    $this->db->query("UPDATE auth_identities SET secret2=".$this->db->escape($passwordHash)." WHERE user_id=".$this->db->escape($id)."");

                    $this->db->query("UPDATE pomar3h6kso5ild SET or_active=".$this->db->escape(1)." WHERE or_id=".$this->db->escape($id)."");

                    $user = $this->home->getOrganierDetails($id);

                    // $from = "info@africavotes.info";
                    // $company = "AfricaVotes";
                    $names = $user->or_firstname . " " .  $user->or_lastname;
                    $subject = "Account Activation";
                    $message = "Hello ".$names. "; Your Account at AfricaVoting has been activated successfully, Please login with your email: ".$user->or_company_email." and Password: ".$password." You will be able to update your password from your account. Thank You.";

                    // $this->email->setFrom($from, $company);
                    $this->email->setTo($user->or_company_email);
                    $this->email->setCC('joshuaosipo@gmail.com');
                    $this->email->setSubject($subject);
                    $this->email->setMessage($message);
                    $this->email->send();

                    $this->session->setTempdata('success', 'Account Activated successfully', 3);
                    return redirect()->back();
                }else{
                    $this->session->setTempdata('error', 'Error updating Account', 3);
                    return redirect()->back();
                }
            }else{
                $result = $this->db->query("UPDATE users SET active=".$this->db->escape(0)." WHERE id=".$this->db->escape($id)."");
                if($result){
                    $this->db->query("UPDATE pomar3h6kso5ild SET or_active=".$this->db->escape(0)." WHERE or_id=".$this->db->escape($id)."");
                    $this->session->setTempdata('success', 'Account updated successfully', 3);
                    return redirect()->back();
                }else{
                    $this->session->setTempdata('error', 'Error updating Account', 3);
                    return redirect()->back();
                }
            }
        }

    }

    // Admins
    public function all_admins(){
        $data = [
            'page_title' => 'Admins',
            'admins' => $this->admins->getAllAdmins()
        ];

        return view("admin/admins/all_admins", $data);
    }

    // Create Admin
    public function add_admins(){
        $data = [
            'page_title' => 'Add Admins',
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'email' => 'required|valid_email|is_unique[auth_identities.secret]',
                'username' => 'required|min_length[6]|is_unique[users.username]',
                'password' => 'required|min_length[8]|strong_password',
                'cpassword' => 'required|matches[password]',
            ];

            $messages = [
                'password' => [
                    'required' => 'Password field is required',
                    'min_length' => 'Password cannot be less than 8 characters',
                    'strong_password' => 'Please supply a strong password'
                ],
                'cpassword' => [
                    'required' => 'Confirm password is required',
                    'matches' => 'The two passwords donot match'
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {

                $config = config('Auth');

                if (
                    (defined('PASSWORD_ARGON2I') && $config->hashAlgorithm == PASSWORD_ARGON2I)
                    ||
                    (defined('PASSWORD_ARGON2ID') && $config->hashAlgorithm == PASSWORD_ARGON2ID)
                )
                {
                    $hashOptions = [
                        'memory_cost' => $config->hashMemoryCost,
                        'time_cost'   => $config->hashTimeCost,
                        'threads'     => $config->hashThreads,
                    ];
                }
                else
                {
                    $hashOptions = [
                        'cost' => $config->hashCost,
                    ];
                }

                $password = $this->request->getVar('password');
                $passwordHash = password_hash(self::preparePassword($password),$this->config->hashAlgorithm,$hashOptions);

                $data = [
                    'username' => $this->request->getVar('username'),
                    'active' => 1
                ];

                $result = $this->admins->save($data);

                if($result){

                    $userid = $this->admins->getInsertID();

                    $identityTable = [
                        'user_id' => $userid,
                        'type' => "email_password",
                        'secret' => $this->request->getVar('email'),
                        'secret2' => $passwordHash,
                        'force_reset' => 0,

                    ];

                    $this->identity->save($identityTable);

                    $groupTable = [
                        'user_id' => $userid,
                        'group' => "admin",
                    ];

                    $this->groups->save($groupTable);

                    $this->session->setTempdata('success', 'Admin created successfully', 3);
                    return redirect()->to(current_url());
                }else{
                    $this->session->setTempdata('error', 'Failed to create admin', 3);
                    return redirect()->to(current_url());
                }


            }
    
        }

        return view("admin/admins/add_admin", $data);
    }

    protected static function preparePassword(string $password): string
	{
		return base64_encode(hash('sha384', $password, true));
	}

    // PROJECTS
    public function projects_list()
    {
        $data = [
            'page_title' => 'All Projects',
            'projects' => $this->projects->getAllProjects()
        ];

        return view("admin/projects/all_projects", $data);
    }

    public function add_project()
    {
        $data = [
            'page_title' => 'Add Project',
            'organizers' => $this->db->query("SELECT * FROM pomar3h6kso5ild WHERE or_active=".$this->db->escape(1)."")->getResult()
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'name' => 'required|is_unique[afrv_organ_projects.pname]',
                'creators' => 'required',
                'description' => 'required',
            ];

            $messages = [
                'name' => [
                    'required' => 'Project name is required',
                    'is_unique' => 'Project name was already used before',
                ],
                'creators' => [
                    'required' => 'Project authors is required',
                ],
                'creators' => [
                    'required' => 'Project description is required',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {

                $pref = random_string("alnum", 15);
                $data = [
                    'pref' => $pref,
                    'pname' => $this->remove_quotes(ucwords($this->request->getVar('name'))),
                    'pslug' => url_title(strtolower($this->request->getVar('name')), '-', true),
                    'pdescription' => $this->remove_quotes($this->request->getVar('description')),
                    'pauthor' => $this->remove_quotes($this->request->getVar('creators')),
                ];

                $result = $this->projects->save($data);

                if ($result) {

                    $this->session->setTempdata('success', 'Project added successfully', 3);
                    return redirect()->to(current_url());
                } else {
                    $this->session->setTempdata('error', 'Sorry! Project could not be added, try again', 3);
                    return redirect()->to(current_url());
                }
            }
        }

        return view("admin/projects/add_project", $data);
    }

    public function edit_project($id)
    {
        $data = [
            'page_title' => 'Edit Project',
            'project' => $this->projects->getProjectDetails($id),
            'organizers' => $this->db->query("SELECT * FROM pomar3h6kso5ild WHERE or_active=".$this->db->escape(1)."")->getResult()
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'name' => 'required',
                'creators' => 'required',
                'description' => 'required',
            ];

            $messages = [
                'name' => [
                    'required' => 'Project name is required',
                ],
                'creators' => [
                    'required' => 'Project authors is required',
                ],
                'creators' => [
                    'description' => 'Project description is required',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {

                $data = [
                    'pname' => $this->remove_quotes($this->request->getVar('name')),
                    'pslug' => url_title(strtolower($this->request->getVar('name')), '-', true),
                    'pdescription' => $this->remove_quotes($this->request->getVar('description')),
                    'pauthor' => $this->remove_quotes($this->request->getVar('creators')),
                ];

                $result = $this->projects->update($id, $data);

                if ($result) {

                    $this->session->setTempdata('success', 'Project updated successfully', 3);
                    return redirect()->to(current_url());
                } else {
                    $this->session->setTempdata('error', 'Sorry! Project could not be updated, try again', 3);
                    return redirect()->to(current_url());
                }
            }
        }

        return view("admin/projects/edit_project", $data);
    }

    public function delete_project($id)
    {

        $query = $this->db->query("SELECT * FROM afrv_organ_projects WHERE pid=".$this->db->escape($id)."")->getRow();
        $this->db->query("DELETE FROM 0l3m5ccavrkqywj WHERE edproject=".$this->db->escape($query->pref)."");

        $result = $this->projects->delete($id);

        if ($result) {
            $this->session->setTempdata('success', 'Project deleted successfully', 3);
            return redirect()->to(base_url('admin/projects/all-projects'));
        } else {
            $this->session->setTempdata('error', 'Sorry! Project could not be deleted, try again', 3);
            return redirect()->to(base_url('admin/projects/all-projects'));
        }
    }

    public function editions_list()
    {
        $data = [
            'page_title' => 'All Editions',
            'editions' => $this->editions->getAllEditions()
        ];

        return view("admin/projects/all_editions", $data);
    }

    public function running_editions()
    {
        $data = [
            'page_title' => 'Running Editions',
            'editions' => $this->editions->getRunningEditions(date('Y-m-d'))
        ];

        return view("admin/projects/running_editions", $data);
    }

    public function ended_editions()
    {
        $data = [
            'page_title' => 'Ended Editions',
            'editions' => $this->editions->getEndedEditions(date('Y-m-d'))
        ];

        return view("admin/projects/ended_editions", $data);
    }

    public function add_edition()
    {
        $data = [
            'page_title' => 'Add Edition',
            'projects' => $this->projects->getAllProjects(),
            'organizers' => $this->db->query("SELECT * FROM pomar3h6kso5ild WHERE or_active=".$this->db->escape(1)."")->getResult()
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'name' => 'required|is_unique[0l3m5ccavrkqywj.edname]',
                'venues' => 'required',
                'sdate' => 'required',
                'edate' => 'required',
                'project' => 'required',
                'creators' => 'required',
                'status' => 'required',
                'banner' => [
                    'uploaded[banner]',
                    'mime_in[banner,image/png,image/jpg,image/jpeg,image/gif]',
                    'ext_in[banner,png,jpg,jpeg,gif]'
                ],
                'vend' => 'required',
            ];

            $messages = [
                'creators' => [
                    'required' => 'Edition Author is required',
                ],
                'name' => [
                    'required' => 'Edition title is required',
                    'is_unique' => 'Edition title was already used before',
                ],
                'venues' => [
                    'required' => 'Venue field is required',
                ],
                'sdate' => [
                    'required' => 'Start Date is required',
                ],
                'edate' => [
                    'required' => 'End Date is required',
                ],
                'project' => [
                    'required' => 'Project is required',
                ],
                'vend' => [
                    'required' => 'Voting end date is required',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {

                $banner = $this->request->getFile('banner');
                $newBanner = $banner->getRandomName();

                $simage = $this->request->getFile('sbanner');
                $newSimage = $simage->getRandomName();

                $pref = random_string("alnum", 15);
                $project = $this->request->getVar('project');

                $data = [
                    'edref' => $pref,
                    'edname' => $this->remove_quotes($this->request->getVar('name')),
                    'edslug' => url_title(strtolower($this->request->getVar('name')), '-', true),
                    'edproject' => $project,
                    'edbanner' => $newBanner,
                    'edsimage' => $newSimage,
                    'edvenues' => $this->remove_quotes($this->request->getVar('venues')),
                    'edstart' => $this->request->getVar('sdate'),
                    'edend' => $this->request->getVar('edate'),
                    'edvotingend' => $this->request->getVar('vend'),
                    'edauthor' => $this->remove_quotes($this->request->getVar('creators')),
                    'edvotes' => 0,
                    'edviews' => 0,
                    'edboosts' => 0,
                    'edstatus' => $this->remove_quotes($this->request->getVar('status'))
                ];

                $result = $this->editions->save($data);

                if ($result) {
                    $editions = $this->db->query("SELECT peditions FROM afrv_organ_projects WHERE pref=" . $this->db->escape($project) . "")->getRow();
                    $total = $editions->peditions + 1;

                    $this->db->query("UPDATE afrv_organ_projects SET peditions=" . $this->db->escape($total) . "");

                    $banner->move('assets/web/uploads/projects', $newBanner);
                    $simage->move('assets/web/uploads/projects', $newSimage);

                    $this->session->setTempdata('success', 'Project Edition added successfully', 3);
                    return redirect()->to(current_url());
                } else {
                    $this->session->setTempdata('error', 'Sorry! Project Edition could not be added, try again', 3);
                    return redirect()->to(current_url());
                }
            }
        }

        return view("admin/projects/add_edition", $data);
    }

    public function edit_edition($id)
    {

        $data = [
            'page_title' => 'Edit Edition',
            'projects' => $this->projects->getAllProjects(),
            'edition' => $this->editions->getEditionsDetails($id),
            'organizers' => $this->db->query("SELECT * FROM pomar3h6kso5ild WHERE or_active=".$this->db->escape(1)."")->getResult()
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'name' => 'required',
                'venues' => 'required',
                'sdate' => 'required',
                'edate' => 'required',
                'project' => 'required',
                'vend' => 'required',
                'status' => 'required',
                'creators' => 'required'
            ];

            $messages = [
                'name' => [
                    'required' => 'Edition title is required',
                ],
                'venues' => [
                    'required' => 'Venue field is required',
                ],
                'sdate' => [
                    'required' => 'Start Date is required',
                ],
                'edate' => [
                    'required' => 'End Date is required',
                ],
                'project' => [
                    'required' => 'Project is required',
                ],
                'vend' => [
                    'required' => 'Voting end date is required',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {

                if (!empty($_FILES['banner']['name'])) {
                    // Remove old image
                    $findFile = $this->editions->getEditionsDetails($id);
                    $old_img = $findFile->edbanner;

                    if (file_exists($old_img)) {
                        unlink('assets/web/uploads/projects/' . $old_img);
                    }

                    $banner = $this->request->getFile('banner');
                    $newBanner = $banner->getRandomName();
                }

                if (!empty($_FILES['sbanner']['name'])) {
                    // Remove old image
                    $findSfile = $this->editions->getEditionsDetails($id);
                    $old_simg = $findSfile->edsimage;

                    if (file_exists($old_simg)) {
                        unlink('assets/web/uploads/projects/' . $old_simg);
                    }

                    $sbanner = $this->request->getFile('sbanner');
                    $newSbanner = $sbanner->getRandomName();
                }

                $data = [
                    'edname' => $this->remove_quotes($this->request->getVar('name')),
                    'edslug' => url_title(strtolower($this->request->getVar('name')), '-', true),
                    'edproject' => $this->remove_quotes($this->request->getVar('project')),
                    'edauthor' => $this->remove_quotes($this->request->getVar('creators')),
                    'edbanner' => (!empty($_FILES['banner']['name']) ? $newBanner : $this->request->getVar('old_image')),
                    'edsimage' => (!empty($_FILES['sbanner']['name']) ? $newSbanner : $this->request->getVar('old_simage')),
                    'edvenues' => $this->remove_quotes($this->request->getVar('venues')),
                    'edstart' => $this->remove_quotes($this->request->getVar('sdate')),
                    'edend' => $this->request->getVar('edate'),
                    'edvotingend' => $this->request->getVar('vend'),
                    'edstatus' => $this->request->getVar('status')
                ];

                $result = $this->editions->update($id, $data);

                if ($result) {

                    if (!empty($_FILES['banner']['name'])) {
                        $banner->move('assets/web/uploads/projects', $newBanner);
                    }

                    if (!empty($_FILES['sbanner']['name'])) {
                        $sbanner->move('assets/web/uploads/projects', $newSbanner);
                    }

                    $this->session->setTempdata('success', 'Project Edition updated successfully', 3);
                    return redirect()->to(current_url());
                } else {
                    $this->session->setTempdata('error', 'Sorry! Project Edition could not be updated, try again', 3);
                    return redirect()->to(current_url());
                }
            }
        }

        return view("admin/projects/edit_edition", $data);
    }

    // PARTICIPANTS
    public function participants_list()
    {

        $data = [
            'page_title' => 'Participants',
            'participants' => $this->participants->getAllParticipants()
        ];

        return view("admin/participants/participants_list", $data);
    }

    public function participants_rankings()
    {
        $data = [
            'page_title' => 'Rankings',
            'editions' => $this->editions->getAllEditions()
        ];

        return view("admin/participants/participants_rankings", $data);
    }

    public function add_participants()
    {

        $data = [
            'page_title' => 'Add Participant',
            'countries' => $this->db->query("SELECT * FROM countries ORDER BY country_name ASC")->getResult(),
            'editions' => $this->editions->getAllEditions()
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'name' => 'required',
                'country' => 'required',
                'edition' => 'required',
                'profile' => [
                    'uploaded[profile]',
                    'mime_in[profile,image/png,image/jpg,image/jpeg,image/gif]',
                    'ext_in[profile,png,jpg,jpeg,gif]'
                ],
            ];

            $messages = [
                'name' => [
                    'required' => 'Name is required',
                ],
                'country' => [
                    'required' => 'Country is required',
                ],
                'project' => [
                    'required' => 'Project is required',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {

                $banner = $this->request->getFile('profile');
                $newBanner = $banner->getRandomName();
                $edition = $this->request->getVar('edition');
                $editionQuery = $this->db->query("SELECT edproject, edauthor FROM 0l3m5ccavrkqywj WHERE edref=" . $this->db->escape($edition) . "")->getRow();

                $pref = random_string("alnum", 15);

                $today = date('Y-m-d');
                $year = date('Y', strtotime($today));

                $data = [
                    'cref' => $pref,
                    'cnames' => ucwords($this->request->getVar('name')),
                    'cslug' => url_title(strtolower($this->request->getVar('name')), '-', true),
                    'ccountry' => $this->request->getVar('country'),
                    'cimage' => $newBanner,
                    'cvotes' => 0,
                    'cviews' => 0,
                    'cboost' => 0,
                    'cproject' => $editionQuery->edproject,
                    'cedition' => $edition,
                    'cyear' => $year,
                    'cauthor' => $editionQuery->edauthor,
                ];

                $result = $this->participants->save($data);

                if ($result) {
                    $banner->move('assets/web/uploads/participants', $newBanner);
                    $this->session->setTempdata('success', 'Participant added successfully', 3);
                    return redirect()->to(current_url());
                } else {
                    $this->session->setTempdata('error', 'Sorry! Participant could not be added, try again', 3);
                    return redirect()->to(current_url());
                }
            }
        }

        return view("admin/participants/add_participants", $data);
    }
    
    public function edit_participant($id){

        $data = [
            'page_title' => 'Edit Participant',
            'countries' => $this->db->query("SELECT * FROM countries ORDER BY country_name ASC")->getResult(),
            'editions' => $this->editions->getAllEditions(),
            'participant' => $this->participants->getParticipantDetails($id),
            'organizer' => $this->participants->getOrganizers()
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'name' => 'required',
                'country' => 'required',
                'edition' => 'required',
            ];

            $messages = [
                'name' => [
                    'required' => 'Name is required',
                ],
                'country' => [
                    'required' => 'Country is required',
                ],
                'project' => [
                    'required' => 'Project is required',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {

                if (!empty($_FILES['profile']['name'])) {
                    // Remove old image
                    $findFile = $this->participants->getParticipantDetails($id);
                    $old_img = $findFile->cimage;

                    if (file_exists($old_img)) {
                        unlink('assets/web/uploads/participants/' . $old_img);
                    }

                    $banner = $this->request->getFile('profile');
                    $newBanner = $banner->getRandomName();
                }

                $edition = $this->request->getVar('edition');
                $editionQuery = $this->db->query("SELECT edproject FROM 0l3m5ccavrkqywj WHERE edref=" . $this->db->escape($edition) . "")->getRow();

                $today = date('Y-m-d');
                $year = date('Y', strtotime($today));

                $data = [
                    'cnames' => $this->remove_quotes(ucwords($this->request->getVar('name'))),
                    'cslug' => url_title(strtolower($this->request->getVar('name')), '-', true),
                    'ccountry' => $this->request->getVar('country'),
                    'cimage' => (!empty($_FILES['profile']['name']) ? $newBanner : $this->request->getVar('old_image')),
                    'cproject' => $editionQuery->edproject,
                    'cedition' => $edition,
                    'cauthor' => $this->request->getVar('organizer'),
                ];

                $result = $this->participants->update($id, $data);

                if ($result) {
                    if (!empty($_FILES['profile']['name'])) {
                        $banner->move('assets/web/uploads/participants', $newBanner);
                    }
                    
                    $this->session->setTempdata('success', 'Participant updated successfully', 3);
                    return redirect()->to(current_url());
                } else {
                    $this->session->setTempdata('error', 'Sorry! Participant could not be updated, try again', 3);
                    return redirect()->to(current_url());
                }
            }
        }

        return view("admin/participants/edit_participant", $data);
    }


    // Remove Quotes
    public function remove_quotes($data)
    {
        $string = strip_quotes($data);
        $string2 = strip_slashes($string);
        $html = htmlentities($string2);
        return $html;
    }
}
