<?php
/**
 * Control GUI and AJAX requests
 *
 * @since	1.2
 * @package	WordPress
 */
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    wp_die;
}

set_time_limit(0); // Set time limit infinit.

add_action('admin_menu', 'cs_theme');
if (!function_exists('cs_theme')) {

    /**
     * Add Importer item to WP Admin Dashboard sidebar menu
     */
    function cs_theme() {
        add_theme_page('Import Demo Data', __('Import Demo Data', 'cs_frame'), 'read', 'cs_demo_importer', 'cs_demo_importer');
    }

}

// delete_option( 'item_purchase_code_verification' );


if (!function_exists('cs_demo_importer')) {

    /**
     * Output GUI for Demo Importer
     */
    function cs_demo_importer() {
        $theme_id = THEME_ENVATO_ID;
        $theme_name = THEME_NAME;

        if (function_exists('get_server_requirements')) {
            $server_requirements = get_server_requirements();
        } else {
            wp_die(__('Server requirements not available.', 'cs_frame'));
        }

        if (function_exists('get_plugin_requirements')) {
            $plugin_requirements = get_plugin_requirements();
        } else {
            wp_die(__('Plugin requirements not available.', 'cs_frame'));
        }

        if (function_exists('get_demo_data_structure')) {
            $demo_data_structure = get_demo_data_structure();
        } else {
            wp_die(__('Demo data structure not available.', 'cs_frame'));
        }
        ?>
        <div style="margin-left: 15px;">
            <h2><?php _e('Import Demo Data', 'cs_frame'); ?></h2>
            <form method="post">
                <div class="importer-wrapper container custom-importer">
                    <?php
                    // Check if API is available.
                    $response = wp_remote_post(REMOTE_API_URL);
                    if (is_wp_error($response)) {
                        wp_die('<h2 class="error">' . __('Sorry, It seems that API server is not available. Please, contact your hosting provider to disable Firewall and remove Strict Permissions so that request can be generated across servers to import demo data.', 'cs_frame') . '</h2>');
                    }
                    ?>
                    <div class="importer-steps-wrapper row">
                        <div class="step step-1 col-lg-3 col-md-3 col-sm-12 active">
                            <div class="title-holder">
                                <span class="title-large"><?php _e('Landing', 'cs_frame'); ?></span>
                                <span class="title-small"><?php _e('Server Requirements', 'cs_frame'); ?></span>
                            </div>
                        </div>
                        <div class="step step-2 col-lg-3 col-md-3 col-sm-12">
                            <div class="title-holder">
                                <span class="title-large"><?php _e('Validate', 'cs_frame'); ?></span>
                                <span class="title-small"><?php _e('Purchase Key', 'cs_frame'); ?></span>
                            </div>
                        </div>
                        <div class="step step-3 col-lg-3 col-md-3 col-sm-12">
                            <div class="title-holder">
                                <span class="title-large"><?php _e('Import', 'cs_frame'); ?></span>
                                <span class="title-small"><?php _e('Existing Items', 'cs_frame'); ?></span>
                            </div>
                        </div>
                        <div class="step step-4 col-lg-3 col-md-3 col-sm-12">
                            <div class="title-holder">
                                <span class="title-large"><?php _e('Done', 'cs_frame'); ?></span>
                                <span class="title-small"><?php _e('Have Fun', 'cs_frame'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="importer-steps-containers-wrapper importer-text row">
                        <div class="step-1-container">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h3><?php _e('Server Requirements', 'cs_frame'); ?></h3>
                                <ul class="importer-requirement">
                                    <?php if (!empty($server_requirements)) : ?>
                                        <?php foreach ($server_requirements as $requirement) : ?>
                                            <li>
                                                <div class="pull-left">
                                                    <div class="text-holder">
                                                        <span class="text-bold text-uppercase"><?php echo $requirement['title']; ?></span>
                                                        <span class="details"><?php echo $requirement['description']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="pull-right">
                                                    <div class="importer-version">
                                                        <span><?php echo $requirement['version']; ?></span>
                                                        <i class="<?php echo $requirement['is_met'] ? 'icon-check-circle' : 'error icon-cross5'; ?>"></i>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <a href="http://chimpgroup.com/wp-demo/documentation/documentation/jobcareer-docs" class="importer-btn">
                                            <i class="icon-book3"></i>
                                            <?php _e('Online Document', 'cs_frame'); ?>
                                        </a>	
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <a href="http://chimpgroup.com/support/" class="importer-btn help">
                                            <i class="icon-group"></i>
                                            <?php _e('Need Help?', 'cs_frame'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h3><?php _e('Plugin Requirements', 'cs_frame'); ?></h3>
                                <ul class="importer-requirement">
                                    <?php if (!empty($plugin_requirements)) : ?>
                                        <?php foreach ($plugin_requirements as $requirement) : ?>
                                            <li>
                                                <div class="pull-left">
                                                    <div class="text-holder">
                                                        <span class="text-bold text-uppercase"><?php echo $requirement['title']; ?></span>
                                                        <span class="details">
                                                            <?php echo $requirement['description']; ?>
                                                            <?php
                                                            if (!empty($requirement['new_version'])) {
                                                                echo '<br><span class="error">There is a new version ' . $requirement['new_version'] . ' available.</span>';
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="pull-right">
                                                    <div class="importer-version">
                                                        <span><?php echo $requirement['version']; ?></span>
                                                        <i class="<?php echo $requirement['is_installed'] ? 'icon-check-circle' : 'error icon-cross5'; ?>"></i>
                                                    </div>

                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                                <!--
                                <h3><?php _e('Reason for giving away', 'cs_frame'); ?></h3>
                                <p>
                                <?php _e('In order to make our products real worth of your money. We keep improving
									theme everyday. Your feedback is vital for us. We offer FREE PSDs worth 10$
									in exchange to your precious words of review on ThemeForest download section
									for the product.', 'cs_frame'); ?>
                                        
                                </p>

                                <h3><?php _e('How you can get free PSD', 'cs_frame'); ?></h3>
                                <p>
                                <?php _e('Give Review on item which you bought on ThemeForest by going to ThemeForest Downloads section.', 'cs_frame'); ?>
                                </p>
                                -->
                                <ul class="importer-social-media">
                                    <li>
                                        <a data-original-title="facebook" href="https://www.facebook.com/chimpstudiothemes"><i class="icon-facebook7"></i></a>
                                    </li>
                                    <li>
                                        <a data-original-title="google" href="https://plus.google.com/117490960128710835976/posts"><i class="icon-googleplus7"></i></a>
                                    </li>
                                    <li>
                                        <a data-original-title="twitter" href="https://twitter.com/ChimpThemes"><i class="icon-twitter6"></i></a>
                                    </li>
                                    <!--<li>
                                                    <a data-original-title="youtube" href="#"><i class="icon-youtube-play"></i></a>
                                    </li>-->
                                </ul>
                            </div>
                        </div>

                        <div class="step-2-container validate-purchase-key hidden">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h3><?php _e('Purchase code check', 'cs_frame'); ?></h3>
                                <p><?php _e('Please enter your item purchase code of ChimpStudio', 'cs_frame'); ?></p>
                                <?php
                                $envato_purchase_code_verification = get_option('item_purchase_code_verification');
                                $verify_code = true;
                                if ($envato_purchase_code_verification) {
                                    if (
                                            isset($envato_purchase_code_verification['item_id']) && $theme_id == $envato_purchase_code_verification['item_id'] && $envato_purchase_code_verification['last_verification_time'] + 30 * 24 * 60 * 60 > time()
                                    ) {
                                        $verify_code = false;
                                    }
                                }
                                ?>
                                <?php if ($verify_code) : ?>
                                    <form role="form">
                                        <div class="control-group">
                                            <label for="item-purchase-code"><?php _e('Item Purchase Code', 'cs_frame'); ?></label>
                                            <input type="text" name="item-purchase-code" id="item-purchase-code" class="form-contorl">
                                            <label class="purchase-code-error" style="color: #ff0000; display: none;"><?php _e('Please provide a valid Item Purchase Code', 'cs_frame'); ?></label>
                                            <label class="purchase-code-exists-error" style="color: #ff0000; display: none;"><?php _e('The Purchase Code is being used on another site. Please deregister it from there and then try again.', 'cs_frame'); ?></label><br>

                                            <label for="envato-email-address"><?php _e('Envato Provided Email Address', 'cs_frame'); ?></label>
                                            <input type="text" name="envato-email-address" id="envato-email-address" class="form-contorl">
                                            <br><br>
                                        </div>
                                    </form>
                                <?php else : ?>
                                    <h3 style="color: #069c14;"><?php _e('It seems that, you have already verified purchase code. Proceed to next step', 'cs_frame'); ?></h3>
                                    <input type="button" value="<?php _e('Deregister Purchase Code', 'cs_frame'); ?>" class="importer-next-btn release-purchase-code"><br><br><br>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="step-3-container hidden">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="sub-step-1">
                                    <h3><?php _e('Please choose demo', 'cs_frame'); ?></h3>
                                    <p><?php _e('Please select a demo to install demo data.', 'cs_frame'); ?></p>
                                    <ul class="demos-list importer-list row">
                                        <?php if (!empty($demo_data_structure)) : $counter = 0; ?>
                                            <?php foreach ($demo_data_structure as $demo_item) : $counter ++; ?>
                                                <li class="demo-data-item-wrapper col-lg-3 col-md-3 col-sm-6 col-xs-12" data-name="<?php echo $demo_item['slug']; ?>">
                                                    <div class="radiobox">
                                                        <input type="radio" id="demo-<?php echo $counter; ?>" value="" name="<?php echo $dmoe_item['name']; ?>">
                                                        <label for="demo-1">
                                                            <a href="#">
                                                                <img src="<?php echo $demo_item['image_url']; ?>" alt="<?php echo $demo_item['name']; ?>">
                                                            </a>
                                                        </label>
                                                    </div>
                                                    <span class="demo-title"><?php echo $demo_item['name']; ?></span>
                                                    <a href="#" class="btn-import"><i class="icon-check-circle"></i></a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <h3><?php _e('No demo data\'s defined. :(', 'cs_frame'); ?></h3>
                                        <?php endif; ?>
                                    </ul>
                                </div>

                                <div class="sub-step-2 col-lg-5 col-md-5 col-sm-12 col-xs-12 hidden">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h3><?php _e('Select what to import:', 'cs_frame'); ?></h3>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <a class="unselect-all" href="javascript:void(0);" style="float: right; font-weight: bold;padding-top: 15px;"><?php _e('Unselect All', 'cs_frame'); ?></a>
                                            <a class="select-all" href="javascript:void(0);" style="float: right; font-weight: bold;padding-top: 15px;"><?php _e('Select All', 'cs_frame'); ?>&nbsp;/&nbsp;</a>
                                        </div>
                                    </div>
                                    <?php
                                    $is_job_hunt_installed = isset($plugin_requirements['job_hunt']['is_installed']) ? $plugin_requirements['job_hunt']['is_installed'] : false;
                                    $is_rev_slider_installed = isset($plugin_requirements['rev_slider']['is_installed']) ? $plugin_requirements['rev_slider']['is_installed'] : false;
                                    ?>
                                    <ul class="job-select-demo">
                                        <li class="content-chk-wrapper following-pages hidden">
                                            <div class="radiobox">
                                                <input type="checkbox" id="chk-wp-content" value="content" name="chk-wp-content" class="checkbox-data-import-type">
                                                <label for="chk-wp-content" class="checkbox-data-import-type"><?php _e('WP Content ( Pages, Posts, etc. )', 'cs_frame'); ?></label>
                                            </div>
                                        </li>
                                        <li class="navitems-chk-wrapper following-pages hidden">
                                            <div class="radiobox">
                                                <input type="checkbox" id="chk-wp-navitems" value="navitems" name="chk-wp-navitems" class="checkbox-data-import-type">
                                                <label for="chk-wp-navitems" class="checkbox-data-import-type"><?php _e('Navigation Menu Items', 'cs_frame'); ?></label>
                                            </div>
                                        </li>
                                        <li class="media-attachments-chk-wrapper following-pages hidden">
                                            <div class="radiobox">
                                                <input type="checkbox" id="chk-wp-media-attachments" value="media_attachments" name="chk-wp-media-attachments" class="checkbox-data-import-type">
                                                <label for="chk-wp-media-attachments" class="checkbox-data-import-type"><?php _e('Media Attachments', 'cs_frame'); ?></label>
                                            </div>
                                        </li>
                                        <li class="options-chk-wrapper hidden">
                                            <div class="radiobox">
                                                <input type="checkbox" id="chk-theme-options" value="theme_options" name="chk-theme-options" class="checkbox-data-import-type">
                                                <label for="chk-theme-options" class="checkbox-data-import-type"><?php _e('Theme Options', 'cs_frame'); ?></label>	
                                            </div>
                                        </li>
                                        <li class="plugin-chk-wrapper hidden">
                                            <div class="radiobox">
                                                <input type="checkbox" id="chk-plugin-options" value="plugin_options" name="chk-plugin-options" class="checkbox-data-import-type">
                                                <label for="chk-plugin-options" class="checkbox-data-import-type"><?php _e('Plugin Options', 'cs_frame'); ?></label>	
                                            </div>
                                        </li>
                                        <li class="widgets-chk-wrapper hidden">
                                            <div class="radiobox">
                                                <input type="checkbox" id="chk-widgets" value="widgets" name="chk-widgets" class="checkbox-data-import-type">
                                                <label for="chk-widgets" class="checkbox-data-import-type"><?php _e('Widgets', 'cs_frame'); ?></label>
                                            </div>
                                        </li>
                                        <li class="menus-chk-wrapper hidden">
                                            <div class="radiobox">
                                                <input type="checkbox" id="chk-menus" value="menus" name="chk-menus" class="checkbox-data-import-type">
                                                <label for="chk-menus" class="checkbox-data-import-type"><?php _e('Menus Locations', 'cs_frame'); ?></label>
                                            </div>
                                        </li>
                                        <li class="users-chk-wrapper hidden <?php echo $is_job_hunt_installed ? '' : 'error'; ?>">
                                            <div class="radiobox">
                                                <input type="checkbox" id="chk-users" value="users" name="chk-users" class="checkbox-data-import-type" <?php echo $is_job_hunt_installed ? '' : 'disabled="disabled"'; ?>>
                                                <label for="chk-users" class="checkbox-data-import-type">
                                                    <?php _e('Users', 'cs_frame'); ?>
                                                    <?php echo $is_job_hunt_installed ? '' : '<br>' . _e('Please install Job Hunt Plugin.', 'cs_frame'); ?>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="sliders-chk-wrapper hidden <?php echo $is_rev_slider_installed ? '' : 'error'; ?>">
                                            <div class="radiobox">
                                                <input type="checkbox" id="chk-rev-slider" value="rev_slider" name="chk-rev-slider" class="checkbox-data-import-type" <?php echo $is_rev_slider_installed ? '' : 'disabled="disabled"'; ?>>
                                                <label for="chk-rev-slider" class="checkbox-data-import-type">
                                                    <?php _e('Revolution Slider', 'cs_frame'); ?>
                                                    <?php echo $is_rev_slider_installed ? '' : '<br>' . _e('Please install Revolution Slider Plugin.', 'cs_frame'); ?>
                                                </label>
                                            </div>
                                            <div class="overwrite-options">
                                                <h4><?php _e('Select what to do if following things exist:', 'cs_frame'); ?></h4>
                                                <ul class="radio-custom-holder">
                                                    <li class="animations-overwrite">
                                                        <span><?php _e('Custom Animations', 'cs_frame'); ?></span>
                                                        <input type="radio" id="rdio-custom-animations-overwrite" name="rdio-custom-animations" value="true" checked="checked">
                                                        <label for="rdio-custom-animations-overwrite"><?php _e('Overwrite', 'cs_frame'); ?></label>
                                                        <input type="radio" id="rdio-custom-animations-append" name="rdio-custom-animations" value="false">
                                                        <label for="rdio-custom-animations-append"><?php _e('Append', 'cs_frame'); ?></label>
                                                    </li>
                                                    <li class="animations-overwrite">
                                                        <span><?php _e('', 'cs_frame'); ?>Custom Navigations</span>
                                                        <input type="radio" id="rdio-custom-navigations" name="rdio-custom-navigations" value="true" checked="checked"> 
                                                        <label for="rdio-custom-navigations"><?php _e('Overwrite', 'cs_frame'); ?></label>
                                                        <input type="radio" id="rdio-custom-navigations-append" name="rdio-custom-navigations" value="false"> 
                                                        <label for="rdio-custom-navigations-append"><?php _e('Append', 'cs_frame'); ?></label>
                                                    </li>
                                                    <li class="animations-overwrite">
                                                        <span><?php _e('Static Styles', 'cs_frame'); ?></span>
                                                        <input type="radio" id="rdio-static-styles" name="rdio-static-styles" value="true" checked="checked">
                                                        <label for="rdio-static-styles"><?php _e('Overwrite', 'cs_frame'); ?></label>
                                                        <input type="radio" id="rdio-static-styles-1" name="rdio-static-styles" value="false">
                                                        <label for="rdio-static-styles-1"><?php _e('Append', 'cs_frame'); ?></label>
                                                        <input type="radio" id="rdio-static-styles-2" name="rdio-static-styles" value="none">
                                                        <label for="rdio-static-styles-2"><?php _e('Ignore', 'cs_frame'); ?></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="sub-step-3 hidden">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <h3><?php _e('Importing Demo Data:', 'cs_frame'); ?></h3>
                                        <ul class="list-process-queue">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-4-container importe-success hidden">
                            <div class="col-lg-12">
                                <i class="icon-check-circle"></i>
                                <h5><?php _e('Congratulations!!!', 'cs_frame'); ?></h5>
                                <h1><?php _e('Your demo data has been successfully imported.', 'cs_frame'); ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="cs-importer-controls-wrapper">
                        <div class="control-group pull-left">
                            <input type="button" value="<?php _e('Previous Step', 'cs_frame'); ?>" class="btn-prev-step importer-next-btn pull-left">
                        </div>
                        <div class="control-group pull-right">
                            <img src="<?php echo admin_url('/images/wpspin_light.gif'); ?>" alt="loading" class="importer-ajax-loader pull-left hidden" style="width: 15px; padding: 5px;">
                            <input type="button" value="<?php _e('Next Step', 'cs_frame'); ?>" class="btn-next-step importer-next-btn pull-right">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script type="text/javascript">
            (function ($) {
                $(function ( ) {
                    var current_step = 1;
                    var current_sub_step = 1;
                    var import_error_count = 0;
                    var is_purchase_code_verified = false;
                    var is_purchase_code_already_verified = <?php echo $verify_code ? 'false' : 'true'; ?>;
                    var is_urls_fetched = false;
                    var selected_demo = "";
                    var urls = [];

                    function change_step_callback(elem) {
                        change_step = true;
                        if (current_step == 1) {
                            // Show previous button.
                            $(".btn-prev-step").show();
                        } else if (current_step == 2) {
                            if (is_purchase_code_verified || is_purchase_code_already_verified) {
                                change_step = true;
                            } else if ($("input[name='item-purchase-code']").val() != "") {
                                $(".importer-ajax-loader").show();
                                $(".purchase-code-error").hide();
                                // Verify item purchase code.
                                $.ajax({
                                    "method": "post",
                                    "url": "<?php echo admin_url('admin-ajax.php'); ?>",
                                    "data": {
                                        "action": "cs_import_demo_data_callback",
                                        "action_type": "verify_purchase_code",
                                        "item_purchase_code": $("input[name='item-purchase-code']").val(),
                                        "envato_email_address": $("input[name='envato-email-address']").val(),
                                    },
                                    "dataType": "json",
                                    "success": function (data) {
                                        if (data.success == true) {
                                            is_purchase_code_verified = true;
                                            change_step_callback(elem);
                                            $(".importer-ajax-loader").hide();
                                        } else {
                                            if (data.message == 'already_exists') {
                                                $(".purchase-code-exists-error").show();
                                            } else {
                                                $(".purchase-code-error").show();
                                            }
                                            $(".importer-ajax-loader").hide();
                                        }
                                    }
                                });
                                // Do not change step until item purchase code is not verified.
                                change_step = false;
                            } else {
                                alert("<?php echo __('Please provide product purchase code.', 'cs_frame'); ?>");
                                change_step = false;
                            }
                        } else if (current_step == 3) {
                            if (selected_demo == "") {
                                alert("<?php echo __('Please select a demo.', 'cs_frame'); ?>");
                                change_step = false;
                            } else {
                                if (current_sub_step == 1) {
                                    if (!is_urls_fetched) {
                                        $(".importer-ajax-loader").show();
                                        $(".purchase-code-error").hide();
                                        // Get demo data urls
                                        $.ajax({
                                            "method": "post",
                                            "url": "<?php echo admin_url('admin-ajax.php'); ?>",
                                            "data": {
                                                "action": "cs_import_demo_data_callback",
                                                "action_type": "get_demo_data_urls",
                                                "item_purchase_code": $(".item-purchase-code").val(),
                                                "envato_email_address": $("input[name='envato-email-address']").val(),
                                                "item_demo_data_slug": selected_demo
                                            },
                                            "dataType": "json",
                                            "success": function (data) {
                                                if (data.success == true) {
                                                    // Show only those items for whom demo data is available.
                                                    urls = data.output.urls;
                                                    $.each(urls, function (key, value) {
                                                        var wrapper = $("." + value + "-chk-wrapper");
                                                        wrapper.show( );
                                                        var elem = wrapper.find('input[type="checkbox"]');
                                                        elem.prop("checked", elem.is(":enabled"));
                                                    });
                                                    is_urls_fetched = true;

                                                    // Remove existing conflicted pages.
                                                    $(".overwrite-options", $(".content-chk-wrapper")).remove();

                                                    // Show conflicted pages.
                                                    $(".content-chk-wrapper").append(data.output.conflicted_pages);

                                                    $(".sub-step-1").hide(function () {
                                                        $(".sub-step-2").show( );
                                                    });
                                                    current_sub_step++;
                                                    $(".importer-ajax-loader").hide();
                                                } else {
                                                    $(".importer-ajax-loader").hide();
                                                }
                                            }
                                        });
                                    }
                                    change_step = false;
                                } else if (current_sub_step == 2) {
                                    var data_types = {
                                        "content": ["content", "WP Content ( posts, pages, etc. )"],
                                        "navitems": ["navitems", "Navigation Menu Items"],
                                        "media_attachments": ["media_attachments", "Media Attachments"],
                                        "theme_options": ["options", "Theme Options"],
                                        "plugin_options": ["plugins", "Plugin Options"],
                                        "widgets": ["widgets", "Widgets"],
                                        "menus": ["menus", "Menus"],
                                        "users": ["users", "Users"],
                                        "rev_slider": ["rev_slider", "Revolution Slider"]
                                    };
                                    var queue = [];
                                    $(".checkbox-data-import-type:checked").each(function (index, elem) {
                                        var label = $(elem).val();
                                        var item = data_types[ label ];
                                        if ("content" == label) {
                                            var conflicted_pages = [];
                                            $(".chk-conflicted-pages:checked").each(function (index, elem) {
                                                conflicted_pages.push($(elem).val());
                                            });
                                            item.push(conflicted_pages);
                                        } else if ("rev_slider" == label) {
                                            var slider_options = [];
                                            slider_options.push($("input[name='rdio-custom-animations']:checked").val());
                                            slider_options.push($("input[name='rdio-custom-navigations']:checked").val());
                                            slider_options.push($("input[name='rdio-static-styles']:checked").val());

                                            item.push(slider_options);
                                        }
                                        queue.push(item);
                                    });

                                    // check there should be at least one item to import
                                    if (queue.length < 1) {
                                        alert("<?php echo __('Please select at least one item to import.', 'cs_frame'); ?>");
                                        change_step = false;
                                    } else {
                                        $(".sub-step-2").hide(function () {
                                            $(".sub-step-3").show();
                                        });

                                        $.each(queue, function (index, value) {
                                            $(".list-process-queue").append('<li class="' + value[0] + '-item"><div class="pull-left"><span class="message">Importing ' + value[1] + '...</span></div><div class="pull-right"><i class="item-status waiting"></i></div></li>');
                                        });

                                        $(elem).hide( );
                                        $(".btn-prev-step").hide();
                                        process_importer_queue(queue);
                                        change_step = false;
                                    }
                                }
                            }
                        } else if (current_step == 4) {
                            current_step--;
                            change_step = true;
                        }

                        // Change step.
                        if (change_step) {
                            $(".step-" + current_step).removeClass("active");
                            $(".step-" + current_step + "-container").fadeOut(function () {
                                current_step += 1;
                                $(".step-" + current_step).addClass("active");
                                $(".step-" + current_step + "-container").fadeIn();
                            });
                        }
                    }

                    $(".btn-next-step").click(function () {
                        change_step_callback(this);
                    });

                    // Hide previous button on first step.
                    $(".btn-prev-step").hide( );

                    $(".btn-prev-step").click(function () {
                        var change_step = false;
                        if (current_step == 1 || current_step == 2) {
                            change_step = true;
                        } else if (current_step == 3) {
                            if (current_sub_step == 1) {
                                is_purchase_code_verified = false;
                                change_step = true;
                            } else if (current_sub_step == 2) {
                                is_urls_fetched = false;
                                current_sub_step--;
                                $(".sub-step-2").hide(function ( ) {
                                    $(".sub-step-1").show();
                                });
                            }
                        }


                        // Change step.
                        if (change_step) {
                            $(".step-" + current_step).removeClass("active");
                            $(".step-" + current_step + "-container").fadeOut(function ( ) {
                                current_step--;
                                $(".step-" + current_step).addClass("active");
                                $(".step-" + current_step + "-container").fadeIn( );
                                if (current_step == 1) {
                                    $(".btn-prev-step").hide();
                                }
                            });
                        }
                    });

                    $(".demo-data-item-wrapper").click(function () {
                        selected_demo = $(this).data("name");
                        return false;
                    });

                    function process_importer_queue(queue) {

                        item = queue.shift( );
                        data_type_name = item[0];
                        data_type_label = item[1];
                        other_data = "";
                        if ("content" == data_type_name || "rev_slider" == data_type_name) {
                            other_data = item[2];
                        }
                        var data = {
                            "action": "cs_import_demo_data_callback",
                            "action_type": "import_data",
                            "selected_demo": selected_demo,
                            "import_type": data_type_name,
                            "other_data": other_data,
                        };

                        $(".item-status", $(".list-process-queue li." + data_type_name + "-item")).removeClass("waiting").addClass("processing");
                        // Import data one by one from queue.
                        jQuery.ajax({
                            "type": "POST",
                            "url": "<?php echo admin_url('admin-ajax.php'); ?>",
                            "data": data,
                            "dataType": "json",
                            "success": function (data) {
                                var parentNode = $(".list-process-queue li." + data_type_name + "-item");

                                if (data.status == true) {
                                    $(".item-status", parentNode).removeClass("processing").addClass("icon-check-circle done");
                                    $(".message", parentNode).text(data_type_label + " successfully imported.");
                                } else {
                                    import_error_count++;
                                    $(".item-status", parentNode).removeClass("processing").addClass("error icon-cross5");
                                    $(".message", parentNode).text("Unable to import " + data_type_label);
                                }

                                if (queue.length > 0) {
                                    process_importer_queue(queue);
                                } else {
                                    add_to_active_themes();
                                    if (import_error_count < 1) {
                                        current_step++;
                                        change_step_callback(this);
                                    }
                                }
                            },
                            "error": function (xhr, ajaxOptions, thrownError) {
                                var parentNode = $(".list-process-queue li." + data_type_name + "-item");
                                $(".item-status", parentNode).removeClass("processing").addClass("error icon-cross5");
                                $(".message", parentNode).text("Unable to import " + data_type_label);
                                import_error_count++;
                                if (queue.length > 0) {
                                    process_importer_queue(queue);
                                }
                            }
                        });
                    }


                    function add_to_active_themes() {
                        $.ajax({
                            "method": "post",
                            "url": "<?php echo admin_url('admin-ajax.php'); ?>",
                            "data": {
                                "action": "add_to_active_themes",
                                "selected_demo": selected_demo,
                            },
                            "dataType": "json",
                            "success": function (data) {
                                console.log(data);
                            }
                        });
                    }

                    $('.release-purchase-code').click(function ( ) {
                        $.ajax({
                            "method": "post",
                            "url": "<?php echo admin_url('admin-ajax.php'); ?>",
                            "data": {
                                "action": "release_purchase_code",
                            },
                            "dataType": "json",
                            "success": function (data) {
                                location.reload();
                            }
                        });
                    });

                    $('.importer-list li').click(function ( ) {
                        $(this).addClass('importer-list-active').siblings( ).removeClass('importer-list-active');
                    });

                    $("#chk-wp-content,#chk-rev-slider").bind("change", function ( ) {
                        $(this).parent( ).parent( ).find(".overwrite-options").toggle($(this).is(":checked"));
                    });

                    $("#setting-error-tgmpa, #message, .notice").hide( );

                    jQuery('.sub-step-2 .select-all').click(function () {
                        //jQuery(this).hide();
                        jQuery('.sub-step-2 .unselect-all').show();
                        jQuery('.job-select-demo').find('input:checkbox').each(function () {
                            var disabled = jQuery(this).attr('disabled');
                            if (disabled !== 'disabled') {
                                jQuery(this).attr('checked', true);
                                jQuery(this).change();
                            }
                        });
                    });
                    jQuery('.sub-step-2 .unselect-all').click(function () {
                        //jQuery(this).hide();
                        jQuery('.sub-step-2 .select-all').show();
                        jQuery('.job-select-demo').find('input:checkbox').each(function () {
                            var disabled = jQuery(this).attr('disabled');
                            if (disabled !== 'disabled') {
                                jQuery(this).attr('checked', false);
                                jQuery(this).change();
                            }
                        });
                    });
                });
            })(jQuery);
        </script>
        <?php
    }

}

add_action('wp_ajax_cs_import_demo_data_callback', 'cs_import_demo_data_callback');

/**
 * Handle AJAX improt demo data calls
 */
function cs_import_demo_data_callback() {
    $remote_api_url = REMOTE_API_URL;
    $action_type = isset($_POST['action_type']) ? $_POST['action_type'] : '';
    if ('import_data' == $action_type) {
        if (!class_exists('CS_Data_Importer')) {
            require_once cs_framework::plugin_dir() . 'include/cs-importer/cs-data-importer.php';
        }

        $selected_demo = isset($_POST['selected_demo']) ? $_POST['selected_demo'] : '';
        $import_type = isset($_POST['import_type']) ? $_POST['import_type'] : '';

        if (empty($selected_demo) || empty($import_type)) {
            echo __('Incomplete requested parameters', 'cs_frame');
            wp_die();
        }

        $envato_purchase_code_verification = get_option('item_purchase_code_verification');
        if (!empty($envato_purchase_code_verification)) {
            $urls = json_decode($envato_purchase_code_verification['urls'], true);

            if (isset($urls[$selected_demo])) {
                $urls = $urls[$selected_demo];
            } else {
                echo json_encode(array('success' => false, 'message' => __('Sorry, i don\'t have URLs to import for this demo.', 'cs_frame')));
                wp_die();
            }
        } else {
            echo json_encode(array('success' => false, 'message' => __('Sorry, i don\'t have URLs to import.', 'cs_frame')));
            wp_die();
        }

        $cs_importer = new CS_Data_Importer();
        $cs_importer->demo_data_name = $selected_demo;

        if ('content' == $import_type) {
            // Delete conflicted pages if any selected by user.
            $selected_conflicted_pages = isset($_POST['other_data']) ? $_POST['other_data'] : array();
            foreach ($selected_conflicted_pages as $key => $val) {
                // Get post by title.
                $page_to_be_deleted = get_page_by_title($val);
                if ($page_to_be_deleted) {
                    wp_delete_post($page_to_be_deleted->ID, true);
                }
            }

            $cs_importer->homepage_slug = $cs_importer->demo_data_name . '-home';
            $cs_importer->wp_data_path = isset($urls['content-new']) ? $urls['content-new'] : '';
            $cs_importer->is_content = true;
        } elseif ('navitems' == $import_type) {
            $cs_importer->wp_data_path = isset($urls['navitems']) ? $urls['navitems'] : '';
            $cs_importer->is_navitems = true;
        } elseif ('media_attachments' == $import_type) {
            $cs_importer->wp_data_path = isset($urls['media-attachments']) ? $urls['media-attachments'] : '';
            $cs_importer->attachments_path = isset($urls['attachments']) ? $urls['attachments'] : '';
            $cs_importer->is_attachments_zip = true;
            $cs_importer->is_media_attachments = true;
        } elseif ('widgets' == $import_type) {
            $cs_importer->widget_data_path = isset($urls['widgets']) ? $urls['widgets'] : '';
            $cs_importer->is_widgets = true;
        } elseif ('options' == $import_type) {
            $cs_importer->theme_options_data_path = isset($urls['options']) ? $urls['options'] : '';
            $cs_importer->is_theme_options = true;
        } elseif ('users' == $import_type) {
            $cs_importer->users_data_path = isset($urls['users']) ? $urls['users'] : '';
            $cs_importer->is_users = true;
        } elseif ('menus' == $import_type) {
            $cs_importer->menus_data_path = isset($urls['menus']) ? $urls['menus'] : '';
            $cs_importer->is_menus = true;
        } elseif ('plugins' == $import_type) {
            $cs_importer->plugins_data_path = isset($urls['plugin']) ? $urls['plugin'] : '';
            $cs_importer->is_plugins = true;
        } elseif ('rev_slider' == $import_type) {
            $cs_importer->sliders_data_path = isset($urls['sliders']) ? $urls['sliders'] : '';
            $cs_importer->is_sliders = true;
            $cs_importer->sliders_options = isset($_POST['other_data']) ? $_POST['other_data'] : array(false, false, false);
        }

        $cs_importer->import();
    } elseif ('verify_purchase_code' == $action_type) {
        $envato_purchase_code_verification = get_option('item_purchase_code_verification');
        $item_purchase_code = isset($_POST['item_purchase_code']) ? $_POST['item_purchase_code'] : '';
        $envato_email_address = isset($_POST['envato_email_address']) ? $_POST['envato_email_address'] : '';

        $validate_purchase_code_now = false;
        if ($envato_purchase_code_verification) {
            // If last verfication is past 30 days ago then do that again.
            if (
                    $item_purchase_code == $envato_purchase_code_verification['item_purchase_code'] && $envato_purchase_code_verification['last_verification_time'] + 30 * 24 * 60 * 60 > time()
            ) {
                $success = true;
            } else {
                $validate_purchase_code_now = true;
            }
        } else {
            $validate_purchase_code_now = true;
        }
        $success = false;

        $url = $remote_api_url;

        $verify_post_data = array(
            'action' => 'check_purchase_code',
            'theme_puchase_code' => $item_purchase_code,
            'site_url' => site_url(),
        );
        $verify_response = wp_remote_post($url, array('body' => $verify_post_data));

        if (isset($verify_response['body']) && $verify_response['body'] < 1) {
            // Validate purchase code now if it is required.
            if ($validate_purchase_code_now) {
                $url = $remote_api_url;
                $post_data = array(
                    'action' => 'verify_purchase_code',
                    'item_purchase_code' => $item_purchase_code,
                    'item_id' => THEME_ENVATO_ID,
                    'theme_name' => THEME_NAME,
                );

                $response = wp_remote_post($url, array('body' => $post_data));

                if (is_wp_error($response)) {
                    $success = false;
                } else {
                    $body = json_decode($response['body'], true);

                    if ('true' == $body['success']) {
                        $data_for_option = [
                            'last_verification_time' => time(),
                            'item_puchase_code' => $item_purchase_code,
                            'envato_email_address' => $envato_email_address,
                            'item_name' => THEME_NAME,
                            'item_id' => THEME_ENVATO_ID,
                            'supported_until' => date("Y-m-d H:i:s", strtotime(json_decode($response['body'])->supported_until)),
                            'urls' => json_encode($body['urls']),
                        ];
                        if ($envato_purchase_code_verification) {
                            update_option('item_purchase_code_verification', $data_for_option);
                        } else {
                            add_option('item_purchase_code_verification', $data_for_option);
                        }
                        $success = true;
                    } else {
                        $success = false;
                    }
                }
            } else {
                $success = false;
            }
            echo json_encode(array('success' => $success));
        } else {
            echo json_encode(array('success' => $success, 'message' => 'already_exists'));
        }
    } elseif ('get_demo_data_urls' == $action_type) {
        $envato_purchase_code_verification = get_option('item_purchase_code_verification');
        $demo_data_name = isset($_POST['item_demo_data_slug']) ? $_POST['item_demo_data_slug'] : '';
        $output = array();
        if (!empty($envato_purchase_code_verification)) {
            $urls = json_decode($envato_purchase_code_verification['urls'], true);

            if (isset($urls[$demo_data_name])) {
                $output['urls'] = array_keys($urls[$demo_data_name]);
                $output['conflicted_pages'] = cs_get_importer_conflicted_pages($demo_data_name);
            }
        }
        $is_success = ( empty($output) === false );
        echo json_encode(array('success' => $is_success, 'output' => $output));
    } else {
        echo __('Invalid action type.', 'cs_frame');
    }
    wp_die();
}

if (!function_exists('cs_get_importer_conflicted_pages')) {

    /**
     * Return conflicted pages for the demo data in importer
     *
     * @param	string	$demo_data_name	demo data type/name.
     * @return	string	a string containing all conflicted pages HTML generated.
     */
    function cs_get_importer_conflicted_pages($demo_data_name) {
        $output = '';
        $confliced_pages_file = cs_framework::plugin_dir() . 'include/cs-importer/conflicts.php';
        if (file_exists($confliced_pages_file)) {
            require_once $confliced_pages_file;
            $conflicted_pages = $conflicted_pages[$demo_data_name];
            foreach ($conflicted_pages as $key => $name) {
                if (get_page_by_title($name) == null) {
                    unset($conflicted_pages[$key]);
                }
            }
        } else {
            $conflicted_pages = array();
        }
        if (!empty($conflicted_pages)) {
            ob_start();
            ?>
            <div class="overwrite-options">
                <h4 style="font-weight: bold;">Either rename following pages or Select Pages to be deleted on conflict:</h4>
                <ul>
                    <?php foreach ($conflicted_pages as $key => $val) : ?>
                        <li>
                            <input type="checkbox" id="<?php echo $val; ?>" class="chk-conflicted-pages" name="conflicted_pages[]" value="<?php echo $val; ?>" checked="checked">
                            <label for="<?php echo $val; ?>"><?php echo $val; ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
            $output = ob_get_contents();
            ob_end_clean();
        }
        return $output;
    }

}


if (!function_exists('cs_delete_default_content_callback')) {
    add_action('cs_delete_default_content', 'cs_delete_default_content_callback');

    function cs_delete_default_content_callback() {
        // Find and delete the WP default 'Sample Page'
        $defaultPage = get_page_by_title('Sample Page');
        if (isset($defaultPage->ID) && $defaultPage->ID != '') {
            wp_delete_post($defaultPage->ID, true);
        }

        // Find and delete the WP default 'Hello world!' post
        $defaultPost = get_posts(array('title' => 'Hello World!'));
        if (isset($defaultPost[0]->ID) && $defaultPost[0]->ID != '') {
            wp_delete_post($defaultPost[0]->ID, true);
        }
    }
}

if (!function_exists('jobcareer_unserialize')) {
    function jobcareer_unserialize($string) {
        $string = preg_replace_callback(
            '!s:(\d+):"(.*?)";!s',
            function ($matches) {
                if ( isset( $matches[2] ) )
                    return 's:'.strlen($matches[2]).':"'.$matches[2].'";';
            },
            $string
        );
        return unserialize($string);
    }
}
