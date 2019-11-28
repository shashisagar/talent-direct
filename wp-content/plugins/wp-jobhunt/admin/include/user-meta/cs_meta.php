<?php
/**
 * @Add Meta Box For Candidate Post
 * @return
 *
 */
add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');

function cs_user_edit_form_multipart_encoding() {

    echo ' enctype="multipart/form-data"';
}

add_action('user_edit_form_tag', 'cs_user_edit_form_multipart_encoding');

function extra_user_profile_fields($user) {
    global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
    $cs_plugin_options = get_option('cs_plugin_options');
    $cs_award_switch = $cs_plugin_options['cs_award_switch'];
    $cs_portfolio_switch = $cs_plugin_options['cs_portfolio_switch'];
    $cs_skills_switch = $cs_plugin_options['cs_skills_switch'];
    $cs_education_switch = $cs_plugin_options['cs_education_switch'];
    $cs_experience_switch = $cs_plugin_options['cs_experience_switch'];

    $specialisms_label = esc_html__('Specialisms', 'jobhunt');
    $specialisms_label = apply_filters('jobhunt_replace_specialisms_to_categories', $specialisms_label);
    ?>
    <table class="form-table">
        <?php do_action('jobhunt_add_field_user_meta', $user); ?>
        <tr>
            <th><label for="specialism"><?php echo $specialisms_label; ?></label></th>
            <td>
                <?php
                /* Make sure the user can assign terms of the specialism taxonomy before proceeding. */
                $country_args = array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'fields' => 'all',
                    'slug' => '',
                    'hide_empty' => false,
                );
                $terms = get_terms('specialisms', $country_args);
                // If there are any specialism terms, loop through them and display checkboxes.
                if (!empty($terms)) {
                    $specialisms_option = array();
                    foreach ($terms as $term) {
                        $specialisms_option[esc_attr($term->slug)] = $term->name;
                    }
                    $cs_opt_array = array(
                        'usermeta' => true,
                        'user' => $user,
                        'std' => '',
                        'id' => 'specialisms',
                        'classes' => 'chosen-select',
                        'options' => $specialisms_option,
                    );
                    $cs_form_fields2->cs_form_multiselect_render($cs_opt_array);
                } else {
                    $no_specialisms_available_label = esc_html__('There are no specialisms available.', 'jobhunt');
                    $no_specialisms_available_label = apply_filters('jobhunt_replace_no_specialisms_available', $no_specialisms_available_label);
                    // If there are no specialism terms, display a message.
                    echo $no_specialisms_available_label;
                }
                ?>
            </td>
        </tr>
        <tr>
            <th><label for="user_status"><?php echo esc_html__('Profile Approved', 'jobhunt'); ?></label></th>
            <td><?php
                $user_status = array();
                $user_status = array(
                    '1' => 'Approved',
                    '0' => 'Pending',
                );
                $cs_opt_array = array(
                    'std' => isset($user->user_status) ? $user->user_status : '',
                    'id' => '',
                    'cust_id' => 'profile_approved',
                    'cust_name' => 'profile_approved',
                    'classes' => 'chosen-select-no-single small',
                    'options' => $user_status,
                );
                $cs_form_fields2->cs_form_select_render($cs_opt_array);
                ?></td>
        </tr>
    </table> 
    <?php
    $user_roles = isset($user->roles) ? $user->roles : '';
    $cs_candidate_role = false;
    $cs_employer_role = false;
    if (($user_roles != '' && in_array("cs_employer", $user_roles))) {
        $cs_employer_role = true;
    } elseif (($user_roles != '' && in_array("cs_candidate", $user_roles))) {
        $cs_candidate_role = true;
    }
    $custom_field = '';
    if ($cs_candidate_role == false && $cs_employer_role == false) {
        $custom_field = 'display:none;';
    }
    $candidate_custom_field_str = '';
    if ($cs_candidate_role == false) {
        $candidate_custom_field_str = ' style="display:none;"';
    }
    $employer_custom_field_str = '';
    if ($cs_employer_role == false) {
        $employer_custom_field_str = ' style="display:none;"';
    }

    $remove_candidate_role = 'no';
    $remove_candidate_role = apply_filters('jobhunt_remove_candidate_role_frontend', $remove_candidate_role);
    ?>
    <!-- Tab panes -->
    <div class="cs-user-customfield-block" style="<?php echo $custom_field; ?>;overflow:hidden; position:relative; ">
        <h3><?php esc_html_e("Extra profile information", "jobhunt"); ?></h3>
        <div class="page-wrap page-opts left" >
            <div class="option-sec">
                <div class="opt-conts">
                    <div class="elementhidden">
                        <nav class="admin-navigtion">
                            <ul id="cs-options-tab">
                                <li><a name="#tab-profile-settings" href="javascript:;"><i class="icon-user9"></i><?php echo esc_html__('My Profile', 'jobhunt'); ?></a></li>
                                <?php if (isset($cs_award_switch) && $cs_award_switch == 'on') { ?>
                                    <li <?php echo force_balance_tags($candidate_custom_field_str); ?> class="cs-candidate-fields"><a name="#tab-award-settings" href="javascript:;"><i class="icon-trophy5"></i><?php echo esc_html__('Award', 'jobhunt'); ?></a></li>
                                <?php } ?>
                                <?php if (isset($cs_portfolio_switch) && $cs_portfolio_switch == 'on') { ?>
                                    <li <?php echo force_balance_tags($candidate_custom_field_str); ?> class="cs-candidate-fields"><a name="#tab-portfolio-setting" href="javascript:;"><i class="icon-pictures5"></i><?php echo esc_html__('Portfolio', 'jobhunt'); ?> </a></li>
                                <?php } ?>
                                <?php if (isset($cs_skills_switch) && $cs_skills_switch == 'on') { ?>
                                    <li <?php echo force_balance_tags($candidate_custom_field_str); ?> class="cs-candidate-fields"><a name="#tab-skill-setting" href="javascript:;"><i class="icon-pie2"></i><?php echo esc_html__('Skills', 'jobhunt'); ?> </a></li>
                                <?php } ?>
                                <?php if (isset($cs_education_switch) && $cs_education_switch == 'on') { ?>
                                    <li <?php echo force_balance_tags($candidate_custom_field_str); ?> class="cs-candidate-fields"><a name="#tab-education-setting" href="javascript:;"><i class="icon-graduation"></i><?php echo esc_html__('Education', 'jobhunt'); ?> </a></li>
                                <?php } ?>
                                <?php if (isset($cs_experience_switch) && $cs_experience_switch == 'on') { ?>
                                    <li <?php echo force_balance_tags($candidate_custom_field_str); ?> class="cs-candidate-fields"><a name="#tab-experience-setting" href="javascript:;"><i class="icon-list-alt"></i><?php echo esc_html__('Experience', 'jobhunt'); ?> </a></li>
                                <?php } ?>
                                <?php do_action('jobhunt_users_tabs_backend', $candidate_custom_field_str); ?>
                                <?php $label = apply_filters('jobhunt_cv_letter_headings', esc_html__('CV & Cover Letter', 'jobhunt')); ?>
                                <li  <?php echo force_balance_tags($candidate_custom_field_str); ?> class="cs-candidate-fields"><a name="#tab-cvcover-letter" href="javascript:;"><i class="icon-vcard"></i><?php echo $label; ?> </a></li>
                                <li <?php echo force_balance_tags($candidate_custom_field_str); ?> class="cs-candidate-fields"><a name="#tab-candidate-fav-list" href="javascript:;"><i class="icon-heart11"></i><?php echo esc_html__('Favourite Jobs', 'jobhunt'); ?> </a></li>
                                <li <?php echo force_balance_tags($candidate_custom_field_str); ?> class="cs-candidate-fields"><a name="#tab-candidate-custom-fields" href="javascript:;"><i class="icon-list-alt"></i><?php echo esc_html__('Candidate Custom Fields', 'jobhunt'); ?> </a></li>
                                <!-- employer tabs -->
                                <?php if ($remove_candidate_role != 'yes') { ?>
                                    <li <?php echo force_balance_tags($employer_custom_field_str); ?> class="cs-employer-fields"><a name="#tab-employer-fav-list" href="javascript:void(0);"><i class="icon-heart11"></i><?php echo esc_html__('Favourite Resumes', 'jobhunt'); ?></a></li>
                                <?php } ?>
                                <li <?php echo force_balance_tags($employer_custom_field_str); ?> class="cs-employer-fields"><a name="#tab-employer-custom-fields" href="javascript:void(0);"><i class="icon-list-alt"></i><?php echo esc_html__('Employer Custom Fields', 'jobhunt'); ?></a></li>
                            </ul>
                        </nav>
                        <div id="tabbed-content">
                            <div id="tab-profile-settings">
                                <?php cs_user_profile_setting($user); ?>
                            </div>
                            <div class="cs-candidate-fields" id="tab-award-settings">
                                <div class="theme-help">
                                    <h4>
                                        <?php esc_html_e('Awards', 'jobhunt'); ?>
                                    </h4>
                                    <div class="clear"></div>
                                </div>
                                <?php cs_candidate_award_list($user); ?>
                            </div>
                            <div class="cs-candidate-fields" id="tab-portfolio-setting">
                                <div class="theme-help">
                                    <h4>
                                        <?php esc_html_e('Portfolio', 'jobhunt'); ?>
                                    </h4>
                                    <div class="clear"></div>
                                </div>
                                <?php cs_candidate_portfolio_list($user); ?>
                            </div>
                            <div class="cs-candidate-fields" id="tab-skill-setting">
                                <div class="theme-help">
                                    <h4>
                                        <?php esc_html_e('Skills', 'jobhunt'); ?>
                                    </h4>
                                    <div class="clear"></div>
                                </div>
                                <?php cs_candidate_skills_list($user); ?>
                            </div>
                            <div class="cs-candidate-fields" id="tab-education-setting">
                                <div class="theme-help">
                                    <h4>
                                        <?php esc_html_e('Education', 'jobhunt'); ?>
                                    </h4>
                                    <div class="clear"></div>
                                </div>
                                <?php cs_candidate_education_list($user); ?>
                            </div>
                            <div class="cs-candidate-fields" id="tab-experience-setting">
                                <div class="theme-help">
                                    <h4>
                                        <?php esc_html_e('Experience', 'jobhunt'); ?>
                                    </h4>
                                    <div class="clear"></div>
                                </div>
                                <?php cs_candidate_experience_list($user); ?>
                            </div>
                            <?php do_action('jobhunt_users_tabs_content_backend', $user); ?>
                            <div class="cs-candidate-fields" id="tab-cvcover-letter">
                                <?php
                                $is_cv_documents = add_filter('jobhunt_is_candidate_cv_documnets', false);

                                if ($is_cv_documents == false) {
                                    ?>
                                    <?php do_action('cs_candidate_cv_documents_admin', $user); ?>
                                <?php } else { ?>
                                    <div class="theme-help">
                                        <h4>
                                            <?php esc_html_e('CV & Cover Letter', 'jobhunt'); ?>
                                        </h4>
                                        <div class="clear"></div>
                                    </div>
                                    <?php cs_candidate_cvcover_letter($user); ?>
                                <?php } ?>
                            </div>
                            <div class="cs-candidate-fields" id="tab-candidate-fav-list">
                                <div class="theme-help">
                                    <h4>
                                        <?php esc_html_e('Favourite Jobs', 'jobhunt'); ?>
                                    </h4>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div class="cs-candidate-fields" id="tab-candidate-custom-fields">

                                <div class="theme-help">
                                    <h4>
                                        <?php esc_html_e('Candidate Custom Fields', 'jobhunt'); ?>
                                    </h4>
                                    <div class="clear"></div>
                                </div>
                                <?php cs_candidate_profile_custom_fields($user); ?>
                            </div>
                            <!-- employer tabbing content -->
                            <div class="cs-employer-fields" id="tab-employer-fav-list">
                                <div class="theme-help">
                                    <h4><?php esc_html_e('Favourite Resumes', 'jobhunt'); ?></h4>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div class="cs-employer-fields" id="tab-employer-custom-fields">
                                <div class="theme-help">
                                    <h4><?php esc_html_e('Employer Custom Fields', 'jobhunt'); ?></h4>
                                    <div class="clear"></div>
                                </div>
                                <?php cs_employer_profile_custom_fields($user); ?>
                            </div>
                            <!-- end employer tabbing content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <!-- End extra fields for user profile tabbing -->

    <?php
}

