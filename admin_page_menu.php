<div class="wrap">
    <h2>Sticky menu options page</h2> 
    <form method="post" action="options.php">
        <?php settings_fields( 'wp_scanner_menu' ); ?>
        <table class="form-table">
             <tr valign="top">
                <th scope="row">Inform emails</th>
                <td><input type="text" name="emails" value="<?php echo get_option('emails') ?>" /></td>
            </tr>
             <tr valign="top">
                <th scope="row">Call back</th>
                <td><input type="text" name="call_back_phone" value="<?php echo get_option('call_back_phone') ?>" />
                    <input type="checkbox" name="call_back" value="1" <?php checked(1 == get_option('call_back')); ?> />
                </td>
            </tr>  
             <tr valign="top">
                <th scope="row">Feedback</th>
                <td><input type="text" name="feedback_email" value="<?php echo get_option('feedback_email') ?>" />
                    <input type="checkbox" name="feedback" value="1" <?php checked(1 == get_option('feedback')); ?> />
                </td>
            </tr>     
             <tr valign="top">
                <th scope="row">Search form</th>
                <td><input type="checkbox" name="search_form" value="1" <?php checked(1 == get_option('search_form')); ?> /></td>
            </tr>
             <tr valign="top">
                <th scope="row">Menu</th>
                <td><input type="checkbox" name="menu" value="1" <?php checked(1 == get_option('menu')); ?> /></td>
            </tr>
        </table>
        <p class="submit"><input type="submit" value="<?php _e('Save changes') ?>" /></p>
    </form>
</div>

