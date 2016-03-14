<div class="wrap">
    <h2>Site scanner options page</h2>
    <form method="post" action="options.php">
        <?php settings_fields( 'wp_scanner' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Scan interval hours</th>
                <td><input type="text" name="scan_interval" value="<?php echo get_option('scan_interval') ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Enable posts scan</th>
                <td><input type="checkbox" name="enable_posts_scan" value="1" <?php checked(1 == get_option('enable_posts_scan')); ?> /></td>
            </tr>
             <tr valign="top">
                <th scope="row">Enable files scan</th>
                <td><input type="checkbox" name="enable_files_scan" value="1" <?php checked(1 == get_option('enable_files_scan')); ?> /></td>
            </tr>               
             <tr valign="top">
                <th scope="row">Scan directories</th>
                <td><input type="text" name="directories" value="<?php echo get_option('directories') ?>" /></td>
            </tr>
             <tr valign="top">
                <th scope="row">Scan pattern</th>
                <td><input type="text" name="pattern" value="<?php echo get_option('pattern') ?>" /></td>
            </tr>
             <tr valign="top">
                <th scope="row">Post types</th>
                <td><input type="text" name="post_types" value="<?php echo get_option('post_types') ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Inform emails</th>
                <td><input type="text" name="emails" value="<?php echo get_option('emails') ?>" /></td>
            </tr>
        </table>
        <p class="submit"><input type="submit" value="<?php _e('Save changes') ?>" /></p>
    </form>
</div>
