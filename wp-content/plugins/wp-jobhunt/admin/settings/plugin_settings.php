<?php

/**
 *  File Type: Settings Class
 */
if (!class_exists('cs_plugin_options')) {

    class cs_plugin_options {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            add_action('wp_ajax_cs_add_extra_feature_to_list', array(&$this, 'cs_add_extra_feature_to_list'));
            add_action('wp_ajax_cs_add_feats_to_list', array(&$this, 'cs_add_feats_to_list'));
            add_action('wp_ajax_cs_add_safetytext_to_list', array(&$this, 'cs_add_safetytext_to_list'));
            add_action('wp_ajax_cs_add_package_to_list', array(&$this, 'cs_add_package_to_list'));
            add_action('wp_ajax_cs_add_cv_pkg_to_list', array(&$this, 'cs_add_cv_pkg_to_list'));
        }

        /**
         * End Contructer Function
         */

        /**
         * Start Function how to register setting in admin submenu page
         */
        public function cs_register_jobunt_settings() {
            //add submenu page
            add_submenu_page('edit.php?post_type=jobs', esc_html__('Settings', 'jobhunt'), esc_html__('Settings', 'jobhunt'), 'manage_options', 'cs_settings', array(&$this, 'cs_settings'));
        }

        /**
         * End Function how to register setting in admin submenu page
         */

        /**
         * Start Function how to call setting function
         */
        public function cs_settings() {
            // initialize settings array 
            cs_settings_option();

            cs_settings_options_page();
        }

        /**
         * end Function how to call setting function
         */

        /**
         * Start Function how to create package section
         */
        public function cs_packages_section() {
            global $post, $cs_form_fields2, $package_id, $counter_package, $package_title, $package_price, $package_duration, $package_no_ads, $package_description, $cs_package_type, $package_listings, $package_cvs, $package_submission_limit, $package_duration_period, $package_featured_ads, $cs_list_dur, $package_feature, $cs_html_fields, $cs_plugin_options;
            $cs_plugin_options = get_option('cs_plugin_options');
            if (isset($cs_plugin_options['cs_packages_options']) && $cs_plugin_options['cs_packages_options'] != '') {
                $cs_packages_options = $cs_plugin_options['cs_packages_options'];
            } else {
                $cs_packages_options = '';
            }
            $currency_sign = jobcareer_get_currency_sign();
            $cs_free_package_switch = get_option('cs_free_package_switch');
            $cd_checked = '';
            if (isset($cs_free_package_switch) && $cs_free_package_switch == 'on') {
                $cd_checked = 'checked';
            }
            $cs_opt_array = array(
                'id' => '',
                'std' => '1',
                'cust_id' => "",
                'cust_name' => "dynamic_directory_package",
                'return' => true,
            );


            $cs_html = $cs_form_fields2->cs_form_hidden_render($cs_opt_array) . '
                
                <script>
                    jQuery(document).ready(function($) {
                        jQuery("#total_packages").sortable({
                            cancel : \'td div.table-form-elem\'
                        });
                    });
                </script>';
            $cs_html .= '<div class="form-elements" id="safetysafe_switch_add_package">
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<a href="javascript:cs_createpop(\'add_package_title\',\'filter\')" class="button button_style">' . esc_html__('Add Package', 'jobhunt') . '</a>
					</div>
				</div>';
            $cs_html .= '<div class="cs-list-table">
              <table class="to-table" border="0" cellspacing="0">
                <thead>
                  <tr>
                    <th style="width:80%;">' . esc_html__('Title', 'jobhunt') . '</th>
                    <th style="width:80%;" class="centr">' . esc_html__('Actions', 'jobhunt') . '</th>
                    <th style="width:0%;" class="centr"></th>
                  </tr>
                </thead>
                <tbody id="total_packages">';
            if (isset($cs_packages_options) && is_array($cs_packages_options) && count($cs_packages_options) > 0) {
                foreach ($cs_packages_options as $package_key => $package) {
                    if (isset($package_key) && $package_key <> '') {
                        $counter_package = $package_id = isset($package['package_id']) ? $package['package_id'] : '';
                        $package_title = isset($package['package_title']) ? $package['package_title'] : '';
                        $package_price = isset($package['package_price']) ? $package['package_price'] : '';
                        $package_duration = isset($package['package_duration']) ? $package['package_duration'] : '';
                        $package_description = isset($package['package_description']) ? $package['package_description'] : '';
                        $cs_package_type = isset($package['package_type']) ? $package['package_type'] : '';
                        $package_listings = isset($package['package_listings']) ? $package['package_listings'] : '';
                        $package_cvs = isset($package['package_cvs']) ? $package['package_cvs'] : '';
                        $package_submission_limit = isset($package['package_submission_limit']) ? $package['package_submission_limit'] : '';
                        $package_duration_period = isset($package['package_duration_period']) ? $package['package_duration_period'] : '';
                        $cs_list_dur = isset($package['cs_list_dur']) ? $package['cs_list_dur'] : '';
                        $package_feature = isset($package['package_feature']) ? $package['package_feature'] : '';
                        $package_featured_ads = isset($package['package_featured_ads']) ? $package['package_featured_ads'] : '';
                        apply_filters('jobhunt_package_post_limit_package_section', $package);
                        $cs_html .= $this->cs_add_package_to_list();
                    }
                }
            }
            $cs_html .= '</tbody>
              </table>
              </div>
              </form>
              <div id="add_package_title" style="display: none;">
                <div class="cs-heading-area">
                  <h5> <i class="icon-plus-circle"></i> ' . esc_html__('Package Settings', 'jobhunt') . ' </h5>
                  <span class="cs-btnclose" onClick="javascript:cs_remove_overlay(\'add_package_title\',\'append\')"> <i class="icon-times"></i></span> </div>';

            $cs_opt_array = array(
                'name' => esc_html__('Package Title', 'jobhunt'),
                'desc' => '',
                'hint_text' => esc_html__("Enter title here.", "jobhunt"),
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_title',
                    'cust_name' => 'package_title',
                    'return' => true,
                ),
            );

            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);


            $cs_opt_array = array(
                'name' => esc_html__('Price', 'jobhunt') . CS_FUNCTIONS()->cs_special_chars($currency_sign),
                'desc' => '',
                'hint_text' => esc_html__("Enter price here.", "jobhunt"),
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_price',
                    'cust_name' => 'package_price',
                    'return' => true,
                ),
            );

            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);



            $cs_opt_array = array(
                'name' => esc_html__('Package Type', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'id' => 'package_type',
                    'cust_name' => 'package_type',
                    'options' => array(
                        'single' => esc_html__('Single Submission', 'jobhunt'),
                        'subscription' => esc_html__('Subscription', 'jobhunt'),
                    ),
                    'return' => true,
                    'onclick' => 'cs_package_type_toogle(this.value, \'\')',
                    'classes' => 'chosen-select-no-single'
                ),
            );


            $cs_html .= $cs_html_fields->cs_select_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('No of Listings in Package', 'jobhunt'),
                'desc' => '',
                'id' => 'package_listings_con',
                'hint_text' => '',
                'extra_atr' => 'style="display:none;"',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'id' => '',
                    'cust_id' => 'package_listings',
                    'cust_name' => 'package_listings',
                    'return' => true,
                ),
            );

            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);


            // hide attribute		
            $cs_opt_array = array(
                'name' => esc_html__('No of CV\'s', 'jobhunt'),
                'desc' => '',
                'id' => '',
                'hint_text' => '',
                'styles' => 'display:none',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'id' => '',
                    'cust_id' => 'package_cvs',
                    'cust_name' => 'package_cvs',
                    'return' => true,
                ),
            );

            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('Package Expiry', 'jobhunt'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_id' => 'package_duration',
                            'cust_name' => 'package_duration',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'package_duration_period',
                            'cust_name' => 'package_duration_period',
                            'classes' => 'chosen-select-no-single',
                            'div_classes' => 'select-small',
                            'return' => true,
                            'options' => array(
                                'days' => esc_html__('Days', 'jobhunt'),
                                'months' => esc_html__('Months', 'jobhunt'),
                                'years' => esc_html__('Years', 'jobhunt'),
                            ),
                        ),
                    ),
                ),
            );
            $cs_html .= $cs_html_fields->cs_multi_fields($cs_opt_array);
            $cs_packg_field = '';
            $cs_packg_field = apply_filters('jobhunt_add_package_field', $cs_packg_field);
            $cs_html .= $cs_packg_field;

            $cs_opt_array = array(
                'name' => esc_html__('Listings Expiry', 'jobhunt'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_id' => 'package_submission_limit',
                            'cust_name' => 'package_submission_limit',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'cs_list_dur',
                            'cust_name' => 'cs_list_dur',
                            'classes' => 'chosen-select-no-single',
                            'return' => true,
                            'div_classes' => 'select-small',
                            'options' => array(
                                'days' => esc_html__('Days', 'jobhunt'),
                                'months' => esc_html__('Months', 'jobhunt'),
                                'years' => esc_html__('Years', 'jobhunt'),
                            ),
                        ),
                    ),
                ),
            );
            //$cs_html .= $cs_html_fields->cs_multi_fields($cs_opt_array);
            $updated_data = $cs_html_fields->cs_multi_fields($cs_opt_array);
            $updated_data = apply_filters('jobhunt_add_package_update_field', $updated_data, $counter_package);
            $cs_html .= $updated_data;


            $cs_opt_array = array(
                'name' => esc_html__('Package Featured', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_feature',
                    'cust_name' => 'package_feature',
                    'options' => array(
                        'no' => esc_html__('No', 'jobhunt'),
                        'yes' => esc_html__('Yes', 'jobhunt'),
                    ),
                    'return' => true,
                    'classes' => 'chosen-select-no-single'
                ),
            );
            $cs_html .= $cs_html_fields->cs_select_field($cs_opt_array);
            $cs_opt_array = array(
                'name' => esc_html__('Description', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_description',
                    'cust_name' => 'package_description',
                    'return' => true,
                ),
            );
            $cs_html .= $cs_html_fields->cs_textarea_field($cs_opt_array);
            $cs_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_html__('Add Package to List', 'jobhunt'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'after' => '<div class="package-loader"></div>',
                    'cust_type' => 'button',
                    'extra_atr' => 'onClick="add_package_to_list(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(wp_jobhunt::plugin_url()) . '\')" ',
                ),
            );
            $submit_button = $cs_html_fields->cs_text_field($cs_opt_array);
            $submit_button = apply_filters('jobhunt_add_package_submit_field', $submit_button);
            $cs_html .= $submit_button;
            $cs_html .= '</div>';
            return $cs_html;
        }

        /**
         * end Function how to create package section
         */

        /**
         * Start Function how to add package in list section
         */
        public function cs_add_package_to_list() {
            global $counter_package, $cs_form_fields2, $package_id, $package_title, $package_price, $package_duration, $package_description, $cs_package_type, $package_listings, $package_cvs, $package_submission_limit, $cs_list_dur, $package_duration_period, $package_featured_ads, $package_feature, $cs_html_fields, $cs_plugin_options;
            foreach ($_POST as $keys => $values) {
                $$keys = $values;
            }
            if (isset($_POST['package_title']) && $_POST['package_title'] <> '') {
                $package_id = time();
            }
            if (empty($package_id)) {
                $package_id = $counter_package;
            }
            $currency_sign = jobcareer_get_currency_sign();

            $cs_opt_array = array(
                'id' => '',
                'std' => absint($package_id),
                'cust_id' => "",
                'cust_name' => "package_id_array[]",
                'return' => true,
            );
            $cs_html = '
            <tr class="parentdelete" id="edit_track' . esc_attr($counter_package) . '">
              <td id="subject-title' . esc_attr($counter_package) . '" style="width:100%;">' . esc_attr($package_title) . '</td>
              <td class="centr" style="width:20%;"><a href="javascript:cs_createpop(\'edit_track_form' . esc_js($counter_package) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
              <td style="width:0"><div id="edit_track_form' . esc_attr($counter_package) . '" style="display: none;" class="table-form-elem">
                  ' . $cs_form_fields2->cs_form_hidden_render($cs_opt_array) . '
                  <div class="cs-heading-area">
                    <h5 style="text-align: left;"> ' . esc_html__('Package Settings', 'jobhunt') . '</h5>
                    <span onclick="javascript:cs_remove_overlay(\'edit_track_form' . esc_js($counter_package) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                    <div class="clear"></div>
                  </div>';
            $cs_opt_array = array(
                'name' => esc_html__('Package Title', 'jobhunt'),
                'desc' => '',
                'hint_text' => esc_html__("Enter title here.", "jobhunt"),
                'echo' => false,
                'field_params' => array(
                    'std' => htmlspecialchars($package_title),
                    'cust_id' => 'package_title' . esc_attr($counter_package),
                    'cust_name' => 'package_title_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );

            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);


            $cs_opt_array = array(
                'name' => esc_html__('Price edit', 'jobhunt') . CS_FUNCTIONS()->cs_special_chars($currency_sign),
                'desc' => '',
                'hint_text' => esc_html__("Enter price here.", "jobhunt"),
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_price),
                    'cust_id' => 'package_price' . esc_attr($counter_package),
                    'cust_name' => 'package_price_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );

            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);



            $cs_opt_array = array(
                'name' => esc_html__('Package Type', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => $cs_package_type,
                    'id' => 'cs_package_type' . esc_attr($counter_package),
                    'cust_name' => 'package_type_array[]',
                    'options' => array(
                        'single' => esc_html__('Single Submission', 'jobhunt'),
                        'subscription' => esc_html__('Subscription', 'jobhunt'),
                    ),
                    'return' => true,
                    'onclick' => 'cs_package_type_toogle(this.value, \'' . esc_attr($counter_package) . '\')',
                    'classes' => 'chosen-select-no-single',
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $cs_html .= $cs_html_fields->cs_select_field($cs_opt_array);



            $cs_opt_array = array(
                'name' => esc_html__('No of Listings in Package', 'jobhunt'),
                'desc' => '',
                'id' => 'package_listings_con' . esc_attr($counter_package),
                'hint_text' => '',
                'extra_atr' => 'style="display:' . esc_attr($cs_package_type == 'subscription' ? 'block' : 'none') . '"',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_listings),
                    'id' => '',
                    'cust_id' => 'package_listings' . esc_attr($counter_package),
                    'cust_name' => 'package_listings_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('No of CV\'s', 'jobhunt'),
                'desc' => '',
                'id' => '',
                'hint_text' => '',
                'styles' => 'display:none',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_cvs),
                    'id' => '',
                    'cust_id' => 'package_cvs' . esc_attr($counter_package),
                    'cust_name' => 'package_cvs_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );

            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('Package Expiry', 'jobhunt'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => esc_attr($package_duration),
                            'id' => '',
                            'cust_id' => 'package_duration' . esc_attr($counter_package),
                            'cust_name' => 'package_duration_array[]',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => esc_attr($package_duration_period),
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'package_duration_period' . esc_attr($counter_package),
                            'cust_name' => 'package_duration_period_array[]',
                            'classes' => 'chosen-select-no-single',
                            'div_classes' => 'select-small',
                            'options' => array(
                                'days' => esc_html__('Days', 'jobhunt'),
                                'months' => esc_html__('Months', 'jobhunt'),
                                'years' => esc_html__('Years', 'jobhunt'),
                            ),
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                ),
            );
            $cs_html .= $cs_html_fields->cs_multi_fields($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('Listings Expiry', 'jobhunt'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => esc_attr($package_submission_limit),
                            'id' => '',
                            'cust_id' => 'package_submission_limit' . esc_attr($counter_package),
                            'cust_name' => 'package_submission_limit_array[]',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => esc_attr($cs_list_dur),
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'cs_list_dur' . esc_attr($counter_package),
                            'cust_name' => 'cs_list_dur_array[]',
                            'classes' => 'chosen-select-no-single',
                            'div_classes' => 'select-small',
                            'options' => array(
                                'days' => esc_html__('Days', 'jobhunt'),
                                'months' => esc_html__('Months', 'jobhunt'),
                                'years' => esc_html__('Years', 'jobhunt'),
                            ),
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                ),
            );


            $cs_html .= $cs_html_fields->cs_multi_fields($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('Package Featured', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => $package_feature,
                    'cust_id' => 'package_feature' . esc_attr($counter_package),
                    'cust_name' => 'package_feature_array[]',
                    'options' => array(
                        'no' => esc_html__('No', 'jobhunt'),
                        'yes' => esc_html__('Yes', 'jobhunt'),
                    ),
                    'classes' => 'chosen-select-no-single',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $cs_html .= $cs_html_fields->cs_select_field($cs_opt_array);



            $cs_opt_array = array(
                'name' => esc_html__('Description', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_description),
                    'cust_id' => 'package_description' . esc_attr($counter_package),
                    'cust_name' => 'package_description_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $cs_html .= $cs_html_fields->cs_textarea_field($cs_opt_array);
            $cs_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_html__('Update Package', 'jobhunt'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'cust_type' => 'button',
                    'extra_atr' => 'onclick="update_title(' . esc_js($counter_package) . '); cs_remove_overlay(\'edit_track_form' . esc_js($counter_package) . '\',\'append\')"',
                ),
            );
            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);
            $cs_html .= '
                </div></td>
            </tr>';
            if (isset($_POST['package_title'])) {
                echo force_balance_tags($cs_html);
                die();
            } else {
                return $cs_html;
            }
        }

        /**
         * end Function how to add package in list section
         */

        /**
         * Start Function how to create cv package section
         */
        public function cs_cv_pkgs_section() {
            global $post, $cv_pkg_id, $cs_form_fields2, $cs_html_fields, $counter_cv_pkg, $cv_pkg_title, $cv_pkg_price, $cv_pkg_dur, $cv_pkg_desc, $cv_pkg_cvs, $cv_pkg_dur_period, $cs_plugin_options;
            $cs_plugin_options = get_option('cs_plugin_options');
            $cs_cv_pkgs_options = isset($cs_plugin_options['cs_cv_pkgs_options']) ? $cs_plugin_options['cs_cv_pkgs_options'] : '';
            $currency_sign = jobcareer_get_currency_sign();
            $cs_opt_array = array(
                'id' => '',
                'std' => "1",
                'cust_id' => "",
                'cust_name' => "dynamic_directory_cv_pkg",
                'return' => true,
            );
            $cs_html = $cs_form_fields2->cs_form_hidden_render($cs_opt_array) . '
                <script>
                jQuery(document).ready(function($) {
                    jQuery("#total_cv_pkgs").sortable({
                        cancel : \'td div.table-form-elem\'
                    });
                });
                </script>';
            $cs_html .= '<div class="form-elements" id="safetysafe_switch_add_package_cv">
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
					<a href="javascript:cs_createpop(\'add_cv_pkg_title\',\'filter\')" class="button button_style">' . esc_html__('Add Package', 'jobhunt') . '</a>
				</div>
			</div>';

            $cs_html .= '<div class="cs-list-table">
              <table class="to-table" border="0" cellspacing="0">
                <thead>
                  <tr>
                    <th style="width:80%;">' . esc_html__('Title', 'jobhunt') . '</th>
                    <th style="width:80%;" class="centr">' . esc_html__('Actions', 'jobhunt') . '</th>
                    <th style="width:0%;" class="centr"></th>
                  </tr>
                </thead>
                <tbody id="total_cv_pkgs">';
            if (isset($cs_cv_pkgs_options) && is_array($cs_cv_pkgs_options) && count($cs_cv_pkgs_options) > 0) {
                foreach ($cs_cv_pkgs_options as $cv_pkg_key => $cv_pkg) {
                    if (isset($cv_pkg_key) && $cv_pkg_key <> '') {
                        $counter_cv_pkg = $cv_pkg_id = isset($cv_pkg['cv_pkg_id']) ? $cv_pkg['cv_pkg_id'] : '';
                        $cv_pkg_title = isset($cv_pkg['cv_pkg_title']) ? $cv_pkg['cv_pkg_title'] : '';
                        $cv_pkg_price = isset($cv_pkg['cv_pkg_price']) ? $cv_pkg['cv_pkg_price'] : '';
                        $cv_pkg_desc = isset($cv_pkg['cv_pkg_desc']) ? $cv_pkg['cv_pkg_desc'] : '';
                        $cv_pkg_cvs = isset($cv_pkg['cv_pkg_cvs']) ? $cv_pkg['cv_pkg_cvs'] : '';
                        $cv_pkg_dur = isset($cv_pkg['cv_pkg_dur']) ? $cv_pkg['cv_pkg_dur'] : '';
                        $cv_pkg_dur_period = isset($cv_pkg['cv_pkg_dur_period']) ? $cv_pkg['cv_pkg_dur_period'] : '';
                        $cs_html .= $this->cs_add_cv_pkg_to_list();
                    }
                }
            }
            $cs_html .= '
                </tbody>
              </table>
              </div>
              </form>
              <div id="add_cv_pkg_title" style="display: none;">
                <div class="cs-heading-area">
                  <h5> <i class="icon-plus-circle"></i> ' . esc_html__('Package Settings', 'jobhunt') . ' </h5>
                  <span class="cs-btnclose" onClick="javascript:cs_remove_overlay(\'add_cv_pkg_title\',\'append\')"> <i class="icon-times"></i></span> </div>';
            $cs_opt_array = array(
                'name' => esc_html__('Title', 'jobhunt'),
                'desc' => '',
                'hint_text' => esc_html__("Enter Title here.", "jobhunt"),
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'cv_pkg_title',
                    'cust_name' => 'cv_pkg_title',
                    'return' => true,
                ),
            );
            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('Price', 'jobhunt') . CS_FUNCTIONS()->cs_special_chars($currency_sign),
                'desc' => '',
                'hint_text' => esc_html__("Enter Price here.", "jobhunt"),
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'cv_pkg_price',
                    'cust_name' => 'cv_pkg_price',
                    'return' => true,
                ),
            );

            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('No of CV\'s', 'jobhunt'),
                'desc' => '',
                'id' => 'cv_pkg_listings_con',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'cv_pkg_cvs',
                    'cust_name' => 'cv_pkg_cvs',
                    'return' => true,
                ),
            );
            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('Package Expiry', 'jobhunt'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_id' => 'cv_pkg_dur',
                            'cust_name' => 'cv_pkg_dur',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => '',
                            'id' => 'map_search_btn',
                            'cust_type' => '',
                            'cust_id' => 'cv_pkg_dur_period',
                            'cust_name' => 'cv_pkg_dur_period',
                            'classes' => 'chosen-select-no-single',
                            'div_classes' => 'select-small',
                            'return' => true,
                            'options' => array(
                                'days' => esc_html__('Days', 'jobhunt'),
                                'months' => esc_html__('Months', 'jobhunt'),
                                'years' => esc_html__('Years', 'jobhunt'),
                            ),
                        ),
                    ),
                ),
            );


            $cs_html .= $cs_html_fields->cs_multi_fields($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('Description', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'cv_pkg_desc',
                    'cust_name' => 'cv_pkg_desc',
                    'return' => true,
                ),
            );
            $cs_html .= $cs_html_fields->cs_textarea_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_html__('Add Package to List', 'jobhunt'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'cust_type' => 'button',
                    'after' => '<div class="cv_pkg-loader"></div>',
                    'extra_atr' => 'onClick="add_cv_pkg_to_list(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(wp_jobhunt::plugin_url()) . '\')" ',
                ),
            );
            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);

            $cs_html .= '
              </div>';
            return $cs_html;
        }

        /**
         * end Function how to create cv package section
         */

        /**
         * Start Function how to add data in package section
         */
        public function cs_add_cv_pkg_to_list() {
            global $post, $cv_pkg_id, $cs_form_fields2, $counter_cv_pkg, $cs_html_fields, $cv_pkg_title, $cv_pkg_price, $cv_pkg_dur, $cv_pkg_desc, $cv_pkg_cvs, $cv_pkg_dur_period, $cs_plugin_options;
            foreach ($_POST as $keys => $values) {
                $$keys = $values;
            }
            if (isset($_POST['cv_pkg_title']) && $_POST['cv_pkg_title'] <> '') {
                $cv_pkg_id = time();
            }
            if (empty($cv_pkg_id)) {
                $cv_pkg_id = $counter_cv_pkg;
            }
            $currency_sign = jobcareer_get_currency_sign();
            $cs_opt_array = array(
                'id' => '',
                'std' => absint($cv_pkg_id),
                'cust_id' => '',
                'cust_name' => "cv_pkg_id_array[]",
                'return' => true,
            );

            $cs_html = '
            <tr class="parentdelete" id="edit_track' . esc_attr($counter_cv_pkg) . '">
              <td id="subject-title' . esc_attr($counter_cv_pkg) . '" style="width:100%;">' . esc_attr($cv_pkg_title) . '</td>
              <td class="centr" style="width:20%;"><a href="javascript:cs_createpop(\'edit_track_form' . esc_js($counter_cv_pkg) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
              <td style="width:0"><div id="edit_track_form' . esc_attr($counter_cv_pkg) . '" style="display: none;" class="table-form-elem">
                  ' . $cs_form_fields2->cs_form_hidden_render($cs_opt_array) . '
                  <div class="cs-heading-area">
                    <h5 style="text-align: left;"> ' . esc_html__('Package Settings', 'jobhunt') . '</h5>
                    <span onclick="javascript:cs_remove_overlay(\'edit_track_form' . esc_js($counter_cv_pkg) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                    <div class="clear"></div>
                  </div>';


            $cs_opt_array = array(
                'name' => esc_html__('Package Title', 'jobhunt'),
                'desc' => '',
                'hint_text' => esc_html__("Enter Package Title here.", "jobhunt"),
                'echo' => false,
                'field_params' => array(
                    'std' => htmlspecialchars($cv_pkg_title),
                    'cust_id' => 'cv_pkg_title' . esc_attr($counter_cv_pkg),
                    'cust_name' => 'cv_pkg_title_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true
                ),
            );

            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);


            $cs_opt_array = array(
                'name' => esc_html__('Price', 'jobhunt') . CS_FUNCTIONS()->cs_special_chars($currency_sign),
                'desc' => '',
                'hint_text' => esc_html__("Enter Price here.", "jobhunt"),
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($cv_pkg_price),
                    'cust_id' => 'cv_pkg_price' . esc_attr($counter_cv_pkg),
                    'cust_name' => 'cv_pkg_price_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true
                ),
            );

            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);



            $cs_opt_array = array(
                'name' => esc_html__('No of CV\'s', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($cv_pkg_cvs),
                    'cust_id' => 'cv_pkg_cvs' . esc_attr($counter_cv_pkg),
                    'cust_name' => 'cv_pkg_cvs_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true
                ),
            );

            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('Package Expiry', 'jobhunt'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => esc_attr($cv_pkg_dur),
                            'id' => '',
                            'cust_id' => 'cv_pkg_dur' . esc_attr($counter_cv_pkg),
                            'cust_name' => 'cv_pkg_dur_array[]',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                            'array' => true,
                            'force_std' => true
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => $cv_pkg_dur_period,
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'cv_pkg_dur_period' . esc_attr($counter_cv_pkg),
                            'cust_name' => 'cv_pkg_dur_period_array[]',
                            'classes' => 'chosen-select-no-single',
                            'return' => true,
                            'div_classes' => 'select-small',
                            'options' => array(
                                'days' => esc_html__('Days', 'jobhunt'),
                                'months' => esc_html__('Months', 'jobhunt'),
                                'years' => esc_html__('Years', 'jobhunt'),
                            ),
                            'return' => true,
                            'array' => true,
                            'force_std' => true
                        ),
                    ),
                ),
            );

            $cs_html .= $cs_html_fields->cs_multi_fields($cs_opt_array);

            $cs_opt_array = array(
                'name' => esc_html__('Description', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($cv_pkg_desc),
                    'cust_id' => 'cv_pkg_desc' . esc_attr($counter_cv_pkg),
                    'cust_name' => 'cv_pkg_desc_array[]',
                    'return' => true,
                ),
            );
            $cs_html .= $cs_html_fields->cs_textarea_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_html__('Update Package', 'jobhunt'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'cust_type' => 'button',
                    'extra_atr' => 'onclick="update_title(' . esc_js($counter_cv_pkg) . '); cs_remove_overlay(\'edit_track_form' . esc_js($counter_cv_pkg) . '\',\'append\')"',
                ),
            );
            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);
            $cs_html .= ' 
                </div></td>
            </tr>';
            if (isset($_POST['cv_pkg_title'])) {
                echo force_balance_tags($cs_html);
                die();
            } else {
                return $cs_html;
            }
        }

        /**
         * Start Function how to show extra features in feature list
         */
        public function cs_add_extra_feature_to_list() {
            global $counter_extra_feature, $cs_form_fields2, $extra_feature_id, $extra_feature_title, $extra_feature_price, $extra_feature_type, $extra_feature_guests, $extra_feature_fchange, $extra_feature_desc, $cs_form_fields;
            foreach ($_POST as $keys => $values) {
                $$keys = $values;
            }
            $cs_plugin_options = get_option("cs_plugin_options");
            $currency_sign = jobcareer_get_currency_sign();
            $cs_extra_features_options = $cs_plugin_options['cs_extra_features_options'];
            if (isset($_POST['cs_extra_feature_title']) && $_POST['cs_extra_feature_title'] <> '') {
                $extra_feature_id = time();
                $extra_feature_title = $_POST['cs_extra_feature_title'];
            }
            if (isset($_POST['cs_extra_feature_price']) && $_POST['cs_extra_feature_price'] <> '') {
                $extra_feature_price = $_POST['cs_extra_feature_price'];
            }
            if (isset($_POST['cs_extra_feature_type']) && $_POST['cs_extra_feature_type'] <> '') {
                $extra_feature_type = $_POST['cs_extra_feature_type'];
            }
            if (isset($_POST['cs_extra_feature_guests']) && $_POST['cs_extra_feature_guests'] <> '') {
                $extra_feature_guests = $_POST['cs_extra_feature_guests'];
            }
            if (isset($_POST['cs_extra_feature_fchange']) && $_POST['cs_extra_feature_fchange'] <> '') {
                $extra_feature_fchange = $_POST['cs_extra_feature_fchange'];
            }
            if (isset($_POST['cs_extra_feature_desc']) && $_POST['cs_extra_feature_desc'] <> '') {
                $extra_feature_desc = $_POST['cs_extra_feature_desc'];
            }
            if (empty($extra_feature_id)) {
                $extra_feature_id = $counter_extra_feature;
            }
            if (isset($_POST['cs_extra_feature_title']) && is_array($cs_extra_features_options) && ($this->cs_in_array_field($extra_feature_title, 'cs_extra_feature_title', $cs_extra_features_options))) {
                $cs_error_message = sprintf(esc_html__('This feature "%s" is already exist. Please create with another Title', 'jobhunt'), $extra_feature_title);
                $html = '
                <tr class="parentdelete" id="edit_track' . esc_attr($counter_extra_feature) . '">
					<td style="width:100%;">' . $cs_error_message . '</td>
                </tr>';
                echo force_balance_tags($html);
                die();
            } else {
                $extra_feature_price = isset($extra_feature_price) ? esc_attr($extra_feature_price) : '';
                $cs_opt_array = array(
                    'id' => '',
                    'std' => absint($extra_feature_id),
                    'cust_id' => "",
                    'cust_name' => "extra_feature_id_array[]",
                    'return' => true,
                );
                $html = '
                <tr class="parentdelete" id="edit_track' . esc_attr($counter_extra_feature) . '">
                  <td id="subject-title' . esc_attr($counter_extra_feature) . '" style="width:80%;">' . esc_attr($extra_feature_title) . '</td>
                  <td class="centr" style="width:20%;"><a href="javascript:cs_createpop(\'edit_track_form' . esc_js($counter_extra_feature) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
                  <td style="width:0"><div id="edit_track_form' . esc_attr($counter_extra_feature) . '" style="display: none;" class="table-form-elem">
                      ' . $cs_form_fields2->cs_form_hidden_render($cs_opt_array) . '
                      <div class="cs-heading-area">
                        <h5 style="text-align: left;">' . esc_html__('Extra Feature Settings', 'jobhunt') . '</h5>
                        <span onclick="javascript:cs_remove_overlay(\'edit_track_form' . esc_js($counter_extra_feature) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                        <div class="clear"></div>
                      </div>';
                $html .= $cs_form_fields->cs_form_text_render(
                        array('name' => esc_html__('Extra Feature Title', 'jobhunt'),
                            'id' => 'extra_feature_title',
                            'classes' => '',
                            'std' => $extra_feature_title,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => ''
                        )
                );
                $html .= $cs_form_fields->cs_form_text_render(
                        array('name' => esc_html__('Price', 'jobhunt'),
                            'id' => 'extra_feature_price',
                            'classes' => '',
                            'std' => $extra_feature_price,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => ''
                        )
                );
                $html .= $cs_form_fields->cs_form_select_render(
                        array('name' => esc_html__('Type', 'jobhunt'),
                            'id' => 'extra_feature_type',
                            'classes' => '',
                            'std' => $extra_feature_type,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => '',
                            'options' => array('none' => esc_html__('None', 'jobhunt'), 'one-time' => esc_html__('One Time', 'jobhunt'), 'daily' => esc_html__('Daily', 'jobhunt')),
                        )
                );
                $html .= $cs_form_fields->cs_form_select_render(
                        array('name' => esc_html__('Guests', 'jobhunt'),
                            'id' => 'extra_feature_guests',
                            'classes' => '',
                            'std' => $extra_feature_guests,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => '',
                            'options' => array('none' => esc_html__('None', 'jobhunt'), 'per-head' => esc_html__('Per Head', 'jobhunt'), 'group' => esc_html__('Group', 'jobhunt')),
                        )
                );
                $html .= $cs_form_fields->cs_form_checkbox_render(
                        array('name' => esc_html__('Frontend Changeable', 'jobhunt'),
                            'id' => 'extra_feature_fchange',
                            'classes' => '',
                            'std' => $extra_feature_fchange,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => '',
                        )
                );
                $html .= $cs_form_fields->cs_form_textarea_render(
                        array('name' => esc_html__('Description', 'jobhunt'),
                            'id' => 'extra_feature_desc',
                            'classes' => '',
                            'std' => $extra_feature_desc,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => '',
                        )
                );

                $cs_opt_array = array(
                    'name' => '',
                    'desc' => '',
                    'hint_text' => '',
                    'echo' => false,
                    'field_params' => array(
                        'std' => esc_html__('Update Extra Feature', 'jobhunt'),
                        'cust_id' => '',
                        'cust_name' => '',
                        'return' => true,
                        'cust_type' => 'button',
                        'extra_atr' => 'onclick="cs_remove_overlay(\'edit_track_form' . esc_js($counter_extra_feature) . '\',\'append\')" ',
                    ),
                );
                $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);
                $html .= '
                    </div></td>
                </tr>';
                if (isset($_POST['cs_extra_feature_title']) && isset($_POST['cs_extra_feature_price'])) {
                    echo force_balance_tags($html);
                } else {
                    return $html;
                }
            }
            if (isset($_POST['cs_extra_feature_title']) && isset($_POST['cs_extra_feature_price']))
                die();
        }

        /**
         * Start Function how to add data in  feature list
         */
        public function cs_add_feats_to_list() {
            global $counter_feats, $feats_id, $feats_title, $feats_image, $feats_desc, $cs_form_fields, $cs_form_fields2;
            foreach ($_POST as $keys => $values) {
                $$keys = $values;
            }
            $cs_plugin_options = get_option("cs_plugin_options");
            $currency_sign = jobcareer_get_currency_sign();
            if (isset($_POST['cs_feats_title']) && $_POST['cs_feats_title'] <> '') {
                $feats_id = time();
                $feats_title = $_POST['cs_feats_title'];
            }
            if (isset($_POST['cs_feats_image']) && $_POST['cs_feats_image'] <> '') {
                $feats_image = $_POST['cs_feats_image'];
            }

            if (isset($_POST['cs_feats_desc']) && $_POST['cs_feats_desc'] <> '') {
                $feats_desc = $_POST['cs_feats_desc'];
            }
            if (empty($feats_id)) {
                $feats_id = $counter_feats;
            }
            $feats_desc = isset($feats_desc) ? esc_attr($feats_desc) : '';
            $cs_opt_array = array(
                'id' => '',
                'std' => absint($feats_id),
                'cust_id' => '',
                'cust_name' => "feats_id_array[]",
                'return' => true,
            );
            $html = '
                <tr class="parentdelete" id="edit_track' . esc_attr($counter_feats) . '">
                  <td id="subject-title' . esc_attr($counter_feats) . '" style="width:80%;">' . esc_attr($feats_title) . '</td>
                  <td class="centr" style="width:20%;"><a href="javascript:cs_createpop(\'edit_track_form' . esc_js($counter_feats) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
                  <td style="width:0"><div id="edit_track_form' . esc_attr($counter_feats) . '" style="display: none;" class="table-form-elem">
                      ' . $cs_form_fields2->cs_form_hidden_render($cs_opt_array) . '
                      <div class="cs-heading-area">
                        <h5 style="text-align: left;">' . esc_html__('Feature Settings', 'jobhunt') . '</h5>
                        <span onclick="javascript:cs_remove_overlay(\'edit_track_form' . esc_js($counter_feats) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                        <div class="clear"></div>
                      </div>';
            $html .= $cs_form_fields->cs_form_text_render(
                    array('name' => esc_html__('Feature Title', 'jobhunt'),
                        'id' => 'feats_title',
                        'classes' => '',
                        'std' => $feats_title,
                        'description' => '',
                        'return' => true,
                        'array' => true,
                        'hint' => ''
                    )
            );
            $html .= $cs_form_fields->cs_form_fileupload_render(
                    array('name' => esc_html__('Image', 'jobhunt'),
                        'id' => 'feats_image',
                        'classes' => '',
                        'std' => $feats_image,
                        'description' => '',
                        'return' => true,
                        'array' => true,
                        'hint' => ''
                    )
            );
            $html .= $cs_form_fields->cs_form_textarea_render(
                    array('name' => esc_html__('Description', 'jobhunt'),
                        'id' => 'feats_desc',
                        'classes' => '',
                        'std' => $feats_desc,
                        'description' => '',
                        'return' => true,
                        'array' => true,
                        'hint' => ''
                    )
            );

            $cs_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_html__('Update Feature', 'jobhunt'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'cust_type' => 'button',
                    'extra_atr' => ' onclick="cs_remove_overlay(\'edit_track_form' . esc_js($counter_feats) . '\',\'append\')" ',
                ),
            );
            $cs_html .= $cs_html_fields->cs_text_field($cs_opt_array);

            $html .= '</div></td></tr>';
            if (isset($_POST['cs_feats_title']) && isset($_POST['cs_feats_desc'])) {
                echo force_balance_tags($html);
            } else {
                return $html;
            }
            if (isset($_POST['cs_feats_title']) && isset($_POST['cs_feats_desc']))
                die();
        }

        /**
         * Start Function how create safetytext data section
         */
        public function cs_safetytext_section() {
            global $post, $safety_id, $counter_safety, $cs_safety_title, $cs_safety_desc, $cs_plugin_options, $cs_form_fields, $cs_form_fields2, $cs_html_fields;
            $cs_plugin_options = get_option("cs_plugin_options");
            $cs_safetytext_options = isset($cs_plugin_options['cs_safetytext_options']) ? $cs_plugin_options['cs_safetytext_options'] : '';
            $cs_opt_array = array(
                'id' => '',
                'std' => '1',
                'cust_id' => '',
                'cust_name' => "dynamic_safety_text",
                'return' => true,
            );

            $html = '
            <!--<form name="dir-safety" method="post" action="#">-->
            ' . $cs_form_fields2->cs_form_hidden_render($cs_opt_array) . '
                <script>
                jQuery(document).ready(function($) {
                    $("#total_safety").sortable({
                                                cancel : \'td div.table-form-elem\'
                    });
                    });
                </script>';
            $html .= '<div class="form-elements" id="safetysafe_switch_add">
                	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    	<a href="javascript:cs_createpop(\'add_safety_title\',\'filter\')" class="button button_style">' . esc_html__("Add Safety Text", "jobhunt") . '</a>
                    </div>
                </div>';
            $display = '';
            if (isset($cs_safetytext_options) && is_array($cs_safetytext_options) && count($cs_safetytext_options) > 0) {
                $display = 'block';
            } else {
                $display = 'none';
            }
            $html .= '<div class="cs-list-table" style="display:' . $display . '">
              <table class="to-table" border="0" cellspacing="0">
                <thead>
                  <tr>
                    <th style="width:80%;">' . esc_html__("Title", "jobhunt") . '</th>
                    <th style="width:80%;" class="centr">' . esc_html__("Actions", "jobhunt") . '</th>
                    <th style="width:0%;" class="centr"></th>
                  </tr>
                </thead>
                <tbody id="total_safety">';
            if (isset($cs_safetytext_options) && is_array($cs_safetytext_options) && count($cs_safetytext_options) > 0) {
                foreach ($cs_safetytext_options as $safetytext_key => $safetytext) {
                    if (isset($safetytext_key) && $safetytext_key <> '') {
                        $counter_safety = $safety_id = isset($safetytext['safety_id']) ? $safetytext['safety_id'] : '';
                        $cs_safety_title = isset($safetytext['cs_safety_title']) ? $safetytext['cs_safety_title'] : '';
                        $cs_safety_desc = isset($safetytext['cs_safety_desc']) ? $safetytext['cs_safety_desc'] : '';

                        $html .= $this->cs_add_safetytext_to_list();
                    }
                }
            }
            $html .= '
                </tbody>
              </table>
              </div>
              <!--</form>-->
              <div id="add_safety_title" style="display: none;">
                <div class="cs-heading-area">
                  <h5><i class="icon-plus-circle"></i> ' . esc_html__('Safety Text Settings', 'jobhunt') . '</h5>
                  <span class="cs-btnclose" onClick="javascript:cs_remove_overlay(\'add_safety_title\',\'append\')"> <i class="icon-times"></i></span> 	
				</div>';

            $cs_opt_array = array(
                'name' => esc_html__('Title', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_html__('Title', 'jobhunt'),
                    'id' => 'safety_title',
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
                    'id' => 'safety_desc',
                    'return' => true,
                ),
            );

            $html .= $cs_html_fields->cs_textarea_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_html__('Add Safety Text to List', 'jobhunt'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'cust_type' => 'button',
                    'extra_atr' => '  onClick="add_safety_to_list(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(wp_jobhunt::plugin_url()) . '\')"',
                ),
            );
            $html .= $cs_html_fields->cs_text_field($cs_opt_array);
            $html .= '</div>';

            echo force_balance_tags($html, true);
        }

        /**
         * Start Function how add data in safetytext  section
         */
        public function cs_add_safetytext_to_list() {
            global $counter_safety, $safety_id, $cs_safety_title, $cs_safety_desc, $cs_form_fields, $cs_form_fields2, $cs_html_fields;
            foreach ($_POST as $keys => $values) {
                $$keys = $values;
            }
            $cs_plugin_options = get_option("cs_plugin_options");
            if (isset($_POST['cs_safety_title']) && $_POST['cs_safety_title'] <> '') {
                $safety_id = time();
                $cs_safety_title = $_POST['cs_safety_title'];
            }

            if (isset($_POST['cs_safety_desc']) && $_POST['cs_safety_desc'] <> '') {
                $cs_safety_desc = $_POST['cs_safety_desc'];
            }
            if (empty($safety_id)) {
                $safety_id = $counter_safety;
            }
            $cs_safety_desc = isset($cs_safety_desc) ? esc_attr($cs_safety_desc) : '';
            $cs_opt_array = array(
                'id' => '',
                'std' => absint($safety_id),
                'cust_id' => "",
                'cust_name' => "safety_id_array[]",
                'return' => true,
            );

            $html = '
                <tr class="parentdelete" id="edit_track' . esc_attr($counter_safety) . '">
                  <td id="subject-title' . esc_attr($counter_safety) . '" style="width:80%;">' . esc_attr($cs_safety_title) . '</td>
                  <td class="centr" style="width:20%;"><a href="javascript:cs_createpop(\'edit_track_form' . esc_js($counter_safety) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
                  <td style="width:0"><div id="edit_track_form' . esc_attr($counter_safety) . '" style="display: none;" class="table-form-elem">
                      ' . $cs_form_fields2->cs_form_hidden_render($cs_opt_array) . '
                      <div class="cs-heading-area">
                        <h5 style="text-align: left;">' . esc_html__('Safety Settings', 'jobhunt') . '</h5>
                        <span onclick="javascript:cs_remove_overlay(\'edit_track_form' . esc_js($counter_safety) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                        <div class="clear"></div>
                      </div>';


            $cs_opt_array = array(
                'name' => esc_html__('Title', 'jobhunt'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => $cs_safety_title,
                    'id' => 'safety_title',
                    'return' => true,
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
                    'std' => $cs_safety_desc,
                    'id' => 'safety_desc',
                    'return' => true,
                    'array' => true,
                ),
            );

            $html .= $cs_html_fields->cs_textarea_field($cs_opt_array);

            $cs_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_html__('Update', 'jobhunt'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'cust_type' => 'button',
                    'extra_atr' => ' onclick="cs_remove_overlay(\'edit_track_form' . esc_js($counter_safety) . '\',\'append\')"',
                ),
            );
            $html .= $cs_html_fields->cs_text_field($cs_opt_array);
            $html .= '
                    </div></td>
                </tr>';
            if (isset($_POST['cs_safety_title']) && isset($_POST['cs_safety_desc'])) {
                echo force_balance_tags($html);
            } else {
                return $html;
            }
            if (isset($_POST['cs_safety_title']) && isset($_POST['cs_safety_title']))
                die();
        }

        /**
         *
         * Array Fields
         */
        function cs_in_array_field($array_val, $array_field, $array, $strict = false) {
            if ($strict) {
                foreach ($array as $item)
                    if (isset($item[$array_field]) && $item[$array_field] === $array_val)
                        return true;
            }
            else {
                foreach ($array as $item)
                    if (isset($item[$array_field]) && $item[$array_field] == $array_val)
                        return true;
            }
            return false;
        }

        /**
         * Start Function that how to check duplicate values
         */
        function cs_check_duplicate_value($array_val, $array_field, $array) {
            $cs_val_counter = 0;
            foreach ($array as $item) {
                if (isset($item[$array_field]) && $item[$array_field] == $array_val) {
                    $cs_val_counter ++;
                }
            }
            if ($cs_val_counter > 1)
                return true;
            return false;
        }

        /**
         * Start Function that how to remove  duplicate values
         */
        function cs_remove_duplicate_extra_value() {
            $cs_plugin_options = get_option('cs_plugin_options');
            $cs_extra_features_options = $cs_plugin_options['cs_extra_features_options'];
            $extrasdata = array();
            $extra_feature_array = $extra_features = '';
            if (isset($cs_extra_features_options) && is_array($cs_extra_features_options) && count($cs_extra_features_options) > 0) {
                $extra_feature_array = $extra_features = $extrasdata = array();
                foreach ($cs_extra_features_options as $extra_feature_key => $extra_feature) {
                    if (isset($extra_feature_key) && $extra_feature_key <> '') {
                        $extra_feature_id = isset($extra_feature['extra_feature_id']) ? $extra_feature['extra_feature_id'] : '';
                        $extra_feature_title = isset($extra_feature['cs_extra_feature_title']) ? $extra_feature['cs_extra_feature_title'] : '';
                        $extra_feature_price = isset($extra_feature['cs_extra_feature_price']) ? $extra_feature['cs_extra_feature_price'] : '';
                        $extra_feature_type = isset($extra_feature['cs_extra_feature_type']) ? $extra_feature['cs_extra_feature_type'] : '';
                        $extra_feature_guests = isset($extra_feature['cs_extra_feature_guests']) ? $extra_feature['cs_extra_feature_guests'] : '';
                        $extra_feature_fchange = isset($extra_feature['cs_extra_feature_fchange']) ? $extra_feature['cs_extra_feature_fchange'] : '';
                        $extra_feature_desc = isset($extra_feature['cs_extra_feature_desc']) ? $extra_feature['cs_extra_feature_desc'] : '';
                        if (!$this->cs_check_duplicate_value($extra_feature_title, 'cs_extra_feature_title', $cs_extra_features_options)) {
                            $extra_feature_array['extra_feature_id'] = $extra_feature_id;
                            $extra_feature_array['cs_extra_feature_title'] = $extra_feature_title;
                            $extra_feature_array['cs_extra_feature_price'] = $extra_feature_price;
                            $extra_feature_array['cs_extra_feature_type'] = $extra_feature_type;
                            $extra_feature_array['cs_extra_feature_guests'] = $extra_feature_guests;
                            $extra_feature_array['cs_extra_feature_fchange'] = $extra_feature_fchange;
                            $extra_feature_array['cs_extra_feature_desc'] = $extra_feature_desc;
                            $extra_features[$extra_feature_id] = $extra_feature_array;
                        }
                    }
                }
                $extrasdata['cs_extra_features_options'] = $extra_features;
                $cs_options = array_merge($cs_plugin_options, $extrasdata);
                update_option("cs_plugin_options", $cs_options);
            }
            //End if
        }

        /**
         * end Function of how to remove  duplicate values
         */
    }

    //End Class
}
if (!function_exists('cs_settings_fields')) {

    /**
     * Start Function that set value in setting fields
     */
    function cs_settings_fields($key, $param) {
        global $post, $cs_html_fields;
        $cs_gateway_options = get_option('cs_gateway_options');
        $cs_value = $param['std'];
        $html = '';
        switch ($param['type']) {
            case 'text':
                if (isset($cs_gateway_options)) {
                    if (isset($cs_gateway_options[$param['id']])) {
                        $val = $cs_gateway_options[$param['id']];
                    } else {
                        $val = $param['std'];
                    }
                } else {
                    $val = $param['std'];
                }
                $cs_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $val,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'cust_type' => $param['type'],
                        'classes' => 'vsmall',
                    ),
                );
                $output = $cs_html_fields->cs_text_field($cs_opt_array);

                $html .= $output;
                break;
            case 'textarea':
                $val = $param['std'];
                $std = get_option($param['id']);
                if (isset($cs_gateway_options)) {
                    if (isset($cs_gateway_options[$param['id']])) {
                        $val = $cs_gateway_options[$param['id']];
                    } else {
                        $val = $param['std'];
                    }
                } else {
                    $val = $param['std'];
                }


                $cs_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $val,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'extra_atr' => 'rows="10" cols="60"',
                        'classes' => '',
                    ),
                );
                $output = $cs_html_fields->cs_textarea_field($cs_opt_array);

                $html .= $output;
                break;
            case "checkbox":
                $saved_std = '';
                $std = '';
                if (isset($cs_gateway_options)) {
                    if (isset($cs_gateway_options[$param['id']])) {
                        $saved_std = $cs_gateway_options[$param['id']];
                    }
                } else {
                    $std = $param['std'];
                }
                $checked = '';
                if (!empty($saved_std)) {
                    if ($saved_std == 'on') {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                } elseif ($std == 'on') {
                    $checked = 'checked="checked"';
                } else {
                    $checked = '';
                }

                $cs_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'classes' => 'myClass',
                    ),
                );
                $output = $cs_html_fields->cs_checkbox_field($cs_opt_array);
                $html .= $output;
                break;
            case "logo":
                if (isset($cs_gateway_options) and $cs_gateway_options <> '' && isset($cs_gateway_options[$param['id']])) {
                    $val = $cs_gateway_options[$param['id']];
                } else {
                    $val = $param['std'];
                }
                $output = '';
                $display = ($val <> '' ? 'display' : 'none');
                if (isset($value['tab'])) {
                    $output .='<div class="main_tab"><div class="horizontal_tab" style="display:' . $param['display'] . '" id="' . $param['tab'] . '">';
                }

                $cs_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $val,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'classes' => '',
                    ),
                );
                $output = $cs_html_fields->cs_upload_file_field($cs_opt_array);
                $html .= $output;
                break;
            case 'select' :

                $options = '';
                if (isset($param['options']) && is_array($param['options'])) {
                    foreach ($param['options'] as $value => $option) {
                        $options[$value] = $option;
                    }
                }
                $cs_opt_array = array(
                    'name' => esc_attr($param["title"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['description']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $cs_value,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'classes' => 'cs-form-select cs-input chosen-select-no-single',
                        'options' => $options,
                    ),
                );
                $output = $cs_html_fields->cs_upload_file_field($cs_opt_array);
                $html .= $output;
                break;
            default :
                break;
        }
        return $html;
    }

}
/**
 * Start Function that how to Checkt load satus
 */
