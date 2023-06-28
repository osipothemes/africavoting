<?php

namespace App\Controllers\Web;

require_once ROOTPATH . "vendor/autoload.php";

use Flutterwave\EventHandlers\EventHandlerInterface;
use Flutterwave\Flutterwave;

use App\Controllers\BaseController;
use App\Models\Web\HomeModel;
use App\Models\Web\VotingActivityModel;
use App\Models\Web\BoostingActivityModel;
use App\Models\Web\UsersModel;
use App\Models\Web\OrganizerInfoModel;
use App\Models\Web\AuthIdentitiesModel;
use App\Models\Web\AuthGroupsModel;
use App\Models\Web\LoginModel;
use App\Models\Web\BoostsModel;
use CodeIgniter\Database\Query;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserModel;
use App\Models\Web\EditionsModel;


class Home extends BaseController
{
    public $home;
    public $voting;
    public $boosting;
    public $users;
    public $usersinfo;
    public $identity;
    public $groups;
    public $loginModel;
    public $email;
    public $db;
    public $transactionsModel;
    public $client;
    public $token;
    public $success_url;
    public $publicKey;
    public $secretKey;
    public $encryptionKey;
    public $env;
    public $currency;
    public $prefix;
    public $overrideRef;
    public $boosts;
    public $editions;

    public function __construct()
    {

        $this->home = new HomeModel();
        $this->voting = new VotingActivityModel();
        $this->boosting = new BoostingActivityModel();
        $this->users = new UsersModel();
        $this->usersinfo = new OrganizerInfoModel();
        $this->identity = new AuthIdentitiesModel();
        $this->groups = new AuthGroupsModel();
        $this->editions = new EditionsModel();
        $this->loginModel = new LoginModel();
        $this->boosts = new BoostsModel();

        //Start Curl Services in codeigniter 4
        $this->client = \Config\Services::curlrequest();
        //Get required paramenters for the process & unique transaction token.
        $this->token = bin2hex(random_bytes(18));

        //Success link to connect to redirected Flutterwave link and help process results in your ci4 system.
        $this->success_url = site_url('payment-success');
        //Flutterwave connection credentials
        $this->publicKey      = getenv('PUBLIC_KEY');
        $this->secretKey      = getenv('SECRET_KEY');
        $this->encryptionKey  = getenv('ENCRYPTION_KEY');
        $this->env            = getenv('ENV');
        $this->currency       = 'UGX';
        $this->prefix         = 'afr';
        $this->overrideRef    = false;

        $this->db = \Config\Database::connect();
        $this->email = \Config\Services::email();
        $this->session = session();
    }

    public function index()
    {
        $data = [
            'page_title' => 'Home',
            'projects' => $this->home->getAllEditions()
        ];

        return view("web/index", $data);
    }

