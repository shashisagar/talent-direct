<?php
/**

 * File Type: Employer Templates

 */
if (!class_exists('cs_employer_templates')) {



    class cs_employer_templates {

        /**

         * Start construct Functions

         */
        public function __construct() {
// Post Job Function
            add_action('wp_ajax_cs_employer_post_job', array(&$this, 'cs_employer_post_job'));
            add_action('wp_ajax_nopriv_cs_employer_post_job', array(&$this, 'cs_employer_post_job'));
        }

        /**
         * Start Function for how to create Employer Menu
         */
        public function cs_employer_menu($uid, $cs_pkg_array) {

            global $cs_plugin_options, $cs_form_fields2, $cs_form_fields_frontend;
            ;
            $cs_user_data = get_userdata($uid);
            $cs_comp_name = $cs_user_data->display_name;
            $emp_cell_no = get_user_meta($uid, 'cs_phone_number', true);
            $employer_email_address = $cs_user_data->user_email;
            $cs_candidate_switch = isset($cs_plugin_options['cs_candidate_switch']) ? $cs_plugin_options['cs_candidate_switch'] : '';
            $cs_emploayer_dashboard_vew = isset($cs_plugin_options['cs_employer_dashboard_view']) ? $cs_plugin_options['cs_employer_dashboard_view'] : '';
            if ($cs_emploayer_dashboard_vew == '') {
                $cs_emploayer_dashboard_vew = 'default';
            }
            $cs_job_id = isset($_GET['job_id']) ? $_GET['job_id'] : '';
            $remove_candidate_role = 'no';
            $remove_candidate_role = apply_filters('jobhunt_remove_candidate_role_frontend', $remove_candidate_role);
            $cs_value = get_user_meta($uid, 'user_img', true);
            $imagename_only = $cs_value;
            $cs_jobhunt = new wp_jobhunt();
            $celine_active = false;
            $celine_active = apply_filters('jobhunt_celine_depedency', $celine_active);
            ?>
            <?php if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'default') { ?>
                <aside class="section-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <?php } if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'fancy' || $cs_emploayer_dashboard_vew == 'fancy_full') { ?>
                    <aside class="section-sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="bg-holder">
                            <?php if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'fancy') { ?>
                                <div class="cs-profile-holder">
                                    <div class="cs-img-detail">
                                        <div class="alert alert-dismissible user-img"> 
                                            <div class="page-wrap" id="cs_employer_img_box">
                                                <div class="upload-btn-div">
                                                    <div class="fileUpload uplaod-btn btn cs-color csborder-color">
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
                                                        ?>
                                                        <label class="browse-icon">
                                                            <?php
                                                            $cs_opt_array = array(
                                                                'std' => esc_html__('Browse', 'jobhunt'),
                                                                'id' => '',
                                                                'force_std' => true,
                                                                'return' => true,
                                                                'cust_id' => '',
                                                                'cust_name' => 'media_upload',
                                                                'classes' => 'left cs-uploadimg upload',
                                                                'cust_type' => 'file',
                                                            );
                                                            echo force_balance_tags($cs_form_fields2->cs_form_text_render($cs_opt_array));
                                                            ?>
                                                        </label>
                                                    </div>
                                                    <br /> 
                                                    <span id="cs_employer_profile_img_msg" style="display:none;"><?php esc_html_e('Max file size is 1MB, Minimum dimension: 270x210 And Suitable files are .jpg & .png', 'jobhunt') ?></span>
                                                </div>
                                                <figure>
                                                    <?php
                                                    if ($cs_value <> '') {
                                                        $cs_value = cs_get_img_url($cs_value, '');
                                                        ?>
                                                        <img src="<?php echo esc_url($cs_value); ?>" id="cs_employer_img_img" width="100" alt="" />
                                                    <?php } else { ?>
                                                        <img src="<?php echo esc_url($cs_jobhunt->plugin_url()); ?>assets/images/upload-img.jpg" id="cs_employer_img_img" width="100" alt="" />
                                                        <?php
                                                    }
                                                    ?>
                                                </figure>
                                            </div>
                                        </div>
                                        <div class="user-info">
                                            <h5 class="cs-candidate-title"><?php echo esc_html__($cs_comp_name, 'jobhunt'); ?></h5>
                                            <em> <i class="icon-phone6"></i> <?php echo esc_html__($emp_cell_no, 'jobhunt'); ?></em>
                                            <em> <i class="icon-mail6"></i> <?php echo esc_html__($employer_email_address, 'jobhunt'); ?></em>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <ul class="account-menu">
                            <li id="employer_left_resumes_link" 
							<?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'resumes') || (!isset($_REQUEST['profile_tab']) || $_REQUEST['profile_tab'] == '')) echo 'class="active"'; ?>
							>
                                        <a id="employer_resumes_click_link_id" href="javascript:void(0);" onclick='cs_dashboard_tab_load("resumes", "employer", "<?php echo esc_js(admin_url('admin-ajax.php')); ?>", "<?php echo absint($uid); ?>", "");' ><i class="icon-heart11"></i><?php esc_html_e('Your Candidates', 'jobhunt'); ?></a>
                                    </li>
                            <li id="employer_left_profile_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'profile')) echo 'class="active"'; ?>>
                                <a id="employer_profile_click_link_id" href="javascript:void(0);" onclick="cs_dashboard_tab_load('profile', 'employer', '<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($uid); ?>');" ><i class="icon-building"></i><?php esc_html_e('Company Profile', 'jobhunt'); ?></a>
                            </li>
                            <?php
                            if (!$celine_active) {
                                ?>
                                <li id="employer_left_packages_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'packages')) echo 'class="active"'; ?>>
                                    <a id="employer_packages_click_link_id" href="javascript:void(0);" onclick='cs_dashboard_tab_load("packages", "employer", "<?php echo esc_js(admin_url('admin-ajax.php')); ?>", "<?php echo absint($uid); ?>", "");' ><i class="icon-tag7"></i><?php esc_html_e('Packages', 'jobhunt'); ?></a>
                                </li>
                            <?php } ?>
                            <li id="employer_left_postjobs_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'postjobs')) echo 'class="active"'; ?>>
                                <a id="employer_postjobs_click_link_id" href="javascript:void(0);" onclick='cs_dashboard_tab_load("postjobs", "employer", "<?php echo esc_js(admin_url('admin-ajax.php')); ?>", "<?php echo absint($uid); ?>", "");' ><i class="icon-plus-square"></i><?php esc_html_e('Post a New Job', 'jobhunt'); ?></a>
                            </li>
                            <li id="employer_left_jobs_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'jobs') || (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'editjob' )) echo 'class="active"'; ?>>
                                <a id="employer_jobs_click_link_id" href="javascript:void(0);" onclick="cs_dashboard_tab_load('jobs', 'employer', '<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($uid); ?>');" ><i class="icon-suitcase5"></i><?php esc_html_e('Manage Jobs', 'jobhunt'); ?></a>
                            </li>
                            <?php
                            if (!$celine_active) {
                                ?>
                                <li id="employer_left_transactions_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'transactions')) echo 'class="active"'; ?>>
                                    <a id="employer_transactions_click_link_id" href="javascript:void(0);" onclick="cs_dashboard_tab_load('transactions', 'employer', '<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($uid); ?>');" ><i class="icon-graph"></i><?php esc_html_e('Transactions', 'jobhunt'); ?></a>
                                </li>
                            <?php } ?>  
                            <?php
                            $candidate_enable = true;
                            $candidate_enable = apply_filters('jobhunt_candidate_enable', $candidate_enable);
                            ?>
                            <?php if ($candidate_enable == true && $remove_candidate_role != 'yes' && !$celine_active) { ?>
                                <?php
                                if ($cs_candidate_switch == 'on') { // if admin allow to view candidate after buy cv package
                                    ?>
                                   <!-- <li id="employer_left_resumes_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'resumes')) echo 'class="active"'; ?>>
                                        <a id="employer_resumes_click_link_id" href="javascript:void(0);" onclick='cs_dashboard_tab_load("resumes", "employer", "<?php echo esc_js(admin_url('admin-ajax.php')); ?>", "<?php echo absint($uid); ?>", "");' ><i class="icon-file4"></i><?php esc_html_e('Resumes', 'jobhunt'); ?></a>
                                    </li>-->
                                <?php } else { ?>
                                   <!-- <li id="employer_left_resumes_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'resumes')) echo 'class="active"'; ?>>
                                        <a id="employer_resumes_click_link_id" href="javascript:void(0);" onclick='cs_dashboard_tab_load("resumes", "employer", "<?php echo esc_js(admin_url('admin-ajax.php')); ?>", "<?php echo absint($uid); ?>", "");' ><i class="icon-heart11"></i><?php esc_html_e('Resumes', 'jobhunt'); ?></a>
                                    </li>-->
                                    <?php
                                }
                            }
                            ?>
                            
                            <?php
                            $profile_tab = isset($_REQUEST['profile_tab']) ? $_REQUEST['profile_tab'] : '';
                            do_action('jobhunt_employer_dashboard_menu_left', $profile_tab, $uid);
                            ?>
                            <li id="employer_left_change_password_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'change_password')) echo 'class="active"'; ?>>
                                <a id="employer_change_password_click_link_id" href="javascript:void(0);" onclick='cs_dashboard_tab_load("change_password", "employer", "<?php echo esc_js(admin_url('admin-ajax.php')); ?>", "<?php echo absint($uid); ?>", "");' ><i class="icon-lock3"></i><?php esc_html_e('Change Password', 'jobhunt'); ?></a>
                            </li>
                            <?php
                            $cs_href = esc_url(get_author_posts_url($uid));
                            ?>
                            <li>
                                <a href="<?php echo esc_url($cs_href); ?>" ><i class="icon-user9"></i><?php esc_html_e('View Profile', 'jobhunt'); ?></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="cs_remove_profile('<?php echo esc_js(admin_url('admin-ajax.php')) ?> ', '<?php echo $uid; ?>');"><i class="icon-trash4"></i><?php esc_html_e('Delete Profile', 'jobhunt'); ?></a>
                            </li>
                            <?php do_action('jobhunt_manage_employee_tab', $uid, $_REQUEST); ?>
                            <li><a href="<?php echo esc_url(wp_logout_url(cs_server_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) ?>"><i class="icon-logout"></i><?php esc_html_e('Logout', 'jobhunt'); ?></a> </li>

                        </ul>
                        <?php if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'fancy') { ?>
                        </div>
                    <?php } ?>
                </aside>
                <?php
            }
            /**
             * Start Function for Employer Post job
             */
            public function cs_employer_post_job($cs_elem = false) {

                global $post, $gateways, $current_user, $cs_form_fields2;
                $general_settings = new CS_PAYMENTS();
                if ($cs_elem == true) {
                    $cs_pag_id = $post->ID;
                }
                $cs_plugin_options = get_option('cs_plugin_options');
                $cs_free_jobs_switch = isset($cs_plugin_options['cs_free_jobs_switch']) ? $cs_plugin_options['cs_free_jobs_switch'] : '';
                $cs_free_jobs_switch = apply_filters('jobhunt_gerard_free_job_switch', $cs_free_jobs_switch);
                if (isset($_POST['pkg_array'])) {
                    $cs_pkg_array = stripslashes($_POST['pkg_array']);
                    $post_array = json_decode($cs_pkg_array, true);
                    if (is_array($post_array) && sizeof($post_array) > 0) {
                        if (isset($post_array['job_imge'])) {
                            $job_imge = $post_array['job_imge'];
                        }
                        if (isset($post_array['post_array'])) {
                            $post_array = $post_array['post_array'];
                            $_POST = array_merge($_POST, $post_array);
                        }
                    }
                }
                $uid = (isset($_POST['cs_uid']) and $_POST['cs_uid'] <> '') ? $_POST['cs_uid'] : '';
                $cs_plugin_options = get_option('cs_plugin_options');
                if (class_exists('cs_employer_functions')) {
                    $cs_emp_funs = new cs_employer_functions();
                }
                $cs_vat_switch = isset($cs_plugin_options['cs_vat_switch']) ? $cs_plugin_options['cs_vat_switch'] : '';
                $cs_pay_vat = isset($cs_plugin_options['cs_payment_vat']) ? $cs_plugin_options['cs_payment_vat'] : '0';
                if (isset($cs_plugin_options['cs_use_woocommerce_gateway']) && $cs_plugin_options['cs_use_woocommerce_gateway'] == 'on') {
                    $cs_pay_vat = 0;
                }
                $currency_sign = jobcareer_get_currency_sign();
                $cs_feature_amount = isset($cs_plugin_options['cs_job_feat_price']) ? $cs_plugin_options['cs_job_feat_price'] : '';
                $cs_packages_options = isset($cs_plugin_options['cs_packages_options']) ? $cs_plugin_options['cs_packages_options'] : '';
                $cs_job_id = isset($_GET['job_id']) ? $_GET['job_id'] : '';
                if (isset($_POST['cs_external_url_id']) && !empty($_POST['cs_external_url_id'])) {
                    update_post_meta($cs_job_id, "cs_external_url_id", $_POST['cs_external_url_id']);
                }
                // add post or not
                $cs_post_job = true;
                if (isset($_POST['cs_update_job']) && $_POST['cs_update_job'] != '') {
                    $cs_post_job = false;
                }
                // add post or not
                $cs_current_date = strtotime(date('d-m-Y'));
                if (!is_user_logged_in() && isset($_POST['cs_pkg_trans']) && $_POST['cs_pkg_trans'] == 1) {
                    $cs_username = isset($_POST['cs_user']) ? $_POST['cs_user'] : '';
                    $cs_user_email = isset($_POST['cs_emp_email']) ? $_POST['cs_emp_email'] : '';
                    $cs_posting_user = $cs_emp_funs->cs_create_user($cs_username, $cs_user_email);
                } else {
                    $cs_posting_user = $current_user->ID;
                }
                $cs_trans_pkg = isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '';
                // Checking Subscription
                $cs_pkg_subscribe = false;
                if ($cs_emp_funs->cs_is_pkg_subscribed($cs_trans_pkg)) {
                    $cs_pkg_subscribe = true;
                    $cs_trans_ins_id = $cs_emp_funs->cs_is_pkg_subscribed($cs_trans_pkg, true);
                } else if ($cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_price') != '' && $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_price') <= 0) {
                    $cs_pkg_subscribe = true;
                    $cs_trans_ins_id = '';
                }
                $cs_job_emplyr = get_post_meta($cs_job_id, 'cs_job_username', true);
                $cs_job_emplyr = cs_get_user_id_by_login($cs_job_emplyr);
                $job_pckge_id = get_post_meta($cs_job_id, 'cs_job_package', true);
                $get_job_feat = get_post_meta($cs_job_id, 'cs_job_featured', true);
                $cs_external_link = get_post_meta($cs_job_id, "cs_external_url_id", true);
                if ($get_job_feat == 'on') {
                    $get_job_feat = 'yes';
                }
                $cs_job_pkg = '';
                $cs_job_expiry = '';
                if ($cs_job_id <> '') {
                    $cs_job_pkg = get_post_meta($cs_job_id, 'cs_job_package', true);
                    $cs_job_expiry = get_post_meta($cs_job_id, 'cs_job_expired', true);
                }
                $job_expired_case = false;
                if ($cs_post_job == false && ( $cs_job_expiry <= $cs_current_date || $cs_job_pkg == '' )) {
                    $job_expired_case = true;
                }
                // When update job and package expire but job not expire then package subscribe is true.
                if ($job_expired_case == false && $cs_post_job == false && $cs_job_id != '') {
                    $cs_pkg_subscribe = true;
                }
                // Updating Data into Meta
                if ($cs_job_id <> '' && isset($_POST['cs_pkg_trans']) && $_POST['cs_pkg_trans'] == 1 && $cs_job_emplyr == $current_user->ID) {
                    if ($job_expired_case == true) {
                        if (isset($_POST['job_pckge']) && $_POST['job_pckge'] != '') {
                            if ($cs_emp_funs->cs_is_pkg_subscribed($_POST['job_pckge'])) {
                                $cs_ins_exp = $cs_emp_funs->cs_job_expiry($_POST['job_pckge']);
                                $cs_pkg_transe_id = $cs_emp_funs->cs_is_pkg_subscribed($_POST['job_pckge'], true);
                                //update_post_meta($cs_job_id, 'cs_job_expired', strtotime($cs_ins_exp));
                                update_post_meta($cs_job_id, 'cs_job_package', $_POST['job_pckge']);
                                update_post_meta($cs_job_id, 'cs_trans_id', $cs_pkg_transe_id);
                                update_post_meta($cs_job_id, 'cs_job_status', 'active');
                                // update transaction [Add job ID of the updated job]
                                $cs_transe_post_id = $cs_emp_funs->cs_get_post_id_by_meta_key('cs_transaction_id', $cs_pkg_transe_id);
                                $cs_job_poste_ids = get_post_meta($cs_transe_post_id, "cs_job_id", true);
                                $cs_job_poste_ids = explode(',', $cs_job_poste_ids);
                                if (is_array($cs_job_poste_ids) && $cs_job_poste_ids[0] != '') {
                                    $cs_job_poste_ids = array_merge($cs_job_poste_ids, array($cs_job_id));
                                    $cs_job_poste_ids = implode(',', $cs_job_poste_ids);
                                    update_post_meta($cs_transe_post_id, "cs_job_id", "$cs_job_poste_ids");
                                } else {
                                    update_post_meta($cs_transe_post_id, "cs_job_id", "$cs_job_id");
                                }
                                //what if feature also selected
                                if ($get_job_feat != 'yes') {
                                    $cs_total_amount = 0;
                                    if (isset($_POST['cs_job_featured']) && $_POST['cs_job_featured'] != '') {
                                        $cs_total_amount += CS_FUNCTIONS()->cs_num_format($cs_feature_amount);
                                    }
                                    $cs_smry_totl = $cs_total_amount;
                                    if ($cs_vat_switch == 'on' && $cs_pay_vat > 0) {
                                        $cs_vat_amount = $cs_total_amount * ( $cs_pay_vat / 100 );
                                        $cs_total_amount = CS_FUNCTIONS()->cs_num_format($cs_vat_amount) + $cs_total_amount;
                                    }
                                    $cs_trans_pkg = isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '';
                                    $cs_pkg_title = $cs_emp_funs->get_pkg_field($cs_trans_pkg);
                                    $cs_pkg_expiry = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration');
                                    $cs_pkg_duration = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration_period');
                                    $cs_pkg_expir_days = strtotime($cs_emp_funs->cs_date_conv($cs_pkg_expiry, $cs_pkg_duration));
                                    $cs_pkg_list_num = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_listings');
                                    $cs_pkg_list_exp = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_submission_limit');
                                    $cs_pkg_list_per = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'cs_list_dur');
                                    $cs_trans_fields = array(
                                        'cs_job_id' => $cs_job_id,
                                        'cs_trans_id' => rand(149344111, 991435901),
                                        'cs_trans_user' => $cs_posting_user,
                                        'cs_package_title' => $cs_pkg_title,
                                        'cs_trans_package' => isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '',
                                        'cs_trans_featured' => isset($_POST['cs_job_featured']) ? $_POST['cs_job_featured'] : '',
                                        'cs_trans_amount' => $cs_total_amount,
                                        'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                                        'cs_trans_list_num' => $cs_pkg_list_num,
                                        'cs_trans_list_expiry' => $cs_pkg_list_exp,
                                        'cs_trans_list_period' => $cs_pkg_list_per,
                                    );
                                    if ($cs_pkg_subscribe) {
                                        $cs_trans_fields['cs_trans_only_featued'] = 'yes';
                                    }
                                    if ($cs_total_amount > 0 && $job_expired_case == true) {
                                        $cs_trans_html = $cs_emp_funs->cs_pay_process($cs_trans_fields);
                                    }
                                }
                                if ($cs_total_amount <= 0 && $job_expired_case == true) {
                                    update_post_meta($cs_job_id, 'cs_job_expired', strtotime($cs_ins_exp));
                                }
                            } else {
                                $cs_ins_exp = $cs_emp_funs->cs_job_expiry($_POST['job_pckge']);
                                //update_post_meta($cs_job_id, 'cs_job_expired', strtotime($cs_ins_exp));
                                update_post_meta($cs_job_id, 'cs_job_package', $_POST['job_pckge']);
                                //update_post_meta($cs_job_id, 'cs_job_status', 'awaiting-activation');
                                // Generate new transaction
                                $cs_total_amount = 0;
                                if (isset($_POST['job_pckge']) && $_POST['job_pckge'] <> '')
                                    $cs_total_amount += CS_FUNCTIONS()->cs_num_format($cs_emp_funs->get_pkg_field($_POST['job_pckge'], 'package_price'));
                                if (isset($_POST['cs_job_featured']) && $_POST['cs_job_featured'] != '' && $get_job_feat != 'yes') {
                                    $cs_total_amount += CS_FUNCTIONS()->cs_num_format($cs_feature_amount);
                                }
                                $cs_smry_totl = $cs_total_amount;
                                if ($cs_vat_switch == 'on' && $cs_pay_vat > 0) {
                                    $cs_vat_amount = $cs_total_amount * ( $cs_pay_vat / 100 );
                                    $cs_total_amount = CS_FUNCTIONS()->cs_num_format($cs_vat_amount) + $cs_total_amount;
                                }
                                $cs_trans_pkg = isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '';
                                $cs_pkg_title = $cs_emp_funs->get_pkg_field($cs_trans_pkg);
                                $cs_pkg_expiry = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration');
                                $cs_pkg_duration = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration_period');
                                $cs_pkg_expir_days = strtotime($cs_emp_funs->cs_date_conv($cs_pkg_expiry, $cs_pkg_duration));
                                $cs_pkg_list_num = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_listings');
                                $cs_pkg_list_exp = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_submission_limit');
                                $cs_pkg_list_per = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'cs_list_dur');
                                $cs_trans_fields = array(
                                    'cs_job_id' => $cs_job_id,
                                    'cs_trans_id' => rand(149344111, 991435901),
                                    'cs_trans_user' => $cs_posting_user,
                                    'cs_package_title' => $cs_pkg_title,
                                    'cs_trans_package' => isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '',
                                    'cs_trans_featured' => isset($_POST['cs_job_featured']) ? $_POST['cs_job_featured'] : '',
                                    'cs_trans_amount' => $cs_total_amount,
                                    'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                                    'cs_trans_list_num' => $cs_pkg_list_num,
                                    'cs_trans_list_expiry' => $cs_pkg_list_exp,
                                    'cs_trans_list_period' => $cs_pkg_list_per,
                                );
                                if ($cs_total_amount > 0) {
                                    update_post_meta($cs_job_id, 'cs_job_status', 'awaiting-activation');
                                    $cs_trans_html = $cs_emp_funs->cs_pay_process($cs_trans_fields);
                                } else {
                                    if (isset($cs_plugin_options['cs_jobs_review_option']) && $cs_plugin_options['cs_jobs_review_option'] != 'on') {
                                        update_post_meta($cs_job_id, 'cs_job_status', 'active');
                                    } else {
                                        update_post_meta($cs_job_id, 'cs_job_status', 'awaiting-activation');
                                    }
                                    update_post_meta($cs_job_id, 'cs_job_expired', strtotime($cs_ins_exp));
                                }
                            }
                        }
                    }
                    $cs_job_feat = isset($_POST['cs_job_featured']) && $_POST['cs_job_featured'] != '' ? 'yes' : 'no';
                    $cs_job_cus = isset($_POST['cs_cus_field']) ? $_POST['cs_cus_field'] : '';
                    if ($get_job_feat == 'yes') {
                        update_post_meta((int) $cs_job_id, 'cs_job_featured', $cs_job_feat);
                    }
                    if (is_array($cs_job_cus) && sizeof($cs_job_cus) > 0) {
                        foreach ($cs_job_cus as $c_key => $c_val) {
                            update_post_meta((int) $cs_job_id, "$c_key", $c_val);
                        }
                    }
                    // update job specialisms
                    $cs_job_specialisms = isset($_POST['cs_job_specialisms']) ? $_POST['cs_job_specialisms'] : '';
                    if (!empty($cs_job_specialisms)) {
                        wp_set_post_terms($cs_job_id, array(), 'specialisms', FALSE);
                        foreach ($cs_job_specialisms as $cs_spec) {
                            $cs_spec = (int) $cs_spec;
                            wp_set_post_terms($cs_job_id, array($cs_spec), 'specialisms', true);
                        }
                    }
                    // update job type
                    $cs_job_types = isset($_POST['cs_job_types']) ? $_POST['cs_job_types'] : '';
                    if ($cs_job_types != '') {
                        wp_set_post_terms((int) $cs_job_id, array($cs_job_types), 'job_type', FALSE);
                    }
                    // update location 
                    $cs_post_loc_country = isset($_POST['cs_post_loc_country']) ? $_POST['cs_post_loc_country'] : '';
                    if ($cs_post_loc_country != '') {
                        update_post_meta((int) $cs_job_id, "cs_post_loc_country", $cs_post_loc_country);
                    }
                    $cs_post_loc_region = isset($_POST['cs_post_loc_region']) ? $_POST['cs_post_loc_region'] : '';
                    if ($cs_post_loc_region != '') {
                        update_post_meta((int) $cs_job_id, "cs_post_loc_region", $cs_post_loc_region);
                    }
                    $cs_post_loc_city = isset($_POST['cs_post_loc_city']) ? $_POST['cs_post_loc_city'] : '';
                    if ($cs_post_loc_city != '') {
                        update_post_meta((int) $cs_job_id, "cs_post_loc_city", $cs_post_loc_city);
                    }
                    $cs_post_loc_address = isset($_POST['cs_post_loc_address']) ? $_POST['cs_post_loc_address'] : '';
                    if ($cs_post_loc_address != '') {
                        update_post_meta((int) $cs_job_id, "cs_post_loc_address", $cs_post_loc_address);
                    }
                    $cs_post_loc_latitude = isset($_POST['cs_post_loc_latitude']) ? $_POST['cs_post_loc_latitude'] : '';
                    if ($cs_post_loc_latitude != '') {
                        update_post_meta((int) $cs_job_id, "cs_post_loc_latitude", $cs_post_loc_latitude);
                    }
                    $cs_post_loc_longitude = isset($_POST['cs_post_loc_longitude']) ? $_POST['cs_post_loc_longitude'] : '';
                    if ($cs_post_loc_longitude != '') {
                        update_post_meta((int) $cs_job_id, "cs_post_loc_longitude", $cs_post_loc_longitude);
                    }
                    $cs_add_new_loc = isset($_POST['cs_add_new_loc']) ? $_POST['cs_add_new_loc'] : '';
                    if ($cs_add_new_loc != '') {

                        update_post_meta((int) $cs_job_id, "cs_add_new_loc", $cs_add_new_loc);
                    }
                    $cs_post_loc_zoom = isset($_POST['cs_post_loc_zoom']) ? $_POST['cs_post_loc_zoom'] : '';

                    if ($cs_post_loc_zoom != '') {

                        update_post_meta((int) $cs_job_id, "cs_post_loc_zoom", $cs_post_loc_zoom);
                    }
                    $job_post_args = array(
                        'ID' => $cs_job_id,
                        'post_title' => isset($_POST['cs_job_title']) ? $_POST['cs_job_title'] : '',
                        'post_content' => isset($_POST['cs_job_desc']) ? $_POST['cs_job_desc'] : '',
                    );
                    $cs_job_title_str = isset($_POST['cs_job_title']) ? $_POST['cs_job_title'] : '';
                    $cs_old_job_title_str = isset($_POST['old_job_title']) ? $_POST['old_job_title'] : '';
                    if ($cs_old_job_title_str != $cs_job_title_str) {

                        $job_post_args['post_name'] = sanitize_title($cs_job_title_str);
                    }
                    do_action('jobhunt_update_job_attachment_frontend', $cs_job_id, $_POST, $_FILES);
                    wp_update_post($job_post_args);

                    do_action('jobhunt_job_updated_on_front', $cs_job_id);
                }
                $cs_job_pkg = get_post_meta($cs_job_id, 'cs_job_package', true);
                $cs_job_expiry = get_post_meta($cs_job_id, 'cs_job_expired', true);
                $job_pckge_id = get_post_meta($cs_job_id, 'cs_job_package', true);
                $get_job_feat = get_post_meta($cs_job_id, 'cs_job_featured', true);
                $cs_job_emplyr = get_post_meta($cs_job_id, 'cs_job_username', true);
                $cs_job_emplyr = cs_get_user_id_by_login($cs_job_emplyr);
                $cs_status_changing = false;
                if ($get_job_feat == 'on') {
                    $get_job_feat = 'yes';
                }
                // Getting Data of job
                if ($cs_job_id <> '' && is_user_logged_in() && $cs_job_emplyr == $current_user->ID) {
                    $cs_job_titl = get_the_title($cs_job_id);
                    $cs_job_expire = get_post_meta((int) $cs_job_id, 'cs_job_expired', true);
                    if ($cs_job_expiry >= $cs_current_date && $cs_job_pkg != '') {
                        $cs_status_changing = true;
                        if (isset($_POST['cs_pkg_trans']) && isset($_POST['cs_post_status']) && $_POST['cs_pkg_trans'] == 1) {
                            update_post_meta((int) $cs_job_id, 'cs_job_status', $_POST['cs_post_status']);
                        }
                    }
                }
                $cs_img_value = get_post_meta($cs_job_id, 'job_img', true);
                if ($cs_job_id != '') {
                    $post_job = get_post($cs_job_id);
                    $cs_job_desc = $post_job->post_content;
                }
                $cs_job_status = get_post_meta($cs_job_id, 'cs_job_status', true);
                if (class_exists('cs_employer_functions')) {
                    if (isset($_POST['cs_pkg_trans']) && $_POST['cs_pkg_trans'] == 1) { // only for renewal job
                        if ($cs_free_jobs_switch == 'on') {
                            if ($cs_post_job == true) {
                                $cs_ins_exp = date('Y-m-d H:i:s', strtotime("+5 years"));
                                $cs_job_fields = array();
                                $cs_job_fields = array(
                                    'cs_job_id' => rand(149344111, 991435901),
                                    'cs_job_user' => $cs_posting_user,
                                    'cs_job_title' => isset($_POST['cs_job_title']) ? $_POST['cs_job_title'] : '',
                                    'cs_job_desc' => isset($_POST['cs_job_desc']) ? $_POST['cs_job_desc'] : '',
                                    'cs_job_expire' => $cs_ins_exp,
                                    'cs_job_specialisms' => isset($_POST['cs_job_specialisms']) ? $_POST['cs_job_specialisms'] : '',
                                    'cs_job_types' => isset($_POST['cs_job_types']) ? $_POST['cs_job_types'] : '',
                                    'cs_job_custom' => isset($_POST['cs_cus_field']) ? $_POST['cs_cus_field'] : '',
                                    'cs_post_loc_country' => isset($_POST['cs_post_loc_country']) ? $_POST['cs_post_loc_country'] : '',
                                    'cs_post_loc_region' => isset($_POST['cs_post_loc_region']) ? $_POST['cs_post_loc_region'] : '',
                                    'cs_post_loc_city' => isset($_POST['cs_post_loc_city']) ? $_POST['cs_post_loc_city'] : '',
                                    'cs_post_loc_address' => isset($_POST['cs_post_loc_address']) ? $_POST['cs_post_loc_address'] : '',
                                    'cs_post_loc_latitude' => isset($_POST['cs_post_loc_latitude']) ? $_POST['cs_post_loc_latitude'] : '',
                                    'cs_post_loc_longitude' => isset($_POST['cs_post_loc_longitude']) ? $_POST['cs_post_loc_longitude'] : '',
                                    'cs_add_new_loc' => isset($_POST['cs_add_new_loc']) ? $_POST['cs_add_new_loc'] : '',
                                    'cs_post_loc_zoom' => isset($_POST['cs_post_loc_zoom']) ? $_POST['cs_post_loc_zoom'] : '',
                                );
                                if (isset($cs_plugin_options['cs_jobs_review_option']) && $cs_plugin_options['cs_jobs_review_option'] != 'on') {
                                    $cs_job_fields['cs_job_status'] = 'active';
                                } else {
                                    $cs_job_fields['cs_job_status'] = 'awaiting-activation';
                                }
                                if ($cs_elem == true) {
                                    $job_id = $cs_emp_funs->cs_add_job($cs_job_fields, true);
                                } else {
                                    $job_id = $cs_emp_funs->cs_add_job($cs_job_fields);
                                }
                                do_action('jobhunt_update_job_attachment_frontend', $job_id, $_POST, $_FILES);
                                $cs_job_msg = esc_html__('Created Successfully.', 'jobhunt');
                            } else {
                                $job_id = $cs_job_id;
                                $cs_job_msg = esc_html__('Updated Successfully.', 'jobhunt');
                            }
                        } else {
                            if ($cs_pkg_subscribe == true) {
                                if ($cs_post_job == true) {
                                    $cs_ins_pkg = isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '';
                                    $cs_ins_exp = $cs_emp_funs->cs_job_expiry($cs_ins_pkg);
                                    $cs_job_fields = array();
                                    if (isset($cs_plugin_options['cs_jobs_review_option']) && $cs_plugin_options['cs_jobs_review_option'] != 'on') {
                                        $cs_job_fields = array(
                                            'cs_job_id' => rand(149344111, 991435901),
                                            'cs_job_user' => $cs_posting_user,
                                            'cs_job_title' => isset($_POST['cs_job_title']) ? $_POST['cs_job_title'] : '',
                                            'cs_job_desc' => isset($_POST['cs_job_desc']) ? $_POST['cs_job_desc'] : '',
                                            'cs_job_expire' => $cs_ins_exp,
                                            'cs_job_specialisms' => isset($_POST['cs_job_specialisms']) ? $_POST['cs_job_specialisms'] : '',
                                            'cs_job_types' => isset($_POST['cs_job_types']) ? $_POST['cs_job_types'] : '',
                                            'cs_job_custom' => isset($_POST['cs_cus_field']) ? $_POST['cs_cus_field'] : '',
                                            'cs_job_pkg' => $cs_ins_pkg,
                                            'cs_job_status' => 'active', // if subscribe package already 
                                            'cs_post_loc_country' => isset($_POST['cs_post_loc_country']) ? $_POST['cs_post_loc_country'] : '',
                                            'cs_post_loc_region' => isset($_POST['cs_post_loc_region']) ? $_POST['cs_post_loc_region'] : '',
                                            'cs_post_loc_city' => isset($_POST['cs_post_loc_city']) ? $_POST['cs_post_loc_city'] : '',
                                            'cs_post_loc_address' => isset($_POST['cs_post_loc_address']) ? $_POST['cs_post_loc_address'] : '',
                                            'cs_post_loc_latitude' => isset($_POST['cs_post_loc_latitude']) ? $_POST['cs_post_loc_latitude'] : '',
                                            'cs_post_loc_longitude' => isset($_POST['cs_post_loc_longitude']) ? $_POST['cs_post_loc_longitude'] : '',
                                            'cs_add_new_loc' => isset($_POST['cs_add_new_loc']) ? $_POST['cs_add_new_loc'] : '',
                                            'cs_post_loc_zoom' => isset($_POST['cs_post_loc_zoom']) ? $_POST['cs_post_loc_zoom'] : '',
                                        );
                                    } else {
                                        $cs_job_fields = array(
                                            'cs_job_id' => rand(149344111, 991435901),
                                            'cs_job_user' => $cs_posting_user,
                                            'cs_job_title' => isset($_POST['cs_job_title']) ? $_POST['cs_job_title'] : '',
                                            'cs_job_desc' => isset($_POST['cs_job_desc']) ? $_POST['cs_job_desc'] : '',
                                            'cs_job_expire' => $cs_ins_exp,
                                            'cs_job_specialisms' => isset($_POST['cs_job_specialisms']) ? $_POST['cs_job_specialisms'] : '',
                                            'cs_job_types' => isset($_POST['cs_job_types']) ? $_POST['cs_job_types'] : '',
                                            'cs_job_custom' => isset($_POST['cs_cus_field']) ? $_POST['cs_cus_field'] : '',
                                            'cs_job_pkg' => $cs_ins_pkg,
                                            'cs_job_status' => 'awaiting-activation', // if subscribe package already 
                                            'cs_post_loc_country' => isset($_POST['cs_post_loc_country']) ? $_POST['cs_post_loc_country'] : '',
                                            'cs_post_loc_region' => isset($_POST['cs_post_loc_region']) ? $_POST['cs_post_loc_region'] : '',
                                            'cs_post_loc_city' => isset($_POST['cs_post_loc_city']) ? $_POST['cs_post_loc_city'] : '',
                                            'cs_post_loc_address' => isset($_POST['cs_post_loc_address']) ? $_POST['cs_post_loc_address'] : '',
                                            'cs_post_loc_latitude' => isset($_POST['cs_post_loc_latitude']) ? $_POST['cs_post_loc_latitude'] : '',
                                            'cs_post_loc_longitude' => isset($_POST['cs_post_loc_longitude']) ? $_POST['cs_post_loc_longitude'] : '',
                                            'cs_add_new_loc' => isset($_POST['cs_add_new_loc']) ? $_POST['cs_add_new_loc'] : '',
                                            'cs_post_loc_zoom' => isset($_POST['cs_post_loc_zoom']) ? $_POST['cs_post_loc_zoom'] : '',
                                        );
                                    }
                                    if ($cs_elem == true) {
                                        $job_id = $cs_emp_funs->cs_add_job($cs_job_fields, true);
                                    } else {
                                        $job_id = $cs_emp_funs->cs_add_job($cs_job_fields);
                                    }
                                    do_action('jobhunt_update_job_attachment_frontend', $job_id, $_POST, $_FILES);
                                    $cs_job_msg = esc_html__('Created Successfully.', 'jobhunt');
                                } else {
                                    $job_id = $cs_job_id;
                                    $cs_job_msg = esc_html__('Updated Successfully.', 'jobhunt');
                                }
                                if ($cs_pkg_subscribe && $cs_post_job == true) {
                                    $trans_post_id = $cs_emp_funs->cs_get_post_id_by_meta_key("cs_transaction_id", $cs_trans_ins_id);
                                    $cs_job_post_ids = get_post_meta($trans_post_id, "cs_job_id", true);
                                    $cs_job_post_ids = explode(',', $cs_job_post_ids);
                                    if (is_array($cs_job_post_ids) && !in_array($job_id, $cs_job_post_ids) && $cs_job_post_ids[0] != '') {
                                        $cs_job_post_ids = array_merge($cs_job_post_ids, array($job_id));
                                        $cs_job_post_ids = implode(',', $cs_job_post_ids);
                                        update_post_meta($trans_post_id, "cs_job_id", "$cs_job_post_ids");
                                    } else {
                                        update_post_meta($trans_post_id, "cs_job_id", "$job_id");
                                    }
                                }
                                if (isset($cs_trans_ins_id) && $cs_trans_ins_id <> '' && $cs_pkg_subscribe == true) {
                                    update_post_meta((int) $job_id, 'cs_trans_id', $cs_trans_ins_id);
                                }
                                $cs_total_amount = isset($cs_total_amount) && $cs_total_amount > 0 ? $cs_total_amount : 0; //warning removal
                                if ($get_job_feat != 'yes') {
                                    if (isset($_POST['cs_job_featured']) && $_POST['cs_job_featured'] != '') {
                                        $cs_total_amount += CS_FUNCTIONS()->cs_num_format($cs_feature_amount);
                                    }
                                    $cs_smry_totl = isset($cs_total_amount) && $cs_total_amount > 0 ? $cs_total_amount : 0;
                                    if ($cs_vat_switch == 'on' && $cs_pay_vat > 0) {
                                        $cs_vat_amount = $cs_total_amount * ( $cs_pay_vat / 100 );
                                        $cs_total_amount = CS_FUNCTIONS()->cs_num_format($cs_vat_amount) + $cs_total_amount;
                                    }
                                    $cs_trans_pkg = isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '';
                                    $cs_pkg_title = $cs_emp_funs->get_pkg_field($cs_trans_pkg);
                                    $cs_pkg_expiry = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration');
                                    $cs_pkg_duration = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration_period');
                                    $cs_pkg_expir_days = strtotime($cs_emp_funs->cs_date_conv($cs_pkg_expiry, $cs_pkg_duration));
                                    $cs_pkg_list_num = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_listings');
                                    $cs_pkg_list_exp = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_submission_limit');
                                    $cs_pkg_list_per = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'cs_list_dur');
                                    $cs_trans_fields = array(
                                        'cs_job_id' => $job_id,
                                        'cs_trans_id' => rand(149344111, 991435901),
                                        'cs_trans_user' => $cs_posting_user,
                                        'cs_package_title' => $cs_pkg_title,
                                        'cs_trans_package' => isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '',
                                        'cs_trans_featured' => isset($_POST['cs_job_featured']) ? $_POST['cs_job_featured'] : '',
                                        'cs_trans_amount' => isset($cs_total_amount) && $cs_total_amount > 0 ? $cs_total_amount : 0,
                                        'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                                        'cs_trans_list_num' => $cs_pkg_list_num,
                                        'cs_trans_list_expiry' => $cs_pkg_list_exp,
                                        'cs_trans_list_period' => $cs_pkg_list_per,
                                    );
                                    if ($cs_pkg_subscribe) {
                                        $cs_trans_fields['cs_trans_only_featued'] = 'yes';
                                    }
                                    $cs_total_amount = isset($cs_total_amount) && $cs_total_amount > 0 ? $cs_total_amount : 0;
                                    if ($cs_total_amount > 0 && $job_expired_case != true) {
                                        $cs_trans_html = $cs_emp_funs->cs_pay_process($cs_trans_fields);
                                    }
                                }
                            } else {
                                if ($cs_post_job == true) {
                                    $cs_ins_pkg = isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '';
                                    $cs_ins_exp = $cs_emp_funs->cs_job_expiry($cs_ins_pkg);
                                    $cs_job_fields = array(
                                        'cs_job_id' => rand(149344111, 991435901),
                                        'cs_job_user' => $cs_posting_user,
                                        'cs_job_title' => isset($_POST['cs_job_title']) ? $_POST['cs_job_title'] : '',
                                        'cs_job_desc' => isset($_POST['cs_job_desc']) ? $_POST['cs_job_desc'] : '',
                                        'cs_job_specialisms' => isset($_POST['cs_job_specialisms']) ? $_POST['cs_job_specialisms'] : '',
                                        'cs_job_types' => isset($_POST['cs_job_types']) ? $_POST['cs_job_types'] : '',
                                        'cs_job_expire' => $cs_ins_exp,
                                        'cs_job_custom' => isset($_POST['cs_cus_field']) ? $_POST['cs_cus_field'] : '',
                                        'cs_job_pkg' => '',
                                        'cs_job_status' => 'awaiting-activation',
                                        'cs_post_loc_country' => isset($_POST['cs_post_loc_country']) ? $_POST['cs_post_loc_country'] : '',
                                        'cs_post_loc_region' => isset($_POST['cs_post_loc_region']) ? $_POST['cs_post_loc_region'] : '',
                                        'cs_post_loc_city' => isset($_POST['cs_post_loc_city']) ? $_POST['cs_post_loc_city'] : '',
                                        'cs_post_loc_address' => isset($_POST['cs_post_loc_address']) ? $_POST['cs_post_loc_address'] : '',
                                        'cs_post_loc_latitude' => isset($_POST['cs_post_loc_latitude']) ? $_POST['cs_post_loc_latitude'] : '',
                                        'cs_post_loc_longitude' => isset($_POST['cs_post_loc_longitude']) ? $_POST['cs_post_loc_longitude'] : '',
                                        'cs_add_new_loc' => isset($_POST['cs_add_new_loc']) ? $_POST['cs_add_new_loc'] : '',
                                        'cs_post_loc_zoom' => isset($_POST['cs_post_loc_zoom']) ? $_POST['cs_post_loc_zoom'] : '',
                                    );
                                    if ($cs_elem == true) {
                                        $job_id = $cs_emp_funs->cs_add_job($cs_job_fields, true);
                                    } else {
                                        $job_id = $cs_emp_funs->cs_add_job($cs_job_fields);
                                    }
                                    do_action('jobhunt_update_job_attachment_frontend', $job_id, $_POST, $_FILES);
                                    $cs_job_msg = esc_html__('Created Successfully.', 'jobhunt');
                                } else {
                                    $job_id = $cs_job_id;
                                    $cs_job_msg = esc_html__('Updated Successfully.', 'jobhunt');
                                }
                                $cs_total_amount = 0;
                                if (isset($_POST['job_pckge']) && $_POST['job_pckge'] <> '')
                                    $cs_total_amount += CS_FUNCTIONS()->cs_num_format($cs_emp_funs->get_pkg_field($_POST['job_pckge'], 'package_price'));
                                if (isset($_POST['cs_job_featured']) && $_POST['cs_job_featured'] != '')
                                    $cs_total_amount += CS_FUNCTIONS()->cs_num_format($cs_feature_amount);
                                $cs_smry_totl = $cs_total_amount;
                                if ($cs_vat_switch == 'on' && $cs_pay_vat > 0) {
                                    $cs_vat_amount = $cs_total_amount * ( $cs_pay_vat / 100 );
                                    $cs_total_amount = CS_FUNCTIONS()->cs_num_format($cs_vat_amount) + $cs_total_amount;
                                }
                                $cs_trans_pkg = isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '';
                                $cs_pkg_title = $cs_emp_funs->get_pkg_field($cs_trans_pkg);
                                $cs_pkg_expiry = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration');
                                $cs_pkg_duration = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_duration_period');
                                $cs_pkg_expir_days = strtotime($cs_emp_funs->cs_date_conv($cs_pkg_expiry, $cs_pkg_duration));
                                $cs_pkg_list_num = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_listings');
                                $cs_pkg_list_exp = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'package_submission_limit');
                                $cs_pkg_list_per = $cs_emp_funs->get_pkg_field($cs_trans_pkg, 'cs_list_dur');
                                $cs_trans_fields = array(
                                    'cs_job_id' => $job_id,
                                    'cs_trans_id' => rand(149344111, 991435901),
                                    'cs_trans_user' => $cs_posting_user,
                                    'cs_package_title' => $cs_pkg_title,
                                    'cs_trans_package' => isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '',
                                    'cs_trans_featured' => isset($_POST['cs_job_featured']) ? $_POST['cs_job_featured'] : '',
                                    'cs_trans_amount' => $cs_total_amount,
                                    'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                                    'cs_trans_list_num' => $cs_pkg_list_num,
                                    'cs_trans_list_expiry' => $cs_pkg_list_exp,
                                    'cs_trans_list_period' => $cs_pkg_list_per,
                                );
                                if ($cs_total_amount > 0 && $job_expired_case != true) {
                                    $cs_trans_html = $cs_emp_funs->cs_pay_process($cs_trans_fields);
                                }
                            }
                        }
                    }
                }
                $cs_act_class = 'active';
                $cs_conf_class = 'cs-confrmation-tab';
                $cs_conf_act_class = '';
                if (( isset($_POST['cs_pkg_trans']) && $_POST['cs_pkg_trans'] == 1 && isset($cs_total_amount) && $cs_total_amount > 0 ) || isset($_POST['invoice'])) {
                    $cs_act_class = '';
                    $cs_conf_class = '';
                    $cs_conf_act_class = 'active';
                }
                $cs_access = true;
                if (isset($_GET['job_id']) && $_GET['job_id'] != '' && $cs_job_emplyr != $current_user->ID) {
                    $cs_access = false;
                }
                if ($cs_access == true) {
                    $cs_emp_dashboard = isset($cs_plugin_options['cs_emp_dashboard']) ? $cs_plugin_options['cs_emp_dashboard'] : '';
                    $qry_str = '';
                    if (isset($_GET['job_id'])) {
                        $qry_str .= '&job_id=' . $_GET['job_id'];
                    }
                    if (isset($_GET['action'])) {
                        $qry_str .= '&action=' . $_GET['action'];
                    }
                    if ($qry_str != '') {
                        if (strpos(get_permalink($cs_emp_dashboard), "?") !== false) {
                            $cs_emp_dash_link = get_permalink($cs_emp_dashboard) . '&profile_tab=editjob' . $qry_str;
                        } else {
                            $cs_emp_dash_link = get_permalink($cs_emp_dashboard) . '?profile_tab=editjob' . $qry_str;
                        }
                    } else {
                        if (strpos(get_permalink($cs_emp_dashboard), "?") !== false) {
                            $cs_emp_dash_link = get_permalink($cs_emp_dashboard) . '&profile_tab=postjobs';
                        } else {
                            $cs_emp_dash_link = get_permalink($cs_emp_dashboard) . '?profile_tab=postjobs';
                        }
                    }
                    ?>
                    <div class="scetion-title">
                        <h3>
                            <?php
                            if (isset($_GET['job_id']) && $_GET['job_id'] != '') {
                                if (isset($cs_job_titl))
                                    echo esc_html__('Edit Job', 'jobhunt') . " -> " . esc_attr($cs_job_titl);
                                else
                                    echo esc_html__('Edit Job', 'jobhunt');
                            } else {

                                echo esc_html__('Post a new job', 'jobhunt');
                            }
                            ?>
                        </h3>
                    </div>
                    <div class="dashboard-content-holder">          
                        <div class="cs-post-job<?php
                        if (!is_user_logged_in()) {
                            echo ' cs-prevent';
                        }
                        if ($cs_free_jobs_switch == 'on') {
                            echo ' cs-post-free-job';
                        }
                        ?>">
                            <?php if (isset($cs_job_msg) && $cs_job_msg != '') { ?>
                                <div class="alert alert-success alt-msg">
                                    <?php echo esc_attr($cs_job_msg) ?>
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                </div>
                            <?php } ?>
                            <?php
                            if ($cs_elem == true) {
                                $cs_emp_dash_link = get_permalink($cs_pag_id);
                            }
                            $user = cs_get_user_id();
                            $employer_status_msg = '';
                            $user_status = get_user_meta($user, 'cs_user_status', true);
                            if ($user_status == 'inactive') {
                                $employer_status_msg = esc_html__("You can't post a new job because your account is not activated yet.", 'jobhunt');
                            }
                            ?>
                            <form action="<?php echo esc_url_raw($cs_emp_dash_link) ?>" method="post" id="cs-emp-form" employer-status="<?php echo esc_html($employer_status_msg); ?>" data-ajaxurl="<?php echo esc_url(admin_url('admin-ajax.php')) ?>" enctype="multipart/form-data">
                                <?php
                                if ($cs_free_jobs_switch != 'on') {
                                    ?>
                                    <ul class="post-step tabs-nav">
                                        <li class="<?php echo sanitize_html_class($cs_act_class) ?>">
                                            <h6><a href="cs-tab1" id="cs-detail-tab"><i class="icon-briefcase4"></i><?php esc_html_e('Job Detail', 'jobhunt'); ?></a></h6>
                                        </li>
                                        <li id="cs_pakg_step">
                                            <h6><a href="cs-tab2" class="cs-check-tabs"><i class="icon-creditcard"></i><?php esc_html_e('Package & Payments', 'jobhunt'); ?></a></h6>
                                        </li>
                                        <li class="<?php echo sanitize_html_class($cs_conf_act_class) ?>">
                                            <h6><a href="cs-tab3" class="cs-check-tabs <?php echo sanitize_html_class($cs_conf_class) ?>"><i class="icon-checkmark6"></i><?php esc_html_e('Confirmation', 'jobhunt'); ?></a></h6>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                ?>
                                <div class="tabs-content">
                                    <?php
                                    if ($cs_free_jobs_switch != 'on') {
                                        ?>
                                        <div class="tabs" id="cs-tab1">
                                            <?php
                                        }
                                        ?>
                                        <div class="input-info">
                                            <div class="row">
                                                <?php
                                                if (!is_user_logged_in()) {
                                                    ?>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div role="alert" class="alert alert-dismissible user-message"> 
                                                            <span>
                                                                <button aria-label="<?php esc_html_e('Close', 'jobhunt') ?>" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                                                <?php echo esc_html__('If you don’t have an account you can create one below by entering your email address. A password will be automatically emailed to you. or', 'jobhunt') . ' <a onclick="trigger_func(\'#btn-header-main-login\');">' . esc_html__('Login', 'jobhunt') . '</a>'; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <small class="cs-chk-msg" id="cs-email-chk"></small>
                                                    <?php
                                                }
                                                ?>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <label><?php esc_html_e('Job Title', 'jobhunt'); ?></label>
                                                    <?php
                                                    $cs_opt_array = array(
                                                        'id' => 'job_title',
                                                        'std' => isset($cs_job_titl) ? $cs_job_titl : '',
                                                        'desc' => '',
                                                        'classes' => 'form-control',
                                                        'extra_atr' => ' placeholder="' . esc_html__('Job Title', 'jobhunt') . '"',
                                                        'required' => 'yes',
                                                        'hint_text' => '',
                                                    );
                                                    $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                    if (isset($_GET['job_id']) && $_GET['job_id'] != '') {      // when a job edit then set old job title 
                                                        $cs_opt_array = array(
                                                            'id' => 'old_job_title',
                                                            'std' => isset($cs_job_titl) ? $cs_job_titl : '',
                                                            'return' => true,
                                                            'prefix' => '',
                                                        );
                                                        echo force_balance_tags($cs_form_fields2->cs_form_hidden_render($cs_opt_array));
                                                    }
                                                    ?>
                                                </div>
                                                <?php apply_filters('employer_job_gallery', $cs_job_id); ?>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <label><?php esc_html_e('Job Description', 'jobhunt'); ?></label>
                                                    <?php
                                                    $cs_job_desc = (isset($cs_job_desc)) ? ($cs_job_desc) : '';
                                                    echo $cs_form_fields2->cs_form_textarea_render(
                                                            array('name' => esc_html__('Award Description', 'jobhunt'),
                                                                'id' => 'cs_job_desc',
                                                                'cust_name' => 'cs_job_desc',
                                                                'classes' => 'col-md-12',
                                                                'std' => $cs_job_desc,
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
                                                <?php do_action('jobhunt_job_attachment_front', $cs_job_id); ?>
                                                <?php do_action('jobhunt_tony_job_level_fields_frontend', $cs_job_id); ?>      
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <label><?php esc_html_e('Email Address (you will receive CVs on this email)', 'jobhunt'); ?> </label>
                                                    <?php
                                                    if (!is_user_logged_in()) {
                                                        $cs_opt_array = array(
                                                            'id' => 'emp_email',
                                                            'std' => '',
                                                            'desc' => '',
                                                            'classes' => 'form-control',
                                                            'required' => 'yes',
                                                            'type' => 'email',
                                                            'extra_atr' => 'onblur="cs_user_avail(\'email\')" placeholder="Email Address (you will receive CVs on this email)"',
                                                            'hint_text' => '',
                                                        );
                                                        $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                        ?>
                                                        <span class="cs-email-validation" id="cs_user_email_validation"></span>
                                                        <?php
                                                    } else {
                                                        $cs_opt_array = array(
                                                            'id' => 'emp_email',
                                                            'std' => $current_user->user_email,
                                                            'desc' => '',
                                                            'classes' => 'form-control',
                                                            'extra_atr' => 'readonly',
                                                            'hint_text' => '',
                                                        );
                                                        $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                    }
                                                    ?>
                                                </div>
                                                <!--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <label><?php esc_html_e('Username', 'jobhunt'); ?></label>
                                                    <?php
                                                    if (!is_user_logged_in()) {
                                                        $cs_opt_array = array(
                                                            'id' => 'user',
                                                            'std' => '',
                                                            'desc' => '',
                                                            'classes' => 'form-control',
                                                            'required' => 'no',
                                                            'type' => 'email',
                                                            'extra_atr' => 'onblur="cs_user_avail(\'username\')" placeholder="' . esc_html__('Username', 'jobhunt') . '"',
                                                            'hint_text' => '',
                                                        );
                                                        $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                        ?>
                                                        <span class="cs-email-validation" id="cs_user_name_validation"></span>
                                                        <?php
                                                    } else {
                                                        $cs_opt_array = array(
                                                            'id' => 'user',
                                                            'std' => $current_user->user_nicename,
                                                            'desc' => '',
                                                            'classes' => 'form-control',
                                                            'extra_atr' => 'readonly',
                                                            'hint_text' => '',
                                                        );
                                                        $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                    }
                                                    ?>
                                                </div>-->
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <label><?php esc_html_e('Job Type', 'jobhunt'); ?></label>
                                                    <div class="select-holder">
                                                        <?php
                                                        if (!isset($cs_post_id))
                                                            $cs_post_id = '';
                                                        cs_get_job_type_dropdown('cs_job_types', 'cs_job_types', $cs_job_id, 'chosen-select form-control', true)
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <label><?php esc_html_e('specialisms', 'jobhunt'); ?></label>
                                                    <div class="select-holder">
                                                        <?php
                                                        if (!isset($cs_post_id)) {

                                                            $cs_post_id = '';
                                                        }
                                                        cs_get_job_specialisms_dropdown('cs_job_specialisms', 'cs_job_specialisms', $cs_job_id, 'chosen-select form-control', true)
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                                if (class_exists('cs_employer_functions')) {
                                                    if ($cs_job_id <> '' && is_user_logged_in() && $cs_job_emplyr == $current_user->ID) {
                                                        echo force_balance_tags($cs_emp_funs->cs_custom_fields($cs_job_id), true);
                                                    } else {
                                                        echo force_balance_tags($cs_emp_funs->cs_custom_fields(), true);
                                                    }
                                                }
                                                if ($cs_status_changing == true) {                                                   
                                                }
                                                do_action('jobhunt_vaavio_job_fields_frontend', $cs_job_id);
                                                do_action('jobhunt_novo_job_fields_frontend', $cs_job_id);
                                                apply_filters('job_hunt_refresh_job_field_frontend', $cs_job_id);
                                                apply_filters('job_hunt_application_deadline_field_frontend', $cs_job_id);
                                                $cs_job_apply_method = isset($cs_plugin_options['cs_job_apply_method']) ? $cs_plugin_options['cs_job_apply_method'] : '';
                                                if (isset($cs_job_apply_method) && $cs_job_apply_method == 'apply_external_link') {
                                                    ?>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <label><?php esc_html_e('External Url', 'jobhunt'); ?></label>
                                                        <?php
                                                        $cs_opt_array = array(
                                                            //'cust_name' => 'external_url_id',
                                                            'id' => 'external_url_id',
                                                            'std' => isset($cs_external_link) ? $cs_external_link : '',
                                                            'desc' => '',
                                                            'classes' => 'form-control',
                                                            'extra_atr' => ' placeholder="' . esc_html__('External link For Job Apply(with htpps:// or http://)', 'jobhunt') . '"',
                                                            'required' => 'yes',
                                                            'hint_text' => '',
                                                        );
                                                        $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                                cs_get_google_autocomplete_fields('job_post', $cs_job_id);
                                                CS_FUNCTIONS()->cs_frontend_location_fields($cs_job_id, 'job_post');
                                                ?>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <?php
                                                    if ($cs_free_jobs_switch == 'on') {
                                                        ?>
                                                        <div class="contact-box">
                                                            <?php
                                                            if (is_user_logged_in() && $cs_job_emplyr == $current_user->ID && $cs_job_id <> '') {
                                                                $cs_opt_array = array(
                                                                    'std' => esc_html__('Update', 'jobhunt'),
                                                                    'id' => '',
                                                                    'return' => true,
                                                                    'classes' => 'continue-btn cs-check-tabs',
                                                                    'cust_type' => 'submit',
                                                                    'cust_name' => 'cs_update_job',
                                                                    'prefix' => '',
                                                                );
                                                                echo force_balance_tags($cs_form_fields2->cs_form_text_render($cs_opt_array));
                                                                $cs_opt_array = array(
                                                                    'std' => '1',
                                                                    'id' => '',
                                                                    'return' => false,
                                                                    'cust_name' => 'cs_pkg_trans',
                                                                );
                                                                $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                                                                $cs_opt_array = array(
                                                                    'std' => esc_html__('Update', 'jobhunt'),
                                                                    'id' => '',
                                                                    'return' => false,
                                                                    'cust_name' => 'cs_update_job',
                                                                );
                                                                $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                                                            } else {

                                                                $cs_opt_array = array(
                                                                    'std' => esc_html__('Post Job', 'jobhunt'),
                                                                    'id' => '',
                                                                    'return' => true,
                                                                    'classes' => 'continue-btn cs-check-tabs',
                                                                    'cust_type' => 'submit',
                                                                    'cust_name' => 'cs_create_job',
                                                                    'prefix' => '',
                                                                );
                                                                echo force_balance_tags($cs_form_fields2->cs_form_text_render($cs_opt_array));
                                                                $cs_opt_array = array(
                                                                    'std' => '1',
                                                                    'id' => '',
                                                                    'return' => false,
                                                                    'cust_name' => 'cs_pkg_trans',
                                                                );
                                                                $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    if ($cs_free_jobs_switch != 'on') {
                                                        ?>
                                                        <div class="account-info-btn btn-holder">
                                                            <ul class="tabs-nav">
                                                                <li><a href="cs-tab2" class="acc-submit cs-section-update cs-color csborder-color cs-check-tabs"><?php esc_html_e('Next', 'jobhunt'); ?></a></li>
                                                            </ul>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if ($cs_free_jobs_switch != 'on') {
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    if ($cs_free_jobs_switch != 'on') {
                                        ?>
                                        <div class="tabs" id="cs-tab2">
                                            <div class="cs-packege-payment">
                                                <div class="row">
                                                    <?php
                                                    $cs_summry_init = 0;
                                                    $cs_summry_pkg = '';
                                                    if (is_array($cs_packages_options) && sizeof($cs_packages_options) > 0) {
                                                        $cs_pkg_contr = 0;
                                                        foreach ($cs_packages_options as $pckg_key => $pckg) {
                                                            if (isset($pckg_key) && $pckg_key <> '') {
                                                                $pckg_id = isset($pckg['package_id']) ? $pckg['package_id'] : '';
                                                                $pckg_price = isset($pckg['package_price']) ? $pckg['package_price'] : '';
                                                                $cs_pckg_price = $pckg_price;
                                                                if (is_user_logged_in() && $cs_emp_funs->cs_is_pkg_subscribed($pckg_id)) {
                                                                    $cs_pckg_price = 0;
                                                                }
                                                                if (is_user_logged_in() && $cs_job_emplyr == $current_user->ID && $cs_job_id <> '' && $cs_emp_funs->cs_update_pkg_subs('', $job_pckge_id)) {
                                                                    $cs_summry_pkg = $cs_emp_funs->cs_update_pkg_subs(true, $job_pckge_id);
                                                                    $cs_summry_pkg = isset($cs_summry_pkg['pkg_id']) ? $cs_summry_pkg['pkg_id'] : '';
                                                                    $cs_summry_init = 0;
                                                                } else if (is_user_logged_in() && $cs_job_emplyr == $current_user->ID && $cs_job_id <> '' && $cs_job_expiry >= $cs_current_date && $cs_job_pkg != '') {
                                                                    $cs_summry_pkg = $cs_job_pkg;
                                                                    $cs_summry_init = 0;
                                                                } else if (is_user_logged_in() && $cs_job_emplyr == $current_user->ID && $cs_job_id <> '' && $cs_job_pkg != '' && $cs_emp_funs->get_pkg_field($cs_job_pkg, 'package_price') <= 0) {
                                                                    $cs_summry_pkg = $cs_job_pkg;
                                                                    $cs_summry_init = 0;
                                                                } else {
                                                                    if ($cs_pkg_contr == 0) {
                                                                        $cs_summry_pkg = $pckg_id;
                                                                        $cs_summry_init = $cs_pckg_price;
                                                                    }
                                                                }
                                                            }
                                                            $cs_pkg_contr ++;
                                                        }
                                                    }
                                                    ?>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <div class="cs-order-summery">
                                                            <h3><?php esc_html_e('Order summery', 'jobhunt') ?></h3>
                                                            <ul class="cs-sumry-clacs" data-subs="<?php esc_html_e('Subscription', 'jobhunt') ?>" data-feat="<?php esc_html_e('Feature Price', 'jobhunt') ?>" data-total="<?php esc_html_e('Total', 'jobhunt') ?>" data-vat="<?php printf(esc_html__('VAT (%s&#37;)', 'jobhunt'), $cs_pay_vat) ?>" data-gtotal="<?php esc_html_e('Grand Total', 'jobhunt') ?>" data-currency="<?php echo esc_attr($currency_sign) ?>">
                                                                <?php
                                                                if ($cs_summry_pkg != '') {
                                                                    ?>
                                                                    <li><span><?php echo esc_attr($cs_emp_funs->get_pkg_field($cs_summry_pkg)) . ' ' . esc_html__('Subscription', 'jobhunt') ?></span><em><?php echo jobcareer_get_currency($cs_summry_init, true); ?></em></li>
                                                                    <li><span><?php esc_html_e('Total', 'jobhunt') ?></span><em><?php echo jobcareer_get_currency($cs_summry_init, true); ?></em></li>
                                                                    <?php
                                                                    if ($cs_vat_switch == 'on' && $cs_summry_init > 0) {
                                                                        if ($cs_pay_vat > 0) {
                                                                            $cs_s_vat_amount = $cs_summry_init * ( $cs_pay_vat / 100 );
                                                                            $cs_summry_init = CS_FUNCTIONS()->cs_num_format($cs_s_vat_amount) + $cs_summry_init;
                                                                            ?>
                                                                            <li><span><?php printf(esc_html__('VAT (%s&#37;)', 'jobhunt'), $cs_pay_vat) ?></span><em><?php echo jobcareer_get_currency($cs_s_vat_amount, true) ?></em></li>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                <li><span><?php esc_html_e('Grand Total', 'jobhunt') ?></span><em><?php echo jobcareer_get_currency($cs_summry_init, true) ?></em></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                        <div class="cs-package-detail"<?php if ($cs_vat_switch == 'on') { ?> data-vatp="<?php echo CS_FUNCTIONS()->cs_num_format($cs_pay_vat) ?>" data-vat=""<?php } ?>>
                                                            <?php
                                                            if (is_user_logged_in() && $cs_job_emplyr == $current_user->ID && $cs_job_id <> '' && $cs_emp_funs->cs_update_pkg_subs('', $job_pckge_id) && $cs_job_expiry >= $cs_current_date) {
                                                                $cs_subscribed_pkg = $cs_emp_funs->cs_update_pkg_subs(true, $job_pckge_id);
                                                                if (isset($cs_subscribed_pkg['pkg_id']) && $cs_subscribed_pkg['pkg_id'] == $job_pckge_id) {
                                                                    echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->cs_user_pkg_detail($cs_subscribed_pkg));
                                                                } else if ($job_pckge_id <> '' && $cs_emp_funs->cs_is_pkg_subscribed($job_pckge_id)) {
                                                                    echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->cs_user_pkg_detail($job_pckge_id));
                                                                } else {
                                                                    if ($job_pckge_id <> '' && $cs_emp_funs->get_pkg_field($job_pckge_id) != '' && $cs_emp_funs->get_pkg_field($job_pckge_id, 'package_price') <= 0) {
                                                                        printf(esc_html__('You are using "%s" Package.', 'jobhunt'), $cs_emp_funs->get_pkg_field($job_pckge_id));
                                                                    }
                                                                }
                                                                $cs_opt_array = array(
                                                                    'std' => $job_pckge_id,
                                                                    'id' => '',
                                                                    'echo' => true,
                                                                    'cust_name' => 'job_pckge',
                                                                );
                                                                $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                                                            } else if (is_user_logged_in() && $cs_job_emplyr == $current_user->ID && $cs_job_id <> '' && $cs_job_expiry >= $cs_current_date && $cs_job_pkg != '') {
                                                                echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->cs_user_pkg_detail($cs_job_pkg, $cs_job_expiry));
                                                                $cs_opt_array = array(
                                                                    'std' => $job_pckge_id,
                                                                    'id' => '',
                                                                    'echo' => true,
                                                                    'cust_name' => 'job_pckge',
                                                                );
                                                                $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                                                            } else {
                                                                if (is_array($cs_packages_options) && sizeof($cs_packages_options) > 0) {
                                                                    ?>
                                                                    <div id="accordion2" class="accordion">
                                                                        <?php
                                                                        $cs_pkg_counter = 0;
                                                                        $active_package_id = 0;
                                                                        foreach ($cs_packages_options as $package_key => $package) {

                                                                            if (isset($package_key) && $package_key <> '') {

                                                                                $package_id = isset($package['package_id']) ? $package['package_id'] : '';

                                                                                $package_title = isset($package['package_title']) ? $package['package_title'] : '';

                                                                                $package_price = isset($package['package_price']) ? $package['package_price'] : '';

                                                                                $package_listings = isset($package['package_listings']) ? $package['package_listings'] : '';

                                                                                $package_submission_limit = isset($package['package_submission_limit']) ? $package['package_submission_limit'] : '';

                                                                                $cs_list_dur = isset($package['cs_list_dur']) ? $package['cs_list_dur'] : '';

                                                                                $package_duration = isset($package['package_duration']) ? $package['package_duration'] : '';

                                                                                $package_duration_period = isset($package['package_duration_period']) ? $package['package_duration_period'] : '';

                                                                                $package_description = isset($package['package_description']) ? $package['package_description'] : '';

                                                                                $cs_package_type = isset($package['package_type']) ? $package['package_type'] : '';

                                                                                $cs_package_type_text = $cs_package_type == "single" ? esc_html__('Single Submission', 'jobhunt') : esc_html__('Subscription', 'jobhunt');

                                                                                $cs_pkg_chkd = '';

                                                                                if ($cs_pkg_counter == 0) {

                                                                                    $cs_pkg_chkd = ' checked="checked"';
                                                                                }

                                                                                $cs_pckg_price = $package_price;

                                                                                if (is_user_logged_in() && $cs_emp_funs->cs_is_pkg_subscribed($package_id)) {
                                                                                    $cs_pckg_price = 0;
                                                                                    $active_package_id = $package_id;
                                                                                }
                                                                                ?>
                                                                                <div class="accordion-group">
                                                                                    <div class="accordion-heading">
                                                                                        <?php
                                                                                        $cs_opt_array = array(
                                                                                            'std' => $package_id,
                                                                                            'id' => '',
                                                                                            'return' => true,
                                                                                            'cust_type' => 'radio',
                                                                                            'extra_atr' => 'data-price="' . CS_FUNCTIONS()->cs_num_format($cs_pckg_price) . '" data-title="' . $package_title . '"  ' . CS_FUNCTIONS()->cs_special_chars($cs_pkg_chkd) . '',
                                                                                            'cust_id' => 'job_pckge_' . $package_id,
                                                                                            'cust_name' => 'job_pckge',
                                                                                            'prefix' => '',
                                                                                        );
                                                                                        echo force_balance_tags($cs_form_fields2->cs_form_text_render($cs_opt_array));
                                                                                        if ($cs_emp_funs->cs_is_pkg_subscribed($package_id)) {
                                                                                            ?>
                                                                                            <label for="<?php echo esc_attr('job_pckge_' . $package_id); ?>"><span><span></span></span><?php echo esc_attr($package_title) ?> <em> <?php esc_html_e('(Already Purchased)', 'jobhunt') ?> <a href="#acc-<?php echo absint($package_id) ?>" data-parent="#accordion2" data-toggle="collapse" class=""><?php esc_html_e('Detail', 'jobhunt') ?></a> </em></label>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?><label for="<?php echo esc_attr('job_pckge_' . $package_id); ?>"><span><span></span></span><?php echo esc_attr($package_title) ?> <em><?php echo jobcareer_get_currency($package_price, true); ?></em></label><?php
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="accordion-body collapse" id="acc-<?php echo absint($package_id) ?>">
                                                                                        <div class="accordion-inner">
                                                                                            <ul>
                                                                                                <li> <span><?php esc_html_e('Package Type', 'jobhunt'); ?></span> <strong><?php echo CS_FUNCTIONS()->cs_special_chars($cs_package_type_text); ?></strong> </li>
                                                                                                <li> <span><?php esc_html_e('Duration', 'jobhunt'); ?></span> <strong><?php printf(esc_html__('%s %s', 'jobhunt'), $package_duration, $package_duration_period) ?></strong> </li>
                                                                                                <li> <span><?php esc_html_e('Listing Duration', 'jobhunt'); ?></span> <strong><?php printf(esc_html__('%s %s', 'jobhunt'), $package_submission_limit, $cs_list_dur) ?></strong> </li>
                                                                                                <?php if ($cs_package_type == 'subscription') { ?>
                                                                                                    <li> <span><?php esc_html_e('No. of Listings', 'jobhunt'); ?></span> <strong><?php printf(esc_html__('%s Listings included.', 'jobhunt'), $package_listings); ?></strong></li>
                                                                                                <?php } ?>
                                                                                            </ul>
                                                                                            <?php
                                                                                            if (is_user_logged_in()) {
                                                                                                echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->cs_subscribed_pkg_summary($package_id));
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            $cs_pkg_counter ++;
                                                                        }
                                                                        ?>
                                                                        <?php if ($active_package_id > 0) { ?>
                                                                            <script type="text/javascript">
                                                                                jQuery(document).ready(function () {
                                                                                    jQuery('.cs-package-detail .accordion-heading #job_pckge_<?php echo $active_package_id; ?>').trigger("click");
                                                                                    cs_job_pricing();
                                                                                });
                                                                            </script>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            if ($cs_feature_amount <> '') {
                                                                if (is_user_logged_in() && $cs_job_emplyr == $current_user->ID && $get_job_feat == 'yes' || $get_job_feat == 'on') {
                                                                    $cspaid_class = ' class="cs-paid" checked="checked"';
                                                                } else {
                                                                    $cspaid_class = '';
                                                                }
                                                                ?>
                                                                <div class="job-featured">
                                                                    <div class="cs-text">
                                                                        <input type="checkbox" id="cs_job_featured" data-price="<?php echo CS_FUNCTIONS()->cs_num_format($cs_feature_amount) ?>" name="cs_job_featured"<?php
                                                                        if (is_user_logged_in() && $cs_job_emplyr == $current_user->ID && $get_job_feat == 'yes') {
                                                                            echo ' class="cs-paid" checked="checked"';
                                                                        }
                                                                        ?>>
                                                                        <label for="cs_job_featured"><span></span><?php esc_html_e('Make this job Featured', 'jobhunt') ?></label>
                                                                        <?php
                                                                        $cs_job_feat_txt = isset($cs_plugin_options['cs_job_feat_txt']) ? $cs_plugin_options['cs_job_feat_txt'] : '';
                                                                        if ($cs_job_feat_txt <> '') {
                                                                            ?>
                                                                            <p><?php echo CS_FUNCTIONS()->cs_special_chars($cs_job_feat_txt) ?></p>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <span><?php esc_html_e('Price', 'jobhunt') ?>: <em><?php echo jobcareer_get_currency($cs_feature_amount, true); ?></em></span>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <div class="contact-box cs-add-up-box" style="display:<?php echo ( $cs_summry_init > 0 ) ? 'none' : 'block' ?>;">
                                                                <?php
                                                                if (is_user_logged_in() && $cs_job_emplyr == $current_user->ID && $cs_job_id <> '') {
                                                                    $cs_opt_array = array(
                                                                        'std' => esc_html__('Update', 'jobhunt'),
                                                                        'id' => '',
                                                                        'return' => true,
                                                                        'classes' => 'continue-btn',
                                                                        'cust_type' => 'submit',
                                                                        'cust_name' => 'cs_update_job',
                                                                        'prefix' => '',
                                                                    );
                                                                    echo force_balance_tags($cs_form_fields2->cs_form_text_render($cs_opt_array));
                                                                } else {
                                                                    $cs_opt_array = array(
                                                                        'std' => esc_html__('Post Job', 'jobhunt'),
                                                                        'id' => '',
                                                                        'return' => true,
                                                                        'classes' => 'continue-btn',
                                                                        'cust_type' => 'submit',
                                                                        'cust_name' => 'cs_create_job',
                                                                        'prefix' => '',
                                                                    );
                                                                    echo force_balance_tags($cs_form_fields2->cs_form_text_render($cs_opt_array));
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="contact-box cs-pay-box" style="display:<?php echo ( $cs_summry_init > 0 ) ? 'block' : 'none' ?>;">
                                                                <ul class="select-card cs-all-gates">
                                                                    <?php
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
                                                                        echo force_balance_tags($cs_form_fields2->cs_form_text_render($cs_opt_array));
                                                                        $cs_gw_counter ++;
                                                                    } else {
                                                                        if (is_array($gateways)) {
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
                                                                                        ?>
                                                                                        <li<?php echo CS_FUNCTIONS()->cs_special_chars($cs_active) ?>>
                                                                                            <a><img alt="" src="<?php echo esc_url($logo) ?>"></a>
                                                                                            <?php
                                                                                            $cs_opt_array = array(
                                                                                                'std' => $key,
                                                                                                'id' => '',
                                                                                                'return' => true,
                                                                                                'cust_type' => 'radio',
                                                                                                'extra_atr' => 'style="display:none; position:absolute;" ' . CS_FUNCTIONS()->cs_special_chars($cs_checked),
                                                                                                'cust_name' => 'cs_payment_gateway',
                                                                                                'prefix' => '',
                                                                                            );
                                                                                            echo force_balance_tags($cs_form_fields2->cs_form_text_render($cs_opt_array));
                                                                                            ?>
                                                                                        </li>
                                                                                        <?php
                                                                                    }
                                                                                    $cs_gw_counter ++;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>

                                                                <?php
                                                                $cs_job_pay_txt = isset($cs_plugin_options['cs_job_pay_txt']) ? $cs_plugin_options['cs_job_pay_txt'] : '';

                                                                if ($cs_job_pay_txt <> '') {
                                                                    ?>

                                                                    <p><?php echo CS_FUNCTIONS()->cs_special_chars($cs_job_pay_txt) ?></p>

                                                                    <?php
                                                                }
                                                                $cs_pay_btn = 'cs_pay_btn';
                                                                if (is_user_logged_in() && $cs_job_emplyr == $current_user->ID && $cs_job_id <> '') {
                                                                    $cs_pay_btn = 'cs_update_job';
                                                                }
                                                                $cs_opt_array = array(
                                                                    'std' => 'Continue to Pay',
                                                                    'id' => '',
                                                                    'return' => true,
                                                                    'cust_type' => 'submit',
                                                                    'classes' => 'continue-btn acc-submit cs-section-update cs-color csborder-color',
                                                                    'cust_name' => $cs_pay_btn,
                                                                );
                                                                echo $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                                $cs_opt_array = array(
                                                                    'std' => '1',
                                                                    'id' => '',
                                                                    'return' => true,
                                                                    'cust_name' => 'cs_pkg_trans',
                                                                );
                                                                echo $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tabs" id="cs-tab3">
                                            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 cs-confirmation">
                                                <?php
                                                if (( isset($_POST['cs_pkg_trans']) && $_POST['cs_pkg_trans'] == 1 && isset($cs_total_amount) && $cs_total_amount > 0 ) || isset($_POST['invoice'])) {
                                                    ?>
                                                    <span class="mail"><i class="icon-mail"></i></span>
                                                    <?php
                                                    $cs_job_welcome_title = isset($cs_plugin_options['cs_job_welcome_title']) ? $cs_plugin_options['cs_job_welcome_title'] : '';
                                                    if ($cs_job_welcome_title <> '') {
                                                        ?>
                                                        <h3><?php echo CS_FUNCTIONS()->cs_special_chars($cs_job_welcome_title) ?></h3>

                                                        <?php
                                                    }
                                                    $cs_job_welcome_con = isset($cs_plugin_options['cs_job_welcome_con']) ? $cs_plugin_options['cs_job_welcome_con'] : '';
                                                    if ($cs_job_welcome_con <> '') {
                                                        ?>
                                                        <p><?php echo CS_FUNCTIONS()->cs_special_chars($cs_job_welcome_con) ?></p>

                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="packege-detial">
                                                        <?php
                                                        $post_pkg = isset($_POST['job_pckge']) ? $_POST['job_pckge'] : '';
                                                        if (isset($_POST['invoice']) && $_POST['invoice'] != '') {
                                                            $pkg_type = get_post_meta($_POST['invoice'], 'cs_transaction_type', true);
                                                            if ($pkg_type == 'cv_trans') {
                                                                $post_pkg = get_post_meta($_POST['invoice'], 'cs_transaction_cv_pkg', true);
                                                            } else {
                                                                $post_pkg = get_post_meta($_POST['invoice'], 'cs_transaction_package', true);
                                                            }
                                                        }
                                                        if ($post_pkg != '') {
                                                            if (isset($pkg_type) && $pkg_type == 'cv_trans') {
                                                                ?>
                                                                <h4><i class="icon-check-circle"></i><?php echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->get_cv_pkg_field($post_pkg)) . esc_html__(' Package Subscription', 'jobhunt') ?></h4>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <h4><i class="icon-check-circle"></i><?php echo CS_FUNCTIONS()->cs_special_chars($cs_emp_funs->get_pkg_field($post_pkg)) . esc_html__(' Package Subscription', 'jobhunt') ?></h4>
                                                                <?php
                                                            }
                                                        }
                                                        if (isset($cs_smry_totl) && isset($cs_pay_vat)) {
                                                            if (isset($cs_vat_amount)) {
                                                                $cs_grand_totl = $cs_smry_totl + $cs_vat_amount;
                                                            } else {
                                                                $cs_grand_totl = $cs_smry_totl + 0;
                                                            }
                                                            ?>
                                                            <ul>
                                                                <li><?php esc_html_e('Total Charges', 'jobhunt') ?><span><?php echo jobcareer_get_currency($cs_smry_totl, true) ?></span></li>
                                                                <li><?php printf(esc_html__('VAT (%s&#37;)', 'jobhunt'), $cs_pay_vat) ?><span><?php
                                                                        if (!isset($cs_vat_amount))
                                                                            $cs_vat_amount = 0;
                                                                        echo jobcareer_get_currency($cs_vat_amount, true);
                                                                        ?></span></li>
                                                                <li><?php esc_html_e('Grand Total', 'jobhunt') ?><span><?php
                                                                        if (!isset($cs_grand_totl))
                                                                            $cs_grand_totl = 0;
                                                                        echo jobcareer_get_currency($cs_grand_totl, true);
                                                                        ?></span></li>
                                                            </ul>
                                                            <?php
                                                        } else if (isset($_POST['invoice']) && $_POST['invoice'] != '') {
                                                            $trans_amount = get_post_meta($_POST['invoice'], 'cs_transaction_amount', true);
                                                            if ($trans_amount != '' && $trans_amount > 0) {
                                                                ?>
                                                                <ul>
                                                                    <li><?php esc_html_e('Total Charges', 'jobhunt') ?><span><?php echo jobcareer_get_currency($trans_amount, true); ?></span></li>
                                                                </ul>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                    if (isset($cs_trans_html)) {
                                                        echo CS_FUNCTIONS()->cs_special_chars($cs_trans_html);
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if (isset($_POST['cs_posting']) && $_POST['cs_posting'] == 'new') {
                                    $cs_opt_array = array(
                                        'std' => 'new',
                                        'id' => '',
                                        'return' => true,
                                        'cust_name' => 'cs_posting',
                                        'prefix' => '',
                                    );
                                    echo force_balance_tags($cs_form_fields2->cs_form_hidden_render($cs_opt_array));
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="unauthorized">
                                <h1><?php _e('You are not <span>authorized</span>', 'jobhunt') ?></h1>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <script>
                    /*chosen for mobile*/
                    if (jQuery('.chosen-container').length > 0) {
                        jQuery('.chosen-container').on('touchstart', function (e) {
                            e.stopPropagation();
                            e.preventDefault();
                            // Trigger the mousedown event.
                            jQuery(this).trigger('mousedown');
                        });
                    }
                    jQuery(document).ready(function ($) {
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


                    });
                    /*
                     * modern selection box function
                     */
                </script>

                <?php
                if ($uid != '') {
                    die();
                }
            }

            /**
             * Start Function how to find for job action
             */
            public function cs_job_action($uid) {

                global $cs_plugin_options, $current_user, $cs_form_fields2;

                $cs_job_id = isset($_GET['job_id']) ? $_GET['job_id'] : '';
                $job_title = '';
                if (isset($cs_job_id) && $cs_job_id != '') {
                    $job_detail = get_job_detail($cs_job_id);
                    $job_title = $job_detail->post_title;
                }
                $applicant_title = '';
                if ($job_title != '') {
                    $applicant_title = $job_title . " " . esc_html__('Applicants', 'jobhunt');
                } else {
                    $applicant_title = esc_html__('Applicants', 'jobhunt');
                }
                $cs_job_act = isset($_GET['action']) ? $_GET['action'] : '';
                $cs_emp_funs = new cs_employer_functions();
                if ($cs_job_act == 'applicants') {
                    $cs_fav_resumes = array();
                    $cs_fav_resumes = count_usermeta('cs-user-jobs-applied-list', serialize(strval($cs_job_id)), 'LIKE', true);
                    $cs_fav_resumes = apply_filters('jobhunt_job_applications_list', $cs_fav_resumes, $cs_job_id);
                    ?>
                    <div class="cs-resumes">
                        <div class="scetion-title">
                            <h4><?php echo esc_html($applicant_title); ?></h4>
                        </div>
                        <?php
                        if (is_array($cs_fav_resumes) && sizeof($cs_fav_resumes) > 0 && !empty($cs_fav_resumes)) {
                            ?>
                            <ul class="resumes-list">
                                <?php
                                $cs_candidate_switch = isset($cs_plugin_options['cs_candidate_switch']) ? $cs_plugin_options['cs_candidate_switch'] : '';
                                foreach ($cs_fav_resumes as $key => $cs_fav) {
                                    $candidate_usrid = $cs_fav->ID;
                                    $job_applied_date = cs_find_other_field_user_meta_list($cs_job_id, 'post_id', 'cs-user-jobs-applied-list', 'date_time', $candidate_usrid);
                                    $is_multi_job = apply_filters('jobhunt_is_multi_job_applications_list', false, $cs_fav_resumes);
                                    if ($is_multi_job == true) {
                                        $job_applied_date = $key;
                                    }
                                    $cs_jobs_thumb_url = get_user_meta($cs_fav->ID, "user_img", true);
                                    $cs_jobs_thumb_url = cs_get_img_url($cs_jobs_thumb_url, 'cs_media_5');
                                    $cs_ext = pathinfo($cs_jobs_thumb_url, PATHINFO_EXTENSION);
                                    if ($cs_jobs_thumb_url == '' || $cs_ext == '') {
                                        $cs_jobs_thumb_url = esc_url(wp_jobhunt::plugin_url() . 'assets/images/candidate-no-image.jpg');
                                    }
                                    $user_job_id = isset($_REQUEST['job_id']) && !empty($_REQUEST['job_id']) ? $_REQUEST['job_id'] : '';
                                    $cs_job_title = get_user_meta($cs_fav->ID, "cs_job_title", true);
                                    $cs_loc_address = get_user_meta($cs_fav->ID, "cs_post_loc_address", true);
                                    $cs_candidate_cv_check = get_user_meta($cs_fav->ID, 'cs_candidate_cv_' . $user_job_id . ' ', true);
                                    if (isset($cs_candidate_cv_check) && $cs_candidate_cv_check != '') {
                                        $cs_candidate_cv = get_user_meta($cs_fav->ID, 'cs_candidate_cv_' . $user_job_id . ' ', true);
                                    } else {
                                        $cs_candidate_cv = get_user_meta($cs_fav->ID, "cs_candidate_cv", true);
                                    }
                                    $cs_candidate_linkedin = get_user_meta($cs_fav->ID, 'cs_linkedin', true);
                                    $cs_last_activity_date = get_user_meta($cs_fav->ID, 'cs_user_last_activity_date', true);
                                    $cs_candidate_cv = apply_filters('jobhunt_modified_cv', $cs_candidate_cv, $cs_fav); //custom
                                    ?>
                                    <li>
                                        <?php
                                        if ($cs_jobs_thumb_url != '') {
                                            ?>
                                            <img alt="" src="<?php echo esc_url($cs_jobs_thumb_url) ?>">
                                        <?php } ?>
                                        <div class="cs-text">
                                            <?php if ($cs_candidate_switch == 'on') { ?>
                                                <?php if ($cs_emp_funs->is_employer() && $cs_emp_funs->is_cv_pkg_subs()) { ?>
                                                    <h3><a href="<?php echo esc_url(get_author_posts_url($cs_fav->ID)) ?>">
                                                            <?php
                                                            $user_job_applied_status = get_user_meta($cs_fav->ID, 'cs-jobs-status', true);
                                                            if ($user_job_applied_status = true) {
                                                                echo $cs_fav->first_name;
                                                            } else {
                                                                echo $cs_fav->display_name;
                                                            }
                                                            ?>
                                                        </a></h3>
                                                <?php } else { ?>
                                                    <h3>
                                                        <?php
                                                        $user_job_applied_status = get_user_meta($cs_fav->ID, 'cs-jobs-status', true);
                                                        if ($user_job_applied_status = true) {
                                                            echo $cs_fav->first_name;
                                                        } else {
                                                            echo $cs_fav->display_name;
                                                        }
                                                        ?>
                                                    </h3>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <h3>
                                                    <?php
                                                    $user_job_applied_status = get_user_meta($cs_fav->ID, 'cs-jobs-status', true);
                                                    if ($user_job_applied_status = true) {
                                                        echo $cs_fav->first_name;
                                                    } else {
                                                        echo $cs_fav->display_name;
                                                    }
                                                    ?>
                                                </h3>
                                            <?php } ?>
                                            <?php if ($cs_job_title != '') { ?>
                                                <span><?php echo CS_FUNCTIONS()->cs_special_chars($cs_job_title) ?></span> 
                                                <?php
                                            }
                                            if (isset($job_applied_date) && $job_applied_date != '') {
                                                echo '<span>' . esc_html__("Applied Date : ", "jobhunt") . date(' j F, Y', $job_applied_date) . '</span>';
                                            }
                                            if ($cs_loc_address != '') {
                                                ?>
                                                <span class="location"><?php echo CS_FUNCTIONS()->cs_special_chars($cs_loc_address) ?></span>
                                            <?php } ?>
                                            <div class="cs-posted"> 
                                                <span><?php echo esc_html__('Updated', 'jobhunt') . " " . esc_attr($cs_emp_funs->cs_time_elapsed($cs_last_activity_date)); ?></span> 
                                            </div>
                                            <div class="cs-uploaded candidate-detail">

                                                <div class="cs-downlod-sec">
                                                    <a><?php esc_html_e('Actions', 'jobhunt') ?></a>
                                                    <ul>
                                                        <li>
                                                            <?php if ($cs_candidate_switch == 'on') { ?>
                                                                <?php if ($cs_emp_funs->is_employer() && $cs_emp_funs->is_cv_pkg_subs()) { ?>
                                                                    <a onclick="document.getElementById('cover_letter_light<?php echo esc_html($cs_fav->ID); ?>').style.display = 'block';
                                                                            document.getElementById('cover_letter_fade<?php echo esc_html($cs_fav->ID); ?>').style.display = 'block'" href="javascript:void(0)"><?php esc_html_e('Cover Letter', 'jobhunt') ?></a>
                                                                   <?php } else { ?>
                                                                    <a href="javascript:void(0);" onclick="show_alert_msg('<?php esc_html_e('Please subscribe a package first to View Cover Letter ', 'jobhunt') ?>');"><?php esc_html_e('Cover Letter', 'jobhunt') ?></a>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <a onclick="document.getElementById('cover_letter_light<?php echo esc_html($cs_fav->ID); ?>').style.display = 'block';
                                                                        document.getElementById('cover_letter_fade<?php echo esc_html($cs_fav->ID); ?>').style.display = 'block'" href="javascript:void(0)"><?php esc_html_e('Cover Letter', 'jobhunt') ?></a>
                                                                   <?php
                                                               }
                                                               ?>
                                                        </li>
                                                        <?php
                                                        $display_candidate_contact_details = 'yes';
                                                        $display_candidate_contact_details = apply_filters('jobhunt_candidate_contact_details_for_employers', $display_candidate_contact_details);
                                                        $check_pkg = apply_filters('jobhunt_hide_contact_details', $cs_fav->ID);
                                                        if ($check_pkg == '') {
                                                            $check_pkg = 1;
                                                        }
                                                        if ($display_candidate_contact_details == 'yes') {
                                                            ?>
                                                            <?php if ($cs_candidate_switch == 'on') { ?>
                                                                <?php if (isset($cs_candidate_cv) && !is_array($cs_candidate_cv) && esc_url($cs_candidate_cv) != '' && $cs_emp_funs->is_employer() && !$cs_emp_funs->is_cv_pkg_subs()) { ?>
                                                                    <li><a href="javascript:void(0);" onclick="show_alert_msg('<?php esc_html_e('Please subscribe a package first to Download CV', 'jobhunt') ?>');"><?php esc_html_e('Download CV', 'jobhunt') ?></a></li>
                                                                    <?php
                                                                } elseif (isset($cs_candidate_cv) && !is_array($cs_candidate_cv) && esc_url($cs_candidate_cv) != '' && $cs_emp_funs->is_employer() && $cs_emp_funs->is_cv_pkg_subs()) {
                                                                    do_action('jobhunt_download_cv_link', $cs_candidate_cv);
                                                                    ?>
                                                                <?php } else { ?>

                                                                    <li><a href="javascript:void(0);" onclick="show_alert_msg('<?php esc_html_e('There is no downloadable doc', 'jobhunt') ?>');"><?php esc_html_e('Download', 'jobhunt') ?></a></li>

                                                                <?php } ?>
                                                                <?php
                                                            } else {
                                                                if (isset($cs_candidate_cv) && !is_array($cs_candidate_cv) && esc_url($cs_candidate_cv) != '') {
                                                                    do_action('jobhunt_download_cv_link', $cs_candidate_cv);
                                                                    ?>
                                                                <?php } else { ?>

                                                                    <li><a href="javascript:void(0);" onclick="show_alert_msg('<?php esc_html_e('There is no downloadable doc', 'jobhunt') ?>');"><?php esc_html_e('Download', 'jobhunt') ?></a></li>

                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        if ($check_pkg >= 1) {
                                                            if ($cs_candidate_switch == 'on') {
                                                                ?>
                                                                <?php if ($cs_candidate_linkedin != '' && $cs_emp_funs->is_employer() && $cs_emp_funs->is_cv_pkg_subs()) { ?>

                                                                    <li><a target="_blank" href="<?php echo esc_url($cs_candidate_linkedin) ?>"><?php esc_html_e('Linked-in Profile', 'jobhunt') ?></a></li>

                                                                <?php } elseif ($cs_candidate_linkedin != '') { ?>
                                                                    <li><a href="javascript:void(0);" onclick="show_alert_msg('<?php esc_html_e('Please subscribe a package first to Linked-in Profile', 'jobhunt') ?>');"><?php esc_html_e('Linked-in Profile', 'jobhunt') ?></a></li>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <?php if ($cs_candidate_linkedin != '') { ?>

                                                                    <li><a target="_blank" href="<?php echo esc_url($cs_candidate_linkedin) ?>"><?php esc_html_e('Linked-in Profile', 'jobhunt') ?></a></li>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <?php if ($cs_candidate_switch == 'on') { ?>
                                                                <?php if ($cs_emp_funs->is_employer() && $cs_emp_funs->is_cv_pkg_subs()) { ?>
                                                                    <li><a data-toggle="modal" data-target="#cs-msgbox-<?php echo absint($cs_fav->ID) ?>"><?php esc_html_e('Send a Message', 'jobhunt') ?></a></li>    
                                                                <?php } else { ?>
                                                                    <li><a href="javascript:void(0);" onclick="show_alert_msg('<?php esc_html_e('Please subscribe a package first to Send  Message', 'jobhunt') ?>');"><?php esc_html_e('Send a Message', 'jobhunt') ?></a></li>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <li><a data-toggle="modal" data-target="#cs-msgbox-<?php echo absint($cs_fav->ID) ?>"><?php esc_html_e('Send a Message', 'jobhunt') ?></a></li>   			
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <?php if ($cs_candidate_switch == 'on') { ?>
                                                            <?php if ($cs_emp_funs->is_employer() && $cs_emp_funs->is_cv_pkg_subs()) { ?>
                                                                <li><a href="<?php echo esc_url(get_author_posts_url($cs_fav->ID)) ?>"><?php esc_html_e('View Profile', 'jobhunt') ?></a></li>
                                                            <?php } else { ?>
                                                                <li><a href="javascript:void(0);" onclick="show_alert_msg('<?php esc_html_e('Please subscribe a package first to View Profile', 'jobhunt') ?>');"><?php esc_html_e('View Profile', 'jobhunt') ?></a></li>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <li><a href="<?php echo esc_url(get_author_posts_url($cs_fav->ID)) ?>"><?php esc_html_e('View Profile', 'jobhunt') ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <!-- start specialism popup -->
                                                <div id="cover_letter_fade<?php echo esc_html($cs_fav->ID); ?>" class="black_overlay">
                                                    <div id="cover_letter_light<?php echo esc_html($cs_fav->ID); ?>" class="white_content">
                                                        <a href = "javascript:void(0)" onclick = "document.getElementById('cover_letter_light<?php echo esc_html($cs_fav->ID); ?>').style.display = 'none';
                                                                document.getElementById('cover_letter_fade<?php echo esc_html($cs_fav->ID); ?>').style.display = 'none'">Close</a>
                                                        <h5><a><?php echo get_the_title($cs_fav->ID) ?></a><?php
                                                            if (isset($cs_post_loc_city) && $cs_post_loc_city != '') {
                                                                echo " | " . $cs_post_loc_city;
                                                            }
                                                            echo " - " . esc_html__("Cover Letter", "jobhunt");
                                                            ?>
                                                        </h5>
                                                        <?php
                                                        if (isset($cs_fav->ID) && $cs_fav->ID != '') {
                                                            $user_job_id = isset($_REQUEST['job_id']) && !empty($_REQUEST['job_id']) ? $_REQUEST['job_id'] : '';
                                                            $cs_cover_letter = get_user_meta($cs_fav->ID, 'cs_updated_cover_letter_' . $user_job_id . ' ', true);
                                                            $cs_cover_letter = isset($cs_cover_letter) && !empty($cs_cover_letter) ? $cs_cover_letter : '';
                                                            if (empty($cs_cover_letter)) {
                                                                $cs_cover_letter = get_user_meta($cs_fav->ID, 'cover_letter', true);
                                                            }
                                                            if ($cs_cover_letter == '') {
                                                                $cs_cover_letter = get_user_meta($cs_fav->ID, 'cs_cover_letter', true);
                                                            }
                                                            $cs_cover_letter = apply_filters('jobhunt_job_cover_letter', $cs_cover_letter, $cs_fav->ID);
                                                            if (isset($cs_cover_letter) && $cs_cover_letter != '')
                                                                echo force_balance_tags($cs_cover_letter);
                                                            else
                                                                esc_html_e("Not set by user", "jobhunt");
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <!-- end popup -->
                                                <!-- send message popup -->
                                                <div class="modal fade" id="cs-msgbox-<?php echo absint($cs_fav->ID) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title"><?php esc_html_e('Send a Message', 'jobhunt') ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div id="ajaxcontact-response-<?php echo absint($cs_fav->ID) ?>" class="error-msg"></div>
                                                                <div class="cs-profile-contact-detail employer-message-candidate-form">
                                                                    <form id="ajaxcontactform-<?php echo absint($cs_fav->ID) ?>"  method="post" enctype="multipart/form-data">
                                                                        <div class="input-filed-contact">
                                                                            <i class="icon-user9"></i>
                                                                            <?php
                                                                            $cs_employer_info = get_userdata($uid);
                                                                            $employer_name = $cs_employer_info->display_name;
                                                                            $cs_opt_array = array(
                                                                                'id' => '',
                                                                                'std' => isset($employer_name) ? $employer_name : '',
                                                                                'classes' => 'form-control',
                                                                                'extra_atr' => 'placeholder="' . esc_html__('Enter your Name', 'jobhunt') . '"',
                                                                                'cust_name' => 'ajaxcontactname',
                                                                            );
                                                                            echo $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                                            ?> 
                                                                        </div>
                                                                        <div class="input-filed-contact email-field">
                                                                            <i class="icon-envelope4"></i>
                                                                            <?php
                                                                            $employer_email_address = $cs_employer_info->user_email;
                                                                            $cs_opt_array = array(
                                                                                'id' => '',
                                                                                'std' => isset($employer_email_address) ? $employer_email_address : '',
                                                                                'classes' => 'form-control',
                                                                                'extra_atr' => 'placeholder="' . esc_html__('Email Address', 'jobhunt') . '"',
                                                                                'cust_name' => 'ajaxcontactemail',
                                                                            );
                                                                            echo $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                                            ?> 
                                                                        </div>
                                                                        <div class="input-filed-contact">
                                                                            <i class="icon-mobile4"></i>
                                                                            <?php
                                                                            $emp_cell_no = get_user_meta($uid, 'cs_phone_number', true);
                                                                            $cs_opt_array = array(
                                                                                'id' => '',
                                                                                'std' => isset($emp_cell_no) ? $emp_cell_no : '',
                                                                                'classes' => 'form-control',
                                                                                'extra_atr' => 'placeholder="' . esc_html__('Phone Number', 'jobhunt') . '"',
                                                                                'cust_name' => 'ajaxcontactphone',
                                                                            );
                                                                            echo $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                                            ?> 
                                                                        </div>
                                                                        <div class="input-filed-contact">
                                                                            <?php
                                                                            $cs_opt_array = array(
                                                                                'id' => '',
                                                                                'std' => '',
                                                                                'extra_atr' => 'placeholder="' . esc_html__('Message', 'jobhunt') . '"',
                                                                                'cust_name' => 'ajaxcontactcontents',
                                                                            );
                                                                            echo $cs_form_fields2->cs_form_textarea_render($cs_opt_array);
                                                                            $cs_candidate_email = get_userdata($cs_fav->ID);
                                                                            $user_email_address = $cs_candidate_email->user_email;
                                                                            $cs_opt_array = array(
                                                                                'id' => '',
                                                                                'std' => isset($user_email_address) ? $user_email_address : '',
                                                                                'extra_atr' => 'placeholder="' . esc_html__('Message', 'jobhunt') . '"',
                                                                                'cust_name' => 'candidateemail',
                                                                            );
                                                                            echo $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                                                                            ?> 
                                                                        </div>
                                                                        <div id="jb-id-<?php echo absint($cs_fav->ID) ?>" data-jid="<?php echo absint($cs_fav->ID) ?>">
                                                                            <?php
                                                                            $cs_opt_array = array(
                                                                                'id' => 'jb-cont-send-' . $cs_fav->ID,
                                                                                'classes' => 'cs-bgcolor acc-submit',
                                                                                'std' => esc_html__('Send Request', 'jobhunt'),
                                                                                'extra_atr' => 'data-id="' . $cs_fav->ID . '" onclick="submit_contact_form_ajax(\'#ajaxcontactform-' . absint($cs_fav->ID) . '\',\'' . admin_url('admin-ajax.php') . '\',\'' . $cs_fav->ID . '\');"',
                                                                                'cust_name' => 'candidate_contactus',
                                                                                'cust_type' => 'button',
                                                                            );
                                                                            echo $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                                                            ?> 
                                                                            <div id="loader-data"></div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                        } else {
                            echo '<div class="no-result"><h1>' . esc_html__('No Applicant Found', 'jobhunt') . '</h1></div>';
                        }
                        ?>
                    </div>
                    <?php
                } else if ($cs_job_act == 'edit') {
                    echo '<div id="editjob">';
                    $this->cs_employer_post_job();
                    echo '</div>';
                }
            }
        }
        $cs_emp_temps = new cs_employer_templates();
    }