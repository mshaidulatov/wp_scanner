<?php

/*
Plugin Name: CW Tools
Description: Plugin for checking site changes
Author: M. Olefirenko
Version: 1.4.7
*/

function init_admin_page() {
    register_setting('wp_scanner','last_scan_time');
    register_setting('wp_scanner','enable_posts_scan');
    register_setting('wp_scanner','enable_files_scan');
    register_setting('wp_scanner','directories');
    register_setting('wp_scanner','pattern');
    register_setting('wp_scanner','emails');
    register_setting('wp_scanner','scan_date');
    register_setting('wp_scanner','scan_interval');
    register_setting('wp_scanner','post_types');  
    
    register_setting('wp_scanner_menu','call_back');
    register_setting('wp_scanner_menu','call_back_phone');
    register_setting('wp_scanner_menu','feedback');
    register_setting('wp_scanner_menu','feedback_email');
    register_setting('wp_scanner_menu','search_form');
    register_setting('wp_scanner_menu','menu');  
    
    register_setting('wp_scripts_menu','verge');
    register_setting('wp_scripts_menu','owl_carousel');
    register_setting('wp_scripts_menu','ajax-contact');
    register_setting('wp_scripts_menu','modal');
    register_setting('wp_scripts_menu','stickytab');
    register_setting('wp_scripts_menu','stickytab_css');
    register_setting('wp_scripts_menu','modal_css');   
}

function add_admin_page() {    
    add_menu_page("CW Tools Settings Page","CW Tools","administator","cw_tools","cw_menu_page");
    add_submenu_page("cw_tools","CW Tools","Scan Site","administrator","scaner","plugin_options_page1");
    add_submenu_page("cw_tools","CW Tools","Sticky Menu","administrator","sticky_menu","plugin_options_page2");
    add_submenu_page("cw_tools","CW Tools","Scripts Menu","administrator","scripts_menu","plugin_options_page3");
}

function cw_menu_page() {
   include("admin_page.php"); 
   add_filter( 'cron_schedules', 'add_my_interval' );
   set_cron_job();
}

function plugin_options_page1() {
    include("admin_page.php");
    add_filter( 'cron_schedules', 'add_my_interval' );
    set_cron_job();
}

function plugin_options_page2() {
    include("admin_page_menu.php");
}

function plugin_options_page3() {
    include("admin_page_scripts.php");
}

function set_cron_job() {
    if ( ! wp_next_scheduled( 'scan_cron_action' ) ) {
        wp_schedule_event( time(), 'my_interval', 'scan_cron_action' );
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
    if (get_option("verge") == 1) {
        wp_enqueue_script('verge',plugin_dir_url( __FILE__ ).'sticky_menu/verge.min.js');
    }
    if (get_option("owl_carousel") == 1) {
        wp_enqueue_script('owl_carousel',plugin_dir_url( __FILE__ ).'sticky_menu/owl.carousel.js');
    }
    if (get_option("ajax-contact") == 1) {
        wp_enqueue_script('ajax-contact',plugin_dir_url( __FILE__ ).'sticky_menu/ajax-contact.js');
    }
    if (get_option("modal") == 1) {
        wp_enqueue_script('modal',plugin_dir_url( __FILE__ ).'sticky_menu/modal.js');
    }
    if (get_option("stickytab") == 1) {
        wp_enqueue_script('stickytab',plugin_dir_url( __FILE__ ).'sticky_menu/stickytab.js');
    }
    if (get_option("stickytab_css") == 1) {
        wp_enqueue_style('stickytab',plugin_dir_url( __FILE__ ).'sticky_menu/_stickytab.css');
    }
    if (get_option("modal_css") == 1) {
        wp_enqueue_style('modal',plugin_dir_url( __FILE__ ).'sticky_menu/modal.css');
    }
}

function add_my_interval( $schedules ) {
    $schedules['my_interval'] = array(
        'interval' => 3600*intval(get_option('scan_interval')),
        'display' => __('My Interval')
    );
    return $schedules;
}


require 'plugin-update-checker/plugin-update-checker.php';
$className = PucFactory::getLatestClassVersion('PucGitHubChecker');
$myUpdateChecker = new $className(
    'https://github.com/mshaidulatov/wp_scanner/',
    __FILE__,
    'master'
);

add_action('admin_menu','add_admin_page');
add_action('admin_init','init_admin_page');
add_action('wp_head','wp_head_add');
add_action('wp_enqueue_scripts','wp_scripts_add');
add_action('scan_cron_action','scan_action');
register_deactivation_hook(__FILE__, 'deactivate_plugin');
