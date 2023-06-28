<?php

namespace App\Controllers\Organizer;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;
use App\Models\Organizer\HomeModel;
use App\Models\Organizer\OrganizerInfoModel;
use App\Models\Organizer\ProjectsModel;
use App\Models\Organizer\EditionsModel;
use App\Models\Organizer\ContestantsModel;


class Home extends BaseController
{
    public $home;
    public $organizer;
    public $projects;
    public $editions;
    public $participants;
    protected $auth;
    protected $config;
    public $db;

    public function __construct()
    {
        $this->home = new HomeModel();
        $this->organizer = new OrganizerInfoModel();
        $this->projects = new ProjectsModel();
        $this->editions = new EditionsModel();
        $this->participants = new ContestantsModel();
        $this->config = config('Auth');
        $this->auth = service('authentication');
        $this->db = \Config\Database::connect();
        $this->session = session();
    }

    public function index()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        } 
        $edition = $this->db->query("SELECT edref FROM 0l3m5ccavrkqywj ORDER BY edid DESC")->getFirstRow();
        $data = [
            'page_title' => 'Dashboard',
            'projects' => $this->home->getCountProjects(auth()->user()->id),
            'count_participants' => $this->home->getCountParticipants(auth()->user()->id),
            'boosts' => $this->home->sumBoosts(auth()->user()->id),
            'views' => $this->home->getCountViews(auth()->user()->id),
            'participants' => $this->home->getRecentParticipants(auth()->user()->id)
        ];

        return view("organizers/index", $data);
    }

    // Profile
    public function profile($id)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }

        $data = [
            'page_title' => 'Profile',
            'profile' => $this->organizer->getProfileInfo($id),
            'countries' => $this->organizer->getCountries(),
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'country' => 'required',
                'address' => 'required',
                'mobile' => 'required',
                'description' => 'required'
            ];

            $messages = [
                'country' => [
                    'required' => 'Country is required',
                ],
                'address' => [
                    'required' => 'Address is required',
                ],
                'mobile' => [
                    'required' => 'Mobile is required',
                ],
                'description' => [
                    'required' => 'Company description is required',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {

                $data = [
                    'or_firstname' => $this->remove_quotes(ucwords($this->request->getVar('fname'))),
                    'or_lastname' => $this->remove_quotes(ucwords($this->request->getVar('lname'))),
                    'or_company_address' => $this->remove_quotes(ucwords($this->request->getVar('address'))),
                    'or_company_phone' => $this->request->getVar('mobile'),
                    'or_country' => $this->request->getVar('country'),
                    'or_website' => $this->request->getVar('website'),
                    'or_twitter' => $this->request->getVar('twitter'),
                    'or_instagram' => $this->request->getVar('instagram'),
                    'or_company_desc' => $this->request->getVar('description')
                ];

                $result = $this->organizer->update($id, $data);

                if ($result) {
                    $this->session->setTempdata('success', 'Profile updated successfully', 3);
                    return redirect()->to(current_url());
                } else {
                    $this->session->setTempdata('error', 'Sorry! Profile could not be updated, try again', 3);
                    return redirect()->to(current_url());
                }
            }
        }

        return view("organizers/profile", $data);
    }

    // Security Settings
    public function security_settings($id)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }
        $data = [
            'page_title' => 'Settings',
            'settings' => $this->organizer->getUserSettings($id),
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
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
                ) {
                    $hashOptions = [
                        'memory_cost' => $config->hashMemoryCost,
                        'time_cost'   => $config->hashTimeCost,
                        'threads'     => $config->hashThreads,
                    ];
                } else {
                    $hashOptions = [
                        'cost' => $config->hashCost,
                    ];
                }

                $password = $this->request->getVar('password');
                $passwordHash = password_hash(self::preparePassword($password), $this->config->hashAlgorithm, $hashOptions);

                $result = $this->db->query("UPDATE auth_identities SET secret2=" . $this->db->escape($passwordHash) . " WHERE user_id=" . $this->db->escape($id) . "");

                if ($result) {
                    $this->session->setTempdata('success', 'Settings updated successfully', 3);
                    return redirect()->to(current_url());
                } else {
                    $this->session->setTempdata('error', 'Sorry! Settings could not be updated, try again', 3);
                    return redirect()->to(current_url());
                }
            }
        }

        return view("organizers/security_settings", $data);
    }

    protected static function preparePassword(string $password): string
    {
        return base64_encode(hash('sha384', $password, true));
    }

    // Organizer Project
    public function organizer_projects($id)
    {

        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }
        
        $data = [
            'page_title' => 'Profile',
            'projects' => $this->home->getOrganizerProjects($id),
        ];
        return view("organizers/projects/all_projects", $data);
    }

    // Add Project
    public function add_project()
    {

        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }
        
        $data = [
            'page_title' => 'Add Project',
            'organizer' => $this->db->query("SELECT * FROM pomar3h6kso5ild WHERE or_id=" . $this->db->escape(auth()->user()->id) . "")->getRow()
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'name' => 'required|is_unique[afrv_organ_projects.pname]',
                'description' => 'required',
            ];

            $messages = [
                'name' => [
                    'required' => 'Project name is required',
                    'is_unique' => 'Project name was already used before',
                ],
                'description' => [
                    'required' => 'Project description is required',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {

                $company = $this->db->query("SELECT * FROM pomar3h6kso5ild WHERE or_id=" . $this->db->escape(auth()->user()->id) . "")->getRow();
                $pref = random_string("alnum", 15);
                $data = [
                    'pref' => $pref,
                    'pname' => $this->remove_quotes(ucwords($this->request->getVar('name'))),
                    'pslug' => url_title(strtolower($this->request->getVar('name')), '-', true),
                    'pdescription' => $this->remove_quotes($this->request->getVar('description')),
                    'pcreators' => ucwords($company->or_company_name),
                    'pauthor' => auth()->user()->id,
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

        return view("organizers/projects/add_project", $data);
    }

    // Edit Project
    public function edit_project($id)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }
        
        $data = [
            'page_title' => 'Edit Project',
            'project' => $this->projects->getProjectDetails($id),
            'organizer' => $this->db->query("SELECT * FROM pomar3h6kso5ild WHERE or_id=" . $this->db->escape(auth()->user()->id) . "")->getRow()
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'name' => 'required',
                'description' => 'required',
            ];

            $messages = [
                'name' => [
                    'required' => 'Project name is required',
                ],
                'description' => [
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
        return view("organizers/projects/edit_project", $data);
    }

    // Project Editions
    public function editions_list()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }
        $data = [
            'page_title' => 'All Editions',
            'editions' => $this->editions->getAllEditions(auth()->user()->id)
        ];

        return view("organizers/projects/all_editions", $data);
    }

    public function running_editions()
    {
        $data = [
            'page_title' => 'Running Editions',
            'editions' => $this->editions->getRunningEditions(auth()->user()->id, date('Y-m-d'))
        ];

        return view("organizers/projects/running_editions", $data);
    }

    public function ended_editions()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }
        $data = [
            'page_title' => 'Ended Editions',
            'editions' => $this->editions->getEndedEditions(auth()->user()->id, date('Y-m-d'))
        ];

        return view("organizers/projects/ended_editions", $data);
    }

    public function add_edition()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }
        $data = [
            'page_title' => 'Add Edition',
            'projects' => $this->home->getOrganizerProjects(auth()->user()->id)
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'name' => 'required|is_unique[0l3m5ccavrkqywj.edname]',
                'venues' => 'required',
                'sdate' => 'required',
                'edate' => 'required',
                'project' => 'required',
                'edseo_summery' => 'required',
                'edseo_keywords' => 'required',
                'edtwitter_summery' => 'required',
                'edog_summery' => 'required',
                'banner' => [
                    'uploaded[banner]',
                    'mime_in[banner,image/png,image/jpg,image/jpeg,image/gif]',
                    'ext_in[banner,png,jpg,jpeg,gif]'
                ],
                'vend' => 'required',
            ];

            $messages = [
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

                $pref = random_string("alnum", 15);
                $project = $this->request->getVar('project');

                $data = [
                    'edref' => $pref,
                    'edname' => $this->remove_quotes($this->request->getVar('name')),
                    'edslug' => url_title(strtolower($this->request->getVar('name')), '-', true),
                    'edproject' => $project,
                    'edbanner' => $newBanner,
                    'edvenues' => $this->remove_quotes($this->request->getVar('venues')),
                    'edstart' => $this->remove_quotes($this->request->getVar('sdate')),
                    'edend' => $this->remove_quotes($this->request->getVar('edate')),
                    'edvotingend' => $this->remove_quotes($this->request->getVar('vend')),
                    'edauthor' => auth()->user()->id,
                    'edvotes' => 0,
                    'edviews' => 0,
                    'edboosts' => 0,
                    'edseo_summery' => $this->remove_quotes($this->request->getVar('edseo_summery')),
                    'edseo_keywords' => $this->remove_quotes($this->request->getVar('edseo_keywords')),
                    'edtwitter_summery' => $this->remove_quotes($this->request->getVar('edtwitter_summery')),
                    'edog_summery' => $this->remove_quotes($this->request->getVar('edog_summery')),
                    'edstatus' => 3,
                ];

                $result = $this->editions->save($data);

                if ($result) {
                    $editions = $this->db->query("SELECT peditions FROM afrv_organ_projects WHERE pref=" . $this->db->escape($project) . "")->getRow();
                    $total = $editions->peditions + 1;

                    $this->db->query("UPDATE afrv_organ_projects SET peditions=" . $this->db->escape($total) . "");

                    $banner->move('assets/web/uploads/projects', $newBanner);
                    $this->session->setTempdata('success', 'Project Edition added successfully', 3);
                    return redirect()->to(current_url());
                } else {
                    $this->session->setTempdata('error', 'Sorry! Project Edition could not be added, try again', 3);
                    return redirect()->to(current_url());
                }
            }
        }

        return view("organizers/projects/add_edition", $data);
    }

    public function edit_edition($id)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }

        $data = [
            'page_title' => 'Add Edition',
            'projects' => $this->projects->getAllProjects(),
            'edition' => $this->editions->getEditionsDetails($id)
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'name' => 'required',
                'venues' => 'required',
                'sdate' => 'required',
                'edate' => 'required',
                'project' => 'required',
                'edseo_summery' => 'required',
                'edseo_keywords' => 'required',
                'edtwitter_summery' => 'required',
                'edog_summery' => 'required',
                'vend' => 'required',
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
                    'edbanner' => (!empty($_FILES['banner']['name']) ? $newBanner : $this->request->getVar('old_image')),
                    'edsimage' => (!empty($_FILES['sbanner']['name']) ? $newSbanner : $this->request->getVar('old_simage')),
                    'edvenues' => $this->remove_quotes($this->request->getVar('venues')),
                    'edstart' => $this->remove_quotes($this->request->getVar('sdate')),
                    'edend' => $this->remove_quotes($this->request->getVar('edate')),
                    'edvotingend' => $this->remove_quotes($this->request->getVar('vend')),
                    'edseo_summery' => $this->remove_quotes($this->request->getVar('edseo_summery')),
                    'edseo_keywords' => $this->remove_quotes($this->request->getVar('edseo_keywords')),
                    'edtwitter_summery' => $this->remove_quotes($this->request->getVar('edtwitter_summery')),
                    'edog_summery' => $this->remove_quotes($this->request->getVar('edog_summery')),
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

        return view("organizers/projects/edit_edition", $data);
    }


    // PARTICIPANTS
    public function participants_list()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }
        $data = [
            'page_title' => 'Participants',
            'participants' => $this->participants->getAllParticipants(auth()->user()->id)
        ];

        return view("organizers/participants/participants_list", $data);
    }
    
    public function add_participant(){
        
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }
        
        $data = [
            'page_title' => 'Add Participant',
            'countries' => $this->db->query("SELECT * FROM countries ORDER BY country_name ASC")->getResult(),
            'editions' => $this->editions->getAllEditions(auth()->user()->id)
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

        return view("organizers/participants/add_participants", $data);
    }
    
    public function edit_participant($id){

        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }
        $data = [
            'page_title' => 'Edit Participant',
            'participant' => $this->participants->getParticipantDetails($id),
            'countries' => $this->db->query("SELECT * FROM countries ORDER BY country_name ASC")->getResult(),
            'editions' => $this->participants->getAllEditions(auth()->user()->id)
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'name' => 'required',
                'country' => 'required',
                'edition' => 'required',
            ];

            $messages = [
                'name' => [
                    'required' => 'Participant name is required',
                ],
                'country' => [
                    'required' => 'Country is required',
                ],
                'edition' => [
                    'required' => 'Edition is required',
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

                $data = [
                    'cnames' => $this->remove_quotes($this->request->getVar('name')),
                    'cslug' => url_title(strtolower($this->request->getVar('name')), '-', true),
                    'ccountry' => $this->remove_quotes($this->request->getVar('country')),
                    'cimage' => (!empty($_FILES['profile']['name']) ? $newBanner : $this->request->getVar('old_profile')),
                    'cedition' => $this->remove_quotes($this->request->getVar('edition')),
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

        return view("organizers/participants/edit_participant", $data);
    }

    public function participants_rankings()
    {
        $data = [
            'page_title' => 'Rankings',
            'editions' => $this->editions->getAllEditions(auth()->user()->id)
        ];

        return view("organizers/participants/participants_rankings", $data);
    }

    // Ranking Report
    public function participants_rankings_report()
    {

        $project = $_POST["project"];
        $projectyear = $_POST["projectyear"];
        $query = $this->participants->filterAllParticipants(auth()->user()->id, $projectyear, $project);

        echo json_encode($query);
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
