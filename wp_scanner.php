<?php 
    /*
    Plugin Name: WP Scan Site
    Description: Plugin for checking site changes
    Author: M. Olefirenko
    Version: 1.3
    */

function init_admin_page() {
    register_setting('wp_scanner','last_scan_time');
    register_setting('wp_scanner','enable_posts_scan');
    register_setting('wp_scanner','enable_files_scan');
    register_setting('wp_scanner','directories');
    register_setting('wp_scanner','pattern');
    register_setting('wp_scanner','emails');
    register_setting('wp_scanner','scan_interval');
    register_setting('wp_scanner','post_types');
    register_setting('wp_scanner','call_back');
    register_setting('wp_scanner','call_back_phone');
    register_setting('wp_scanner','feedback');
    register_setting('wp_scanner','feedback_email');
    register_setting('wp_scanner','search_form');
    register_setting('wp_scanner','menu');
}

function add_admin_page() {
    add_options_page("Scan Site Plugin Settings","Scan Site Plugin",'administrator',"scaner","plugin_options_page");
}

function plugin_options_page() {
    include("admin_page.php");
}

function cron_add_scan_interval($schedules) {
    $schedules['scan_interval'] = array(
        'interval' => 30,
        'display' => __('Scan interval for WP Scan Site')
    );
    return $schedules;
}

function scan_action($output) {
    $files_output = "";
    $posts_output = "";
    if (get_option('enable_files_scan')==1) {
        $files_output = scan_files();
    }
    if (get_option('enable_posts_scan')==1) {
        $posts_output = scan_posts();
    }
    update_option('last_scan_time',time());
    if ($output) {
        echo $files_output."<br/>";
        echo $posts_output."<br/>";
    }
    update_option('last_scan_time',current_time('timestamp',0));
}

function scan_files() {
    include("check_files.php");
    $check_files = new check_files();
    $check_files->last_time = get_option('last_scan_time');
    $check_files->directories = explode(',',get_option('directories'));
    $check_files->pattern = get_option('pattern');
    return $check_files->send_report(explode(',',get_option('emails')));
}

function scan_posts() {
    include("check_posts.php");
    $check_posts = new check_posts();
    $check_posts->last_time = get_option('last_scan_time');
    $check_posts->post_types = explode(',',get_option('post_types'));
    return $check_posts->send_report(explode(',',get_option('emails')));
}

add_action('scan_event','scan_action');
add_action('admin_menu','add_admin_page');
add_action('admin_init','init_admin_page');

require 'plugin-update-checker/plugin-update-checker.php';
$className = PucFactory::getLatestClassVersion('PucGitHubChecker');
$myUpdateChecker = new $className(
    'https://github.com/molefirenko/wp_scanner/',
    __FILE__,
    'master'
);

