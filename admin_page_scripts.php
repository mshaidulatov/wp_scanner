<div class="wrap">
    <h2>Scripts menu options page</h2>
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php settings_fields( 'wp_scripts_menu' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Verge</th>
                <td><input type="checkbox" name="verge" value="1" <?php checked(1 == get_option('verge')); ?> /></td>
            </tr>  
             <tr valign="top">
                <th scope="row">Owl Carousel</th>
                <td><input type="checkbox" name="owl_carousel" value="1" <?php checked(1 == get_option('owl_carousel')); ?> /></td>
            </tr>     
            <tr valign="top">
                <th scope="row">Ajax contact</th>
                <td><input type="checkbox" name="ajax-contact" value="1" <?php checked(1 == get_option('ajax-contact')); ?> /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Modal</th>
                <td><input type="checkbox" name="modal" value="1" <?php checked(1 == get_option('modal')); ?> /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Sticky tab</th>
                <td><input type="checkbox" name="stickytab" value="1" <?php checked(1 == get_option('stickytab')); ?> /></td>
            </tr>            
            <tr valign="top">
                <th scope="row">Sticky tab css</th>
                <td><input type="checkbox" name="stickytab_css" value="1" <?php checked(1 == get_option('stickytab_css')); ?> /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Modal css</th>
                <td><input type="checkbox" name="modal_css" value="1" <?php checked(1 == get_option('modal_css')); ?> /></td>
            </tr>
        </table>
        <p class="submit"><input type="submit" value="<?php _e('Save changes') ?>" /></p>
    </form>
</div>