/* ---------------------------------------------------
 * Load States
 * -------------------------------------------------- */
if (!function_exists('cs_load_states')) {

    function cs_load_states() {
        global $cs_theme_options;
        $cs_locations = get_option('cs_location_states');
        $states = '';
        $cs_country = $_POST['country'];
        $cs_country = trim(stripslashes($cs_country));
        if ($cs_country && $cs_country != '') {
            $states_data = isset($cs_locations[$cs_country]) ? $cs_locations[$cs_country] : '';
            $states .= '<option value="">' . esc_html__('Select State', 'jobhunt') . '</option>';
            if (isset($states_data) && $states_data != '') {
                foreach ($states_data as $key => $value) {
                    if ($key != 'no-state') {
                        $states .='<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
                    }
                }
            }
        }
        echo force_balance_tags($states);
        die();
    }

    add_action('wp_ajax_cs_load_states', 'cs_load_states');
}

/**
 * Start Function that how add location in location fields
 */
if (!function_exists('add_locations')) {

    function add_locations($original, $items_to_add, $country, $state = '') {
        if (!empty($state)) {
            $target = $original[$country][$state];
        } else {
            $target = $original[$country];
        }
        $new_arr = array_merge($target, $items_to_add);
        if (!empty($state)) {
            $original[$country][$state] = $new_arr;
        } else {
            $original[$country] = $new_arr;
        }
        return $original;
    }

}