add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');

function save_extra_user_profile_fields($user_id) {
    global $wpdb;
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    $data = array();

    $user_old_status = get_user_meta($user_id, 'cs_user_status', true);
    do_action('jobhunt_employer_featured_job_saving', $user_id, $_POST);
    foreach ($_POST as $key => $value) {
        $user_name = sanitize_title($_POST['display_name']);
        wp_update_user(array('ID' => $user_id, 'user_nicename' => $user_name));
        if (strstr($key, 'cs_')) {
            if ($key == 'cs_transaction_expiry_date' || $key == 'cs_job_expired' || $key == 'cs_job_posted' || $key == 'cs_user_last_activity_date') {
                if ($value == '' || $key == 'cs_user_last_activity_date') {
                    $value = current_time('d-m-Y H:i:s');
                }
                $data[$key] = strtotime($value);

                update_user_meta($user_id, $key, strtotime($value));
            } else {
                if ($key == 'cs_cus_field') {
                    if (is_array($value) && sizeof($value) > 0) {
                        foreach ($value as $c_key => $c_val) {
                            update_user_meta($user_id, $c_key, $c_val);
                        }
                    }
                } else {
                    $update_field = true;
                    $updarte_field = apply_filters('dairyjobs_admin_cv_saving', $update_field, $key);
                    //$update_field = apply_filters('cv_alter_admin_cv_saving', $update_field, $key);
                    if ($updarte_field) {
                        $data[$key] = $value;
                        update_user_meta($user_id, $key, $value);
                    }
                }
            }
        }
        if ($key == 'job_img' || $key == 'user_img' || $key == 'employer_img' || $key == 'cover_user_img') {
            update_user_meta($user_id, $key, cs_save_img_url($value));
        }
        //change user status
        if ($key == 'profile_approved') {
            $wpdb->update(
                    $wpdb->prefix . 'users', array('user_status' => $value), array('ID' => esc_sql($user_id))
            );
        }
        do_action('jobhunt_update_user_forntend', $user_id, $_POST);
    }
    $cs_media_image = cs_user_avatar('cs_user_img_media');

    if ($cs_media_image == '') {
        $cs_media_image = $_POST['user_img'];
    } else {
        $cs_prev_img = get_user_meta($user_id, 'user_img', true);
        cs_remove_img_url($cs_prev_img);
    }
    update_user_meta($user_id, 'user_img', $cs_media_image);

    $cover_media_upload = cs_user_avatar('cs_cover_user_img_media');
    if ($cover_media_upload == '') {
        $cover_media_upload = $_POST['cover_user_img'];
    } else {
        $cs_cover_prev_img = get_user_meta($user_id, 'cover_user_img', true);
        cs_remove_img_url($cs_cover_prev_img);
    }
    update_user_meta($user_id, 'cover_user_img', $cover_media_upload);

    update_user_meta($user_id, 'cs_array_data', $data);
    do_action('liamdemoncuit_employer_google_loc_save', $user_id, $_POST);
    do_action('jobhunt_employer_profile_status_changed', $user_id, $user_old_status);
    do_action('dairyjobs_admin_cv_package_field_saving', $user_id, $_POST);
    do_action('jobhunt_employer_images_save_backend', $user_id, $_POST);
    do_action('jobhunt_after_user_updated', $user_id, $_POST);
}

/**
 * Start How to Add Profile Setting in User
 */
