<?php

class check_files {
    public $directories = array('wp-content');
    //   /.*\.php|.*\.js/i
    public $pattern = '/.*\.php|.*\.js/i';
    public $last_time;
    
    private function rglob($dir,$pattern) {
        $files = array();
        $filenames=glob($dir."/*",GLOB_NOSORT);
        if ($filenames==false) {
            return $files;            
        }
        foreach ($filenames as $filename) {
            if (is_dir($filename)) {
                $files = array_merge($files,$this->rglob($filename,$pattern));   
            }
            elseif (preg_match($pattern,$filename)) {
                   $files[] = $filename; 
            }
        }
        return $files;
    }
    
    public function search_files() {
        $message = '';
        $result = array();
        $file_array = array();
        foreach ($this->directories as $directory) {
            $directory = get_home_path().$directory;
            $result = array_merge($result,$this->rglob($directory,$this->pattern));
        }
        if (empty($result)) {
            die("Files not found"); 
        }
        foreach ($result as $file) {
            $filetime = filemtime($file);
            if ($filetime > $this->last_time) {
                $message = $file.": ".date("Y-m-d H:m:s",$filetime).";";
                $file_array[] = $message;
            }
        }
        return $file_array;
    }
    
    public function send_report($emails) {
        $files = $this->search_files();
        $time = current_time('Y-m-d H:m:s',0);
        $subject = get_bloginfo('name').". File changes report($time)";

        if ($emails=="") {
            return "No emails to send";
        }
        if (empty($files)) {
            $message = "No file chaged since last scan";
            foreach ($emails as $email) {
                wp_mail($email,$subject,$message);
            }
            return "No file chaged since last scan";
        }
        $time = current_time('Y-m-d H:m:s',0);
        $subject = get_bloginfo('name').". File changes report($time)";
        $message = "Following files were changed since last scan: \n";
        foreach ($files as $file) {
            $message .= $file."\n";
        }
        foreach ($emails as $email) {
            wp_mail($email,$subject,$message);
        }
        return $message;
    }
}