/**
 * Start Function that how Delete location in location fields
 */
if (!function_exists('cs_delete_location')) {

    function cs_delete_location() {
        global $cs_theme_options;
        $type = $_POST['type'];
        $cs_location_countries = get_option('cs_location_countries');
        $cs_location_states = get_option('cs_location_states');
        $cs_location_cities = get_option('cs_location_cities');
        if ($type == 'country') {
            $node = $_POST['node'];
            $cs_location_country = cs_remove_location($cs_location_countries, $cs_location_countries[$node]);
            if (isset($cs_location_states[$node])) {
                $cs_location_states = cs_remove_location($cs_location_states, $cs_location_states[$node]);
            }
            if (isset($cs_location_cities[$node])) {
                $cs_location_cities = cs_remove_location($cs_location_cities, $cs_location_cities[$node]);
            }
            update_option('cs_location_countries', $cs_location_country);
            update_option('cs_location_states', $cs_location_states);
            update_option('cs_location_cities', $cs_location_cities);
        } else if ($type == 'state') {
            $node = $_POST['node'];
            $country_node = $_POST['country_node'];

            unset($cs_location_states[$country_node][$node]);

            if (isset($cs_location_cities[$country_node][$node])) {
                unset($cs_location_cities[$country_node][$node]);
            }
            update_option('cs_location_states', $cs_location_states);
            update_option('cs_location_cities', $cs_location_cities);
        } else if ($type == 'city') {
            $node = $_POST['node'];
            $country_node = $_POST['country_node'];
            $state_node = $_POST['state_node'];
            unset($cs_location_cities[$country_node][$state_node][$node]);
            update_option('cs_location_cities', $cs_location_cities);
        }
        die();
    }

    /**
     * Start Function that how Delete location in location fields
     */
    add_action('wp_ajax_cs_delete_location', 'cs_delete_location');
}
/**
 * Start Function that how remove location 
 */