    public function user_authentication()
    {
        if (session()->has('google_user')) {
            return redirect()->back();
        }
        $data = [
            'page_title' => 'User Auth',
        ];

        require_once APPPATH . "Libraries/vendor/autoload.php";
        $google_client = new \Google_Client();
        $google_client->setClientId('390892801726-o6hscb62efl6au01uqhr9io33p6vq6o3.apps.googleusercontent.com');
        $google_client->setClientSecret('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');
        $google_client->setRedirectUri(site_url('users/auth'));
        $google_client->addScope('email');
        $google_client->addScope('profile');

        if ($this->request->getVar('code')) {
            $token = $google_client->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
            if (!isset($token['error'])) {
                $google_client->setAccessToken($token['access_token']);
                $this->session->set('access_token', $token['access_token']);
                // get profile data
                $google_service = new \Google_Service_Oauth2($google_client);
                $gdata = $google_service->userinfo->get();
                // print_r($gdata);

                if ($this->loginModel->google_user_exists($gdata['email'])) {
                    $user_id = $this->db->query("SELECT * FROM auth_identities WHERE secret=" . $this->db->escape($gdata['email']) . "")->getRow();

                    // Update User
                    $userData = [
                        'first_name' => $gdata['given_name'],
                        'last_name' => $gdata['family_name'],
                        'avatar' => $gdata['picture'],
                    ];

                    $this->loginModel->updateUsersTable($userData, $user_id->user_id);

                    // Update Users Table
                    $usersTable = [
                        'secret' => $gdata['email']
                    ];

                    $this->loginModel->updateGoogleUser($usersTable, $gdata['email']);
                    // $this->session->set('google_user', $userData);
                    $this->session->set('google_user', $usersTable);
                    return redirect()->to(site_url('/'));
                } else {
                    // Create User
                    // helper('text');
                    // $username = random_string('alnum', 8);

                    $userData = [
                        'username' => $gdata['email'],
                        'active' => 0,
                        'first_name' => $gdata['given_name'],
                        'last_name' => $gdata['family_name'],
                        'avatar' => $gdata['picture'],
                    ];

                    $result = $this->users->save($userData);

                    if ($result) {

                        $userid = $this->users->getInsertID();

                        $identityTable = [
                            'user_id' => $userid,
                            'type' => "google_login",
                            'secret' => $gdata['email'],
                            'force_reset' => 0,

                        ];

                        $this->identity->save($identityTable);

                        $groupTable = [
                            'user_id' => $userid,
                            'group' => "user",
                        ];

                        $this->groups->save($groupTable);

                        $this->session->set('google_user', $identityTable);
                        return redirect()->to(site_url('/'));
                    }

                    // $this->loginModel->create_google_user($userData);
                }
            }
        }

        if (!$this->session->get('access_token')) {
            $data['googleButton'] = $google_client->createAuthUrl();
        }

        return view("web/user_authentication", $data);
    }

    // Logout google user
    public function logout_user()
    {

        session_destroy();
        $this->session->setTempdata('success', 'Your have logged Out Successfully', 3);
        return redirect()->to(site_url('users/auth'));
    }

    // Terms
    public function terms()
    {
        $data = [
            'page_title' => 'Terms',
        ];

        return view("web/terms", $data);
    }

    // Privacy
    public function privacy_policy()
    {
        $data = [
            'page_title' => 'Privacy',
        ];

        return view("web/privacy_policy", $data);
    }

    
    // Completed Projects
    public function completed_projects(){
        $data = [
            'page_title' => 'Completed Projects',
            'projects' => $this->editions->where('edvotingend <', date('Y-m-d'))->orderby('edid', 'DESC')->paginate(12),
            'pager' => $this->editions->pager,
        ];

        return view("web/completed_projects", $data);
    }

    // Upcoming Projects
    public function finished_projects()
    {
        $data = [
            'page_title' => 'Upcoming Projects',
            'projects' => $this->home->getExpiredEditions(date('Y-m-d')),
        ];

        return view("web/finished_projects", $data);
    }

    // Project Results
    public function project_results($id)
    {
        $query = $this->db->query("SELECT * FROM 0l3m5ccavrkqywj WHERE edslug=" . $this->db->escape($id) . "")->getRow();
        $ended = $this->home->getEditionDetails($query->edref);

        $data = [
            'page_title' => 'Project Results',
            'project' => $this->home->getEditionDetails($query->edref),
            'contestants' => $this->home->getEditionRanking($query->edref),
            'votes' => $this->home->getTotalVotes($query->edref),
            'views' => $this->db->query("SELECT edviews FROM 0l3m5ccavrkqywj WHERE edref=" . $this->db->escape($query->edref) . "")->getRow()
        ];

        return view("web/projectresults", $data);
    }

    public function update_project()
    {

        $editionRef = $_POST["edid"];
        $editionQuery = $this->db->query("SELECT edviews FROM 0l3m5ccavrkqywj WHERE edref=" . $this->db->escape($editionRef) . "")->getRow();
        $totalViews = $editionQuery->edviews + 1;

        $this->db->query("UPDATE 0l3m5ccavrkqywj SET edviews=" . $this->db->escape($totalViews) . "");
    }

