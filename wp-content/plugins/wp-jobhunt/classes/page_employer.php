<?php

/**
 * File Type: Employer
 */
function cs_employer_popup_style() {
    wp_enqueue_style('custom-candidate-style-inline', plugins_url('../assets/css/custom_script.css', __FILE__));
    $cs_plugin_options = get_option('cs_plugin_options');
    $cs_custom_css = '#id_confrmdiv
    {
        display: none;
        background-color: #eee;
        border-radius: 5px;
        border: 1px solid #aaa;
        position: fixed;
        width: 300px;
        left: 50%;
        margin-left: -150px;
        padding: 6px 8px 8px;
        box-sizing: border-box;
        text-align: center;
    }
    #id_confrmdiv .button {
        background-color: #ccc;
        display: inline-block;
        border-radius: 3px;
        border: 1px solid #aaa;
        padding: 2px;
        text-align: center;
        width: 80px;
        cursor: pointer;
    }
    #id_confrmdiv .button:hover
    {
        background-color: #ddd;
    }
    #confirmBox .message
    {
        text-align: left;
        margin-bottom: 8px;
    }';
    wp_add_inline_style('custom-candidate-style-inline', $cs_custom_css);
}

add_action('wp_enqueue_scripts', 'cs_employer_popup_style', 5);
get_header();
$celine_active = false;
$celine_active = apply_filters('jobhunt_celine_depedency', $celine_active);
?>
<div class="main-section">
    <div class="content-area" id="primary">
        <main class="site-main">
            <div class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
                <!-- alert for complete theme -->
                <div class="cs_alerts" ></div>
		<?php
		global $post, $current_user, $wp_roles, $userdata, $cs_form_fields_frontend, $cs_plugin_options, $cs_form_fields2;
		$cs_emploayer_dashboard_vew = isset($cs_plugin_options['cs_employer_dashboard_view']) ? $cs_plugin_options['cs_employer_dashboard_view'] : '';
		if ($cs_emploayer_dashboard_vew == '') {
		    $cs_emploayer_dashboard_vew = 'default';
		}
		wp_jobhunt::cs_enqueue_tabs_script();
		wp_jobhunt::cs_jquery_ui_scripts();
		$cs_emp_funs = '';
		if (class_exists('cs_employer_functions')) {
		    $cs_emp_funs = new cs_employer_functions();
		}
		$cs_emp_temps = '';
		if (class_exists('cs_employer_templates')) {
		    $cs_emp_temps = new cs_employer_templates();
		}
		if (class_exists('cs_employer_ajax_templates')) {
		    $cs_emp_ajax_temps = new cs_employer_ajax_templates();
		}
		$uid = $current_user->ID;
		if (isset($_GET['uid']) && $_GET['uid'] <> '') {
		    $uid = $_GET['uid'];
		}
		$cs_jobhunt = new wp_jobhunt();
		$cs_user_data = get_userdata($uid);
		if (isset($cs_user_data) && $cs_user_data != '') {
		    $cs_comp_name = $cs_user_data->display_name;
		}
		$emp_cell_no = get_user_meta($uid, 'cs_phone_number', true);
		if (isset($cs_user_data) && $cs_user_data != '') {
		    $employer_email_address = $cs_user_data->user_email;
		}
		$cs_value = get_user_meta($uid, 'user_img', true);
		$cs_cover_employer_img_value = get_user_meta($uid, 'cover_user_img', true);
		$imagename_only = $cs_value;
		$cover_imagename_only = $cs_cover_employer_img_value;
		$cs_action = isset($_POST['button_action']) ? $_POST['button_action'] : '';
		$post_title = isset($_POST['post_title']) ? $_POST['post_title'] : '';
		$post_content = isset($_POST['employer_content']) ? $_POST['employer_content'] : '';
		$post_author = $uid;
		$cs_post_id = $cs_emp_funs->cs_get_post_id_by_meta_key("cs_user", $uid);
		// Create employer post
		$employer_post = array(
		    'ID' => $cs_post_id,
		    'post_title' => $post_title,
		    'post_content' => $post_content,
		    'post_author' => $post_author,
		    'post_type' => 'employer',
		    'post_date' => current_time('Y-m-d h:i:s')
		);

		if (isset($cs_post_id) and $cs_post_id <> '' and $cs_action == 'update') {
		    wp_update_post($employer_post);
		}
		if (is_user_logged_in()) {
		    global $current_user;
		    $cs_emp_dashboard = isset($cs_plugin_options['cs_emp_dashboard']) ? $cs_plugin_options['cs_emp_dashboard'] : '';
		    if ($cs_emp_dashboard != '') {
			$cs_employer_link = get_permalink($cs_emp_dashboard);
		    }
		    $employer_post_data = get_post($cs_post_id);
		    $cs_employer_title = isset($employer_post_data->post_title) ? $employer_post_data->post_title : '';
		    $employer_address = get_user_address_string_for_list($cs_post_id);
		}
		$cs_emp_funs->cs_init_editor();
		$cs_pkg_array = $cs_blnk_array = array();
		$cs_job_id = isset($_GET['job_id']) ? $_GET['job_id'] : '';

		if (isset($_FILES['media_upload']) && $_FILES['media_upload'] != '' && !isset($_POST['cs_update_job'])) {
		    $attachment_url = apply_filters('jobhunt_job_upload_frontend', 'media_upload', $_FILES);
		    if ($attachment_url != '' && $attachment_url != 'media_upload') {
			$_POST['job_image'] = $attachment_url;
		    }
		}
		$cs_pkg_array['ajax_url'] = esc_url(admin_url('admin-ajax.php'));
		$cs_pkg_array['job_id'] = $cs_job_id;
		$cs_pkg_array['user_id'] = $uid;
		$cs_pkg_array['post_array'] = isset($_POST) ? $_POST : '';

		if (isset($cs_pkg_array['post_array']['cs_job_title'])) {
		    $cs_pkg_array['post_array']['cs_job_title'] = cs_jobhunt_encrypt($cs_pkg_array['post_array']['cs_job_title']);
		}

		if (isset($cs_pkg_array['post_array']['cs_job_desc'])) {
		    $cs_pkg_array['post_array']['cs_job_desc'] = cs_jobhunt_encrypt($cs_pkg_array['post_array']['cs_job_desc']);
		}

		if (isset($cs_pkg_array['post_array']['cs_post_loc_country'])) {
		    $cs_pkg_array['post_array']['cs_post_loc_country'] = cs_jobhunt_encrypt($cs_pkg_array['post_array']['cs_post_loc_country']);
		}

		if (isset($cs_pkg_array['post_array']['cs_post_loc_region'])) {
		    $cs_pkg_array['post_array']['cs_post_loc_region'] = cs_jobhunt_encrypt($cs_pkg_array['post_array']['cs_post_loc_region']);
		}

		if (isset($cs_pkg_array['post_array']['cs_post_loc_city'])) {
		    $cs_pkg_array['post_array']['cs_post_loc_city'] = cs_jobhunt_encrypt($cs_pkg_array['post_array']['cs_post_loc_city']);
		}

		if (isset($cs_pkg_array['post_array']['cs_add_new_loc'])) {
		    $cs_pkg_array['post_array']['cs_add_new_loc'] = cs_jobhunt_encrypt($cs_pkg_array['post_array']['cs_add_new_loc']);
		}

		if (isset($cs_pkg_array['post_array']['cs_post_comp_address'])) {
		    $cs_pkg_array['post_array']['cs_post_comp_address'] = cs_jobhunt_encrypt($cs_pkg_array['post_array']['cs_post_comp_address']);
		}

		if (isset($cs_pkg_array['post_array']['cs_post_loc_address'])) {
		    $cs_pkg_array['post_array']['cs_post_loc_address'] = cs_jobhunt_encrypt($cs_pkg_array['post_array']['cs_post_loc_address']);
		}

		if (isset($cs_pkg_array['post_array']['cs_create_job'])) {
		    $cs_pkg_array['post_array']['cs_create_job'] = cs_jobhunt_encrypt($cs_pkg_array['post_array']['cs_create_job']);
		}

		if (isset($cs_pkg_array['post_array']['cs_update_job'])) {
		    $cs_pkg_array['post_array']['cs_update_job'] = cs_jobhunt_encrypt($cs_pkg_array['post_array']['cs_update_job']);
		}

		// custom fields
		$cs_cus_fields_array = array();
		if (isset($cs_pkg_array['post_array']['cs_cus_field']) && is_array($cs_pkg_array['post_array']['cs_cus_field'])) {
		    foreach ($cs_pkg_array['post_array']['cs_cus_field'] as $cus_key => $cus_value) {

			if (is_array($cus_value)) {
			    $cus_vall_array = array();
			    foreach ($cus_value as $cus_vall) {
				$cus_vall_array[] = cs_jobhunt_encrypt($cus_vall);
			    }
			    $cs_cus_fields_array[$cus_key] = $cus_vall_array;
			} else {
			    $cs_cus_fields_array[$cus_key] = cs_jobhunt_encrypt($cus_value);
			}
		    }
		}
		$cs_pkg_array['post_array']['cs_cus_field'] = $cs_cus_fields_array;

		$cs_blnk_array['ajax_url'] = esc_url(admin_url('admin-ajax.php'));
		$cs_blnk_array['job_id'] = '';
		$cs_blnk_array['user_id'] = $uid;
		if (is_array($cs_pkg_array) && sizeof($cs_pkg_array) > 0) {
		    $cs_pkg_array = json_encode($cs_pkg_array, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		}
		if (is_array($cs_blnk_array) && sizeof($cs_blnk_array) > 0) {
		    $cs_blnk_array = json_encode($cs_blnk_array, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		}
		?>
                <script type="text/javascript">
                    var pkg_array = '<?php echo CS_FUNCTIONS()->cs_special_chars($cs_pkg_array) ?>';
                    var blank_array = '<?php echo CS_FUNCTIONS()->cs_special_chars($cs_blnk_array) ?>';
                    var autocomplete;
                </script>
		<?php
		$cs_dash_class = 'active';
		$cs_job_class = '';
		if ($cs_job_id != '') {
		    $cs_dash_class = '';
		    $cs_job_class = 'active';
		}
		if (is_user_logged_in()) {

		    $user_role = cs_get_loginuser_role();
		    if (isset($user_role) && $user_role <> '' && $user_role == 'cs_employer') {
			?>
			<div id="main">
			    <div class="main-section cs-jax-area" data-ajaxurl="<?php echo esc_js(admin_url('admin-ajax.php')); ?>">
				<?php if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'default') { ?>
	    			<div class="employer-dashboard">
				    <?php } ?>
				    <?php if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'fancy') { ?>
	    			    <div class="employer-dashboard dasborad-fancy">
					<?php } ?>
					<?php if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'fancy_full') { ?>
	    				<div class="employer-dashboard dasborad-fancy fancy-full">

	    				    <div class="cs-upload-sec">
	    					<div class="container">
	    					    <div class="row">
	    						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
	    								<h5 class="cs-candidate-title"><span><?php echo esc_html__($cs_comp_name, 'jobhunt'); ?></span></h5>
	    								<span><em> <i class="icon-phone6"></i> <?php echo esc_html__($emp_cell_no, 'jobhunt'); ?></em></span>
	    								<span><em> <i class="icon-mail6"></i> <?php echo esc_html__($employer_email_address, 'jobhunt'); ?></em></span>
	    							    </div>

	    							</div>
	    						    </div>
	    						</div> </div> </div>
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
									    <img src="<?php echo esc_url($cs_jobhunt->plugin_url()); ?>assets/images/no-cover-full.jpg" id="cs_cover_employer_img_img" width="100" alt="" />
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
	    				    </div>
					    <?php } ?>
					    <div class="<?php if (isset($cs_plugin_options['cs_plugin_single_container']) && $cs_plugin_options['cs_plugin_single_container'] == 'on') echo 'container' ?>">
						<div class="row">
						    <div class="cs-content-holder">
							<?php
							global $current_user, $Payment_Processing;

							$employer_post_data = get_post($cs_post_id);
							$cs_employer_title = isset($employer_post_data->post_title) ? $employer_post_data->post_title : '';
							$cs_employer_address = get_user_address_string_for_list($cs_post_id);
							$cs_order_data = $Payment_Processing->custom_order_status_display();
							update_option('wooC_current_page', cs_server_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
							?>
							<input type="hidden" id="wooC_current_page" value="<?php echo cs_server_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
							<?php if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'default') { ?>
	    						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    						    <div class="cs-tabs nav-position-left row" id="cstabs">
								    <?php $cs_emp_temps->cs_employer_menu($uid, $cs_pkg_array); ?>
	    							<div class="tab-content col-lg-9 col-md-9 col-sm-12 col-xs-12" id="employer-dashboard" data-validationmsg="<?php esc_html_e("Please ensure that all required fields are completed and formatted correctly", "jobhunt"); ?>">
	    							    <!-- warning popup -->
	    							    <div id="id_confrmdiv">
	    								<div class="cs-confirm-container">
	    								    <i class="icon-exclamation2"></i>
	    								    <div class="message"><?php esc_html_e("Do you really want to delete?", "jobhunt"); ?></div>
	    								    <a href="javascript:void(0);" id="id_truebtn"><?php esc_html_e("Yes, Delete It", "jobhunt"); ?></a>
	    								    <a href="javascript:void(0);" id="id_falsebtn"><?php esc_html_e("Cancel", "jobhunt"); ?></a>
	    								</div>
	    							    </div>
	    							    <!-- end warning popup -->
	    							    <div class="main-cs-loader"></div>
									<?php
									$cs_posting = '';
									if (isset($_POST['cs_posting']) && $_POST['cs_posting'] == 'new') {
									    $cs_posting = 'new';
									}
									if ($cs_posting != 'new') {
									    ?>
									    <div id="cs-act-tab" class="tab-pane <?php echo sanitize_html_class($cs_job_class) ?> fade in tabs-container">
										<?php $cs_emp_temps->cs_job_action($uid) ?>
									    </div>
									    <?php
									}

									$active = 'active';
									if (isset($cs_order_data) && !empty($cs_order_data)) {
									    ?>

									    <div class="tab-pane active fade1 tabs-container" id="orderdata">
										<div class="cs-loader"></div>
										<?php
										global $woocommerce;
										if (class_exists('WooCommerce')) {
										    WC()->payment_gateways();
										    echo '<h3>' . $cs_order_data['status_message'] . '</h3>';
										    do_action('woocommerce_thankyou_' . $cs_order_data['payment_method'], $cs_order_data['order_id']);
										    $Payment_Processing->remove_raw_data($cs_order_data['order_id']);
										}
										?>
									    </div>
									    <?php
									    $active = '';
									}
									?>

	    							    <div class="tab-pane <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'profile') || (!isset($_REQUEST['profile_tab']) || $_REQUEST['profile_tab'] == '')) echo ($active); ?> fade1 tabs-container" id="profile">
	    								<div class="cs-loader"></div>
									    <?php
									    $cs_jobhunt = new wp_jobhunt();
									    $cs_jobhunt->cs_location_gmap_script();
									    $cs_jobhunt->cs_google_place_scripts();
									    $cs_jobhunt->cs_autocomplete_scripts();
									    if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'profile') || (!isset($_REQUEST['profile_tab']) || $_REQUEST['profile_tab'] == '')) {
										?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_emp_profile('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
										    });
										</script>
										<?php
									    }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'jobs') echo $active; ?> fade1 tabs-container" id="jobs">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'jobs') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_manage_job('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
									<?php
									if (!$celine_active) {
									    ?>
									    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'transactions') echo $active; ?> fade1 tabs-container" id="transactions">
										<div class="cs-loader"></div>
										<?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'transactions') { ?>
		    								<script>
		    								    jQuery(window).load(function () {
		    									cs_ajax_trans_history('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
		    								    });
		    								</script>
										<?php }
										?>
									    </div>
									    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'resumes') echo $active; ?> fade1 tabs-container" id="resumes">
										<div class="cs-loader"></div>
										<?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'resumes') { ?>
		    								<script>
		    								    jQuery(window).load(function () {
		    									cs_ajax_fav_resumes('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
		    								    });
		    								</script>
										<?php }
										?>
									    </div>
									    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'shortlisted_resume') echo $active; ?> fade1 tabs-container" id="shortlisted_resume">
										<div class="cs-loader"></div>
										<?php
										if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'shortlisted_resume') {
										    ?>
		    								<script>
		    								    jQuery(window).load(function () {});
		    								</script>
										    <?php
										}
										?>
									    </div>
									    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'packages') echo $active; ?> fade1 tabs-container" id="packages">
										<div class="cs-loader"></div>
										<?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'packages') { ?>
		    								<script>
		    								    jQuery(window).load(function () {
		    									cs_ajax_job_packages(pkg_array);
		    								    });
		    								</script>
										<?php }
										?>
									    </div>
									<?php } ?>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'postjobs') echo $active; ?> fade1 tabs-container" id="postjobs">

	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'postjobs') { ?>
										<script type="text/javascript">
										    jQuery(window).load(function () {
											cs_ajax_emp_job('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>', pkg_array);
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
									<?php
									$profile_tab = isset($_REQUEST['profile_tab']) ? $_REQUEST['profile_tab'] : '';
									do_action('jobhunt_employer_dashboard_tabs', $profile_tab, $uid);
									?>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'change_password') echo $active; ?> fade1 tabs-container" id="change_password">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'change_password') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_employer_change_password(pkg_array);
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
									<?php
									$profile_tab = isset($_REQUEST['profile_tab']) ? $_REQUEST['profile_tab'] : '';
									do_action('jobhunt_employer_dashboard_tabs_content', $profile_tab, $uid, $cs_pkg_array, $active);
									?>
	    							</div>
	    						    </div>
	    						</div>
							<?php } ?>
							<?php if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'fancy') { ?>
	    						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    						    <div class="cs-tabs nav-position-left row" id="cstabs">
								    <?php $cs_emp_temps->cs_employer_menu($uid, $cs_pkg_array); ?>
	    							<div class="tab-content col-lg-8 col-md-8 col-sm-12 col-xs-12" id="employer-dashboard" data-validationmsg="<?php esc_html_e("Please ensure that all required fields are completed and formatted correctly", "jobhunt"); ?>">
	    							    <!-- warning popup -->
	    							    <div id="id_confrmdiv">
	    								<div class="cs-confirm-container">
	    								    <i class="icon-exclamation2"></i>
	    								    <div class="message"><?php esc_html_e("Do you really want to delete?", "jobhunt"); ?></div>
	    								    <a href="javascript:void(0);" id="id_truebtn"><?php esc_html_e("Yes, Delete It", "jobhunt"); ?></a>
	    								    <a href="javascript:void(0);" id="id_falsebtn"><?php esc_html_e("Cancel", "jobhunt"); ?></a>
	    								</div>
	    							    </div>
	    							    <!-- end warning popup -->
	    							    <div class="main-cs-loader"></div>
									<?php
									$cs_posting = '';
									if (isset($_POST['cs_posting']) && $_POST['cs_posting'] == 'new') {
									    $cs_posting = 'new';
									}
									if ($cs_posting != 'new') {
									    ?>
									    <div id="cs-act-tab" class="tab-pane <?php echo sanitize_html_class($cs_job_class) ?> fade in tabs-container">
										<?php $cs_emp_temps->cs_job_action($uid) ?>
									    </div>
									    <?php
									}

									$active = 'active';
									if (isset($cs_order_data) && !empty($cs_order_data)) {
									    ?>

									    <div class="tab-pane active fade1 tabs-container" id="orderdata">
										<div class="cs-loader"></div>
										<?php
										global $woocommerce;
										if (class_exists('WooCommerce')) {
										    WC()->payment_gateways();
										    echo '<h3>' . $cs_order_data['status_message'] . '</h3>';
										    do_action('woocommerce_thankyou_' . $cs_order_data['payment_method'], $cs_order_data['order_id']);
										    $Payment_Processing->remove_raw_data($cs_order_data['order_id']);
										}
										?>
									    </div>
									    <?php
									    $active = '';
									}
									?>

	    							    <div class="tab-pane <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'profile') || (!isset($_REQUEST['profile_tab']) || $_REQUEST['profile_tab'] == '')) echo ($active); ?> fade1 tabs-container" id="profile">
	    								<div class="cs-loader"></div>
									    <?php
									    $cs_jobhunt = new wp_jobhunt();
									    $cs_jobhunt->cs_location_gmap_script();
									    $cs_jobhunt->cs_google_place_scripts();
									    $cs_jobhunt->cs_autocomplete_scripts();
									    if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'profile') || (!isset($_REQUEST['profile_tab']) || $_REQUEST['profile_tab'] == '')) {
										?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_emp_profile('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
										    });
										</script>
										<?php
									    }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'jobs') echo $active; ?> fade1 tabs-container" id="jobs">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'jobs') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_manage_job('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'transactions') echo $active; ?> fade1 tabs-container" id="transactions">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'transactions') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_trans_history('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'resumes') || (!isset($_REQUEST['profile_tab']) || $_REQUEST['profile_tab'] == '')) echo ($active); ?> fade1 tabs-container" id="resumes">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'resumes') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_fav_resumes('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'shortlisted_resume') echo $active; ?> fade1 tabs-container" id="shortlisted_resume">
	    								<div class="cs-loader"></div>
									    <?php
									    if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'shortlisted_resume') {
										?>
										<script>
										    jQuery(window).load(function () {});
										</script>
										<?php
									    }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'packages') echo $active; ?> fade1 tabs-container" id="packages">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'packages') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_job_packages(pkg_array);
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'postjobs') echo $active; ?> fade1 tabs-container" id="postjobs">

	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'postjobs') { ?>
										<script type="text/javascript">
										    jQuery(window).load(function () {
											cs_ajax_emp_job('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>', pkg_array);
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
									<?php
									$profile_tab = isset($_REQUEST['profile_tab']) ? $_REQUEST['profile_tab'] : '';
									do_action('jobhunt_employer_dashboard_tabs', $profile_tab, $uid);
									?>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'change_password') echo $active; ?> fade1 tabs-container" id="change_password">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'change_password') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_employer_change_password(pkg_array);
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
									<?php
									$profile_tab = isset($_REQUEST['profile_tab']) ? $_REQUEST['profile_tab'] : '';
									do_action('jobhunt_employer_dashboard_tabs_content', $profile_tab, $uid, $cs_pkg_array, $active);
									?>
	    							</div>
	    						    </div>
	    						</div>
							<?php } ?>

							<?php if (isset($cs_emploayer_dashboard_vew) && $cs_emploayer_dashboard_vew == 'fancy_full') { ?>
	    						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    						    <div class="cs-tabs nav-position-left row" id="cstabs">
								    <?php $cs_emp_temps->cs_employer_menu($uid, $cs_pkg_array); ?>
	    							<div class="tab-content col-lg-8 col-md-8 col-sm-12 col-xs-12" id="employer-dashboard" data-validationmsg="<?php esc_html_e("Please ensure that all required fields are completed and formatted correctly", "jobhunt"); ?>">
	    							    <!-- warning popup -->
	    							    <div id="id_confrmdiv">
	    								<div class="cs-confirm-container">
	    								    <i class="icon-exclamation2"></i>
	    								    <div class="message"><?php esc_html_e("Do you really want to delete?", "jobhunt"); ?></div>
	    								    <a href="javascript:void(0);" id="id_truebtn"><?php esc_html_e("Yes, Delete It", "jobhunt"); ?></a>
	    								    <a href="javascript:void(0);" id="id_falsebtn"><?php esc_html_e("Cancel", "jobhunt"); ?></a>
	    								</div>
	    							    </div>
	    							    <!-- end warning popup -->
	    							    <div class="main-cs-loader"></div>
									<?php
									$cs_posting = '';
									if (isset($_POST['cs_posting']) && $_POST['cs_posting'] == 'new') {
									    $cs_posting = 'new';
									}
									if ($cs_posting != 'new') {
									    ?>
									    <div id="cs-act-tab" class="tab-pane <?php echo sanitize_html_class($cs_job_class) ?> fade in tabs-container">
										<?php $cs_emp_temps->cs_job_action($uid) ?>
									    </div>
									    <?php
									}

									$active = 'active';
									if (isset($cs_order_data) && !empty($cs_order_data)) {
									    ?>

									    <div class="tab-pane active fade1 tabs-container" id="orderdata">
										<div class="cs-loader"></div>
										<?php
										global $woocommerce;
										if (class_exists('WooCommerce')) {
										    WC()->payment_gateways();
										    echo '<h3>' . $cs_order_data['status_message'] . '</h3>';
										    do_action('woocommerce_thankyou_' . $cs_order_data['payment_method'], $cs_order_data['order_id']);
										    $Payment_Processing->remove_raw_data($cs_order_data['order_id']);
										}
										?>
									    </div>
									    <?php
									    $active = '';
									}
									?>

	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'profile') echo $active; ?> fade1 tabs-container" id="profile">
	    								<div class="cs-loader"></div>
									    <?php
									    $cs_jobhunt = new wp_jobhunt();
									    $cs_jobhunt->cs_location_gmap_script();
									    $cs_jobhunt->cs_google_place_scripts();
									    $cs_jobhunt->cs_autocomplete_scripts();
									    if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'profile') || (!isset($_REQUEST['profile_tab']) || $_REQUEST['profile_tab'] == '')) {
										?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_emp_profile('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
										    });
										</script>
										<?php
									    }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'jobs') echo $active; ?> fade1 tabs-container" id="jobs">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'jobs') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_manage_job('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'transactions') echo $active; ?> fade1 tabs-container" id="transactions">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'transactions') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_trans_history('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'resumes') echo $active; ?> fade1 tabs-container" id="resumes">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'resumes') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_fav_resumes('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'shortlisted_resume') echo $active; ?> fade1 tabs-container" id="shortlisted_resume">
	    								<div class="cs-loader"></div>
									    <?php
									    if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'shortlisted_resume') {
										?>
										<script>
										    jQuery(window).load(function () {});
										</script>
										<?php
									    }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'packages') echo $active; ?> fade1 tabs-container" id="packages">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'packages') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_ajax_job_packages(pkg_array);
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'postjobs') echo $active; ?> fade1 tabs-container" id="postjobs">

	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'postjobs') { ?>
										<script type="text/javascript">
										    jQuery(window).load(function () {
											cs_ajax_emp_job('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>', pkg_array);
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
									<?php
									$profile_tab = isset($_REQUEST['profile_tab']) ? $_REQUEST['profile_tab'] : '';
									do_action('jobhunt_employer_dashboard_tabs', $profile_tab, $uid);
									?>
	    							    <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'change_password') echo $active; ?> fade1 tabs-container" id="change_password">
	    								<div class="cs-loader"></div>
									    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'change_password') { ?>
										<script>
										    jQuery(window).load(function () {
											cs_employer_change_password(pkg_array);
										    });
										</script>
									    <?php }
									    ?>
	    							    </div>
									<?php
									$profile_tab = isset($_REQUEST['profile_tab']) ? $_REQUEST['profile_tab'] : '';
									do_action('jobhunt_employer_dashboard_tabs_content', $profile_tab, $uid, $cs_pkg_array, $active);
									?>
	    							</div>
	    						    </div>
	    						</div>
							<?php } ?>
						    </div>
						</div>
					    </div>
					</div>
				    </div>
				</div>
				<?php
			    } else {
				?>
				<div id="main">
				    <div class="main-section">
					<section class="candidate-profile">
					    <div class="<?php if (isset($cs_plugin_options['cs_plugin_single_container']) && $cs_plugin_options['cs_plugin_single_container'] == 'on') echo 'container' ?>">
						<div class="row">
						    <div class="col-md-12">
							<div class="unauthorized">
							    <?php
							    _e('<h1>Please register yourself as an <span>employer</span> to access this page.</h1>', 'jobhunt');
							    ?>
							</div>
						    </div>
						</div>
					    </div>
					</section>
				    </div>
				</div>
				<?php
			    }
			} else {
			    ?>
    			<div id="main">
    			    <div class="main-section">
    				<section class="candidate-profile">
    				    <div class="<?php if (isset($cs_plugin_options['cs_plugin_single_container']) && $cs_plugin_options['cs_plugin_single_container'] == 'on') echo 'container' ?>" id="employer-dashboard" data-validationmsg="<?php esc_html_e("Please ensure that all required fields are completed and formatted correctly", "jobhunt"); ?>">
    					<div class="row">
    					    <div class="col-md-12">
						    <?php
						    echo '<div id="postjobs">';
						    //$cs_emp_temps->cs_employer_post_job();
						    echo do_shortcode('[cs_register register_role="contributor"] [/cs_register]');
						    echo '</div>';
						    ?>
    					    </div>
    					</div>
    				    </div>
    				</section>
    			    </div>
    			</div>
			    <?php
			}
			?>
                    </div>
                    </main>
                </div>
            </div>
	    <?php
	    get_footer();
	    