if (!function_exists('cs_user_profile_setting')) {

    function cs_user_profile_setting($user) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
        $cs_html_fields->cs_heading_render(
                array(
                    'name' => esc_html__('Profile Settings', 'jobhunt'),
                    'id' => 'profile_setting',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => ''
                )
        );
        $plugin_action = false;
        $plugin_action = apply_filters('digitalmarketing_candidate_cap_backend', $plugin_action, $user);
        if (!$plugin_action) {
            $cs_opt_array = array(
                'std' => '',
                'user' => $user,
                'id' => 'user_img',
                'name' => esc_html__('Profile Image', 'jobhunt'),
                'desc' => '',
                'dp' => true,
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'usermeta' => true,
                    'user' => $user,
                    'std' => '',
                    'dp' => true,
                    'id' => 'user_img',
                    'classes' => 'left cs-uploadimg upload',
                    'return' => true,
                ),
            );
            $cs_html_fields->cs_custom_upload_file_field($cs_opt_array);
            $cs_opt_array = array(
                'std' => '',
                'user' => $user,
                'std' => '',
                'id' => 'cover_user_img',
                'name' => esc_html__('Cover Image', 'jobhunt'),
                'desc' => '',
                'dp' => true,
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'usermeta' => true,
                    'user' => $user,
                    'std' => '',
                    'dp' => true,
                    'id' => 'cover_user_img',
                    'classes' => 'left cs-cover-uploadimg upload',
                    'return' => true,
                ),
            );
            $cs_html_fields->cs_custom_upload_file_field($cs_opt_array);
        }
        do_action('jobhunt_user_fields_backend', $user);

        $cs_opt_array = array(
            'name' => esc_html__('Job Title', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'job_title',
                'return' => true,
            ),
        );

        $cs_html_fields->cs_text_field($cs_opt_array);
        do_action('jobhunt_show_dni_backend', $user);
        do_action('dairyjobs_admin_cv_fields', $user);
        $user_status = array();
        $user_status = array(
            'active' => esc_html__('Active', 'jobhunt'),
            'inactive' => esc_html__('Inactive', 'jobhunt'),
        );
        $cs_opt_array = array(
            'name' => esc_html__('Profile Status', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'user_status',
                'classes' => 'chosen-select-no-single',
                'options' => $user_status,
                'return' => true,
            ),
        );

        $cs_html_fields->cs_select_field($cs_opt_array);
        $allow_search = array();
        $allow_search = array(
            'yes' => esc_html__('Yes', 'jobhunt'),
            'no' => esc_html__('No', 'jobhunt'),
        );

        $cs_opt_array = array(
            'name' => esc_html__('Allow In Search & listing', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'allow_search',
                'classes' => 'chosen-select-no-single',
                'options' => $allow_search,
                'return' => true,
            ),
        );

        $cs_allow_in_search_user_switch = isset($cs_plugin_options['cs_allow_in_search_user_switch']) ? $cs_plugin_options['cs_allow_in_search_user_switch'] : '';
        if (isset($cs_allow_in_search_user_switch) && $cs_allow_in_search_user_switch == 'on') {
            $cs_html_fields->cs_select_field($cs_opt_array);
        }




        $cs_opt_array = array(
            'name' => esc_html__('Minimum Salary', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'minimum_salary',
                'return' => true,
            ),
        );

        $cs_html_fields->cs_text_field($cs_opt_array);

        do_action('make_featured_backend_field', $user);
        do_action('jobhunt_candidate_profile_fields_backend', $user);

        $cs_opt_array = array(
            'name' => esc_html__('Last Activity', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'id' => 'user_last_activity_date',
                'format' => 'd-m-Y H:i:s',
                'disabled' => 'yes',
                'strtotime' => true,
                'return' => true,
            ),
        );

        $cs_html_fields->cs_date_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('Package Transaction Id', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'trans_id',
                'return' => true,
            ),
        );

        $cs_html_fields->cs_text_field($cs_opt_array);
        $cs_opt_array = array(
            'name' => esc_html__('Package Buy On:', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'id' => 'job_posted',
                'classes' => '',
                'strtotime' => true,
                'std' => '', //current_time('d-m-Y H:i:s'),
                'description' => '',
                'hint' => '',
                'format' => 'd-m-Y H:i:s',
                'return' => true,
            ),
        );

        $cs_html_fields->cs_date_field($cs_opt_array);
        $cs_opt_array = array(
            'name' => esc_html__('Package Expired on:', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '', //date('d-m-Y'),
                'id' => 'job_expired',
                'format' => 'd-m-Y',
                'strtotime' => true,
                'return' => true,
            ),
        );

        $cs_html_fields->cs_date_field($cs_opt_array);

        $cs_html_fields->cs_heading_render(
                array(
                    'name' => esc_html__('Social Networks', 'jobhunt'),
                    'id' => 'social_network',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => ''
                )
        );

        $cs_opt_array = array(
            'name' => esc_html__('Facebook', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'facebook',
                'return' => true,
            ),
        );

        $cs_html_fields->cs_text_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('Twitter', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'twitter',
                'return' => true,
            ),
        );

        $cs_html_fields->cs_text_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('LinkedIn', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'linkedin',
                'return' => true,
            ),
        );

        $cs_html_fields->cs_text_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('Phone No', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'phone_number',
                'return' => true,
            ),
        );
        $cs_html_fields->cs_text_field($cs_opt_array);
        do_action('jobhunt_employer_video_url_backend_field', $user);
        $cs_location_fields_show = isset($cs_plugin_options['cs_location_fields']) ? $cs_plugin_options['cs_location_fields'] : 'off';
        if ($cs_location_fields_show == 'on') {
            $cs_html_fields->cs_heading_render(
                    array(
                        'name' => esc_html__('Mailing Information', 'jobhunt'),
                        'id' => 'mailing_information',
                        'classes' => '',
                        'std' => '',
                        'description' => '',
                        'hint' => ''
                    )
            );

            CS_FUNCTIONS()->cs_location_fields($user);
        }
    }

}
/**
 * Start How to Add Profile Award List in Candidate
 */