    // Update Participant
    public function update_participant()
    {
        $userRef = $_POST["cref"];
        $userQuery = $this->db->query("SELECT cviews FROM vuzpq4kzjwmgblc WHERE cref=" . $this->db->escape($userRef) . "")->getRow();
        $totalViews = $userQuery->cviews + 1;

        $this->db->query("UPDATE vuzpq4kzjwmgblc SET cviews=" . $this->db->escape($totalViews) . " WHERE cref=" . $this->db->escape($userRef) . "");
    }

    // Vote
    public function vote($id)
    {


        $query = $this->db->query("SELECT * FROM 0l3m5ccavrkqywj WHERE edslug=" . $this->db->escape($id) . "")->getRow();
        
        if($query->edref == 'Fu5SvGjm0U8IZkc'){
            return redirect()->to(site_url('/'));
        }
        
        if($query->edref == 'gQTu3DJPe6pKEhU'){
            return redirect()->to(site_url('/'));
        }
        
        if($query->edref == 'XFkGh0uDJPsnrfZ'){
            return redirect()->to(site_url('/'));
        }
        // Check if voting already ended
        $totalViews = $query->edviews + 1;

        $this->db->query("UPDATE 0l3m5ccavrkqywj SET edviews=" . $this->db->escape($totalViews) . " WHERE edref=" . $this->db->escape($query->edref) . "");
        $ended = $this->home->getEditionDetails($query->edref);

        $data = [
            'page_title' => 'Vote',
            'project' => $this->home->getEditionDetails($query->edref),
            'countries' => $this->home->getEditionCountries($query->edref),
            'participants' => $this->home->getEditionParticipants($query->edref),
            'views' => $this->db->query("SELECT edviews FROM 0l3m5ccavrkqywj WHERE edref=" . $this->db->escape($query->edref) . "")->getRow(),
            'url' => site_url('projects/vote/' . $id)
        ];

        if ($this->request->getMethod() == 'post') {


            $userId = $this->request->getVar('userid');
            $userref = $this->request->getVar('userref');
            $edref = $this->request->getVar('edref');
            $email = $this->request->getVar('email');

            // Get contestants info
            $userQuery = $this->db->query("SELECT * FROM vuzpq4kzjwmgblc WHERE cid=" . $this->db->escape($userId) . " AND cedition=" . $this->db->escape($edref) . "")->getRow();
            $editionQuery = $this->db->query("SELECT edref, edvotes, edproject FROM 0l3m5ccavrkqywj WHERE edref=" . $this->db->escape($edref) . "")->getRow();
            // if (auth()->loggedIn()) {
            //     $loggedUser = auth()->user()->email;
            // } else {
            //     $uinfo = session()->get('google_email');
            //     $loggedUser = $uinfo['secret'];
            // }
            $alreadyVoted = $this->voting->checkIfVoted($email, $editionQuery->edproject, $edref);

            if ($alreadyVoted > 0) {
                $this->session->setTempdata('error', 'Opps! Looks like you already voted today, please try again tomorrow, or boot instead ', 3);
                return redirect()->back();
            } else {
                $totalVotes = $userQuery->cvotes + 1;
                $totalViews = $userQuery->cviews + 1;
                // Update contestants table
                $this->db->query("UPDATE vuzpq4kzjwmgblc SET cvotes=" . $this->db->escape($totalVotes) . ", cviews=" . $this->db->escape($totalViews) . " WHERE cid=" . $this->db->escape($userId) . " AND cedition=" . $this->db->escape($edref) . " ");
                // Update Editions Table
                $tEditionVotes = $editionQuery->edvotes + 1;
                $this->db->query("UPDATE 0l3m5ccavrkqywj SET edvotes=" . $this->db->escape($tEditionVotes) . " WHERE edref=" . $this->db->escape($edref) . "");
                // if (auth()->loggedIn()) {
                //     $loggedUser = auth()->user()->email;
                // } else {
                //     $uinfo = session()->get('google_email');
                //     $loggedUser = $uinfo['secret'];
                // }
                // Insert to Voting Activity
                $ref = random_string('alnum', 15);
                $data = [
                    'voting_ref' => $ref,
                    'voted_participant' => $userQuery->cref,
                    'voter_email' => $email,
                    'voted_project' => $editionQuery->edproject,
                    'voted_edition' => $editionQuery->edref,
                    'vote_date' => date('Y-m-d')
                ];
                $this->voting->save($data);
                // Display success message
                $this->session->setTempdata('success', 'You have successfully voted for ' . $userQuery->cnames, 3);
                return redirect()->back();
            }
        }

        return view("web/votinglist", $data);
    }

