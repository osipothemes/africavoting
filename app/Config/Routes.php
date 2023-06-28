<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

service('auth')->routes($routes);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->group('/', ['namespace' => 'App\Controllers\Web'], function ($routes) {
    $routes->get('', 'Home::index');
    $routes->get('projects/finished', 'Home::completed_projects');
    $routes->match(['post', 'get'], 'process-payment', 'Home::process_payment');
    // $routes->get('projects/finished', 'Home::finished_projects');
    $routes->get('projects/upcoming', 'Home::finished_projects');
    $routes->get('projects/results/(:any)', 'Home::project_results/$1');
    $routes->post('projects/update-project', 'Home::update_project');
    $routes->post('participants/update-participant', 'Home::update_participant');
    $routes->match(['post', 'get'], 'projects/vote/(:any)', 'Home::vote/$1');
    $routes->match(['post', 'get'], 'participant/vote/(:any)', 'Home::vote_participant/$1');
    $routes->get('participants/details/(:any)', 'Home::participant_details/$1');
    $routes->match(['post', 'get'], 'participants/process-payment', 'Home::process_payment');
    $routes->match(['post', 'get'], 'payment-success', 'Home::successLink');
    $routes->get('terms', 'Home::terms');
    $routes->get('privacy-policy', 'Home::privacy_policy');
    $routes->post('contact-us', 'Home::contact_us');
    // $routes->match(['post', 'get'], 'projects/search/(:any)', 'Home::search/$1');
    $routes->match(['post', 'get'], 'organizer/signup', 'Home::organizer_signup');
    $routes->match(['post', 'get'], 'users/auth', 'Home::user_authentication');
    $routes->match(['post', 'get'], 'users/logout', 'Home::logout_user');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], ['filter' => 'group:superadmin'], function ($routes) {
    $routes->get('/', 'Home::index');
    // Projects
    $routes->get('projects/all-projects', 'Home::projects_list');
    $routes->match(['post', 'get'], 'projects/add-project', 'Home::add_project');
    $routes->match(['post', 'get'], 'projects/edit-project/(:any)', 'Home::edit_project/$1');
    $routes->match(['post', 'get'], 'projects/delete-project/(:any)', 'Home::delete_project/$1');
    $routes->get('projects/all-editions', 'Home::editions_list');
    $routes->get('projects/running-editions', 'Home::running_editions');
    $routes->get('projects/ended-editions', 'Home::ended_editions');
    $routes->match(['post', 'get'], 'projects/add-edition', 'Home::add_edition');
    $routes->match(['post', 'get'], 'projects/edit-edition/(:any)', 'Home::edit_edition/$1');

    // Participants
    $routes->match(['post', 'get'], 'participants/all-participants', 'Home::participants_list');
    $routes->match(['post', 'get'], 'participants/add-participants', 'Home::add_participants');
    $routes->match(['post', 'get'], 'participants/edit-participant/(:any)', 'Home::edit_participant/$1');
    $routes->get('participants/rankings', 'Home::participants_rankings');

    // Organizers
    $routes->get('organizers/active', 'Home::active_organizers');
    $routes->get('organizers/pending', 'Home::pending_organizers');
    $routes->post('organizers/activate-organizer/(:any)', 'Home::activate_organizer/$1');

    // Admins
    $routes->get('all-admins', 'Home::all_admins');
    $routes->match(['post', 'get'], 'add-admin', 'Home::add_admins');
});

$routes->group('organizer', ['namespace' => 'App\Controllers\Organizer'], ['filter' => 'group:beta'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->match(['post', 'get'], 'profile/(:any)', 'Home::profile/$1');
    $routes->match(['post', 'get'], 'security-settings/(:any)', 'Home::security_settings/$1');

    // Projects
    $routes->match(['post', 'get'], 'projects/(:any)', 'Home::organizer_projects/$1');
    $routes->match(['post', 'get'], 'add-projects', 'Home::add_project');
    $routes->match(['post', 'get'], 'edit-project/(:any)', 'Home::edit_project/$1');
    $routes->get('all-editions', 'Home::editions_list');
    $routes->get('running-editions', 'Home::running_editions');
    $routes->get('ended-editions', 'Home::ended_editions');
    $routes->match(['post', 'get'], 'add-edition', 'Home::add_edition');
    $routes->match(['post', 'get'], 'edit-edition/(:any)', 'Home::edit_edition/$1');

    // Participants
    $routes->match(['post', 'get'], 'participants/add-participants', 'Home::add_participant');
    $routes->match(['post', 'get'], 'participants/all-participants', 'Home::participants_list');
    $routes->match(['post', 'get'], 'participants/edit-participant/(:any)', 'Home::edit_participant/$1');
    $routes->get('participants/rankings', 'Home::participants_rankings');

    // Reports
    $routes->post('participants/rankings/report', 'Home::participants_rankings_report');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