if (!function_exists('cs_candidate_award_list')) {

    function cs_candidate_award_list($user) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
        $cs_get_award_list = get_the_author_meta('cs_award_list_array', $user->ID);
        $cs_award_names = get_the_author_meta('cs_award_name_array', $user->ID);
        $cs_award_years = get_the_author_meta('cs_award_year_array', $user->ID);
        $cs_award_descs = get_the_author_meta('cs_award_description_array', $user->ID);
        $html = '
	<script>
		jQuery(document).ready(function($) {
			$("#total_award_list").sortable({
				cancel : \'td div.table-form-elem\'
			});
		});
	</script>
	  <ul class="form-elements">
			<li class="to-button"><a href="javascript:cs_createpop(\'add_awards\',\'filter\')" class="button">' . esc_html__("Add Award", "jobhunt") . '</a> </li>
	   </ul>
	  <div class="cs-list-table">
	  <table class="to-table" border="0" cellspacing="0">
		<thead>
		  <tr>
			<th style="width:40%;">' . esc_html__("Title", "jobhunt") . '</th>
			<th style="width:40%;" class="centr">' . esc_html__("Year", "jobhunt") . '</th>
			<th style="width:20%;" class="right">' . esc_html__("Actions", "jobhunt") . '</th>
		  </tr>
		</thead>
		<tbody id="total_award_list">';
        if (isset($cs_get_award_list) && is_array($cs_get_award_list) && count($cs_get_award_list) > 0) {
            $cs_award_counter = 0;
            foreach ($cs_get_award_list as $award_list) {
                if (isset($award_list) && $award_list <> '') {

                    $counter_extra_feature = $extra_feature_id = $award_list;
                    $cs_award_name = isset($cs_award_names[$cs_award_counter]) ? $cs_award_names[$cs_award_counter] : '';
                    $cs_award_year = isset($cs_award_years[$cs_award_counter]) ? $cs_award_years[$cs_award_counter] : '';
                    $cs_award_description = isset($cs_award_descs[$cs_award_counter]) ? $cs_award_descs[$cs_award_counter] : '';

                    $ca_awards_array = array(
                        'counter_extra_feature' => $counter_extra_feature,
                        'extra_feature_id' => $extra_feature_id,
                        'cs_award_name' => $cs_award_name,
                        'cs_award_year' => $cs_award_year,
                        'cs_award_description' => $cs_award_description,
                    );

                    $html .= cs_add_award_to_list($ca_awards_array);
                }
                $cs_award_counter ++;
            }
        }
        $html .= '
		</tbody>
	  </table>
	
	  </div>
	  <div id="add_awards" style="display: none;">
		<div class="cs-heading-area">
		  <h5><i class="icon-plus-circle"></i> ' . esc_html__('Award Setting', 'jobhunt') . '</h5>
		  <span class="cs-btnclose" onClick="javascript:cs_remove_overlay(\'add_awards\',\'append\')"> <i class="icon-times"></i></span> 	
		</div>';


        $cs_opt_array = array(
            'name' => esc_html__('Award Name', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'award_name_pop',
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('Select Year', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'award_year_pop',
                'format' => 'd-m-Y H:i:s',
                'strtotime' => true,
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_date_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('Award Description', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'award_desc_pop',
                'strtotime' => true,
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_textarea_field($cs_opt_array);

        $html .= '<div class="feature-loader"></div>';
        $cs_opt_array = array(
            'name' => '&nbsp;',
            'desc' => '',
            'hint_text' => '',
            'field_params' => array(
                'std' => esc_html__('Add Award', 'jobhunt'),
                'id' => 'cs_add_awardes',
                'cust_name' => '',
                'cust_type' => 'button',
                'extra_atr' => ' onClick="add_award_to_list(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(wp_jobhunt::plugin_url()) . '\')"',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        echo force_balance_tags($html, true);
    }

}

/**
 * Start How to Add Package Award List in Candidate
 */
if (!function_exists('cs_add_award_to_list')) {

    function cs_add_award_to_list($cs_atts) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
        $cs_defaults = array(
            'counter_extra_feature' => '',
            'extra_feature_id' => '',
            'cs_award_name' => '',
            'cs_award_year' => '',
            'cs_award_description' => '',
        );
        extract(shortcode_atts($cs_defaults, $cs_atts));
        foreach ($_POST as $keys => $values) {
            $$keys = $values;
        }
        if (isset($_POST['cs_award_name']) && $_POST['cs_award_name'] <> '')
            $cs_award_name = $_POST['cs_award_name'];
        if (isset($_POST['cs_award_year']) && $_POST['cs_award_year'] <> '')
            $cs_award_year = $_POST['cs_award_year'];
        if (isset($_POST['cs_award_description']) && $_POST['cs_award_description'] <> '')
            $cs_award_description = $_POST['cs_award_description'];

        if ($extra_feature_id == '' && $counter_extra_feature == '') {
            $counter_extra_feature = $extra_feature_id = time();
        }
        $html = '
            <tr class="parentdelete" id="edit_track' . absint($counter_extra_feature) . '">
              <td id="subject-title' . absint($counter_extra_feature) . '" style="width:40%;">' . esc_attr($cs_award_name) . '</td>
                    <td id="award-year' . absint($counter_extra_feature) . '" style="width:40%;">' . esc_attr($cs_award_year) . '</td>
              <td class="centr" style="width:20%;"><a href="javascript:cs_createpop(\'edit_track_form' . absint($counter_extra_feature) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
              <td style="width:0"><div id="edit_track_form' . esc_attr($counter_extra_feature) . '" style="display: none;" class="table-form-elem">';

        $cs_opt_array = array(
            'cust_id' => 'cs_award_list_array',
            'cust_name' => 'cs_award_list_array[]',
            'extra_atr' => ' data-type="option"',
            'std' => $extra_feature_id,
            'cust_type' => 'hidden',
            'return' => true,
        );
        $html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

        $html .= '
                  <div class="cs-heading-area">
                    <h5 style="text-align: left;">' . esc_html__('Award Settings', 'jobhunt') . '</h5>
                    <span onclick="javascript:cs_remove_overlay(\'edit_track_form' . esc_js($counter_extra_feature) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                    <div class="clear"></div>
                  </div>';

        $cs_opt_array = array(
            'name' => esc_html__('Award Name', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_award_name,
                'id' => 'award_name',
                'return' => true,
                'array' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('Select Year', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_award_year,
                'id' => 'award_year',
                'array' => true,
                'format' => 'd-m-Y H:i:s',
                'strtotime' => true,
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_date_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('Award Description', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_award_description,
                'id' => 'award_description',
                'return' => true,
                'array' => true,
            ),
        );

        $html .= $cs_html_fields->cs_textarea_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => '&nbsp;',
            'desc' => '',
            'hint_text' => '',
            'field_params' => array(
                'std' => esc_html__('Update Award', 'jobhunt'),
                'id' => 'cs_update_awardes',
                'cust_name' => '',
                'cust_type' => 'button',
                'extra_atr' => ' onclick="cs_remove_overlay(\'edit_track_form' . esc_js($counter_extra_feature) . '\',\'append\')"',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $html .= '
          </div></td>
      </tr>';
        if (isset($_POST['cs_award_name']) && isset($_POST['cs_award_year'])) {
            echo force_balance_tags($html);
        } else {
            return $html;
        }
        if (isset($_POST['cs_award_name']) && isset($_POST['cs_award_year']))
            die();
    }

    add_action('wp_ajax_cs_add_award_to_list', 'cs_add_award_to_list');
}

/**
 * Start How to Add Package Portfolio  in Candidate
 */
if (!function_exists('cs_candidate_portfolio_list')) {

    function cs_candidate_portfolio_list($user) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
        $cs_get_port_list = get_the_author_meta('cs_port_list_array', $user->ID);
        $cs_image_titles = get_the_author_meta('cs_image_title_array', $user->ID);
        $cs_image_uploads = get_the_author_meta('cs_image_upload_array', $user->ID);
        $html = '
	<script>
            jQuery(document).ready(function($) {
                $("#total_portfolio_list").sortable({
                     cancel : \'td div.table-form-elem\'
                });
            });
	</script>
	  <ul class="form-elements">
		<li class="to-button"><a href="javascript:cs_createpop(\'add_portfolio\',\'filter\')" class="button">' . esc_html__("Add Portfolio", "jobhunt") . '</a> </li>
	   </ul>
	  <div class="cs-list-table">
	  <table class="to-table" border="0" cellspacing="0">
		<thead>
		  <tr>
                    <th style="width:100%;">' . esc_html__("Title", "jobhunt") . '</th>
                    <th style="width:20%;" class="right">' . esc_html__("Actions", "jobhunt") . '</th>
		  </tr>
		</thead>
		<tbody id="total_portfolio_list">';
        if (isset($cs_get_port_list) && is_array($cs_get_port_list) && count($cs_get_port_list) > 0) {
            $cs_award_counter = 0;
            foreach ($cs_get_port_list as $award_list) {
                if (isset($award_list) && $award_list <> '') {
                    $counter_extra_feature = $extra_feature_id = $award_list;
                    $cs_image_title = isset($cs_image_titles[$cs_award_counter]) ? $cs_image_titles[$cs_award_counter] : '';
                    $cs_image_upload = isset($cs_image_uploads[$cs_award_counter]) ? $cs_image_uploads[$cs_award_counter] : '';
                    $ca_awards_array = array(
                        'counter_extra_feature' => $counter_extra_feature,
                        'extra_feature_id' => $extra_feature_id,
                        'cs_image_title' => $cs_image_title,
                        'cs_image_upload' => $cs_image_upload,
                    );
                    $html .= cs_add_portfolio_to_list($ca_awards_array);
                }
                $cs_award_counter ++;
            }
        }
        $html .= '
		</tbody>
	  </table>	
	  </div>
	  </form>
	  <div id="add_portfolio" style="display: none;">
		<div class="cs-heading-area">
		  <h5><i class="icon-plus-circle"></i> ' . esc_html__('Portfolio Setting', 'jobhunt') . '</h5>
		  <span class="cs-btnclose" onClick="javascript:cs_remove_overlay(\'add_portfolio\',\'append\')"> <i class="icon-times"></i></span> 	
		</div>';

        $cs_opt_array = array(
            'name' => esc_html__('Image Title', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'image_title',
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);


        $cs_opt_array = array(
            'std' => '',
            'id' => 'image_upload',
            'name' => esc_html__('Image Upload', 'jobhunt'),
            'desc' => '',
            'dp' => true,
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'dp' => true,
                'id' => 'image_upload',
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_upload_file_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => '&nbsp;',
            'desc' => '',
            'hint_text' => '',
            'field_params' => array(
                'std' => esc_html__('Add Portfolio', 'jobhunt'),
                'id' => 'cs_add_portfolio',
                'cust_name' => '',
                'cust_type' => 'button',
                'extra_atr' => ' onClick="add_portfolio_to_list(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(wp_jobhunt::plugin_url()) . '\')"',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $html .= '		
		</div>';
        echo force_balance_tags($html, true);
    }

}

/**
 * Start How to Add Package Skill List  in Candidate
 */
if (!function_exists('cs_add_portfolio_to_list')) {

    function cs_add_portfolio_to_list($cs_atts) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
        $cs_defaults = array(
            'counter_extra_feature' => '',
            'extra_feature_id' => '',
            'cs_image_title' => '',
            'cs_image_upload' => '',
        );
        extract(shortcode_atts($cs_defaults, $cs_atts));
        foreach ($_POST as $keys => $values) {
            $$keys = $values;
        }
        if (isset($_POST['cs_image_title']) && $_POST['cs_image_title'] <> '')
            $cs_image_title = $_POST['cs_image_title'];
        if (isset($_POST['cs_image_upload']) && $_POST['cs_image_upload'] <> '')
            $cs_image_upload = $_POST['cs_image_upload'];

        if ($extra_feature_id == '' && $counter_extra_feature == '') {
            $counter_extra_feature = $extra_feature_id = time();
        }
        $html = '
            <tr class="parentdelete" id="edit_track' . esc_attr($extra_feature_id) . '">
               <td id="subject-title' . esc_attr($extra_feature_id) . '" style="width:40%;">' . esc_attr($cs_image_title) . '</td>
            <td class="centr" style="width:20%;"><a href="javascript:cs_createpop(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
               <td style="width:0"><div id="edit_track_form' . esc_attr($extra_feature_id) . '" style="display: none;" class="table-form-elem">';


        $cs_opt_array = array(
            'cust_id' => 'cs_port_list_array',
            'cust_name' => 'cs_port_list_array[]',
            'extra_atr' => ' data-type="option"',
            'std' => $extra_feature_id,
            'cust_type' => 'hidden',
            'return' => true,
        );
        $html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

        $html .= '
                   <div class="cs-heading-area">
                     <h5 style="text-align: left;">' . esc_html__('Portfolio Settings', 'jobhunt') . '</h5>
                     <span onclick="javascript:cs_remove_overlay(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                     <div class="clear"></div>
                   </div>';

        $cs_opt_array = array(
            'name' => esc_html__('Image Title Name', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_image_title,
                'id' => 'image_title',
                'return' => true,
                'array' => true,
                'force_std' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $cs_opt_array = array(
            'std' => $cs_image_upload,
            'id' => 'image_upload',
            'name' => esc_html__('Image Upload', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'array' => true,
            'force_std' => true,
            'field_params' => array(
                'std' => $cs_image_upload,
                'id' => 'image_upload',
                'return' => true,
                'array' => true,
                'force_std' => true,
            ),
        );

        $html .= $cs_html_fields->cs_upload_file_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => '&nbsp;',
            'desc' => '',
            'hint_text' => '',
            'field_params' => array(
                'std' => esc_html__('Update Portfolio', 'jobhunt'),
                'id' => 'cs_update_porst',
                'cust_name' => '',
                'cust_type' => 'button',
                'extra_atr' => ' onclick="cs_remove_overlay(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'append\')"',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $html .= '</div>
      </td>
    </tr>';
        if (isset($_POST['cs_image_title']) && isset($_POST['cs_image_upload'])) {
            echo force_balance_tags($html);
        } else {
            return $html;
        }
        if (isset($_POST['cs_image_title']) && isset($_POST['cs_image_upload']))
            die();
    }

    add_action('wp_ajax_cs_add_portfolio_to_list', 'cs_add_portfolio_to_list');
}


/**
 * Start How to Add Package Skill in Candidate
 */
if (!function_exists('cs_candidate_skills_list')) {

    function cs_candidate_skills_list($user) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;

        $cs_get_skill_list = get_the_author_meta('cs_skills_list_array', $user->ID);
        $cs_skill_titles = get_the_author_meta('cs_skill_title_array', $user->ID);
        $cs_skill_percentages = get_the_author_meta('cs_skill_percentage_array', $user->ID);
        $html = '
	<script>
            jQuery(document).ready(function($) {
                $("#total_skills_list").sortable({
                    cancel : \'td div.table-form-elem\'
                });
            });
	</script>
	  <ul class="form-elements">
		<li class="to-button"><a href="javascript:cs_createpop(\'add_skills\',\'filter\')" class="button">' . esc_html__("Add Skills", "jobhunt") . '</a> </li>
	   </ul>
	  <div class="cs-list-table">
	  <table class="to-table" border="0" cellspacing="0">
		<thead>
		  <tr>
                    <th style="width:100%;">' . esc_html__("Title", "jobhunt") . '</th>
                    <th style="width:20%;" class="right">' . esc_html__("Actions", "jobhunt") . '</th>
		  </tr>
		</thead>
		<tbody id="total_skills_list">';
        if (isset($cs_get_skill_list) && is_array($cs_get_skill_list) && count($cs_get_skill_list) > 0) {
            $cs_award_counter = 0;
            foreach ($cs_get_skill_list as $award_list) {
                if (isset($award_list) && $award_list <> '') {

                    $counter_extra_feature = $extra_feature_id = $award_list;
                    $cs_skill_title = isset($cs_skill_titles[$cs_award_counter]) ? $cs_skill_titles[$cs_award_counter] : '';
                    $cs_skill_percentage = isset($cs_skill_percentages[$cs_award_counter]) ? $cs_skill_percentages[$cs_award_counter] : '';

                    $ca_awards_array = array(
                        'counter_extra_feature' => $counter_extra_feature,
                        'extra_feature_id' => $extra_feature_id,
                        'cs_skill_title' => $cs_skill_title,
                        'cs_skill_percentage' => $cs_skill_percentage,
                    );

                    $html .= cs_add_skills_to_list($ca_awards_array);
                }
                $cs_award_counter ++;
            }
        }
        $html .= '
		</tbody>
	  </table>	
	  </div>
	  </form>
	  <div id="add_skills" style="display: none;">
		<div class="cs-heading-area">
		  <h5><i class="icon-plus-circle"></i> ' . esc_html__('Skills Setting', 'jobhunt') . '</h5>
		  <span class="cs-btnclose" onClick="javascript:cs_remove_overlay(\'add_skills\',\'append\')"> <i class="icon-times"></i></span> 	
		</div>';

        $cs_opt_array = array(
            'name' => esc_html__('Skill Title', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'skill_title',
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('Skill Percentage', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'skill_percentage',
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => '&nbsp;',
            'desc' => '',
            'hint_text' => '',
            'field_params' => array(
                'std' => esc_html__('Add Skills', 'jobhunt'),
                'id' => 'cs_add_skills',
                'cust_name' => '',
                'cust_type' => 'button',
                'extra_atr' => ' onClick="add_skills_to_list(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(wp_jobhunt::plugin_url()) . '\')"',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $html .= '</div>';

        echo force_balance_tags($html, true);
    }

}


/**
 * Start How to Package Add Skill List  in Candidate
 */
if (!function_exists('cs_add_skills_to_list')) {

    function cs_add_skills_to_list($cs_atts) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
        $cs_defaults = array(
            'counter_extra_feature' => '',
            'extra_feature_id' => '',
            'cs_skill_title' => '',
            'cs_skill_percentage' => '',
        );
        extract(shortcode_atts($cs_defaults, $cs_atts));
        foreach ($_POST as $keys => $values) {
            $$keys = $values;
        }
        if (isset($_POST['cs_skill_title']) && $_POST['cs_skill_title'] <> '')
            $cs_skill_title = $_POST['cs_skill_title'];
        if (isset($_POST['cs_skill_percentage']) && $_POST['cs_skill_percentage'] <> '')
            $cs_skill_percentage = preg_replace('/[^0-9]/', '', $_POST['cs_skill_percentage']); // remove all cherecters and alphabats

        if ($extra_feature_id == '' && $counter_extra_feature == '') {
            $counter_extra_feature = $extra_feature_id = time();
        }
        $html = '
                <tr class="parentdelete" id="edit_track' . esc_attr($extra_feature_id) . '">
                  <td id="subject-title' . esc_attr($extra_feature_id) . '" style="width:40%;">' . esc_attr($cs_skill_title) . '</td>
				  
                  <td class="centr" style="width:20%;"><a href="javascript:cs_createpop(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
                  <td style="width:0"><div id="edit_track_form' . esc_attr($extra_feature_id) . '" style="display: none;" class="table-form-elem">';

        $cs_opt_array = array(
            'cust_id' => 'cs_skills_list_array',
            'cust_name' => 'cs_skills_list_array[]',
            'extra_atr' => ' data-type="option"',
            'std' => $extra_feature_id,
            'cust_type' => 'hidden',
            'return' => true,
        );
        $html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);
        $html .= '
                      <div class="cs-heading-area">
                        <h5 style="text-align: left;">' . esc_html__('Skills Settings', 'jobhunt') . '</h5>
                        <span onclick="javascript:cs_remove_overlay(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                        <div class="clear"></div>
                      </div>';

        $cs_opt_array = array(
            'name' => esc_html__('Skill Title Name', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_skill_title,
                'id' => 'skill_title',
                'return' => true,
                'array' => true,
                'force_std' => true,
                'hint' => ''
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('Skill Percentage', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_skill_percentage,
                'id' => 'skill_percentage',
                'return' => true,
                'array' => true,
                'force_std' => true,
                'hint' => ''
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => '&nbsp;',
            'desc' => '',
            'hint_text' => '',
            'field_params' => array(
                'std' => esc_html__('Update Skills', 'jobhunt'),
                'id' => 'cs_updates_skills',
                'cust_name' => '',
                'cust_type' => 'button',
                'extra_atr' => ' onclick="cs_remove_overlay(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'append\')"',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $html .= '</div></td>
                </tr>';

        if (isset($_POST['cs_skill_title']) && isset($_POST['cs_skill_percentage'])) {
            echo force_balance_tags($html);
        } else {
            return $html;
        }

        if (isset($_POST['cs_skill_title']) && isset($_POST['cs_skill_percentage']))
            die();
    }

    add_action('wp_ajax_cs_add_skills_to_list', 'cs_add_skills_to_list');
}

/**
 * Start How to Package Education  in Candidate
 */
if (!function_exists('cs_candidate_education_list')) {

    function cs_candidate_education_list($user) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;

        $cs_get_edu_list = get_the_author_meta('cs_edu_list_array', $user->ID);
        $cs_edu_titles = get_the_author_meta('cs_edu_title_array', $user->ID);
        $cs_edu_from_dates = get_the_author_meta('cs_edu_from_date_array', $user->ID);
        $cs_edu_to_dates = get_the_author_meta('cs_edu_to_date_array', $user->ID);
        $cs_edu_institutes = get_the_author_meta('cs_edu_institute_array', $user->ID);
        $cs_edu_descs = get_the_author_meta('cs_edu_desc_array', $user->ID);
        $html = '
	<script>
		jQuery(document).ready(function($) {
                    $("#total_education_list").sortable({
                        cancel : \'td div.table-form-elem\'
                    });
		});
	</script>
	  <ul class="form-elements">
		<li class="to-button"><a href="javascript:cs_createpop(\'add_education\',\'filter\')" class="button">' . esc_html__("Add Education", "jobhunt") . '</a> </li>
	   </ul>
	  <div class="cs-list-table">
	  <table class="to-table" border="0" cellspacing="0">
		<thead>
		  <tr>
                    <th style="width:100%;">' . esc_html__("Title", "jobhunt") . '</th>
                    <th style="width:20%;" class="right">' . esc_html__("Actions", "jobhunt") . '</th>
		  </tr>
		</thead>
		<tbody id="total_education_list">';
        if (isset($cs_get_edu_list) && is_array($cs_get_edu_list) && count($cs_get_edu_list) > 0) {
            $cs_award_counter = 0;
            foreach ($cs_get_edu_list as $award_list) {
                if (isset($award_list) && $award_list <> '') {
                    $counter_extra_feature = $extra_feature_id = $award_list;
                    $cs_edu_title = isset($cs_edu_titles[$cs_award_counter]) ? $cs_edu_titles[$cs_award_counter] : '';
                    $cs_edu_from_date = isset($cs_edu_from_dates[$cs_award_counter]) ? $cs_edu_from_dates[$cs_award_counter] : '';
                    $cs_edu_to_date = isset($cs_edu_to_dates[$cs_award_counter]) ? $cs_edu_to_dates[$cs_award_counter] : '';
                    $cs_edu_institute = isset($cs_edu_institutes[$cs_award_counter]) ? $cs_edu_institutes[$cs_award_counter] : '';
                    $cs_edu_desc = isset($cs_edu_descs[$cs_award_counter]) ? $cs_edu_descs[$cs_award_counter] : '';
                    $ca_awards_array = array(
                        'counter_extra_feature' => $counter_extra_feature,
                        'extra_feature_id' => $extra_feature_id,
                        'cs_edu_title' => $cs_edu_title,
                        'cs_edu_from_date' => $cs_edu_from_date,
                        'cs_edu_to_date' => $cs_edu_to_date,
                        'cs_edu_institute' => $cs_edu_institute,
                        'cs_edu_desc' => $cs_edu_desc,
                    );
                    $html .= cs_add_education_to_list($ca_awards_array);
                }
                $cs_award_counter ++;
            }
        }
        $html .= '
		</tbody>
	  </table>	
	  </div>
	  </form>
	  <div id="add_education" style="display: none;">
		<div class="cs-heading-area">
		  <h5><i class="icon-plus-circle"></i> ' . esc_html__('Education Setting', 'jobhunt') . '</h5>
		  <span class="cs-btnclose" onClick="javascript:cs_remove_overlay(\'add_education\',\'append\')"> <i class="icon-times"></i></span> 	
		</div>';


        $cs_opt_array = array(
            'name' => esc_html__('Title', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'edu_title',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('From Date', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'edu_from_date',
                'format' => 'd-m-Y',
                'strtotime' => true,
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_date_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('To Date', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'edu_to_date',
                'format' => 'd-m-Y',
                'strtotime' => true,
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_date_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('Institute', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'edu_institute',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('Description', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'edu_desc',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_textarea_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => '&nbsp;',
            'desc' => '',
            'hint_text' => '',
            'field_params' => array(
                'std' => esc_html__('Add Education', 'jobhunt'),
                'id' => 'cs_add_edus',
                'cust_name' => '',
                'cust_type' => 'button',
                'extra_atr' => ' onClick="add_education_to_list(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(wp_jobhunt::plugin_url()) . '\')"',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $html .= '</div>';

        echo force_balance_tags($html, true);
    }

}

/**
 * Start How to Add Education List  in Candidate
 */
if (!function_exists('cs_add_education_to_list')) {

    function cs_add_education_to_list($cs_atts) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
        $cs_defaults = array(
            'counter_extra_feature' => '',
            'extra_feature_id' => '',
            'cs_edu_title' => '',
            'cs_edu_from_date' => '',
            'cs_edu_to_date' => '',
            'cs_edu_institute' => '',
            'cs_edu_desc' => '',
        );
        extract(shortcode_atts($cs_defaults, $cs_atts));
        foreach ($_POST as $keys => $values) {
            $$keys = $values;
        }
        if (isset($_POST['cs_edu_title']) && $_POST['cs_edu_title'] <> '')
            $cs_edu_title = $_POST['cs_edu_title'];
        if (isset($_POST['cs_edu_from_date']) && $_POST['cs_edu_from_date'] <> '')
            $cs_edu_from_date = $_POST['cs_edu_from_date'];
        if (isset($_POST['cs_edu_to_date']) && $_POST['cs_edu_to_date'] <> '')
            $cs_edu_to_date = $_POST['cs_edu_to_date'];
        if (isset($_POST['cs_edu_institute']) && $_POST['cs_edu_institute'] <> '')
            $cs_edu_institute = $_POST['cs_edu_institute'];
        if (isset($_POST['cs_edu_desc']) && $_POST['cs_edu_desc'] <> '')
            $cs_edu_desc = $_POST['cs_edu_desc'];

        if ($extra_feature_id == '' && $counter_extra_feature == '') {
            $counter_extra_feature = $extra_feature_id = time();
        }
        $html = '
                <tr class="parentdelete" id="edit_track' . esc_attr($extra_feature_id) . '">
                  <td id="subject-title' . esc_attr($extra_feature_id) . '" style="width:40%;">' . esc_attr($cs_edu_title) . '</td>				  
                  <td class="centr" style="width:20%;"><a href="javascript:cs_createpop(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
                  <td style="width:0"><div id="edit_track_form' . esc_attr($extra_feature_id) . '" style="display: none;" class="table-form-elem">';
        $cs_opt_array = array(
            'cust_id' => 'cs_edu_list_array',
            'cust_name' => 'cs_edu_list_array[]',
            'extra_atr' => ' data-type="option"',
            'std' => $extra_feature_id,
            'cust_type' => 'hidden',
            'return' => true,
        );
        $html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

        $html .= '
                      <div class="cs-heading-area">
                        <h5 style="text-align: left;">' . esc_html__('Education Settings', 'jobhunt') . '</h5>
                        <span onclick="javascript:cs_remove_overlay(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                        <div class="clear"></div>
                      </div>';

        $cs_opt_array = array(
            'name' => esc_html__('Title', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_edu_title,
                'id' => 'edu_title',
                'return' => true,
                'force_std' => true,
                'array' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('From Date', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_edu_from_date,
                'id' => 'edu_from_date',
                'format' => 'd-m-Y',
                'strtotime' => true,
                'return' => true,
                'force_std' => true,
                'array' => true,
            ),
        );

        $html .= $cs_html_fields->cs_date_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('To Date', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_edu_to_date,
                'id' => 'edu_to_date',
                'format' => 'd-m-Y',
                'strtotime' => true,
                'return' => true,
                'force_std' => true,
                'array' => true,
            ),
        );

        $html .= $cs_html_fields->cs_date_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('Institute', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_edu_institute,
                'id' => 'edu_institute',
                'return' => true,
                'force_std' => true,
                'array' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('Description', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_edu_desc,
                'id' => 'edu_desc',
                'return' => true,
                'array' => true,
            ),
        );

        $html .= $cs_html_fields->cs_textarea_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => '&nbsp;',
            'desc' => '',
            'hint_text' => '',
            'field_params' => array(
                'std' => esc_html__('Update Education', 'jobhunt'),
                'id' => 'cs_updtes_awardes',
                'cust_name' => '',
                'cust_type' => 'button',
                'extra_atr' => ' onclick="cs_remove_overlay(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'append\')"',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $html .= '</div></td>
                </tr>';

        if (isset($_POST['cs_edu_title']) && isset($_POST['cs_edu_from_date'])) {
            echo force_balance_tags($html);
        } else {
            return $html;
        }

        if (isset($_POST['cs_edu_title']) && isset($_POST['cs_edu_from_date']))
            die();
    }

    add_action('wp_ajax_cs_add_education_to_list', 'cs_add_education_to_list');
}

/**
 * Start How to Add experience_list  in Candidate
 */
if (!function_exists('cs_candidate_experience_list')) {

    function cs_candidate_experience_list($user) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
        $cs_get_exp_list = get_the_author_meta('cs_exp_list_array', $user->ID);
        $cs_exp_titles = get_the_author_meta('cs_exp_title_array', $user->ID);
        $cs_exp_from_dates = get_the_author_meta('cs_exp_from_date_array', $user->ID);
        $cs_exp_to_dates = get_the_author_meta('cs_exp_to_date_array', $user->ID);
        $cs_exp_companys = get_the_author_meta('cs_exp_company_array', $user->ID);
        $cs_exp_descs = get_the_author_meta('cs_exp_desc_array', $user->ID);
        $html = '
	<script>
		jQuery(document).ready(function($) {
                    $("#total_experience_list").sortable({
                    cancel : \'td div.table-form-elem\'
                    });
		});
	</script>
	  <ul class="form-elements">
		<li class="to-button"><a href="javascript:cs_createpop(\'add_experience\',\'filter\')" class="button">' . esc_html__("Add Experience", "jobhunt") . '</a> </li>
	   </ul>
	  <div class="cs-list-table">
	  <table class="to-table" border="0" cellspacing="0">
		<thead>
		  <tr>
			<th style="width:100%;">' . esc_html__("Title", "jobhunt") . '</th>
			<th style="width:20%;" class="right">' . esc_html__("Actions", "jobhunt") . '</th>
		  </tr>
		</thead>
		<tbody id="total_experience_list">';
        if (isset($cs_get_exp_list) && is_array($cs_get_exp_list) && count($cs_get_exp_list) > 0) {
            $cs_award_counter = 0;
            foreach ($cs_get_exp_list as $award_list) {
                if (isset($award_list) && $award_list <> '') {

                    $counter_extra_feature = $extra_feature_id = $award_list;
                    $cs_exp_title = isset($cs_exp_titles[$cs_award_counter]) ? $cs_exp_titles[$cs_award_counter] : '';
                    $cs_exp_from_date = isset($cs_exp_from_dates[$cs_award_counter]) ? $cs_exp_from_dates[$cs_award_counter] : '';
                    $cs_exp_to_date = isset($cs_exp_to_dates[$cs_award_counter]) ? $cs_exp_to_dates[$cs_award_counter] : '';
                    $cs_exp_company = isset($cs_exp_companys[$cs_award_counter]) ? $cs_exp_companys[$cs_award_counter] : '';
                    $cs_exp_desc = isset($cs_exp_descs[$cs_award_counter]) ? $cs_exp_descs[$cs_award_counter] : '';



                    $ca_awards_array = array(
                        'counter_extra_feature' => $counter_extra_feature,
                        'extra_feature_id' => $extra_feature_id,
                        'cs_exp_title' => $cs_exp_title,
                        'cs_exp_from_date' => $cs_exp_from_date,
                        'cs_exp_to_date' => $cs_exp_to_date,
                        'cs_exp_company' => $cs_exp_company,
                        'cs_exp_desc' => $cs_exp_desc,
                    );
                    $html .= cs_add_experience_to_list($ca_awards_array);
                }
                $cs_award_counter ++;
            }
        }
        $html .= '
		</tbody>
	  </table>
	
	  </div>
	  </form>
	  <div id="add_experience" style="display: none;">
		<div class="cs-heading-area">
		  <h5><i class="icon-plus-circle"></i> ' . esc_html__('Experience Setting', 'jobhunt') . '</h5>
		  <span class="cs-btnclose" onClick="javascript:cs_remove_overlay(\'add_experience\',\'append\')"> <i class="icon-times"></i></span> 	
		</div>';


        $cs_opt_array = array(
            'name' => esc_html__('Title', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'exp_title',
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('From Date', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'exp_from_date',
                'format' => 'd-m-Y',
                'strtotime' => true,
                'return' => true,
            ),
        );



        $html .= $cs_html_fields->cs_date_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('To Date', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'exp_to_date',
                'format' => 'd-m-Y',
                'strtotime' => true,
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_date_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('Company', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'exp_company',
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('Description', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => '',
                'id' => 'exp_desc',
                'return' => true,
            ),
        );

        $html .= $cs_html_fields->cs_textarea_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => '&nbsp;',
            'desc' => '',
            'hint_text' => '',
            'field_params' => array(
                'std' => esc_html__('Add Experience', 'jobhunt'),
                'id' => 'cs_add_exp_list',
                'cust_name' => '',
                'cust_type' => 'button',
                'extra_atr' => ' onClick="add_experience_to_list(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(wp_jobhunt::plugin_url()) . '\')"',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $html .= '
		</div>';

        echo force_balance_tags($html, true);
    }

}

/**
 * Start How to Add experience_list  in Candidate
 */
if (!function_exists('cs_add_experience_to_list')) {

    function cs_add_experience_to_list($cs_atts) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
        $cs_defaults = array(
            'counter_extra_feature' => '',
            'extra_feature_id' => '',
            'cs_exp_title' => '',
            'cs_exp_from_date' => '',
            'cs_exp_to_date' => '',
            'cs_exp_company' => '',
            'cs_exp_desc' => '',
        );
        extract(shortcode_atts($cs_defaults, $cs_atts));

        foreach ($_POST as $keys => $values) {
            $$keys = $values;
        }
        if (isset($_POST['cs_exp_title']) && $_POST['cs_exp_title'] <> '')
            $cs_exp_title = $_POST['cs_exp_title'];
        if (isset($_POST['cs_exp_from_date']) && $_POST['cs_exp_from_date'] <> '')
            $cs_exp_from_date = $_POST['cs_exp_from_date'];
        if (isset($_POST['cs_exp_to_date']) && $_POST['cs_exp_to_date'] <> '')
            $cs_exp_to_date = $_POST['cs_exp_to_date'];
        if (isset($_POST['cs_exp_company']) && $_POST['cs_exp_company'] <> '')
            $cs_exp_company = $_POST['cs_exp_company'];
        if (isset($_POST['cs_exp_desc']) && $_POST['cs_exp_desc'] <> '')
            $cs_exp_desc = $_POST['cs_exp_desc'];

        if ($extra_feature_id == '' && $counter_extra_feature == '') {
            $counter_extra_feature = $extra_feature_id = time();
        }
        $html = '<tr class="parentdelete" id="edit_track' . esc_attr($extra_feature_id) . '">
                  <td id="subject-title' . esc_attr($extra_feature_id) . '" style="width:40%;">' . esc_attr($cs_exp_title) . '</td>				  
                  <td class="centr" style="width:20%;"><a href="javascript:cs_createpop(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
                  <td style="width:0"><div id="edit_track_form' . esc_attr($extra_feature_id) . '" style="display: none;" class="table-form-elem">';

        $cs_opt_array = array(
            'cust_id' => 'cs_exp_list_array',
            'cust_name' => 'cs_exp_list_array[]',
            'extra_atr' => ' data-type="option"',
            'std' => $extra_feature_id,
            'cust_type' => 'hidden',
            'return' => true,
        );
        $html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

        $html .= '
                      <div class="cs-heading-area">
                        <h5 style="text-align: left;">' . esc_html__('Experience Settings', 'jobhunt') . '</h5>
                        <span onclick="javascript:cs_remove_overlay(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                        <div class="clear"></div>
                      </div>';


        $cs_opt_array = array(
            'name' => esc_html__('Title', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_exp_title,
                'id' => 'exp_title',
                'return' => true,
                'array' => true,
                'force_std' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('From Date', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_exp_from_date,
                'id' => 'exp_from_date',
                'format' => 'd-m-Y',
                'strtotime' => true,
                'force_std' => true,
                'return' => true,
                'array' => true,
            ),
        );

        $html .= $cs_html_fields->cs_date_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => esc_html__('To Date', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_exp_to_date,
                'id' => 'exp_to_date',
                'format' => 'd-m-Y',
                'strtotime' => true,
                'force_std' => true,
                'return' => true,
                'array' => true,
            ),
        );

        $html .= $cs_html_fields->cs_date_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('Company', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_exp_company,
                'id' => 'exp_company',
                'return' => true,
                'array' => true,
                'force_std' => true,
            ),
        );

        $html .= $cs_html_fields->cs_text_field($cs_opt_array);


        $cs_opt_array = array(
            'name' => esc_html__('Description', 'jobhunt'),
            'desc' => '',
            'hint_text' => '',
            'echo' => false,
            'field_params' => array(
                'std' => $cs_exp_desc,
                'id' => 'exp_desc',
                'return' => true,
                'array' => true,
                'force_std' => true,
            ),
        );

        $html .= $cs_html_fields->cs_textarea_field($cs_opt_array);

        $cs_opt_array = array(
            'name' => '&nbsp;',
            'desc' => '',
            'hint_text' => '',
            'field_params' => array(
                'std' => esc_html__('Update Experience', 'jobhunt'),
                'id' => 'updt_exper',
                'cust_name' => '',
                'cust_type' => 'button',
                'extra_atr' => ' onclick="cs_remove_overlay(\'edit_track_form' . esc_js($extra_feature_id) . '\',\'append\')"',
                'return' => true,
            ),
        );
        $html .= $cs_html_fields->cs_text_field($cs_opt_array);

        $html .= '
                </div></td>
                </tr>';
        if (isset($_POST['cs_exp_title']) && isset($_POST['cs_exp_from_date'])) {
            echo force_balance_tags($html);
        } else {
            return $html;
        }
        if (isset($_POST['cs_exp_title']) && isset($_POST['cs_exp_from_date']))
            die();
    }

    add_action('wp_ajax_cs_add_experience_to_list', 'cs_add_experience_to_list');
}

/**
 * Start How to Add cvcover_letter  in Candidate
 */
if (!function_exists('cs_candidate_cvcover_letter')) {

    function cs_candidate_cvcover_letter($user) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
        ?>
        <section class="cs-cover-letter">
            <?php
            $cs_opt_array = array(
                'name' => esc_html__('Cover Letter', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'usermeta' => true,
                    'user' => $user,
                    'std' => '',
                    'id' => 'cover_letter',
                    'return' => true,
                ),
            );

            $cs_html_fields->cs_textarea_field($cs_opt_array);
            $cs_opt_array = array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'candidate_cv',
                'name' => esc_html__('Upload Real Cv', 'jobhunt'),
                'desc' => '',
                'dp' => true,
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'usermeta' => true,
                    'user' => $user,
                    'std' => '',
                    'id' => 'candidate_cv',
                    'return' => true,
                ),
            );

            $cs_html_fields->cs_upload_cv_file_field($cs_opt_array);
            do_action('jobhunt_cv_fields_admin', $user);
            ?>

        </section>
        <?php
    }

}

/**
 * Start How to candidate_custom_fields in Candidate
 */
if (!function_exists('cs_candidate_profile_custom_fields')) {

    function cs_candidate_profile_custom_fields($user) {
        global $post, $cs_form_fields, $cs_form_fields2, $cs_html_fields, $cs_plugin_options;
        $cs_candidate_cus_fields = get_option("cs_candidate_cus_fields");
        if (is_array($cs_candidate_cus_fields) && sizeof($cs_candidate_cus_fields) > 0) {
            foreach ($cs_candidate_cus_fields as $cus_field) {
                $cs_type = isset($cus_field['type']) ? $cus_field['type'] : '';
                switch ($cs_type) {
                    case('text'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_text_field($cs_opt_array);
                        }
                        break;
                    case('textarea'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_textarea_field($cs_opt_array);
                        }
                        break;
                    case('dropdown'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_options = array();
                            if (isset($cus_field['options']['value']) && is_array($cus_field['options']['value']) && sizeof($cus_field['options']['value']) > 0) {
                                if (isset($cus_field['first_value']) && $cus_field['first_value'] != '') {
                                    $cs_options[''] = $cus_field['first_value'];
                                }
                                $cs_opt_counter = 0;
                                foreach ($cus_field['options']['value'] as $cs_option) {

                                    $cs_opt_label = $cus_field['options']['label'][$cs_opt_counter];
                                    $cs_options[$cs_option] = $cs_opt_label;
                                    $cs_opt_counter ++;
                                }
                            }

                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'options' => $cs_options,
                                    'cus_field' => true,
                                    'return' => true,
                                    'classes' => 'dropdown chosen-select-no-single select-medium',
                                ),
                            );

                            if (isset($cus_field['post_multi']) && $cus_field['post_multi'] == 'yes') {
                                $cs_opt_array['multi'] = true;
                            }

                            $cs_html_fields->cs_select_field($cs_opt_array);
                        }
                        break;
                    case('date'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_format = isset($cus_field['date_format']) && $cus_field['date_format'] != '' ? $cus_field['date_format'] : 'd-m-Y';

                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'format' => $cs_format,
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_date_field($cs_opt_array);
                        }
                        break;
                    case('email'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_text_field($cs_opt_array);
                        }
                        break;
                    case('url'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {

                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_text_field($cs_opt_array);
                        }
                        break;
                    case('range'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_text_field($cs_opt_array);
                        }
                        break;
                }
            }
        }
    }

}

/**
 * Start Function How to create Employer Custiom Fields
 */
if (!function_exists('cs_employer_profile_custom_fields')) {

    function cs_employer_profile_custom_fields($user) {
        global $cs_form_fields, $cs_html_fields;
        $cs_employer_cus_fields = get_option("cs_employer_cus_fields");
        if (is_array($cs_employer_cus_fields) && sizeof($cs_employer_cus_fields) > 0) {
            foreach ($cs_employer_cus_fields as $cus_field) {
                $cs_type = isset($cus_field['type']) ? $cus_field['type'] : '';
                switch ($cs_type) {
                    case('text'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_text_field($cs_opt_array);
                        }
                        break;
                    case('textarea'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_textarea_field($cs_opt_array);
                        }
                        break;
                    case('dropdown'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_options = array();
                            if (isset($cus_field['options']['value']) && is_array($cus_field['options']['value']) && sizeof($cus_field['options']['value']) > 0) {
                                if (isset($cus_field['first_value']) && $cus_field['first_value'] != '') {
                                    $cs_options[''] = $cus_field['first_value'];
                                }
                                $cs_opt_counter = 0;
                                foreach ($cus_field['options']['value'] as $cs_option) {

                                    $cs_opt_label = $cus_field['options']['label'][$cs_opt_counter];
                                    $cs_options[$cs_option] = $cs_opt_label;
                                    $cs_opt_counter ++;
                                }
                            }

                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'options' => $cs_options,
                                    'cus_field' => true,
                                    'classes' => 'dropdown chosen-select-no-single select-medium',
                                    'return' => true,
                                ),
                            );

                            if (isset($cus_field['post_multi']) && $cus_field['post_multi'] == 'yes') {
                                $cs_opt_array['multi'] = true;
                            }

                            $cs_html_fields->cs_select_field($cs_opt_array);
                        }
                        break;
                    case('date'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_format = isset($cus_field['date_format']) && $cus_field['date_format'] != '' ? $cus_field['date_format'] : 'd-m-Y';

                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'format' => $cs_format,
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_date_field($cs_opt_array);
                        }
                        break;
                    case('email'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_text_field($cs_opt_array);
                        }
                        break;
                    case('url'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {

                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_text_field($cs_opt_array);
                        }
                        break;
                    case('range'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $cs_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_text_field($cs_opt_array);
                        }
                        break;
                }
            }
        }
    }

}