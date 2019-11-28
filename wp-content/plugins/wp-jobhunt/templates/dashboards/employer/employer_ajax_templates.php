<?php
/**
 * File Type: Employer Ajax Templates
 */
if (!class_exists('cs_employer_ajax_templates')) {

    class cs_employer_ajax_templates {

        /**
         * Start construct Functions
         */
        public function __construct() {
            // Profile
            add_action('wp_ajax_cs_employer_ajax_profile', array(&$this, 'cs_employer_ajax_profile'));
            add_action('wp_ajax_nopriv_cs_employer_ajax_profile', array(&$this, 'cs_employer_ajax_profile'));
            // Transactions
            add_action('wp_ajax_cs_ajax_trans_history', array(&$this, 'cs_ajax_trans_history'));
            add_action('wp_ajax_nopriv_cs_ajax_trans_history', array(&$this, 'cs_ajax_trans_history'));
            // Job Management
            add_action('wp_ajax_cs_ajax_manage_job', array(&$this, 'cs_ajax_manage_job'));
            add_action('wp_ajax_nopriv_cs_ajax_manage_job', array(&$this, 'cs_ajax_manage_job'));
            // Favourite Resumes
            add_action('wp_ajax_cs_ajax_fav_resumes', array(&$this, 'cs_ajax_fav_resumes'));
            add_action('wp_ajax_nopriv_cs_ajax_fav_resumes', array(&$this, 'cs_ajax_fav_resumes'));
            // Job Packages
            add_action('wp_ajax_cs_ajax_job_packages', array(&$this, 'cs_ajax_job_packages'));
            add_action('wp_ajax_nopriv_cs_ajax_job_packages', array(&$this, 'cs_ajax_job_packages'));
            // Change Password
            add_action('wp_ajax_cs_employer_change_password', array(&$this, 'cs_change_password'));
            add_action('wp_ajax_nopriv_cs_employer_change_password', array(&$this, 'cs_change_password'));
        }

        /**
         * Start Function for Creating of employer profile in Ajax
         */
        public function cs_employer_ajax_profile($uid = '') {
            global $post, $current_user, $cs_form_fields2, $cs_form_fields_frontend, $cs_plugin_options;

            if (!is_user_logged_in()) {
                echo 'Please register/login yourself as a employer to access this page.';
                wp_die();
            }
            $cs_emp_funs = new cs_employer_functions();
            if ($uid == '') {
                $uid = (isset($_POST['cs_uid']) and $_POST['cs_uid'] <> '') ? $_POST['cs_uid'] : $current_user->ID;
            }
            if ($uid != '') {
                $cs_user_data = get_userdata($uid);
                $cs_comp_name = $cs_user_data->display_name;
                $cs_comp_detail = $cs_user_data->description;
                $cs_user_status = get_user_meta($uid, 'cs_user_status', true);
                $cs_minimum_salary = get_user_meta($uid, 'cs_minimum_salary', true);
                $cs_allow_search = get_user_meta($uid, 'cs_allow_search', true);
                $cs_facebook = get_user_meta($uid, 'cs_facebook', true);
                $cs_twitter = get_user_meta($uid, 'cs_twitter', true);
                $cs_google_plus = get_user_meta($uid, 'cs_google_plus', true);
                $cs_linkedin = get_user_meta($uid, 'cs_linkedin', true);
                $cs_phone_number = get_user_meta($uid, 'cs_phone_number', true);
				$first_name = get_user_meta($uid, 'first_name', true);
                $cs_email = $cs_user_data->user_email;
                $cs_website = $cs_user_data->user_url;
                $cs_value = get_user_meta($uid, 'user_img', true);
                $cs_cover_employer_img_value = get_user_meta($uid, 'cover_user_img', true);
                $imagename_only = $cs_value;
                $cover_imagename_only = $cs_cover_employer_img_value;
                $cs_jobhunt = new wp_jobhunt();
                $cs_emploayer_dashboard_vew = isset($cs_plugin_options['cs_employer_dashboard_view']) ? $cs_plugin_options['cs_employer_dashboard_view'] : '';
                ?>
                <div class="cs-loader"></div>
                <?php if ($cs_emploayer_dashboard_vew == 'default' && $cs_comp_name != '') { ?>
                    <h3 class="cs-candidate-title"><?php printf(esc_html__('Hi '.$first_name.', welcome to your employer account', 'jobhunt'), esc_html($cs_comp_name)) ?></h3>
                <?php } ?>
                <form id="cs_employer_form" name="cs_employer_form"  enctype="multipart/form-data" method="post">
                    <div class="dashboard-content-holder">
                        <?php do_action('jobhunt_featured_employer_popup_button', $uid); ?>
                        <div class="dashboard-content-holder">
                            <div class="cs-account-info">
                                <?php if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'default') { ?>
                                   <!--<div class="cs-img-detail">
                                        <div class="cs-cover-img">  
                                            <div class="alert alert-dismissible user-img"> 
                                                <div class="page-wrap" id="cs_cover_employer_img_box">
                                                    <figure>
                                                        <?php
                                                        if ($cs_cover_employer_img_value <> '') {
                                                            $cs_cover_employer_img_value = cs_get_img_url($cs_cover_employer_img_value, 'cs_media_0');
                                                            ?>
                                                            <img src="<?php echo esc_url($cs_cover_employer_img_value); ?>" id="cs_cover_employer_img_img" width="100" alt="" />
                                                        <?php } else { ?>
                                                            <img src="<?php echo esc_url($cs_jobhunt->plugin_url()); ?>assets/images/no-cover.jpg" id="cs_cover_employer_img_img" width="100" alt="" />
                                                        <?php } ?>
                                                    </figure>
                                                </div>
                                            </div>
                                            <div class="upload-btn-div">
                                                <div class="fileUpload uplaod-btn btn cs-color csborder-color">
                                                    <span class="cs-color" ><?php esc_html_e('Browse Cover', 'jobhunt'); ?></span>
                                                    <i class="icon-camera6"></i>
                                                    <?php
                                                    $cs_opt_array = array(
                                                        'std' => $imagename_only,
                                                        'id' => '',
                                                        'return' => true,
                                                        'cust_id' => 'cs_employer_img',
                                                        'cust_name' => 'cs_employer_img',
                                                        'prefix' => '',
                                                    );
                                                    echo force_balance_tags($cs_form_fields2->cs_form_hidden_render($cs_opt_array));
                                                    $cs_opt_array = array(
                                                        'std' => $cover_imagename_only,
                                                        'id' => '',
                                                        'return' => true,
                                                        'cust_id' => 'cs_cover_employer_img',
                                                        'cust_name' => 'cs_cover_employer_img',
                                                        'prefix' => '',
                                                    );
                                                    echo force_balance_tags($cs_form_fields2->cs_form_hidden_render($cs_opt_array));
                                                    $cs_opt_array = array(
                                                        'std' => esc_html__('Browse Cover', 'jobhunt'),
                                                        'id' => '',
                                                        'return' => true,
                                                        'force_std' => true,
                                                        'cust_id' => '',
                                                        'cust_name' => 'cover_media_upload',
                                                        'classes' => 'left cs-cover-uploadimg upload',
                                                        'cust_type' => 'file',
                                                    );
                                                    echo force_balance_tags($cs_form_fields2->cs_form_text_render($cs_opt_array));
                                                    ?>
                                                </div>
                                                <br />
                                                <span id="cs_employer_profile_cover_msg" style="display:none;"><?php esc_html_e('Max file size is 1MB, Minimum dimension: 1600x400 And Suitable files are .jpg & .png', 'jobhunt') ?></span>
                                            </div>
                                        </div>
                                    </div>-->
                                <?php } ?>
                                <?php if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'fancy') { ?>
                                    <div class="cs-img-detail">
                                        <div class="cs-cover-img">  
                                            <div class="alert alert-dismissible user-img"> 
                                                <div class="page-wrap" id="cs_cover_employer_img_box">
                                                    <figure>
                                                        <?php
                                                        if ($cs_cover_employer_img_value <> '') {
                                                            $cs_cover_employer_img_value = cs_get_img_url($cs_cover_employer_img_value, 'cs_media_0');
                                                            ?>
                                                            <img src="<?php echo esc_url($cs_cover_employer_img_value); ?>" id="cs_cover_employer_img_img" width="100" alt="" />
                                                        <?php } else { ?>
                                                            <img src="<?php echo esc_url($cs_jobhunt->plugin_url()); ?>assets/images/no-cover.jpg" id="cs_cover_employer_img_img" width="100" alt="" />
                                                        <?php } ?>
                                                    </figure>
                                                </div>
                                            </div>
                                            <div class="upload-btn-div">
                                                <div class="fileUpload uplaod-btn btn cs-color csborder-color">
                                                    <span class="cs-color" ><?php esc_html_e('Browse Cover', 'jobhunt'); ?></span>
                                                    <i class="icon-camera6"></i>
                                                    <?php
                                                    $cs_opt_array = array(
                                                        'std' => $imagename_only,
                                                        'id' => '',
                                                        'return' => true,
                                                        'cust_id' => 'cs_employer_img',
                                                        'cust_name' => 'cs_employer_img',
                                                        'prefix' => '',
                                                    );
                                                    echo force_balance_tags($cs_form_fields2->cs_form_hidden_render($cs_opt_array));
                                                    $cs_opt_array = array(
                                                        'std' => $cover_imagename_only,
                                                        'id' => '',
                                                        'return' => true,
                                                        'cust_id' => 'cs_cover_employer_img',
                                                        'cust_name' => 'cs_cover_employer_img',
                                                        'prefix' => '',
                                                    );
                                                    echo force_balance_tags($cs_form_fields2->cs_form_hidden_render($cs_opt_array));
                                                    $cs_opt_array = array(
                                                        'std' => esc_html__('Browse Cover', 'jobhunt'),
                                                        'id' => '',
                                                        'return' => true,
                                                        'force_std' => true,
                                                        'cust_id' => '',
                                                        'cust_name' => 'cover_media_upload',
                                                        'classes' => 'left cs-cover-uploadimg upload',
                                                        'cust_type' => 'file',
                                                    );
                                                    echo force_balance_tags($cs_form_fields2->cs_form_text_render($cs_opt_array));
                                                    ?>
                                                </div>
                                                <br />
                                                <span id="cs_employer_profile_cover_msg" style="display:none;"><?php esc_html_e('Max file size is 1MB, Minimum dimension: 1600x400 And Suitable files are .jpg & .png', 'jobhunt') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="scetion-title">
                                    <h4><?php esc_html_e('Account Details', 'jobhunt'); ?></h4>
                                </div>
                                <div class="input-info">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label><?php esc_html_e('Company name', 'jobhunt') ?></label>
                                            <?php
                                            $cs_opt_array = array(
                                                'cust_id' => 'company_name',
                                                'cust_name' => 'company_name',
                                                'std' => '',
                                                'desc' => '',
                                                'classes' => 'form-control',
                                                'extra_atr' => ' placeholder="' . esc_html__('Company name', 'jobhunt') . '"',
                                                'hint_text' => '',
                                            );
                                            $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                            ?>
                                        </div>
                                    </div>

                                    <?php
                                    $nicolas_active = false;
                                    $nicolas_active = apply_filters('wp_jobhunt_nicolas_plugin_active', $nicolas_active);
                                    if (!$nicolas_active) {
                                        ?>
                                        <div class="row">
                                            <?php
                                            global $cs_plugin_options;
                                            $cs_allow_in_search_user_switch = isset($cs_plugin_options['cs_allow_in_search_user_switch']) ? $cs_plugin_options['cs_allow_in_search_user_switch'] : '';
                                            if (isset($cs_allow_in_search_user_switch) && $cs_allow_in_search_user_switch == 'on') {
                                                ?>

                                                <?php
                                            }
                                            $specialisms_label = esc_html__('Specialisms', 'jobhunt');
                                            $specialisms_label = apply_filters('jobhunt_replace_specialisms_to_categories', $specialisms_label);
                                            ?>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <label><?php echo esc_html($specialisms_label); ?></label>
                                                <div class="select-holder">
                                                    <?php echo cs_get_specialisms_dropdown('cs_specialisms', 'cs_specialisms', $uid, 'form-control chosen-select', true) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label><?php esc_html_e('Personal Profile', 'jobhunt'); ?> </label>
                                                <p>Please enter a brief profile of yourself. You can add to it and revise it later.(Max 1000 characters)</p>
                                                <?php
                                                $cs_comp_detail = (isset($cs_comp_detail)) ? $cs_comp_detail : '';
                                                echo $cs_form_fields2->cs_form_textarea_render(
                                                        array('name' => esc_html__('Personal Profile', 'jobhunt'),
                                                            'id' => 'comp_detail',
                                                            'classes' => 'col-md-12',
                                                            'cust_name' => 'comp_detail',
                                                            'std' => $cs_comp_detail,
                                                            'description' => '',
                                                            'return' => true,
                                                            'array' => true,
                                                            'cs_editor' => true,
                                                            'force_std' => true,
                                                            'hint' => ''
                                                        )
                                                );
                                                ?>
                                            </div>
                                        </div>

                                    <?php } ?>


                                </div>
                            </div>
                        </div>
                        <div class="cs-social-network">
                            <div class="scetion-title">
                                <h4><?php esc_html_e('Social Network', 'jobhunt'); ?></h4>
                            </div>
                            <div class="input-info">
                                <div class="row">
                                    <div class="social-media-info">
                                        <div class="social-input col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <?php
                                            $social_required_field = true;
                                            $social_required_field = apply_filters('jobhunt_remove_validation_check', $social_required_field);
                                            //$social_required_field = ( $social_required_field == true ) ? ' required="required"' : '';
                                            $cs_opt_array = array(
                                                'id' => 'facebook',
                                                'std' => $cs_facebook,
                                                'desc' => '',
                                                'extra_atr' => ' placeholder="' . esc_html__('Facebook', 'jobhunt') . '"',
                                                'classes' => 'form-control',
                                                'hint_text' => '',
                                            );
                                            $cs_opt_array['extra_atr'] .= $social_required_field;
                                            $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                            ?>
                                            <i class="icon-facebook2"></i> 
                                        </div>
                                        <div class="social-input col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <?php
                                            $cs_opt_array = array(
                                                'id' => 'twitter',
                                                'std' => $cs_twitter,
                                                'desc' => '',
                                                'extra_atr' => ' placeholder="' . esc_html__('Twitter', 'jobhunt') . '"',
                                                'classes' => 'form-control',
                                                'hint_text' => '',
                                            );
                                            $cs_opt_array['extra_atr'] .= $social_required_field;
                                            $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                            ?>
                                            <i class="icon-twitter6"></i> </div>
                                        <div class="social-input col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php
                                            $cs_opt_array = array(
                                                'id' => 'linkedin',
                                                'std' => $cs_linkedin,
                                                'desc' => '',
                                                'extra_atr' => ' placeholder="' . esc_html__('Linkedin', 'jobhunt') . '"',
                                                'classes' => 'form-control',
                                                'hint_text' => '',
                                            );
                                            $cs_opt_array['extra_atr'] .= $social_required_field;
                                            $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                            ?>
                                            <i class="icon-linkedin4"></i> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php //do_action('jobhunt_employer_images_video_fields', $cs_user_data); ?>
                        <div class="cs-contact-info">
                            <div class="scetion-title">
                                <h4><?php esc_html_e('Contact Information', 'jobhunt'); ?></h4>
                            </div>
                            <div class="input-info">
                                <div class="row">
                                    <div class="social-input col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label><?php esc_html_e('Phone Number', 'jobhunt'); ?></label>
                                        <?php
                                        $cs_opt_array = array(
                                            'id' => 'phone_number',
                                            'std' => $cs_phone_number,
                                            'desc' => '',
                                            'extra_atr' => ' placeholder="' . esc_html__('Phone Number', 'jobhunt') . '"',
                                            'classes' => 'form-control',
                                            'hint_text' => '',
                                            'return' => true,
                                        );
                                        //$cs_form_fields2->cs_form_text_render($cs_opt_array);
                                        $field = $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                        $field = apply_filters('jobhunt_profile_phone_field', $field, $uid);
                                        echo $field;
                                        ?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label><?php esc_html_e('Email Address', 'jobhunt'); ?></label>
                                        <?php
                                        $cs_opt_array = array(
                                            'cust_id' => 'user_email',
                                            'cust_name' => 'user_email',
                                            'std' => $cs_email,
                                            'desc' => '',
                                            'extra_atr' => ' placeholder="' . esc_html__('Email Address', 'jobhunt') . '"',
                                            'classes' => 'form-control',
                                            'hint_text' => '',
                                        );
                                        $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                        ?>
                                    </div>
                                    <div class="social-input col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label><?php esc_html_e('Website', 'jobhunt'); ?></label>
                                        <?php
                                        $cs_opt_array = array(
                                            'cust_id' => 'user_url',
                                            'cust_name' => 'user_url',
                                            'std' => $cs_website,
                                            'desc' => '',
                                            'extra_atr' => ' placeholder="' . esc_html__('Website', 'jobhunt') . '"',
                                            'classes' => 'form-control',
                                            'hint_text' => '',
                                        );
                                        $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                        ?>
                                    </div>
                                    <?php
                                    cs_get_google_autocomplete_fields('user');
                                    do_action('jobhunt_frontend_location_fields', $uid, 'employer_profile', $current_user);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $cs_job_cus_fields = get_option("cs_employer_cus_fields");
                        if (is_array($cs_job_cus_fields) && sizeof($cs_job_cus_fields) > 0) {
                            ?>
                            <section class="cs-social-network">
                                <div class="scetion-title">
                                    <h4><?php esc_html_e('Extra Information', 'jobhunt'); ?></h4>
                                </div>
                                <div class="input-info">
                                    <div class="row">
                                        <div class="social-media-info">
                    <?php echo force_balance_tags($cs_emp_funs->cs_employer_custom_fields($uid)); ?>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <?php
                        }
                        ?>
                        <section class="cs-update-btn">
                            <?php
                            $cs_opt_array = array(
                                'std' => 'update_profile',
                                'id' => '',
                                'echo' => true,
                                'cust_id' => 'user_profile',
                                'cust_name' => 'user_profile',
                            );
                            $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                            $cs_opt_array = array(
                                'std' => $uid,
                                'id' => '',
                                'echo' => true,
                                'cust_id' => 'cs_user',
                                'cust_name' => 'cs_user',
                            );
                            $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                            ?>
                            <a href="javascript:void(0);" name="button_action" class="acc-submit cs-section-update cs-color csborder-color" onclick="javascript:ajax_employer_profile_form_save('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js(wp_jobhunt::plugin_url()); ?>', 'cs_employer_form')"><?php esc_html_e('Update', 'jobhunt'); ?></a>
                            <?php
                            $cs_opt_array = array(
                                'std' => 'ajax_employer_form_save',
                                'id' => '',
                                'echo' => true,
                                'cust_name' => 'action',
                            );
                            $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                            $cs_opt_array = array(
                                'std' => $uid,
                                'id' => '',
                                'echo' => true,
                                'cust_name' => 'post_id',
                            );
                            $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                            ?>
                        </section>  
                    </div>
                </form>
                <?php
                do_action('jobhunt_rafal_welcome_notification', $uid);
                ?>
                <script type="text/javascript">
                    if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
                        var config = {
                            '.chosen-select': {width: "100%"},
                            '.chosen-select-deselect': {allow_single_deselect: true},
                            '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%"},
                            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                            '.chosen-select-width': {width: "95%"}
                        }
                        for (var selector in config) {
                            jQuery(selector).chosen(config[selector]);
                        }
                    }
                    jQuery(document).ready(function ($) {
                        //chosen_selectionbox();
                    });
                </script>
                <?php
                die();
            }
        }

        /**
         * Change Password funciton
         */
        public function cs_change_password() {
            $html = '
            <div class="scetion-title">
                <h3>' . esc_html__('Change Password', 'jobhunt') . '</h3>
				<p>Choose a unique password to protect your account</p>
				<p>Choose a password that will be hard for others to guess</p>
            </div>
            <div class="change-pass-content-holder">
                <div class="input-info">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>' . esc_html__('Type your current password', 'jobhunt') . '</label>
                            <input type="password" name="old_password" class="form-control" >
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>' . esc_html__('Type your new password', 'jobhunt') . '</label>
                            <input type="password" name="new_password" class="form-control" >
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>' . esc_html__('Retype your new password', 'jobhunt') . '</label>
                            <input type="password" name="confirm_password" class="form-control" >
                        </div>
                        <div class="col-md-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="button" value="' . esc_html__('Update', 'jobhunt') . '" id="employer-change-pass-trigger" class="acc-submit cs-section-update cs-color csborder-color">   
                        </div>
                    </div>
                </div>
            </div>';
            echo force_balance_tags($html);
            die;
        }

        /**
         * Start Function how to manage job in ajax funciton
         */
        public function cs_ajax_manage_job() {
            global $post, $cs_plugin_options;
            if (class_exists('cs_employer_functions')) {
                $cs_emp_funs = new cs_employer_functions();
            }
            $uid = (isset($_POST['cs_uid']) and $_POST['cs_uid'] <> '') ? $_POST['cs_uid'] : '';
            $cs_uri = (isset($_POST['cs_uri']) and $_POST['cs_uri'] <> '') ? $_POST['cs_uri'] : '';
            if ($uid != '') {
                $userdata = get_userdata($uid);
                ?>
                <div class="cs-manage-jobs">
                    <?php
                    $cs_emp_dashboard = isset($cs_plugin_options['cs_emp_dashboard']) ? $cs_plugin_options['cs_emp_dashboard'] : '';
                    if ($cs_emp_dashboard != '') {
                        $cs_employer_link = get_permalink($cs_emp_dashboard);
                    } else {
                        $cs_employer_link = cs_server_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    }
                    $cs_blog_num_post = ( isset($cs_plugin_options['cs_job_dashboard_pagination']) && $cs_plugin_options['cs_job_dashboard_pagination'] != '' ) ? $cs_plugin_options['cs_job_dashboard_pagination'] : 10;
                    if (empty($_REQUEST['page_id_all']))
                        $_REQUEST['page_id_all'] = 1;
                    $args = array(
                        'posts_per_page' => $cs_blog_num_post,
                        'paged' => $_REQUEST['page_id_all'],
                        'post_type' => 'jobs',
                        'post_status' => 'publish',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'cs_job_username',
                                'value' => $userdata->user_login,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'cs_job_status',
                                'value' => 'delete',
                                'compare' => '!=',
                            ),
                        ),
                        'orderby' => 'ID',
                        'order' => 'DESC',
                    );
                    $custom_query = new WP_Query($args);
                    $count_post = $custom_query->found_posts;
                    ?>
                    <div class="scetion-title">
                        <h3><?php esc_html_e('Manage Jobs', 'jobhunt') ?></h3>
                    </div>
                    <div class="field-holder">
                        <?php
                        if ($custom_query->have_posts()) {
                            $get_uid = ( isset($_GET['uid']) && $_GET['uid'] <> '' ) ? '&amp;uid=' . $_GET['uid'] : '';

                            $remove_candidate_role = 'no';
                            $remove_candidate_role = apply_filters('jobhunt_remove_candidate_role_frontend', $remove_candidate_role);
                            ?>
                            <ul class="dashboard-list">
                                <li><span><span><?php echo absint($cs_emp_funs->posted_jobs_num($uid)) ?></span><em><?php esc_html_e('Job Posted', 'jobhunt') ?></em></span><i class="icon-suitcase5"></i></li>
                                <?php
                                $candidate_enable = true;
                                $candidate_enable = apply_filters('jobhunt_candidate_enable', $candidate_enable);
                                ?>
                                <?php if ($candidate_enable == true && $remove_candidate_role != 'yes') { ?>
                                    <li><span><span><?php echo absint($cs_emp_funs->all_jobs_apps($uid)) ?></span><em><?php esc_html_e('Applications', 'jobhunt'); ?></em></span><i class="icon-building"></i></li>
                                <?php } else { ?>
                                    <li>&nbsp;</li>
                                <?php } ?>
                                <li><span><span id="cs_user_total_active_job"><?php echo absint($cs_emp_funs->active_jobs_num($uid)) ?></span><em><?php esc_html_e('Active Jobs', 'jobhunt'); ?></em></span><i class="icon-graph"></i></li>
                            </ul>
                            <div class="dashboard-content-holder">
                                <ul class = "managment-list">
                                    <?php
                                    while ($custom_query->have_posts()) : $custom_query->the_post();
                                        global $post;
                                        $job_title = $post->post_title;
                                        $job_id = $post->ID;
                                        $job_status_link_allow = 1;
                                        $cs_job_package = get_post_meta($job_id, "cs_job_package", true);
                                        $cs_job_expired = get_post_meta($job_id, "cs_job_expired", true);
                                        $cs_job_status = get_post_meta($job_id, "cs_job_status", true);
                                        if ($cs_job_expired < current_time('timestamp')) { // check job expire
                                            $job_status_link_allow = 0;
                                            update_post_meta($job_id, 'cs_job_status', 'inactive');
                                        }
                                        $cs_job_status = get_post_meta($job_id, "cs_job_status", true);
                                        $cs_job_featured = get_post_meta($job_id, 'cs_job_featured', true);
                                        $cs_job_all_status = array('awaiting-activation' => esc_html__('Awaiting Activation', 'jobhunt'), 'active' => esc_html__('Active', 'jobhunt'), 'inactive' => esc_html__('Inactive', 'jobhunt'));
                                        $cs_shortlisted = count_usermeta('cs-user-jobs-wishlist', serialize(strval($job_id)), 'LIKE');
                                        if (strpos($cs_employer_link, "?") !== false) {
                                            $cs_url = $cs_employer_link . "&profile_tab=editjob&job_id=" . $job_id . $get_uid . "&action=edit";
                                        } else {
                                            $cs_url = $cs_employer_link . "?profile_tab=editjob&job_id=" . $job_id . $get_uid . "&action=edit";
                                        }
                                        // job status link
                                        $current_status = 'active';
                                        $cs_eye_class = 'icon-eye-slash';
                                        $status_toot_tip_text = esc_html__('Active', 'jobhunt');
                                        if ($cs_job_status == 'active') {
                                            $cs_eye_class = 'icon-eye3';
                                            $current_status = 'inactive';
                                            $status_toot_tip_text = esc_html__('Inactive', 'jobhunt');
                                        }
                                        //sataus link allow`
                                        if ($cs_job_status != 'active' && $cs_job_status != 'inactive') // check staus diffrent 
                                            $job_status_link_allow = 0;
                                        if ($cs_job_expired < current_time('timestamp')) // check job expire
                                            $job_status_link_allow = 0;
                                        $cs_apps = 0;
                                        // Getting job application count
                                        $cs_applicants = count_usermeta('cs-user-jobs-applied-list', serialize(strval($job_id)), 'LIKE', true);

                                        $cs_apps += count($cs_applicants);
                                        $cs_apps = apply_filters('jobhunt_count_multi_applications_by_job', $cs_apps, $cs_applicants, $job_id);
                                        ?>
                                        <li>
                                            <div class="manag-title">
                                                <h6><a href="<?php echo esc_url(get_permalink($job_id)); ?>"><?php
                                                        if ($cs_job_featured == 'yes' || $cs_job_featured == 'YES' || $cs_job_featured == 'on') {
                                                            echo '<span>' . esc_html__('Featured', 'jobhunt') . '</span>';
                                                        }
                                                        ?><?php if (isset($job_title)) echo esc_html($job_title); ?></a></h6>
                                                <?php
                                                if ($cs_job_expired != '') {
                                                    ?>
                                                    <div class="expire-date <?php if ($cs_job_expired < strtotime(date('Y-m-d'))) echo ' error-msg'; ?>"><?php echo esc_html__('Expire date:', 'jobhunt'); ?> <span><?php echo date_i18n(get_option('date_format'), $cs_job_expired); ?></span></div>
                                                    <?php
                                                }
                                                ?>
                                                <div class="last-update"><?php echo esc_html__('Last Update:', 'jobhunt') ?> <span><?php the_modified_date(); ?></span></div>
                                            </div>
                                            <div class="list-holder">
                                                <?php
                                                $candidate_enable = true;
                                                $candidate_enable = apply_filters('jobhunt_candidate_enable', $candidate_enable);
                                                ?>
                                                <div class="shortlist">
                                                    <?php if ($candidate_enable == true && $remove_candidate_role != 'yes') { ?>
                                                        <a href="<?php echo esc_url($cs_employer_link) ?>?job_id=<?php echo esc_html($job_id) ?>&profile_tab=applicants&action=applicants" data-toggle="tooltip" data-placement="top" title="<?php echo absint($cs_apps) . " " . esc_html__("Application(s)", 'jobhunt'); ?>" >
                                                            <span><?php echo '<em>' . absint($cs_apps) . '</em> ' . esc_html__('Application(s)', 'jobhunt') ?></span>
                                                        </a>
                                                    <?php } else { ?>
                                                        &nbsp;
                                                    <?php } ?>
                                                </div>
                                                <div id="cs_job_status_html<?php echo esc_html($job_id); ?>" class="application"><?php
                                                    if (isset($cs_job_all_status[$cs_job_status]))
                                                        echo esc_html($cs_job_all_status[$cs_job_status]);
                                                    else
                                                        echo esc_html__("Awaiting Activation", "jobhunt");
                                                    ?></div>
                                                <div class="control">
                                                    <?php if ($job_status_link_allow == 1) { ?>
                                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo esc_html($status_toot_tip_text); ?>" id="cs_job_link<?php echo esc_html($job_id); ?>" href="javascript:void(0);" onclick="cs_job_status_update('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_html($job_id); ?>', '<?php echo esc_html($current_status); ?>')"><i class="<?php echo sanitize_html_class($cs_eye_class) ?>"></i></a>
                                                    <?php } else {
                                                        ?><i class="<?php echo sanitize_html_class($cs_eye_class) ?>"></i><?php
                                                        }
                                                        ?>
                                                    <a data-toggle="tooltip" data-placement="top" title="<?php echo esc_html__("Edit Job", "jobhunt"); ?>" href="<?php echo esc_url($cs_url) ?>"><i class="icon-edit3"></i></a>
                                                    <a data-toggle="tooltip" data-placement="top" title="<?php echo esc_html__("Remove Job", "jobhunt"); ?>" id="cs-job-<?php echo absint($job_id) ?>" onclick="cs_job_delete('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($job_id) ?>')" data-toggle="tooltip" data-original-title="<?php echo esc_html($status_toot_tip_text); ?>" ><i class="icon-trash-o"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                    endwhile;
                                    ?>
                                </ul>
                            </div>
                            <?php
                            //==Pagination Start
                            if ($count_post > $cs_blog_num_post && $cs_blog_num_post > 0) {
                                echo '<nav>';
                                echo cs_ajax_pagination($count_post, $cs_blog_num_post, 'jobs', 'employer', $uid, '');
                                echo '</nav>';
                            }//==Pagination End 
                        } else {
                            echo '<div class="cs-no-record">' . cs_info_messages_listing(esc_html__("There is no record in job list", 'jobhunt')) . '</div>';
                        }
                        ?>
                    </div>
                </div>
                <script>
                    jQuery(document).ready(function () {
                        jQuery('[data-toggle="tooltip"]').tooltip();
                    });

                </script>
                <?php
                die();
            }
        }

        /**
         * Start Function Transaction in Ajax function
         */
        public function cs_ajax_trans_history() {
            global $post, $cs_plugin_options, $gateways;
            $general_settings = new CS_PAYMENTS();
            $currency_sign = jobcareer_get_currency_sign();
            $cs_emp_dashboard = isset($cs_plugin_options['cs_emp_dashboard']) ? $cs_plugin_options['cs_emp_dashboard'] : '';
            $cs_emp_funs = new cs_employer_functions();
            $uid = (isset($_POST['cs_uid']) and $_POST['cs_uid'] <> '') ? $_POST['cs_uid'] : '';
            $cs_blog_num_post = ( isset($cs_plugin_options['cs_job_dashboard_pagination']) && $cs_plugin_options['cs_job_dashboard_pagination'] != '' ) ? $cs_plugin_options['cs_job_dashboard_pagination'] : 10;
            if ($uid != '') {
                if (empty($_REQUEST['page_id_all']))
                    $_REQUEST['page_id_all'] = 1;
                $args = array(
                    'posts_per_page' => $cs_blog_num_post,
                    'paged' => $_REQUEST['page_id_all'],
                    'post_type' => 'cs-transactions',
                    'post_status' => 'publish',
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'cs_transaction_user',
                            'value' => $uid,
                            'compare' => '=',
                        ),
                    ),
                    'orderby' => 'ID',
                    'order' => 'DESC',
                );
                $custom_query = new WP_Query($args);
                $count_records = $custom_query->found_posts;
                ?>
                <div class="cs-transection">
                    <div class="scetion-title">
                        <h3><?php esc_html_e('Transactions', 'jobhunt') ?></h3>
                    </div>
                    <div class="field-holder">
                        <?php
                        if ($custom_query->have_posts()) {
                            $page_link = get_permalink($cs_emp_dashboard);
                            ?>
                            <div class="dashboard-content-holder">
                                <ul class="transaction-list">
                                    <li>
                                        <div class="trans-id"><span><?php esc_html_e('Package Id', 'jobhunt') ?></span></div>
                                        <div class="trans-description"><span><?php esc_html_e('Title', 'jobhunt') ?></span></div>
                                        <div class="trans-date"><span><?php esc_html_e('Payment Date', 'jobhunt') ?></span></div>
                                        <div class="trans-payment"><span><?php esc_html_e('Payment Type', 'jobhunt') ?></span></div>
                                        <div class="trans-amount"><span><?php esc_html_e('Amount', 'jobhunt') ?></span></div>
                                        <div class="trans-status"><span><?php esc_html_e('Status', 'jobhunt') ?></span></div>
                                        <?php do_action('dairyjobs_transaction_download_label_frontend'); ?>
                                    </li>
                                    <?php
                                    while ($custom_query->have_posts()) : $custom_query->the_post();
                                        $cs_trans_id = get_post_meta(get_the_id(), "cs_transaction_id", true);
                                        $cs_trans_gate = get_post_meta(get_the_id(), "cs_transaction_pay_method", true);
                                        $cs_trans_amount = get_post_meta(get_the_id(), "cs_transaction_amount", true);
                                        $currency_position = get_post_meta(get_the_id(), 'cs_transaction_currency_position', true);
                                        $currency_new_sign = get_post_meta(get_the_id(), "cs_transaction_currency_sign", true);
                                        $cs_trans_type = get_post_meta(get_the_id(), "cs_transaction_type", true);

                                        $cs_trans_featured_only = '';
                                        if ($cs_trans_type == 'featured_only') {
                                            $cs_trans_featured_only = "<br>" . esc_html__('(Featured only)', 'jobhunt');
                                        }

                                        $currency_new_sign = ( $currency_new_sign != '' ) ? $currency_new_sign : $currency_sign;

                                        $cs_trans_status = get_post_meta(get_the_id(), "cs_transaction_status", true);
                                        $cs_trans_status = $cs_trans_status == '' ? 'pending' : $cs_trans_status;
                                        if ($cs_trans_status == 'pending') {
                                            $cs_trans_status = esc_html__('Pending', 'jobhunt');
                                        } else if ($cs_trans_status == 'active') {
                                            $cs_trans_status = esc_html__('Active', 'jobhunt');
                                        } else if ($cs_trans_status == 'approved') {
                                            $cs_trans_status = esc_html__('Approved', 'jobhunt');
                                        }
                                        $cs_trans_type = get_post_meta(get_the_id(), "cs_transaction_type", true);
                                        if ($cs_trans_type == 'cv_trans') {
                                            $cs_trans_pkg = get_post_meta(get_the_id(), "cs_transaction_cv_pkg", true);
                                            $cs_trans_pkg_title = $cs_emp_funs->get_cv_pkg_field($cs_trans_pkg);
                                            if ($cs_trans_pkg_title != '') {
                                                $cs_trans_pkg_title = esc_html__('CV Search', 'jobhunt') . ' - ' . $cs_trans_pkg_title;
                                            }
                                        } else {
                                            $cs_trans_pkg = get_post_meta(get_the_id(), "cs_transaction_package", true);
                                            $cs_trans_pkg_title = $cs_emp_funs->get_pkg_field($cs_trans_pkg);
                                            if ($cs_trans_pkg_title != '') {
                                                $cs_trans_pkg_title = esc_html__('Advertise job', 'jobhunt') . ' - ' . $cs_trans_pkg_title;
                                            }
                                        }
                                        $cs_trans_pkg_title = apply_filters('jobhunt_package_type_title', $cs_trans_pkg_title, $cs_trans_type);
                                        if ($cs_trans_pkg_title == '') {
                                            if ($cs_trans_type != 'cv_trans') {
                                                $cs_trans_job = get_post_meta(get_the_id(), "cs_job_id", true);
                                                $cs_trans_pkg_title = esc_html__('Featured Job', 'jobhunt') . ' <a href="' . add_query_arg(array('profile_tab' => 'editjob', 'job_id' => $cs_trans_job, 'action' => 'edit'), $page_link) . '">' . get_the_title($cs_trans_job) . '</a>';
                                            } else {
                                                $cs_trans_pkg_title = esc_html__('Featured Job', 'jobhunt');
                                            }
                                        }
                                        //$cs_trans_gate = isset($gateways[strtoupper($cs_trans_gate)]) ? $gateways[strtoupper($cs_trans_gate)] : '-';
                                        if ($cs_trans_gate != '') {
                                            $cs_trans_gate = isset($gateways[strtoupper($cs_trans_gate)]) ? $gateways[strtoupper($cs_trans_gate)] : $cs_trans_gate;
                                            if (isset($cs_trans_gate) && $cs_trans_gate != '' && $cs_trans_gate == 'cs_wooC_GATEWAY') {
                                                if (class_exists('WooCommerce')) {
                                                    $gateways = WC()->payment_gateways->get_available_payment_gateways();
                                                    if (isset($gateways[$cs_trans_gate]->title)) {
                                                        $cs_trans_gate = $gateways[$cs_trans_gate]->title;
                                                    }
                                                }
                                            }
                                            $cs_trans_gate = isset($cs_trans_gate) ? $cs_trans_gate : esc_html__('Nill', 'jobhunt');
                                            $cs_trans_gate = ($cs_trans_gate != 'cs_wooC_GATEWAY') ? $cs_trans_gate : esc_html__('Nill', 'jobhunt');
                                        } else {
                                            $cs_trans_gate = '-';
                                        }
                                        $cs_trans_gate = ucwords($cs_trans_gate);
                                        $payment_date = get_the_date();
                                        $payment_date = str_replace('/', '-', $payment_date);
                                        ?>
                                        <li>
                                            <div class="trans-id"><span>&nbsp;<?php echo esc_attr($cs_trans_id) ?></span></div>
                                            <div class="trans-description"><span>&nbsp;<?php echo force_balance_tags($cs_trans_pkg_title . $cs_trans_featured_only) ?></span></div>
                                            <div class="trans-date"><span>&nbsp;<?php echo date_i18n(get_option('date_format'), strtotime($payment_date)) ?></span></div>
                                            <div class="trans-payment"><span>&nbsp;<?php echo esc_attr($cs_trans_gate) ?></span></div>
                                            <div class="trans-amount"><span class="amount csborder-color">&nbsp;<?php echo jobcareer_get_currency($cs_trans_amount, true, '', '', $currency_new_sign, $currency_position); ?></span></div>
                                            <div class="trans-status"><span>&nbsp;<?php echo esc_attr(ucfirst($cs_trans_status)) ?></span></div>
                                            <?php do_action('dairyjobs_transaction_download_link_frontend', get_the_id()); ?>
                                        </li>
                                        <?php
                                    endwhile;
                                    ?>
                                </ul>
                            </div>
                            <?php
                            if ($count_records > $cs_blog_num_post && $cs_blog_num_post > 0) {
                                echo '<nav>';
                                echo cs_ajax_pagination($count_records, $cs_blog_num_post, 'transactions', 'employer', $uid, '');
                                echo '</nav>';
                            }//==Pagination End 
                        } else {
                            echo '<div class="cs-no-record">' . cs_info_messages_listing(esc_html__("There is no record in transaction list", 'jobhunt')) . '</div>';
                        }
                        ?>
                    </div>
                </div><?php
                die();
            }
        }

        /**
         * Start Function Create Resumes  in Ajax function
         */
        public function cs_ajax_fav_resumes() {
            global $post, $current_user, $cs_plugin_options, $cs_form_fields2;
            $default_currency_sign = jobcareer_get_currency_sign();
            $cs_candidate_switch = isset($cs_plugin_options['cs_candidate_switch']) ? $cs_plugin_options['cs_candidate_switch'] : '';
            $cs_emp_funs = new cs_employer_functions();
            $uid = (isset($_POST['cs_uid']) and $_POST['cs_uid'] <> '') ? $_POST['cs_uid'] : '';
            if ($uid != '') {
                if ($cs_candidate_switch == 'on') { // paid list
                    echo '
                    <div class="cs-dash-resumes-tabs">
		    <div class="field-holder">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#shortlisted-resumes-list">' . esc_html__('Shortlisted', 'jobhunt') . '</a></li>
                        <li><a data-toggle="tab" href="#download-resumes-list">' . esc_html__('Downloads', 'jobhunt') . '</a></li>
                    </ul>
                    <div class="tab-content">
                    <div id="shortlisted-resumes-list" class="tab-pane fade in active">';
                    $cs_fav_resumes = get_user_meta($uid, 'cs-user-resumes-wishlist', true);
                    if (!empty($cs_fav_resumes) && is_array($cs_fav_resumes)) {
                        $cs_fav_shortlist = array_column_by_two_dimensional($cs_fav_resumes, 'post_id');
                    } else {
                        $cs_fav_shortlist = array();
                    }
                    $heading = esc_html__('Shortlisted', 'jobhunt');
                    $this->cs_fav_resumes_list($cs_fav_shortlist, $uid, $heading, false);
                    echo '
                    </div>
                    <div id="download-resumes-list" class="tab-pane fade">';
                    $cs_fav_resumes = get_user_meta($uid, "cs_fav_resumes", true);
                    $heading = esc_html__('Resumes', 'jobhunt');
                    $this->cs_fav_resumes_list($cs_fav_resumes, $uid, $heading);
                    echo '
                    </div>
                    </div>
		    </div>
                    </div>';
                } else { // free wishlist
                    $cs_fav_resumes = get_user_meta($uid, 'cs-user-resumes-wishlist', true);
                    if (!empty($cs_fav_resumes)) {
                        $cs_fav_shortlist = array_column_by_two_dimensional($cs_fav_resumes, 'post_id');
                    } else {
                        $cs_fav_shortlist = array();
                    }
                    $heading = esc_html__('Shortlisted', 'jobhunt');
                    $this->cs_fav_resumes_list($cs_fav_shortlist, $uid, $heading);
                }
                ?>
                <script>
                    jQuery(document).ready(function () {
                        jQuery('[data-toggle="tooltip"]').tooltip();
                    });
                </script>
                <?php
                die();
            }
        }

        public function cs_fav_resumes_list($cs_fav_resumes = '', $uid = '', $heading = '', $actions_drp = true) {
            global $post, $current_user, $cs_plugin_options, $cs_form_fields2;
            $default_currency_sign = jobcareer_get_currency_sign();
            $cs_candidate_switch = isset($cs_plugin_options['cs_candidate_switch']) ? $cs_plugin_options['cs_candidate_switch'] : '';
            $cs_emp_funs = new cs_employer_functions();
            $cs_vat_switch = isset($cs_plugin_options['cs_vat_switch']) ? $cs_plugin_options['cs_vat_switch'] : '';
            $cs_pay_vat = isset($cs_plugin_options['cs_payment_vat']) ? $cs_plugin_options['cs_payment_vat'] : '0';
            if (isset($cs_plugin_options['cs_use_woocommerce_gateway']) && $cs_plugin_options['cs_use_woocommerce_gateway'] == 'on') {
                $cs_pay_vat = 0;
            }
            $currency_sign = jobcareer_get_currency_sign();
            ?>
            <div class="cs-resumes" data-adminurl="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
                <div class="scetion-title">
                    <h3><?php esc_html_e($heading, 'jobhunt') ?></h3>
                </div>
                <?php
                if (is_array($cs_fav_resumes) && sizeof($cs_fav_resumes) > 0 && isset($cs_fav_resumes) && (!empty($cs_fav_resumes))) {
                    $cs_blog_num_post = ( isset($cs_plugin_options['cs_job_dashboard_pagination']) && $cs_plugin_options['cs_job_dashboard_pagination'] != '' ) ? $cs_plugin_options['cs_job_dashboard_pagination'] : 10;
                    if (empty($_REQUEST['page_id_all'])) {
                        $_REQUEST['page_id_all'] = 1;
                    }
                    $mypost = array('number' => "999999", 'include' => $cs_fav_resumes, 'role' => 'cs_candidate', 'order' => "ASC");
                    $loop_count = new WP_User_Query($mypost);
                    $count_post = $loop_count->total_users;
                    $args = array('number' => $cs_blog_num_post, 'paged' => $_REQUEST['page_id_all'], 'include' => $cs_fav_resumes, 'role' => 'cs_candidate', 'order' => "ASC");
                    $custom_query = new WP_User_Query($args);
                    if ($custom_query->results):
                        ?>
                        <ul class="resumes-list11">
                            <?php
                            foreach ($custom_query->results as $cs_user) {
                                $cs_fav = $cs_user->ID;
                                $cs_user_img = get_user_meta($cs_fav, "user_img", true);
                                $cs_user_img = cs_get_img_url($cs_user_img, 'cs_media_5');
                                if (!cs_image_exist($cs_user_img) || $cs_user_img == "") {
                                    $cs_user_img = esc_url(wp_jobhunt::plugin_url() . 'assets/images/img-not-found16x9.jpg');
                                }
                                $cs_job_title = get_user_meta($cs_fav, "cs_job_title", true);
                                $cs_loc_address = get_user_meta($cs_fav, "cs_post_loc_address", true);
                                $cs_candidate_cv = get_user_meta($cs_fav, "cs_candidate_cv", true);
                                $cs_candidate_linkedin = get_user_meta($cs_fav, 'cs_linkedin', true);
                                $cs_post_loc_city = get_user_meta($cs_fav, 'cs_post_loc_city', true);
                                $cs_candidate_web_http = $cs_user->user_url;
                                $cs_candidate_web = preg_replace('#^https?://#', '', $cs_candidate_web_http);
                                $cs_minimum_salary = get_user_meta($cs_fav, 'cs_minimum_salary', true);
                                $cs_user_last_activity_date = get_user_meta($cs_fav, 'cs_user_last_activity_date', true);
                                $cs_candidate_user = $cs_fav;
                                $cs_get_exp_list = get_user_meta($cs_fav, 'cs_exp_list_array', true);
                                $cs_exp_titles = get_user_meta($cs_fav, 'cs_exp_title_array', true);
                                $cs_exp_from_dates = get_user_meta($cs_fav, 'cs_exp_from_date_array', true);
                                $cs_exp_to_dates = get_user_meta($cs_fav, 'cs_exp_to_date_array', true);
                                $cs_exp_companys = get_user_meta($cs_fav, 'cs_exp_company_array', true);
                                // get all job types
                                $all_specialisms = get_user_meta($cs_fav, 'cs_specialisms', true);
                                $specialisms_values = '';
                                $specialisms_class = '';
                                $specialism_flag = 1;
                                if ($all_specialisms != '') {
                                    foreach ($all_specialisms as $specialisms_item) {
                                        $specialismsitem = get_term_by('slug', $specialisms_item, 'specialisms');
                                        if (is_object($specialismsitem)) {
                                            $specialisms_values .= $specialismsitem->name;
                                            $specialisms_class .= $specialismsitem->slug;
                                            if ($specialism_flag != count($all_specialisms)) {
                                                $specialisms_values .= ", ";
                                                $specialisms_class .= " ";
                                            }
                                            $specialism_flag ++;
                                        }
                                    }
                                }
                                $recent_exp_company = '';
                                $recent_exp_titles = '';
                                $recent_exp_company = '';
                                $recent_exp_titles = '';
                                if (isset($cs_get_exp_list) && is_array($cs_get_exp_list) && count($cs_get_exp_list) > 0) {
                                    $required_index = find_heighest_date_index($cs_exp_to_dates, 'd-m-Y');
                                    $recent_exp_company = $cs_exp_companys[$required_index];
                                    $recent_exp_titles = $cs_exp_titles[$required_index];
                                }
                                $last_login_timestring = get_user_last_login($cs_candidate_user);
                                $user_registered_timestamp = isset($cs_candidate_user) && $cs_candidate_user != '' ? get_user_registered_timestamp($cs_candidate_user) : '';
                                ?>
                                <li>
                                    <img alt="" src="<?php echo esc_url($cs_user_img) ?>">
                                    <div class="cs-text">
                                        <?php
                                        if ($specialisms_values != '') {
                                            echo '<span class="time">' . $specialisms_values . '</span>';
                                        }
                                        ?>
                                        <h5><a><?php echo $cs_user->display_name ?></a><?php
                                            if ($cs_post_loc_city != '') {
                                                echo " | " . urldecode($cs_post_loc_city);
                                            }
                                            if ($cs_minimum_salary != '') {
                                                echo '<span>' . $default_currency_sign . $cs_minimum_salary . esc_html__(' p.a minimum', 'jobhunt') . '</span>';
                                            }
                                            ?></h5>
                                        <?php
                                        if ($recent_exp_titles != '') {
                                            echo '<span><em>' . $recent_exp_titles . '</em> ' . esc_html__('at', 'jobhunt') . ' ' . $recent_exp_company . '</span>';
                                        }
                                        ?>
                                        <div class="cs-uploaded candidate-detail">
                                            <span>
                                                <?php if ($cs_user_last_activity_date != '') { ?>
                                                    <em><?php esc_html_e('Last activity', 'jobhunt') ?></em> <?php echo cs_time_elapsed_string($cs_user_last_activity_date); ?>. 
                                                    <?php
                                                }
                                                if ($user_registered_timestamp != '') {
                                                    ?>
                                                    <em><?php echo esc_html__("Registered", "jobhunt"); ?></em> <?php echo cs_time_elapsed_string($user_registered_timestamp); ?>
                                                <?php } ?>
                                            </span>
                                        </div>
                                    </div>
                                    <?php
                                    if ($actions_drp == true) {
                                        ?>
                                        <div class="cs-downlod-sec">
                                            <a><?php esc_html_e('Actions', 'jobhunt') ?></a>
                                            <ul>
                                                <?php
                                                $action_flag = true;
                                                $action_flag = apply_filters('jobhunt_candidate_action_check', $action_flag, $cs_fav);
                                                if ($action_flag) {
                                                    ?>
                                                    <li>
                                                        <a data-toggle="modal" data-target="#cover_letter_light<?php echo absint($cs_fav) ?>"><?php esc_html_e('Cover Letter', 'jobhunt') ?></a>
                                                    </li>
                                                    <?php
                                                    $display_candidate_contact_details = 'yes';
                                                    $display_candidate_contact_details = apply_filters('jobhunt_candidate_contact_details_for_employers', $display_candidate_contact_details);
                                                    if ($display_candidate_contact_details == 'yes') {
                                                        if (isset($cs_candidate_cv) && ($cs_candidate_cv) != '') {
                                                            do_action('jobhunt_download_cv_link', $cs_candidate_cv, $cs_fav);
                                                            ?>
                                                        <?php } else { ?>
                                                            <li><a href="javascript:void(0);" onclick="show_alert_msg('<?php echo esc_html__('There is no downloadable doc', 'jobhunt') ?>');"><?php esc_html_e('Download CV', 'jobhunt') ?></a></li>
                                                            <?php
                                                        }
                                                    }
                                                    if ($cs_candidate_linkedin != '') {
                                                        ?>
                                                        <li><a target="_blank" href="<?php echo esc_url($cs_candidate_linkedin) ?>"><?php esc_html_e('Linked-in Profile', 'jobhunt') ?></a></li>
                                                    <?php } ?>
                                                    <li>
                                                        <a data-toggle="modal" data-target="#cs-msgbox-<?php echo absint($cs_fav) ?>"><?php esc_html_e('Send a Message ', 'jobhunt') ?></a>
                                                    </li> 
                                                <?php } ?>
                                                <li><a href="<?php echo esc_url(get_author_posts_url($cs_fav)) ?>"><?php esc_html_e('View Profile', 'jobhunt') ?></a></li>
                                            </ul>
                                        </div>
                                        <div class="modal fade" id="cover_letter_light<?php echo absint($cs_fav) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h5>
                                                            <a><?php echo $cs_user->display_name ?></a>
                                                            <?php
                                                            if (isset($cs_post_loc_city) && $cs_post_loc_city != '') {
                                                                echo " | " . $cs_post_loc_city;
                                                            }
                                                            echo " - " . esc_html__("Cover Letter", "jobhunt");
                                                            ?>
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        if (isset($cs_fav) && $cs_fav != '') {
                                                            $cs_cover_letter = get_user_meta($cs_fav, 'cs_cover_letter', true);
                                                            $cs_cover_letter = apply_filters('jobhunt_job_cover_letter', $cs_cover_letter, $cs_fav);
                                                            if (isset($cs_cover_letter) && $cs_cover_letter != '') {
                                                                echo force_balance_tags($cs_cover_letter);
                                                            } else {
                                                                echo esc_html__("Not set by user", "jobhunt");
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        $plugin_active = false;
                                        $plugin_active = apply_filters('jobhunt_dairyjobs_depedency', $plugin_active);

                                        if (!$plugin_active) {
                                            $cs_paid_resumes = get_user_meta($uid, "cs_fav_resumes", true);
                                            echo '<span class="cs-resume-add-btn">';
                                            if (is_array($cs_paid_resumes) && in_array($cs_fav, $cs_paid_resumes)) {
                                                ?>
                                                <a href="<?php echo esc_url(get_author_posts_url($cs_fav)) ?>" class="add_list_icon ad_to_list cs_resume_added cs-button"><?php esc_html_e('View Detail', 'jobhunt') ?></a>
                                                <?php
                                            } else {
                                                ?>
                                                <a data-toggle="tooltip" data-placement="top" title="<?php esc_html_e("Add to List", "jobhunt"); ?>" class="add_list_icon ad_to_list cs-button" id="add-to-btn-<?php echo absint($cs_fav) ?>" onclick="cs_add_to_list('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($cs_fav) ?>')"><?php esc_html_e('Add to List', 'jobhunt') ?></a>
                                                <?php
                                            }
                                            echo '</span>';
                                        }
                                        do_action('jobhunt_dashboard_shorlist_addlist', $uid, $cs_fav);
                                    }
                                    ?>
                                    <a data-toggle="tooltip" data-placement="top" title="<?php esc_html_e("Remove", "jobhunt"); ?>" class="delete" id="cs-resume-<?php echo absint($cs_fav) ?>" onclick="cs_fav_resume_del('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($cs_fav) ?>')"><i class="icon-trash-o"></i></a>
                                    <?php
                                    if ($actions_drp == true) {
                                        ?>
                                        <div id="cs-msgbox-fade<?php echo esc_html($cs_fav); ?>" class="black_overlay"></div>
                                        <div class="modal fade" id="cs-msgbox-<?php echo absint($cs_fav) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <?php
                                                        $contact_heading = '<h4>' . esc_html__('Send message to Candidate', 'jobhunt') . '</h4>';
                                                        $cs_candidate_info = get_userdata($cs_fav);
                                                        if ($cs_candidate_info->display_name != "") {
                                                            $contact_heading = '<h4>' . sprintf(esc_html__('Send message to "%s"', 'jobhunt'), $cs_candidate_info->display_name) . '</h4>';
                                                        }
                                                        echo $contact_heading;
                                                        ?> 
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="cs_employer_id_<?php echo absint($cs_fav) ?>" data-validationmsg="<?php esc_html_e("Please ensure that all required fields are completed and formatted correctly", "jobhunt"); ?>">
                                                            <div id="ajaxcontact-response-<?php echo absint($cs_fav) ?>" class="error-msg"></div>
                                                            <div class="cs-profile-contact-detail">
                                                                <form id="ajaxcontactform-<?php echo absint($cs_fav) ?>"  method="post" enctype="multipart/form-data">
                                                                    <div class="input-filed-contact">
                                                                        <i class="icon-user9"></i>
                                                                        <?php
                                                                        $cs_employer_info = get_userdata($uid);
                                                                        $ajaxcontactname = $cs_employer_info->display_name;
                                                                        $ajaxcontactemail = $cs_employer_info->user_email;
                                                                        $ajaxcontactname = isset($ajaxcontactname) ? $ajaxcontactname : '';
                                                                        $ajaxcontactemail = isset($ajaxcontactemail) ? $ajaxcontactemail : '';
                                                                        $cs_opt_array = array(
                                                                            'id' => 'ajaxcontactname',
                                                                            'std' => $ajaxcontactname,
                                                                            'desc' => '',
                                                                            'classes' => 'form-control',
                                                                            'hint_text' => '',
                                                                        );
                                                                        $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                                        ?>
                                                                    </div>
                                                                    <div class="input-filed-contact">
                                                                        <i class="icon-envelope4"></i>
                                                                        <?php
                                                                        $cs_opt_array = array(
                                                                            'id' => 'ajaxcontactemail',
                                                                            'std' => $ajaxcontactemail,
                                                                            'desc' => '',
                                                                            'classes' => 'form-control',
                                                                            'hint_text' => '',
                                                                        );

                                                                        $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                                        ?>
                                                                    </div>
                                                                    <div class="input-filed-contact">
                                                                        <i class="icon-mobile4"></i>
                                                                        <?php
                                                                        $ajaxcontactphonenumber = get_user_meta($uid, 'cs_phone_number', true);
                                                                        $ajaxcontactphone = isset($ajaxcontactphonenumber) ? $ajaxcontactphonenumber : '';
                                                                        $cs_opt_array = array(
                                                                            'id' => 'ajaxcontactphone',
                                                                            'std' => $ajaxcontactphone,
                                                                            'desc' => '',
                                                                            'classes' => 'form-control',
                                                                            'hint_text' => '',
                                                                        );
                                                                        $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                                        ?>
                                                                    </div>
                                                                    <div class="input-filed-contact">
                                                                        <?php
                                                                        $ajaxcontactcontents = isset($ajaxcontactcontents) ? $ajaxcontactcontents : '';
                                                                        $cs_opt_array = array(
                                                                            'id' => 'ajaxcontactcontents',
                                                                            'std' => $ajaxcontactcontents,
                                                                            'desc' => '',
                                                                            'classes' => 'form-control',
                                                                            'hint_text' => '',
                                                                        );
                                                                        $cs_form_fields2->cs_form_textarea_render($cs_opt_array);
                                                                        ?>
                                                                    </div>
                                                                    <div id="jb-id-<?php echo absint($cs_fav) ?>" data-jid="<?php echo absint($cs_fav) ?>">
                                                                        <?php
                                                                        $cs_opt_array = array(
                                                                            'id' => '',
                                                                            'std' => esc_html__('Send Request', 'jobhunt'),
                                                                            'cust_type' => 'button',
                                                                            'cust_id' => 'jb-cont-send-' . $cs_fav,
                                                                            'cust_name' => 'candidate_contactus',
                                                                            'extra_atr' => 'data-id="' . $cs_fav . '"',
                                                                            'classes' => 'cs-bgcolor acc-submit',
                                                                            'hint_text' => '',
                                                                        );
                                                                        $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                                        ?>
                                                                        <div id="main-cs-loader_<?php echo absint($cs_fav) ?>" class="loader_class"></div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!--Content div--->
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    endif;

                    //==Pagination Start
                    if ($count_post > $cs_blog_num_post && $cs_blog_num_post > 0) {
                        echo '<nav>';
                        echo cs_ajax_pagination($count_post, $cs_blog_num_post, 'resumes', 'employer', $uid, '');
                        echo '</nav>';
                    }
                } else {
                    echo '<div class="cs-no-record">' . cs_info_messages_listing(esc_html__("There is no record in resumes list", 'jobhunt')) . '</div>';
                }
                ?>
            </div>
            <?php
        }

        /**
         * Start Function Createing job Packages in Ajax Function
         */
        public function cs_ajax_job_packages() {
            global $cs_plugin_options, $current_user, $cs_form_fields2;
            $general_settings = new CS_PAYMENTS();
            if (isset($_POST['pkg_array'])) {
                $post_array = stripslashes($_POST['pkg_array']);
                $post_array = json_decode($post_array, true);
                if (is_array($post_array) && sizeof($post_array) > 0) {
                    if (isset($post_array['post_array'])) {
                        $post_array = $post_array['post_array'];
                        $_POST = array_merge($_POST, $post_array);
                    }
                }
            }
            $cs_emp_funs = new cs_employer_functions();
            $cs_vat_switch = isset($cs_plugin_options['cs_vat_switch']) ? $cs_plugin_options['cs_vat_switch'] : '';
            $cs_pay_vat = isset($cs_plugin_options['cs_payment_vat']) ? $cs_plugin_options['cs_payment_vat'] : '0';

            if (isset($cs_plugin_options['cs_use_woocommerce_gateway']) && $cs_plugin_options['cs_use_woocommerce_gateway'] == 'on') {
                $cs_pay_vat = 0;
            }

            $currency_sign = jobcareer_get_currency_sign();
            $cs_feature_amount = isset($cs_plugin_options['cs_job_feat_price']) ? $cs_plugin_options['cs_job_feat_price'] : '';
            $cs_packages_options = isset($cs_plugin_options['cs_packages_options']) ? $cs_plugin_options['cs_packages_options'] : '';
            $cs_cv_pkgs_options = isset($cs_plugin_options['cs_cv_pkgs_options']) ? $cs_plugin_options['cs_cv_pkgs_options'] : '';
            if (isset($_POST['cs_package']) && $_POST['cs_package'] != '') {
                if (!$cs_emp_funs->cs_is_pkg_subscribed($_POST['cs_package'])) {
                    $cs_package = $_POST['cs_package'];
                    $cs_html = '';
                    $cs_total_amount = 0;
                    $cs_total_amount += CS_FUNCTIONS()->cs_num_format($cs_emp_funs->get_pkg_field($_POST['cs_package'], 'package_price'));
                    $cs_smry_totl = $cs_total_amount;
                    if ($cs_vat_switch == 'on' && $cs_pay_vat > 0) {
                        $cs_vat_amount = $cs_total_amount * ( $cs_pay_vat / 100 );
                        $cs_total_amount = CS_FUNCTIONS()->cs_num_format($cs_vat_amount) + $cs_total_amount;
                    }
                    if ($cs_total_amount <= 0) {
                        // Adding Free Package
                        $cs_trans_pkg = isset($_POST['cs_package']) ? $_POST['cs_package'] : '';
                        $cs_pkg_title = $cs_emp_funs->get_pkg_field($cs_trans_pkg);
                        $cs_pkg_expiry = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration');
                        $cs_pkg_duration = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration_period');
                        $cs_pkg_expir_days = strtotime($cs_emp_funs->cs_date_conv($cs_pkg_expiry, $cs_pkg_duration));
                        $cs_pkg_list_num = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_listings');
                        $cs_pkg_list_exp = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_submission_limit');
                        $cs_pkg_list_per = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'cs_list_dur');
                        $cs_trans_fields = array(
                            'cs_job_id' => isset($_POST['cs_package']) ? $_POST['cs_package'] : '',
                            'cs_trans_id' => rand(149344111, 991435901),
                            'cs_trans_user' => $current_user->ID,
                            'cs_package_title' => $cs_pkg_title,
                            'cs_trans_package' => isset($_POST['cs_package']) ? $_POST['cs_package'] : '',
                            'cs_trans_amount' => 0,
                            'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                            'cs_trans_list_num' => $cs_pkg_list_num,
                            'cs_trans_list_expiry' => $cs_pkg_list_exp,
                            'cs_trans_list_period' => $cs_pkg_list_per,
                        );
                        $cs_emp_funs->cs_pay_process($cs_trans_fields);
                        $cs_html .= esc_html__('You have successfully subscribed free package.', 'jobhunt');
                    }
                    if (isset($_POST['cs_pkge_trans']) && $_POST['cs_pkge_trans'] == "1") {
                        if ($cs_total_amount > 0) {
                            $cs_trans_pkg = isset($_POST['cs_package']) ? $_POST['cs_package'] : '';
                            $cs_pkg_title = $cs_emp_funs->get_pkg_field($cs_trans_pkg);
                            $cs_pkg_expiry = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration');
                            $cs_pkg_duration = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration_period');
                            $cs_pkg_expir_days = strtotime($cs_emp_funs->cs_date_conv($cs_pkg_expiry, $cs_pkg_duration));
                            $cs_pkg_list_num = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_listings');
                            $cs_pkg_list_exp = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_submission_limit');
                            $cs_pkg_list_per = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'cs_list_dur');
                            $cs_trans_fields = array(
                                'cs_job_id' => isset($_POST['cs_package']) ? $_POST['cs_package'] : '',
                                'cs_trans_id' => rand(149344111, 991435901),
                                'cs_trans_user' => $current_user->ID,
                                'cs_package_title' => $cs_pkg_title,
                                'cs_trans_package' => isset($_POST['cs_package']) ? $_POST['cs_package'] : '',
                                'cs_trans_amount' => $cs_total_amount,
                                'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                                'cs_trans_list_num' => $cs_pkg_list_num,
                                'cs_trans_list_expiry' => $cs_pkg_list_exp,
                                'cs_trans_list_period' => $cs_pkg_list_per,
                            );
                            $cs_trnas_html = $cs_emp_funs->cs_pay_process($cs_trans_fields);
                        }
                    }

                    if (isset($cs_trnas_html) && $cs_trnas_html != '') {
                        $cs_html .= $cs_trnas_html;
                    } else {
                        if ($cs_total_amount > 0) {
                            $cs_html .= '
                        <form method="post" id="cs-emp-pkgs" data-ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '">
                                <div class="cs-order-summery">
                                        <h4>' . esc_html__('Order summery', 'jobhunt') . '</h4>
                                        <ul class="cs-sumry-clacs">
                                                        <li><span>' . esc_attr($cs_emp_funs->get_pkg_field($_POST['cs_package'])) . ' ' . esc_html__('Subscription', 'jobhunt') . '</span><em>' . jobcareer_get_currency($cs_emp_funs->get_pkg_field($_POST['cs_package'], 'package_price'), true) . '</em></li>';
                            if ($cs_vat_switch == 'on' && isset($cs_vat_amount)) {
                                $cs_html .= '<li><span>' . sprintf(esc_html__('VAT (%s&#37;)', 'jobhunt'), $cs_pay_vat) . '</span><em>' . jobcareer_get_currency($cs_vat_amount, true) . '</em></li>';
                            }
                            $cs_html .= '
                            <li><span>' . esc_html__('Total', 'jobhunt') . '</span><em>' . jobcareer_get_currency($cs_total_amount, true) . '</em></li>
                            </ul>
                            </div>
                            <div class="contact-box cs-pay-box">
                            <ul class="select-card cs-all-gates">';
                            global $gateways;
                            $cs_gateway_options = get_option('cs_plugin_options');
                            $cs_gw_counter = 1;
                            $cs_gatway_enable_flag = 0;
                            if (isset($cs_gateway_options['cs_use_woocommerce_gateway']) && $cs_gateway_options['cs_use_woocommerce_gateway'] == 'on') {
                                $cs_opt_array = array(
                                    'std' => 'cs_wooC_GATEWAY',
                                    'id' => '',
                                    'return' => true,
                                    'cust_type' => 'hidden',
                                    'extra_atr' => '',
                                    'cust_name' => 'cs_payment_gateway',
                                    'prefix' => '',
                                );
                                $cs_html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                $cs_opt_array = array(
                                    'std' => $_POST['wooC_current_page'],
                                    'id' => '',
                                    'return' => true,
                                    'cust_type' => 'hidden',
                                    'extra_atr' => '',
                                    'cust_name' => 'wooC_current_page',
                                    'prefix' => '',
                                );
                                $cs_html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                $cs_gatway_enable_flag ++;
                            } else {
                                if (isset($gateways) && is_array($gateways)) {
                                    foreach ($gateways as $key => $value) {
                                        $status = $cs_gateway_options[strtolower($key) . '_status'];
                                        if (isset($status) && $status == 'on') {
                                            $logo = '';
                                            if (isset($cs_gateway_options[strtolower($key) . '_logo'])) {
                                                $logo = $cs_gateway_options[strtolower($key) . '_logo'];
                                            }
                                            if (isset($logo) && $logo != '') {
                                                $cs_checked = $cs_gw_counter == 1 ? ' checked="checked"' : '';
                                                $cs_active = $cs_gw_counter == 1 ? ' class="active"' : '';
                                                $cs_html .= '<li' . $cs_active . '><a><img alt="" src="' . esc_url($logo) . '"></a>';
                                                $cs_opt_array = array(
                                                    'std' => $key,
                                                    'id' => '',
                                                    'cust_type' => 'radio',
                                                    'extra_atr' => ' style="display:none; position:absolute;" ' . CS_FUNCTIONS()->cs_special_chars($cs_checked),
                                                    'return' => true,
                                                    'cust_name' => 'cs_payment_gateway',
                                                );
                                                $cs_html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                $cs_html .= ' </li>';
                                                $cs_gatway_enable_flag ++;   // if any gatway enable then set flag
                                            }
                                            $cs_gw_counter ++;
                                        }
                                    }
                                }
                            }
                            $cs_html .= '</ul>';
                            if ($cs_gatway_enable_flag > 0) {
                                $cs_opt_array = array(
                                    'std' => absint($cs_package),
                                    'id' => '',
                                    'cust_name' => 'cs_package',
                                    'return' => true,
                                );
                                $cs_html .= $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                                $cs_opt_array = array(
                                    'std' => '1',
                                    'id' => '',
                                    'cust_name' => 'cs_pkge_trans',
                                    'return' => true,
                                );
                                $cs_html .= $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                                $cs_opt_array = array(
                                    'std' => esc_html__('Pay Now', 'jobhunt'),
                                    'id' => '',
                                    'cust_type' => 'submit',
                                    'classes' => 'continue-btn',
                                    'return' => true,
                                );
                                $cs_html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);
                            }
                            $cs_html .= '</div> </form>';
                        }
                    }
                    echo CS_FUNCTIONS()->cs_special_chars($cs_html);
                } else {
                    echo '<div class="cs-no-record">' . cs_info_messages_listing(esc_html__("You have already subscribe this Package", 'jobhunt')) . '</div>';
                }
            }
            do_action('jobhunt_subscribing_package');
            if (isset($_POST['cs_packge']) && $_POST['cs_packge'] != '') {
                if (!$cs_emp_funs->is_cv_pkg_subs()) {
                    $cs_packge = $_POST['cs_packge'];
                    $cv_pkg_price = CS_FUNCTIONS()->cs_num_format($cs_emp_funs->get_cv_pkg_field($_POST['cs_packge'], 'cv_pkg_price'));
                    $cs_html = '';
                    if ($cv_pkg_price > 0) {
                        $cs_total_amount = 0;
                        $cs_total_amount += CS_FUNCTIONS()->cs_num_format($cs_emp_funs->get_cv_pkg_field($_POST['cs_packge'], 'cv_pkg_price'));
                        $cs_smry_totl = $cs_total_amount;
                        if ($cs_vat_switch == 'on' && $cs_pay_vat > 0) {
                            $cs_vat_amount = $cs_total_amount * ( $cs_pay_vat / 100 );
                            $cs_total_amount = CS_FUNCTIONS()->cs_num_format($cs_vat_amount) + $cs_total_amount;
                        }
                        if (isset($_POST['cs_pkg_trans']) && $_POST['cs_pkg_trans'] == 1 && $cs_total_amount > 0) {
                            $cs_trans_pkg = isset($_POST['cs_packge']) ? $_POST['cs_packge'] : '';
                            $cs_pkg_title = $cs_emp_funs->get_cv_pkg_field($cs_trans_pkg);
                            $cs_pkg_expiry = $cs_emp_funs->get_cv_pkg_field($cs_trans_pkg, 'cv_pkg_dur');
                            $cs_pkg_duration = $cs_emp_funs->get_cv_pkg_field($cs_trans_pkg, 'cv_pkg_dur_period');
                            $cs_pkg_expir_days = strtotime($cs_emp_funs->cs_date_conv($cs_pkg_expiry, $cs_pkg_duration));
                            $cs_pkg_cv_num = $cs_emp_funs->get_cv_pkg_field($cs_trans_pkg, 'cv_pkg_cvs');
                            $cs_trans_fields = array(
                                'cs_job_id' => isset($_POST['cs_packge']) ? $_POST['cs_packge'] : '',
                                'cs_trans_id' => rand(149344111, 991435901),
                                'cs_trans_user' => $current_user->ID,
                                'cs_package_title' => $cs_pkg_title,
                                'cs_trans_package' => isset($_POST['cs_packge']) ? $_POST['cs_packge'] : '',
                                'cs_trans_amount' => $cs_total_amount,
                                'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                                'cs_trans_cv_num' => $cs_pkg_cv_num,
                            );
                            $cs_trnas_html = $cs_emp_funs->cs_cv_pay_process($cs_trans_fields);
                        }
                        if (isset($cs_trnas_html) && $cs_trnas_html != '') {
                            $cs_html .= $cs_trnas_html;
                        } else {
                            $cs_html .= '<form method="post" id="cs-emp-resumes" data-ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '">
                                            <div class="cs-order-summery">
                                                <h4>' . esc_html__('Order Summary', 'jobhunt') . '</h4>
                                                <ul class="cs-sumry-clacs">
                                                    <li><span>' . esc_attr($cs_emp_funs->get_cv_pkg_field($_POST['cs_packge'])) . ' ' . esc_html__('Subscription', 'jobhunt') . '</span><em>' . jobcareer_get_currency($cs_emp_funs->get_cv_pkg_field($_POST['cs_packge'], 'cv_pkg_price'), true) . '</em></li>';
                            if ($cs_vat_switch == 'on' && isset($cs_vat_amount)) {
                                $cs_html .= '<li><span>' . sprintf(esc_html__('VAT (%s&#37;)', 'jobhunt'), $cs_pay_vat) . '</span><em>' . jobcareer_get_currency($cs_vat_amount, true) . '</em></li>';
                            }
                            $cs_html .= '
                                        <li><span>' . esc_html__('Total', 'jobhunt') . '</span><em>' . jobcareer_get_currency($cs_total_amount, true) . '</em></li>
                                            </ul>
                                        </div>
                                        <div class="contact-box cs-pay-box">
                                         <ul class="select-card cs-all-gates">';
                            global $gateways;
                            $cs_gateway_options = get_option('cs_plugin_options');
                            $cs_gw_counter = 1;
                            if (isset($cs_gateway_options['cs_use_woocommerce_gateway']) && $cs_gateway_options['cs_use_woocommerce_gateway'] == 'on') {
                                $cs_opt_array = array(
                                    'std' => 'cs_wooC_GATEWAY',
                                    'id' => '',
                                    'return' => true,
                                    'cust_type' => 'hidden',
                                    'extra_atr' => '',
                                    'cust_name' => 'cs_payment_gateway',
                                    'prefix' => '',
                                );
                                $cs_html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                $cs_opt_array = array(
                                    'std' => $_POST['wooC_current_page'],
                                    'id' => '',
                                    'return' => true,
                                    'cust_type' => 'hidden',
                                    'extra_atr' => '',
                                    'cust_name' => 'wooC_current_page',
                                    'prefix' => '',
                                );
                                $cs_html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                $cs_gatway_enable_flag ++;
                            } else {
                                foreach ($gateways as $key => $value) {
                                    $status = $cs_gateway_options[strtolower($key) . '_status'];
                                    if (isset($status) && $status == 'on') {
                                        $logo = '';
                                        if (isset($cs_gateway_options[strtolower($key) . '_logo'])) {
                                            $logo = $cs_gateway_options[strtolower($key) . '_logo'];
                                        }
                                        if (isset($logo) && $logo != '') {
                                            $cs_checked = $cs_gw_counter == 1 ? ' checked="checked"' : '';
                                            $cs_active = $cs_gw_counter == 1 ? ' class="active"' : '';
                                            $cs_html .= ' <li' . $cs_active . '><a><img alt="" src="' . esc_url($logo) . '"></a>';
                                            $cs_opt_array = array(
                                                'std' => $key,
                                                'id' => '',
                                                'cust_type' => 'radio',
                                                'extra_atr' => 'style="display:none; position:absolute;" ' . CS_FUNCTIONS()->cs_special_chars($cs_checked),
                                                'return' => true,
                                                'cust_name' => 'cs_payment_gateway',
                                            );
                                            $cs_html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                            $cs_html .= '</li>';
                                        }
                                        $cs_gw_counter ++;
                                    }
                                }
                            }
                            $cs_html .= ' </ul>';
                            $cs_opt_array = array(
                                'std' => $cs_packge,
                                'id' => '',
                                'cust_name' => 'cs_packge',
                                'return' => true,
                            );
                            $cs_html .= $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                            $cs_html .= '<input type="hidden" name="cs_pkg_trans" value="1">';
                            $cs_opt_array = array(
                                'std' => esc_html__('Pay Now', 'jobhunt'),
                                'id' => '',
                                'return' => true,
                                'classes' => 'continue-btn',
                                'cust_type' => 'submit',
                            );
                            $cs_html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);
                            $cs_html .= '</div> </form>';
                        }
                    } else {
                        // Adding Free Package
                        $cs_trans_pkg = isset($_POST['cs_packge']) ? $_POST['cs_packge'] : '';
                        $cs_pkg_title = $cs_emp_funs->get_cv_pkg_field($cs_trans_pkg);
                        $cs_pkg_expiry = $cs_emp_funs->get_cv_pkg_field($cs_trans_pkg, 'cv_pkg_dur');
                        $cs_pkg_duration = $cs_emp_funs->get_cv_pkg_field($cs_trans_pkg, 'cv_pkg_dur_period');
                        $cs_pkg_expir_days = strtotime($cs_emp_funs->cs_date_conv($cs_pkg_expiry, $cs_pkg_duration));
                        $cs_pkg_cv_num = $cs_emp_funs->get_cv_pkg_field($cs_trans_pkg, 'cv_pkg_cvs');
                        $cs_trans_fields = array(
                            'cs_job_id' => isset($_POST['cs_packge']) ? $_POST['cs_packge'] : '',
                            'cs_trans_id' => rand(149344111, 991435901),
                            'cs_trans_user' => $current_user->ID,
                            'cs_package_title' => $cs_pkg_title,
                            'cs_trans_package' => isset($_POST['cs_packge']) ? $_POST['cs_packge'] : '',
                            'cs_trans_amount' => '0',
                            'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                            'cs_trans_cv_num' => $cs_pkg_cv_num,
                        );
                        $cs_emp_funs->cs_cv_add_trans($cs_trans_fields);
                        $cs_html .= esc_html__('You have successfully subscribed free package.', 'jobhunt');
                    }
                    echo CS_FUNCTIONS()->cs_special_chars($cs_html);
                } else {
                    echo '<div class="cs-no-record">' . cs_info_messages_listing(esc_html__('You have already subscribe a Package.', 'jobhunt')) . '</div>';
                }
            }
            ?>
            <div class="cs-resumes">
                <div class="scetion-title">
                    <h3><?php esc_html_e('Packages', 'jobhunt') ?></h3>
                </div>
                <div class="field-holder">
                    <?php
                    $cs_results = false;
                    $cs_blog_num_post = ( isset($cs_plugin_options['cs_job_dashboard_pagination']) && $cs_plugin_options['cs_job_dashboard_pagination'] != '' ) ? $cs_plugin_options['cs_job_dashboard_pagination'] : 10;
                    if (empty($_REQUEST['page_id_all']))
                        $_REQUEST['page_id_all'] = 1;
                    if ((is_array($cs_packages_options) && sizeof($cs_packages_options) > 0 ) || ( is_array($cs_cv_pkgs_options) && sizeof($cs_cv_pkgs_options) > 0 )) {

                        $args = array(
                            'posts_per_page' => $cs_blog_num_post,
                            'paged' => $_REQUEST['page_id_all'],
                            'post_type' => 'cs-transactions',
                            'post_status' => 'publish',
                            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'cs_transaction_user',
                                    'value' => $current_user->ID,
                                    'compare' => '=',
                                ),
                                array(
                                    'relation' => 'OR',
                                    array(
                                        'key' => 'cs_transaction_cv_pkg',
                                        'value' => '',
                                        'compare' => '!=',
                                    ),
                                    array(
                                        'key' => 'cs_transaction_package',
                                        'value' => '',
                                        'compare' => '!=',
                                    ),
                                ),
                            ),
                        );
                        $custom_query = new WP_Query($args);
                        $count_all_records = $custom_query->found_posts;

                        if ($count_all_records > 0) {
                            ?>
                            <div class="dashboard-content-holder">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>#</td>
                                                <td><?php esc_html_e('Transaction id', 'jobhunt') ?></td>
                                                <td><?php esc_html_e('Package', 'jobhunt') ?></td>
                                                <td><?php esc_html_e('Expiry', 'jobhunt') ?></td>
                                                <td><?php esc_html_e('Total Jobs/CVs', 'jobhunt') ?></td>
                                                <td><?php esc_html_e('Used', 'jobhunt') ?></td>
                                                <td><?php esc_html_e('Remaining', 'jobhunt') ?></td>
                                                <td><?php esc_html_e('Status', 'jobhunt') ?></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cs_trans_num = 1;
                                            $cs_expire_trans = $cs_emp_funs->cs_expire_pkgs_id();
                                            $cv_expire_trans = $cs_emp_funs->cs_expire_cv_pkgs_id();
                                            while ($custom_query->have_posts()) : $custom_query->the_post();
                                                $cs_trans_id = get_post_meta(get_the_id(), "cs_transaction_id", true);
                                                $cs_trans_expiry = get_post_meta(get_the_id(), "cs_transaction_expiry_date", true);
                                                $cs_trans_type = get_post_meta(get_the_id(), "cs_transaction_type", true);
                                                $cs_trans_lists = get_post_meta(get_the_id(), "cs_transaction_listings", true);
                                                $cs_trans_status = get_post_meta(get_the_id(), "cs_transaction_status", true);
                                                $cs_tr_post_id = get_the_id();
                                                $cs_trans_status = $cs_trans_status != '' ? $cs_trans_status : 'pending';
                                                if ($cs_trans_status == 'pending') {
                                                    $cs_trans_status = esc_html__('Pending', 'jobhunt');
                                                } else if ($cs_trans_status == 'active') {
                                                    $cs_trans_status = esc_html__('Active', 'jobhunt');
                                                } else if ($cs_trans_status == 'approved') {
                                                    $cs_trans_status = esc_html__('Approved', 'jobhunt');
                                                }
                                                $cs_trans_status = $cs_trans_status == 'approved' ? 'active' : $cs_trans_status;
                                                $cs_trans_lists = $cs_trans_lists != '' && $cs_trans_lists > 0 ? $cs_trans_lists : 0;
                                                if ($cs_trans_expiry != '') {
                                                    $cs_trans_expiry = date_i18n(get_option('date_format'), $cs_trans_expiry);
                                                }
                                                if ($cs_trans_type == 'cv_trans') {
                                                    $cs_trans_pkg = get_post_meta($cs_tr_post_id, "cs_transaction_cv_pkg", true);
                                                    $cs_trans_pkg_title = $cs_emp_funs->get_cv_pkg_field($cs_trans_pkg);
                                                } else {
                                                    $cs_trans_pkg = get_post_meta($cs_tr_post_id, "cs_transaction_package", true);
                                                    $cs_trans_pkg_title = $cs_emp_funs->get_pkg_field($cs_trans_pkg);
                                                }
                                                if ($cs_trans_type != 'cv_trans' && $cs_trans_type != 'featured_only') {
                                                    if ($cs_emp_funs->cs_is_pkg_subscribed($cs_trans_pkg) && $cs_emp_funs->cs_is_pkg_subscribed($cs_trans_pkg, true) == $cs_trans_id) {
                                                        $cs_pkg = $cs_emp_funs->cs_update_pkg_subs(true, $cs_trans_pkg);

                                                        if (CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->cs_user_pkg_detail($cs_pkg, '', true)) != '') {
                                                            echo '<tr>';
                                                            echo '<td>' . absint($cs_trans_num) . '</td>';
                                                            echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->cs_user_pkg_detail($cs_pkg, '', true));
                                                            echo '</tr>';
                                                            $cs_trans_num ++;
                                                        }
                                                    } else if (is_array($cs_expire_trans) && in_array($cs_tr_post_id, $cs_expire_trans)) {
                                                        echo '<tr>';
                                                        echo '<td>' . absint($cs_trans_num) . '</td>';
                                                        echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->cs_expire_pkgs($cs_tr_post_id));
                                                        echo '</tr>';
                                                        $cs_trans_num ++;
                                                    } else if ($cs_trans_pkg_title != '') {
                                                        $cs_trans_pkg_title = apply_filters('jobhunt_package_type_title', $cs_trans_pkg_title, $cs_trans_type);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo absint($cs_trans_num) ?></td>
                                                            <td>#<?php echo absint($cs_trans_id) ?></td>
                                                            <td><?php echo CS_FUNCTIONS()->cs_special_chars($cs_trans_pkg_title) ?></td>
                                                            <td><?php echo CS_FUNCTIONS()->cs_special_chars($cs_trans_expiry) ?></td>
                                                            <td><?php echo absint($cs_trans_lists) ?></td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td><?php echo ucfirst($cs_trans_status) ?></td>
                                                        </tr>
                                                        <?php
                                                        $cs_trans_num ++;
                                                    }
                                                } else if ($cs_trans_type == 'featured_only') {
                                                    if ($cs_emp_funs->cs_is_pkg_subscribed($cs_trans_pkg) && $cs_emp_funs->cs_is_pkg_subscribed($cs_trans_pkg, true) == $cs_trans_id) {
                                                        $cs_pkg = $cs_emp_funs->cs_update_pkg_subs(true, $cs_trans_pkg);

                                                        if (CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->cs_user_pkg_detail($cs_pkg, '', true)) != '') {
                                                            echo '<tr>';
                                                            echo '<td>' . absint($cs_trans_num) . '</td>';
                                                            echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->cs_user_pkg_detail($cs_pkg, '', true, true));
                                                            echo '</tr>';
                                                            $cs_trans_num ++;
                                                        }
                                                    } else if (is_array($cs_expire_trans) && in_array($cs_tr_post_id, $cs_expire_trans)) {
                                                        echo '<tr>';
                                                        echo '<td>' . absint($cs_trans_num) . '</td>';
                                                        echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->cs_expire_pkgs($cs_tr_post_id, true));
                                                        echo '</tr>';
                                                        $cs_trans_num ++;
                                                    } else if ($cs_trans_pkg_title != '') {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo absint($cs_trans_num) ?></td>
                                                            <td>#<?php echo absint($cs_trans_id) ?></td>
                                                            <td><?php echo CS_FUNCTIONS()->cs_special_chars($cs_trans_pkg_title) . ' ' . esc_html__('(Featured only)', 'jobhunt') ?></td>
                                                            <td><?php echo CS_FUNCTIONS()->cs_special_chars($cs_trans_expiry) ?></td>
                                                            <td colspan="3"> - </td>
                                                            <td><?php echo ucfirst($cs_trans_status) ?></td>
                                                        </tr>
                                                        <?php
                                                        $cs_trans_num ++;
                                                    }
                                                } else if ($cs_trans_type == 'cv_trans') {
                                                    $cs_get_trans_id = '';
                                                    if ($cs_emp_funs->cs_is_cv_pkg_subs($cs_trans_pkg)) {
                                                        $cs_get_trans_id = get_post_meta($cs_emp_funs->cs_is_cv_pkg_subs($cs_trans_pkg, true), "cs_transaction_id", true);
                                                    }
                                                    if ($cs_emp_funs->cs_is_cv_pkg_subs($cs_trans_pkg) && $cs_get_trans_id == $cs_trans_id) {
                                                        $cs_trans_post_id = $cs_tr_post_id;
                                                        $cs_pkg_subs = array('pkg_id' => $cs_trans_pkg, 'trans_id' => $cs_trans_post_id);
                                                        if (CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->user_cv_pkg_detail($cs_pkg_subs, true)) != '') {
                                                            echo '<tr>';
                                                            echo '<td>' . absint($cs_trans_num) . '</td>';
                                                            echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->user_cv_pkg_detail($cs_pkg_subs, true));
                                                            echo '</tr>';
                                                            $cs_trans_num ++;
                                                        }
                                                    } else if (is_array($cv_expire_trans) && in_array($cs_tr_post_id, $cv_expire_trans)) {
                                                        echo '<tr>';
                                                        echo '<td>' . absint($cs_trans_num) . '</td>';
                                                        echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->cs_cv_expire_pkgs($cs_tr_post_id));
                                                        echo '</tr>';
                                                        $cs_trans_num ++;
                                                    } else if ($cs_trans_pkg_title != '') {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo absint($cs_trans_num) ?></td>
                                                            <td>#<?php echo absint($cs_trans_id) ?></td>
                                                            <td><?php echo CS_FUNCTIONS()->cs_special_chars($cs_trans_pkg_title) ?></td>
                                                            <td><?php echo CS_FUNCTIONS()->cs_special_chars($cs_trans_expiry) ?></td>
                                                            <td><?php echo absint($cs_trans_lists) ?></td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td><?php echo ucfirst($cs_trans_status) ?></td>
                                                        </tr>
                                                        <?php
                                                        $cs_trans_num ++;
                                                    }
                                                }
                                            endwhile;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                            if ($count_all_records > $cs_blog_num_post && $cs_blog_num_post > 0) {
                                echo '<nav>';
                                echo cs_ajax_pagination($count_all_records, $cs_blog_num_post, 'packages', 'employer', $uid, '');
                                echo '</nav>';
                            }//==Pagination End
                        } else {
                            echo '<div class="cs-no-record">' . cs_info_messages_listing(esc_html__("There is no package in your list.", 'jobhunt')) . '</div>';
                        }
                    } else {
                        echo '<div class="cs-no-record">' . cs_info_messages_listing(esc_html__("There is no package in your list.", 'jobhunt')) . '</div>';
                    }
                    ?>
                </div>
            </div>
            <?php
            die();
        }

    }

    $cs_emp_ajax_temps = new cs_employer_ajax_templates();
}