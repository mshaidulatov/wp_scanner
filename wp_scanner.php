<?php 
    /*
    Plugin Name: WP Scan Site
    Description: Plugin for checking site changes
    Author: M. Olefirenko
    Version: 1.3.4
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
    register_setting('wp_scanner_menu','call_back');
    register_setting('wp_scanner_menu','call_back_phone');
    register_setting('wp_scanner_menu','feedback');
    register_setting('wp_scanner_menu','feedback_email');
    register_setting('wp_scanner_menu','search_form');
    register_setting('wp_scanner_menu','menu');
    register_setting('wp_scanner','scan_date');
    set_cron_job();    
}

function add_admin_page() {
    add_options_page("Scan Site Plugin Settings","Scan Site Plugin",'administrator',"scaner","plugin_options_page1");
    add_options_page("Scan Site Plugin Settings","Sticky Menu",'administrator',"sticky_menu","plugin_options_page2");
}

function plugin_options_page1() {
    include("admin_page.php");
}

function plugin_options_page2() {
    include("admin_page_menu.php");
}

function set_cron_job() {
    if ( ! wp_next_scheduled( 'scan_cron_action' ) ) {
        wp_schedule_event( time(), 'twicedaily', 'scan_cron_action' );
    }    
}

function deactivate_plugin() {
    wp_clear_scheduled_hook('scan_cron_action');
}

function scan_action($output) {
    update_option('scan_date',date("Y-m-d H:m:s",current_time('timestamp',0)));
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

function wp_head_add() {
    include('sticky_menu/modal.php');
    include('sticky_menu/stickytab.php');
}

function wp_scripts_add() {
    wp_enqueue_script('ajax-contact',plugin_dir_url( __FILE__ ).'sticky_menu/ajax-contact.js');
    wp_enqueue_script('modal',plugin_dir_url( __FILE__ ).'sticky_menu/modal.js');
    wp_enqueue_script('stickytab',plugin_dir_url( __FILE__ ).'sticky_menu/stickytab.js');
    wp_enqueue_style('modal',plugin_dir_url( __FILE__ ).'sticky_menu/modal.css');
    wp_enqueue_style('stickytab',plugin_dir_url( __FILE__ ).'sticky_menu/_stickytab.css');
}

require 'plugin-update-checker/plugin-update-checker.php';
$className = PucFactory::getLatestClassVersion('PucGitHubChecker');
$myUpdateChecker = new $className(
    'https://github.com/molefirenko/wp_scanner/',
    __FILE__,
    'master'
);

add_action('scan_event','scan_action');
add_action('admin_menu','add_admin_page');
add_action('admin_init','init_admin_page');
add_action('wp_head','wp_head_add');
add_action('wp_enqueue_scripts','wp_scripts_add');
add_action('scan_cron_action','scan_action');
register_deactivation_hook(__FILE__, 'deactivate_plugin');