if (!function_exists('cs_remove_location')) {

    function cs_remove_location($array, $item) {
        $index = array_search($item, $array);
        if ($index !== false) {
            unset($array[$index]);
        }
        return $array;
    }

}
/**
 * end Function of how to remove location 
 */
/**
 * Start Function that how to load country of states 
 */
if (!function_exists('cs_load_country_states')) {

    function cs_load_country_states() {
        global $cs_theme_options;
        $states = '';
        $cs_country = $_POST['country'];
        $json = array();
        $json['cities'] = '<option value="">' . esc_html__('Select City', 'jobhunt') . '</option>';
        $cs_country = trim(stripslashes($cs_country));
        if ($cs_country && $cs_country != '') {
            $states = '';
            $selected_spec = get_term_by('slug', $cs_country, 'cs_locations');
            $state_parent_id = $selected_spec->term_id;
            $states_args = array(
                'orderby' => 'name',
                'order' => 'ASC',
                'fields' => 'all',
                'slug' => '',
                'hide_empty' => false,
                'parent' => $state_parent_id,
            );
            $cities = get_terms('cs_locations', $states_args);

            if (isset($cities) && $cities != '' && is_array($cities)) {
                foreach ($cities as $key => $city) {
                    $json['cities'] .= "<option value='" . $city->slug . "'>" . $city->name . "</option>";
                }
            }
        }
        echo json_encode($json);
        die();
    }

    add_action("wp_ajax_cs_load_country_states", "cs_load_country_states");
    add_action("wp_ajax_nopriv_cs_load_country_states", "cs_load_country_states");
}