    // Vote participant
    public function vote_participant($id)
    {

        $query = $this->db->query("SELECT * FROM 0l3m5ccavrkqywj WHERE edslug=" . $this->db->escape($id) . "")->getRow();
        // Check if voting already ended
        $totalViews = $query->edviews + 1;

        $this->db->query("UPDATE 0l3m5ccavrkqywj SET edviews=" . $this->db->escape($totalViews) . " WHERE edref=" . $this->db->escape($query->edref) . "");
        $ended = $this->home->getEditionDetails($query->edref);

        if ($this->request->getMethod() == 'post') {

            $userId = $this->request->getVar('userid');
            $userref = $this->request->getVar('userref');
            $edref = $this->request->getVar('edref');
            $email = $this->request->getVar('email');

            // Get contestants info
            $userQuery = $this->db->query("SELECT * FROM vuzpq4kzjwmgblc WHERE cid=" . $this->db->escape($userId) . " AND cedition=" . $this->db->escape($edref) . "")->getRow();
            $editionQuery = $this->db->query("SELECT edref, edvotes, edproject FROM 0l3m5ccavrkqywj WHERE edref=" . $this->db->escape($edref) . "")->getRow();
            // if (auth()->loggedIn()) {
            //     $loggedUser = auth()->user()->email;
            // } else {
            //     $uinfo = session()->get('google_user');
            //     $loggedUser = $uinfo['secret'];
            // }
            $alreadyVoted = $this->voting->checkIfVoted($email, $editionQuery->edproject, $edref);

            if ($alreadyVoted > 0) {
                $this->session->setTempdata('error', 'Opps! Looks like you already voted today, please try again tomorrow, or boot instead ', 3);
                return redirect()->back();
            } else {
                $totalVotes = $userQuery->cvotes + 1;
                $totalViews = $userQuery->cviews + 1;
                // Update contestants table
                $this->db->query("UPDATE vuzpq4kzjwmgblc SET cvotes=" . $this->db->escape($totalVotes) . ", cviews=" . $this->db->escape($totalViews) . " WHERE cid=" . $this->db->escape($userId) . " AND cedition=" . $this->db->escape($edref) . " ");
                // Update Editions Table
                $tEditionVotes = $editionQuery->edvotes + 1;
                $this->db->query("UPDATE 0l3m5ccavrkqywj SET edvotes=" . $this->db->escape($tEditionVotes) . " WHERE edref=" . $this->db->escape($edref) . "");
                // if (auth()->loggedIn()) {
                //     $loggedUser = auth()->user()->email;
                // } else {
                //     $uinfo = session()->get('google_email');
                //     $loggedUser = $uinfo['secret'];
                // }
                // Insert to Voting Activity
                $ref = random_string('alnum', 15);
                $data = [
                    'voting_ref' => $ref,
                    'voted_participant' => $userQuery->cref,
                    'voter_email' => $email,
                    'voted_project' => $editionQuery->edproject,
                    'voted_edition' => $editionQuery->edref,
                    'vote_date' => date('Y-m-d')
                ];
                $this->voting->save($data);
                // Display success message
                $this->session->setTempdata('success', 'You have successfully voted for ' . $userQuery->cnames, 3);
                return redirect()->back();
            }
        }
    }

