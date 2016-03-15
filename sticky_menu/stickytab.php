<?php
/**
 * Displays Sticky Tab
 * @package WordPress
 * @subpackage ClearCut Web Project 2.0
 * @since ClearCut Web Project 2.0
 */

?>

<div class="sticky-container">
    <?php if (get_option('feedback') == 1) { ?>
    <div class="sticky-item sticky-contact">
        <a class="expandable"  href="#"><img alt="contact us" src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/mailbox-icon.png" /></a>
        <div>
            <form id="mobile-contact" class="ajax-contact" method="post">
                <label for="telephone-mobile">Phone</label>
                <input id="telephone-mobile" name="phone number" type="tel"  class="required" placeholder="Phone *" autocorrect="off" autocomplete="tel" tabindex="1">
                <label for="email-mobile">Email</label>
                <input id="email-mobile" name="email_address" type="email" class="required data-email" placeholder="email@email.com *" autocapitalize="off" autocorrect="off" autocomplete="email" tabindex="2">
                <input class="submit_contact" type="submit" value="SEND">
            </form>
        </div>
    </div>
    <?php } ?>
    
    <?php if (get_option('search_form') == 1) { ?>
    <div class="sticky-item sticky-search">
        <a class="expandable" href="#"><img alt="search" src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/search-icon.png" /></a>
        <div>
            <!-- Search Form -->
            <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" >
                <input name="s" id="s" class="stxt" value="<?php echo get_search_query() ?>" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" type="search" placeholder="Search">
                <input class="sbtn" value="GO" type="submit">
            </form>
            <!-- Search form EOF -->
        </div>
    </div>
    <?php } ?>
    
    <?php if (get_option('call_back')) { ?>
    <div class="sticky-item call-back">
        <a href="tel:<?php echo get_option('call_back_phone'); ?>" class="mobile-menu"/>Call Now</a>
    </div>
    <?php } ?>
    
    <?php if (get_option('menu')) { ?>
    <div class="sticky-item sticky-menu">
        <input type="button" class="mobile-menu" value="menu" />
        <nav>
            <?php wp_nav_menu( array( 'theme_location' => 'header_menu', 'container' => false, 'menu_class' => 'top-menu', 'menu' => 'top'));?>
        </nav>
    </div>
    <?php } ?>
</div>