/**
 * Start Function that how to crate cities against country 
 */
if (!function_exists('cs_load_country_cities')) {

    function cs_load_country_cities() {
        global $cs_theme_options;
        $cs_country = $_POST['country'];
        $cs_state = $_POST['state'];
        $json = array();
        $json['cities'] = '<option value="">' . esc_html__('Select City', 'jobhunt') . '</option>';
        if ($cs_state && $cs_state != '') {
            // load all cities against state  
            $cities = '';
            $selected_spec = get_term_by('slug', $cs_state, 'cs_locations');
            $state_parent_id = $selected_spec->term_id;
            $states_args = array(
                'orderby' => 'name',
                'order' => 'ASC',
                'fields' => 'all',
                'slug' => '',
                'hide_empty' => false,
                'parent' => $state_parent_id,
            );
            $cities = get_terms('cs_locations', $states_args);
            if (isset($cities) && $cities != '' && is_array($cities)) {
                foreach ($cities as $key => $city) {
                    $json['cities'] .= "<option value='" . $city->slug . "'>" . $city->name . "</option>";
                }
            }
        }
        echo json_encode($json);
        die();
    }

    add_action('wp_ajax_cs_load_country_cities', 'cs_load_country_cities');
}

if (class_exists('cs_plugin_options')) {
    $settings_object = new cs_plugin_options();
    add_action('admin_menu', array(&$settings_object, 'cs_register_jobunt_settings'));
}