    // Participant Details
    public function participant_details($id)
    {

        $query = $this->db->query("SELECT cedition FROM vuzpq4kzjwmgblc WHERE cref=" . $this->db->escape($id) . "")->getRow();
        
        if($query->cedition == 'Fu5SvGjm0U8IZkc'){
            return redirect()->to(site_url('/'));
        }
        
        if($query->cedition == 'gQTu3DJPe6pKEhU'){
            return redirect()->to(site_url('/'));
        }
        
        if($query->cedition == 'XFkGh0uDJPsnrfZ'){
            return redirect()->to(site_url('/'));
        }

        // Check if voting already ended
        $ended = $this->home->getEditionDetails($query->cedition);
        if ($ended->edvotingend < date('Y-m-d')) {
            return redirect()->back();
        }

        $data = [
            'page_title' => 'Details',
            'project' => $this->home->getParticipantsDetails($id),
            'countries' => $this->home->getEditionCountries($query->cedition),
            'url' => site_url('participants/details/' . $id),
        ];

        return view("web/participantdetails", $data);
    }

    // Verify flutterwave payment
    public function process_payment()
    {

        if ($this->request->getMethod() == 'post') {
            // Set the API endpoint URL
            $url = 'https://api.flutterwave.com/v3/payments';

            // Set the request headers
            $headers = [
                'Authorization' => 'Bearer ' . getenv('SECRET_KEY'),
                'Content-Type'  => 'application/json',
            ];

            $amount = $this->request->getPost('amount');
            $userref = $this->request->getPost('userref');

            if ($amount == 10000) {
                $votes = 10;
            } elseif ($amount == 15000) {
                $votes = 20;
            } elseif ($amount == 30000) {
                $votes = 35;
            } elseif ($amount == 50000) {
                $votes = 50;
            } elseif ($amount == 100000) {
                $votes = 150;
            } elseif ($amount == 200000) {
                $votes = 250;
            } else {
                $votes = 500;
            }
            // Set the request payload
            $tx_ref = random_string("alnum", 8);
            $payload = [
                'tx_ref'            => $tx_ref,
                'amount'            => $this->request->getPost('amount'),
                'currency'          => $this->currency,
                'redirect_url'      => $this->success_url,
                'customer'          => [
                    'email'         => $this->request->getPost('email'),
                ],
                'meta'              => [
                    'consumer_id'   => $this->request->getPost('userref'),
                    'account_id'    => $this->request->getPost('edref'),
                    'project'       => $this->request->getPost('project'),
                    'form_amount'   => $this->request->getPost('amount'),
                    'c_names'       => $this->request->getPost('cnames'),
                    'pay_email'     => $this->request->getPost('email'),
                    'votes'         => $votes,
                ],
                'customizations'     => [
                    'title'       => "AfricaVoting",
                    'logo'        => base_url('assets/web/uploads/template/logo-africavoting.png'),
                    'description' => "Participant Boost",
                ]
            ];

            // Convert the payload to JSON
            $jsonPayload = json_encode($payload);

            try {
                // Make a POST request to the API endpoint
                $response = $this->client->request('POST', $url, [
                    'headers' => $headers,
                    'body' => $jsonPayload
                ]);

                // Get the response body as JSON
                $responseJson = json_decode($response->getBody(), true);
                //var_dump($responseJson);

                // If the payment was successfully initialized, redirect the user to the payment page
                if (isset($responseJson['status']) && $responseJson['status'] == 'success') {
                    
                    $gdata = [
                        'trans_id' => $tx_ref,
                        'contestant_ref' => $userref,
                        'contestants_names' => $this->request->getPost('cnames'),
                        'boost_amount' => $this->request->getPost('amount'),
                        'boost_email' => $this->request->getPost('email'),
                        'boost_status' => 'pending',
                        'boost_dates' => date('Y-m-d h:i:s'),
                    ];

                    $this->boosts->save($gdata);
                    
                    return redirect()->to($responseJson['data']['link']);
                    
                    
                    //Fetch existing contestant data
                    // $userQuery = $this->db->query("SELECT * FROM vuzpq4kzjwmgblc WHERE cref=" . $this->db->escape($userref) . "")->getRow();
                    // Add Contestant Boost
                    // $totalBoosts = $userQuery->cboost + $amount;
                    // Add Contestant Views
                    // $totalViews = $userQuery->cviews + 1;
                    // Add Votes
                    // $totalVotes = $userQuery->cvotes + $votes;
                    // Update Contestant Table
                    // $this->db->query("UPDATE vuzpq4kzjwmgblc SET cvotes=" . $this->db->escape($totalVotes) . ", cviews=" . $this->db->escape($totalViews) . ", cboost=" . $this->db->escape($totalBoosts) . " WHERE cref=" . $this->db->escape($userref) . "");
                    
                } else {
                    $this->session->setTempdata('error', 'Unable to complete payment, Please try again', 3);
                    return redirect()->to(site_url('participants/details/' . $userref));
                }
            } catch (\Exception $e) {
                // Handle any errors that occur during the request
                echo $e->getCode() . ' ' . $e->getMessage();
            }
        }
    }

