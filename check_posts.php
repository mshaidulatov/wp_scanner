<?php
class check_posts {
    public $last_time;
    public $posts_type;
    function get_modified_posts($last_time,$posts_type) {
        global $wpdb;
        $result = array();
        $posts = $wpdb->get_results("SELECT * from $wpdb->posts",OBJECT);
        foreach ($posts as $post) {
            if (in_array($post->post_type,$posts_type)) {
                $post_time = strtotime($post->post_modified_gmt);
                if ($post_time > $last_time) {
                    $result[] = " ID: ".$post->ID.": ".$post->post_modified_gmt.", Home: ".get_bloginfo('name').", Title: ".$post->post_title.", Post type: ".$post->post_type.";";
                }
            }
        }
        return $result;
    }
    
    public function send_report($emails) {
        $posts = $this->get_modified_posts($this->last_time,$this->posts_type);
        if (empty($emails)) {
            return "No emails to send";
        }
        if (empty($posts)) {
            return "No posts modified since last time";
        }
        else {
            $time = current_time('Y-m-d H:m:s',1);
            $subject = get_bloginfo('name')." - Content changes report ($time)";
            $message = "Following posts were changed since last scan:\n";
            foreach ($posts as $post) {
                $message .= $post."\n";
            }
            foreach ($emails as $email) {
                wp_mail($mail,$subject,$message);
            }
        }
        return $message;
    }
    
}