    public function successLink()
    {
        //Details coming from payment Flutterwave payment Link
        $transactionId = $this->request->getGet('transaction_id');
        $status = $this->request->getGet('status');
        $tx_ref = $this->request->getGet('tx_ref');

        if ($status == 'cancelled') {
            $this->session->setTempdata('error', 'Payment cancelled', 3);
            return redirect()->back();
        } elseif ($status == 'failed') {
            $this->session->setTempdata('error', 'Payment failed, try again', 3);
            return redirect()->back();
        } else {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$transactionId}/verify",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . getenv('SECRET_KEY')
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response);

            $member_id = $res->data->meta->consumer_id;
            $form_amount = $res->data->meta->form_amount;
            $project = $res->data->meta->project;
            $edition = $res->data->meta->account_id;
            $pay_email = $res->data->meta->pay_email;
            $votes = $res->data->meta->votes;
            $method = $res->data->auth_model;
            
            $userQuery = $this->db->query("SELECT * FROM vuzpq4kzjwmgblc WHERE cref=" . $this->db->escape($member_id) . "")->getRow();
            $totalBoosts = $userQuery->cboost + $form_amount;
            $totalViews = $userQuery->cviews + 1;
            $totalVotes = $userQuery->cvotes + $votes;
            $this->db->query("UPDATE vuzpq4kzjwmgblc SET cvotes=" . $this->db->escape($totalVotes) . ", cviews=" . $this->db->escape($totalViews) . ", cboost=" . $this->db->escape($totalBoosts) . " WHERE cref=" . $this->db->escape($member_id) . "");

            $this->db->query("UPDATE boosts SET boost_status=" . $this->db->escape('verified') . " WHERE trans_id=" . $this->db->escape($tx_ref) . "");

            // Add to boosting table
            $boostRef = random_string('alnum', 15);

            $gdata = [
                'boosting_ref' => $boostRef,
                'boosted_participant' => $member_id,
                'booster_email' => $pay_email,
                'boosted_project' => $project,
                'boosted_edition' => $edition,
                'boosted_date' => date('Y-m-d'),
                'boostedamount' => $form_amount,
                'boostmethod' => $method
            ];

            $this->boosting->save($gdata);
            $this->session->setTempdata('success', 'Vote Boost added Successfully', 3);
            return redirect()->to(site_url('participants/details/' . $member_id));
        }
    }

    // Contact
    public function contact_us()
    {

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|valid_email',
                'mobile' => 'required',
                'country' => 'required',
                'subject' => 'required',
                'message' => 'required'
            ];

            $messages = [
                'firstname' => [
                    'required' => 'Firstname is required'
                ],
                'lastname' => [
                    'required' => 'lastname is required'
                ],
                'email' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Email is not valid'
                ],
                'mobile' => [
                    'required' => 'Mobile is required',
                ],
                'country' => [
                    'required' => 'Country is required',
                ],
                'subject' => [
                    'required' => 'Subject is required',
                ],
                'message' => [
                    'required' => 'Message is required',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $this->session->setTempdata('error', 'Opps! There are missing or errors in your form submission ', 3);
                return redirect()->back();
            } else {

                $from = $this->request->getVar('email');
                $names = $this->request->getVar('firstname') . " " . $this->request->getVar('lastname');
                $mobile = $this->request->getVar('mobile');
                $country = $this->request->getVar('country');
                $subject = $this->request->getVar('subject');
                $message = $this->request->getVar('message');

                $this->email->setFrom($from, $names);
                $this->email->setTo('joshuaosipo@gmail.com');
                $this->email->setSubject($subject);
                $this->email->setMessage("Mobile: " . $mobile . " Country: " . $country . "; " . $message);
                $result = $this->email->send();

                if ($result) {
                    $this->session->setTempdata('success', 'Message successfully sent. We will get back to you', 3);
                    return redirect()->back();
                } else {
                    $this->session->setTempdata('error', 'Opps! Message sending failed, please try again', 3);
                    return redirect()->back();
                }
            }
        }
    }

    // Organizer Signup
    public function organizer_signup()
    {
        $data = [
            'page_title' => 'Sign Up',
            'countries' => $this->home->getAllCountris(),
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'fname' => 'required',
                'lname' => 'required',
                'cname' => 'required',
                'country' => 'required',
                'email' => 'required|valid_email|is_unique[auth_identities.secret]',
                'address' => 'required',
                'mobile' => 'required|min_length[10]',
                'description' => 'required'
            ];

            $messages = [
                'fname' => [
                    'required' => 'Firstname is required'
                ],
                'lname' => [
                    'required' => 'lastname is required'
                ],
                'email' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Email is not valid',
                    'is_unique' => 'Email is already used'
                ],
                'mobile' => [
                    'required' => 'Mobile is required',
                ],
                'country' => [
                    'required' => 'Country is required',
                ],
                'address' => [
                    'required' => 'Address is required',
                ],
                'description' => [
                    'required' => 'Comapny Description is required',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {

                $username = random_string('alnum', 8);

                $usersTable = [
                    'username' => $username,
                    'active' => 0,
                ];

                $result = $this->users->save($usersTable);

                $fname = $this->remove_quotes(ucwords($this->request->getVar('fname')));
                $lname = $this->remove_quotes(ucwords($this->request->getVar('lname')));
                $cname = $this->remove_quotes(ucwords($this->request->getVar('cname')));
                $country = $this->remove_quotes($this->request->getVar('country'));
                $email = strtolower($this->request->getVar('email'));
                $address = $this->remove_quotes(ucwords($this->request->getVar('address')));
                $mobile = $this->remove_quotes($this->request->getVar('mobile'));
                $website = strtolower($this->request->getVar('website'));
                $twitter = $this->request->getVar('twitter');
                $instagram = $this->request->getVar('instagram');
                $description = ucwords($this->request->getVar('description'));

                if ($result) {

                    $userid = $this->users->getInsertID();

                    $identityTable = [
                        'user_id' => $userid,
                        'type' => "email_password",
                        'secret' => $email,
                        'secret2' => 123,
                        'force_reset' => 0,

                    ];

                    $this->identity->save($identityTable);

                    $groupTable = [
                        'user_id' => $userid,
                        'group' => "beta",
                    ];

                    $this->groups->save($groupTable);

                    $usersInfoTable = [
                        'or_id' => $userid,
                        'or_firstname' => $fname,
                        'or_lastname' => $lname,
                        'or_company_name' => $cname,
                        'or_company_address' => $address,
                        'or_company_email' => $email,
                        'or_company_phone' => $mobile,
                        'or_country' => $country,
                        'or_website' => $website,
                        'or_twitter' => $twitter,
                        'or_instagram' => $instagram,
                        'or_company_desc' => $description

                    ];

                    $this->usersinfo->save($usersInfoTable);

                    $this->session->setTempdata('success', 'Account Request sent. We will get back to you as soon as possible', 3);
                    return redirect()->to(current_url());
                } else {
                    $this->session->setTempdata('error', 'Opps! Account request failed, please try again', 3);
                    return redirect()->to(current_url());
                }
            }
        }
        return view("web/organizer_signup", $data);
    }

    // Remove Quotes
    public function remove_quotes($data)
    {
        $string = strip_quotes($data);
        $string2 = strip_slashes($string);
        return $string2;
    }
}
