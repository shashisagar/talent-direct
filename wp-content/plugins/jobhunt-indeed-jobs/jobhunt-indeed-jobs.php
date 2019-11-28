<?php
/**
 * Plugin Name: JobHunt Indeed Jobs
 * Plugin URI: http://themeforest.net/user/Chimpstudio/
 * Description: Job Hunt Import Indeed Jobs Add on
 * Version: 2.2
 * Author: ChimpStudio
 * Author URI: http://themeforest.net/user/Chimpstudio/
 * @package Job Hunt
 * Text Domain: jobhunt-indeed-jobs
 */
// Direct access not allowed.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Job_Hunt_Indeed_Jobs_Import class.
 */
class Job_Hunt_Indeed_Jobs {

    public $admin_notices;

    /**
     * construct function.
     */
    public function __construct() {

        // Define constants
        define( 'JOBHUNT_INDEED_JOBS_PLUGIN_VERSION', '2.2' );
        define( 'JOBHUNT_INDEED_JOBS_PLUGIN_DOMAIN', 'jobhunt-indeed-jobs' );
        define( 'JOBHUNT_INDEED_JOBS_PLUGIN_URL', WP_PLUGIN_URL . '/jobhunt-indeed-jobs' );
        define( 'JOBHUNT_INDEED_JOBS_CORE_DIR', WP_PLUGIN_DIR . '/jobhunt-indeed-jobs' );
        define( 'JOBHUNT_INDEED_JOBS_LANGUAGES_DIR', JOBHUNT_INDEED_JOBS_CORE_DIR . '/languages' );
        define( 'JOBHUNT_INDEED_JOBS_INCLUDES_DIR', JOBHUNT_INDEED_JOBS_CORE_DIR . '/includes' );
        $this->admin_notices = array();
        //admin notices
        add_action( 'admin_notices', array( $this, 'job_indeed_jobs_notices_callback' ) );
        if ( ! $this->check_dependencies() ) {
            return false;
        }

        // Initialize Addon
        add_action( 'init', array( $this, 'init' ) );
    }

    /**
     * Initialize application, load text domain, enqueue scripts, include classes and add actions
     */
    public function init() {
		// Add Plugin textdomain
        $locale = apply_filters('plugin_locale', get_locale(), 'jobhunt-indeed-jobs');
        load_textdomain('jobhunt-indeed-jobs', JOBHUNT_INDEED_JOBS_LANGUAGES_DIR.'/jobhunt-indeed-jobs' . "-" . $locale . '.mo');
        load_plugin_textdomain( 'jobhunt-indeed-jobs', false, JOBHUNT_INDEED_JOBS_LANGUAGES_DIR );

        // Enqueue CSS
        wp_enqueue_style( 'jobhunt-indeed-jobs-styles', esc_url( JOBHUNT_INDEED_JOBS_PLUGIN_URL . '/assets/css/jobhunt-indeed-jobs-style.css' ) );
        // Enqueue JS
        wp_enqueue_script( 'jobhunt-indeed-jobs-script', esc_url( JOBHUNT_INDEED_JOBS_PLUGIN_URL . '/assets/js/jobhunt-indeed-jobs-function.js' ), '', 'jobhunt-indeed-jobs', true );

        // include indeed api class
        require_once ( JOBHUNT_INDEED_JOBS_INCLUDES_DIR . '/class-jobhunt-indeed-api.php' );

        // include job frontend view class
        require_once ( JOBHUNT_INDEED_JOBS_INCLUDES_DIR . '/class-jobhunt-job-frontend-view.php' );

        // Add actions
        add_action( 'jobhunt_indeed_job_admin_fields', array( &$this, 'indeed_job_admin_fields' ) );
        add_action( 'admin_menu', array( &$this, 'jobhunt_indeed_jobs_import_page' ) );
        add_action( 'wp_ajax_jobhunt_import_indeed_jobs', array( &$this, 'jobhunt_import_indeed_jobs' ) );
        add_filter( 'jobhunt_jobs_shortcode_admin_default_attributes', array( &$this, 'jobs_shortcode_admin_default_attributes' ), 10, 1 );
        add_action( 'jobhunt_jobs_shortcode_admin_fields', array( &$this, 'jobs_shortcode_admin_fields' ), 10, 1 );
        add_filter( 'jobhunt_save_jobs_shortcode_admin_fields', array( &$this, 'save_jobs_shortcode_admin_fields' ), 10, 3 );
        add_filter( 'jobhunt_jobs_shortcode_frontend_default_attributes', array( &$this, 'jobs_shortcode_frontend_default_attributes' ), 10, 1 );
        add_filter( 'job_hunt_indeed_jobs_listing_parameters', array( &$this, 'indeed_jobs_listing_parameters' ), 10, 2 );
    }

    /**
     * Check plugin dependencies (JobHunt), nag if missing.
     *
     * @param boolean $disable disable the plugin if true, defaults to false.
     */
    public function check_dependencies( $disable = false ) {
        $result = true;
        $active_plugins = get_option( 'active_plugins', array() );
        if ( is_multisite() ) {
            $active_sitewide_plugins = get_site_option( 'active_sitewide_plugins', array() );
            $active_sitewide_plugins = array_keys( $active_sitewide_plugins );
            $active_plugins = array_merge( $active_plugins, $active_sitewide_plugins );
        }
        $jobhunt_is_active = in_array( 'wp-jobhunt/wp-jobhunt.php', $active_plugins );
        if ( ! $jobhunt_is_active ) {
            $this->admin_notices = '<div class="error">' . __( '<em><b>Job Hunt Indeed Jobs</b></em> needs the <b>Job Hunt</b> plugin. Please install and activate it.', 'jobhunt-indeed-jobs' ) . '</div>';
        }
        if ( ! $jobhunt_is_active ) {
            if ( $disable ) {
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                deactivate_plugins( array( __FILE__ ) );
            }
            $result = false;
        }
        return $result;
    }

    public function job_indeed_jobs_notices_callback() {
        if ( isset( $this->admin_notices ) && ! empty( $this->admin_notices ) ) {
            foreach ( $this->admin_notices as $value ) {
                echo $value;
            }
        }
    }

    /**
     * Indeed job admin fields
     */
    public function indeed_job_admin_fields() {
        global $cs_html_fields, $cs_form_fields2;
        $cs_html_fields->cs_heading_render(
                array(
                    'name' => esc_html__( 'Indeed Job Fields', 'jobhunt-indeed-jobs' ),
                    'id' => 'job_referral',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => ''
                )
        );

        $cs_opt_array = array(
            'name' => esc_html__( 'Job Detail Url', 'jobhunt-indeed-jobs' ),
            'desc' => '',
            'hint_text' => esc_html__( 'Indeed job detail page url', 'jobhunt' ),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'job_detail_url',
                'return' => true,
            ),
        );

        $cs_html_fields->cs_text_field( $cs_opt_array );

        $cs_opt_array = array(
            'name' => esc_html__( 'Company Name', 'jobhunt-indeed-jobs' ),
            'desc' => '',
            'hint_text' => esc_html__( 'Indeed job company name', 'jobhunt' ),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'company_name',
                'return' => true,
            ),
        );

        $cs_html_fields->cs_text_field( $cs_opt_array );
    }

    /**
     * Add import indeed jobs admin menu page 
     * */
    public function jobhunt_indeed_jobs_import_page() {
        add_submenu_page( 'edit.php?post_type=jobs', esc_html__( 'Import Indeed Jobs', 'jobhunt-indeed-jobs' ), esc_html__( 'Import Indeed Jobs', 'jobhunt-indeed-jobs' ), 'manage_options', 'import-indeed-jobs', array( &$this, 'jobhunt_import_indeed_jobs_settings' ) );
    }

    /**
     * Indeed jobs settings page
     * */
    public function jobhunt_import_indeed_jobs_settings() {
        global $cs_html_fields, $jobcareer_form_fields, $cs_form_fields2;
        ?>
        <div id="wrapper" class="wrap theme-wrap custom-bg-color">
            <h2><?php echo esc_html__( 'Import Indeed Jobs', 'jobhunt-indeed-jobs' ); ?></h2>
            <div class="updated" id="success_msg"><p><strong><?php _e( 'Indeed jobs are imported successfully.', 'jobhunt-indeed-jobs' ); ?></strong></p></div>
            <div class="error" id="error_msg"><p><strong><?php _e( 'Please enter publisher number to import jobs from Indeed.', 'jobhunt-indeed-jobs' ); ?></strong></p></div>
            <div class="error" id="invalid_publisher_number"></div>
            <form id="jobhunt-import-indeed-jobs" class="jobhunt-indeed-jobs" method="post" action="" enctype="multipart/form-data">
                <?php
                wp_nonce_field( 'cs-import-indeed-jobs-page', '_wpnonce-cs-import-indeed-jobs-page' );
                $cs_opt_array = array(
                    'name' => esc_html__( 'Publisher Number', 'jobhunt-indeed-jobs' ),
                    'desc' => '',
                    'hint_text' => esc_html__( 'Enter publisher number to import search jobs from Indeed.', 'jobhunt-indeed-jobs' ),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'publisher_number',
                        'cust_name' => 'publisher_number',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $cs_html_fields->cs_text_field( $cs_opt_array );

                $cs_opt_array = array(
                    'name' => esc_html__( 'Keywords', 'jobhunt-indeed-jobs' ),
                    'desc' => '',
                    'hint_text' => esc_html__( 'Enter job title, keywords or company name. Default keyword is all.', 'jobhunt-indeed-jobs' ),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'search_keywords',
                        'cust_name' => 'search_keywords',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $cs_html_fields->cs_text_field( $cs_opt_array );

                $countries_list = array();
                $countries = Job_Hunt_Indeed_API::indeed_api_countries();
                if ( $countries ) {
                    foreach ( $countries as $ke => $value ) {
                        $countries_list[$ke] = $value;
                    }
                }
                $cs_opt_array = array(
                    'name' => esc_html__( 'Country', 'jobhunt-indeed-jobs' ),
                    'desc' => '',
                    'hint_text' => esc_html__( 'Enter a country for search.', 'jobhunt-indeed-jobs' ),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'search_country',
                        'cust_name' => 'search_country',
                        'classes' => 'chosen-select-no-single',
                        'options' => $countries_list,
                        'return' => true,
                    ),
                );
                $cs_html_fields->cs_select_field( $cs_opt_array );

                $cs_opt_array = array(
                    'name' => esc_html__( 'Location', 'jobhunt-indeed-jobs' ),
                    'desc' => '',
                    'hint_text' => esc_html__( 'Enter a location for search.', 'jobhunt-indeed-jobs' ),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'search_location',
                        'cust_name' => 'search_location',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $cs_html_fields->cs_text_field( $cs_opt_array );

                $cs_opt_array = array(
                    'name' => esc_html__( 'Job Type', 'jobhunt-indeed-jobs' ),
                    'desc' => '',
                    'hint_text' => esc_html__( 'Choose which type of job to query.', 'jobhunt-indeed-jobs' ),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'job_type',
                        'cust_name' => 'job_type',
                        'classes' => 'chosen-select-no-single',
                        'options' => array(
                            'fulltime' => esc_html__( 'Full Time', 'jobhunt-indeed-jobs' ),
                            'parttime' => esc_html__( 'Part Time', 'jobhunt-indeed-jobs' ),
                            'contract' => esc_html__( 'Contract', 'jobhunt-indeed-jobs' ),
                            'internship' => esc_html__( 'Internship', 'jobhunt-indeed-jobs' ),
                            'temporary' => esc_html__( 'Temporary', 'jobhunt-indeed-jobs' ),
                        ),
                        'return' => true,
                    ),
                );
                $cs_html_fields->cs_select_field( $cs_opt_array );

                $cs_opt_array = array(
                    'name' => esc_html__( 'Sort By', 'jobhunt-indeed-jobs' ),
                    'desc' => '',
                    'hint_text' => esc_html__( 'Choose sort query results by Date/Relevance.', 'jobhunt-indeed-jobs' ),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'sort_by',
                        'cust_name' => 'sort_by',
                        'classes' => 'chosen-select-no-single',
                        'options' => array(
                            'date' => esc_html__( 'Date', 'jobhunt-indeed-jobs' ),
                            'relevance' => esc_html__( 'Relevance', 'jobhunt-indeed-jobs' ),
                        ),
                        'return' => true,
                    ),
                );
                $cs_html_fields->cs_select_field( $cs_opt_array );

                $cs_opt_array = array(
                    'name' => esc_html__( 'Start Import Jobs', 'jobhunt-indeed-jobs' ),
                    'desc' => '',
                    'hint_text' => esc_html__( 'Enter start number to import jobs. Default start number is 1.', 'jobhunt-indeed-jobs' ),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '1',
                        'cust_id' => 'start',
                        'cust_name' => 'start',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $cs_html_fields->cs_text_field( $cs_opt_array );
				
				$cs_opt_array = array(
                    'name' => esc_html__( 'No. of Jobs to Import (Maximum Limit 25)', 'jobhunt-indeed-jobs' ),
                    'desc' => '',
                    'hint_text' => esc_html__( 'Enter number of jobs to import. Default number of import jobs is 10. Maximum import jobs limit is 25.', 'jobhunt-indeed-jobs' ),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '10',
                        'cust_id' => 'limit',
                        'cust_name' => 'limit',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $cs_html_fields->cs_text_field( $cs_opt_array );

                $cs_opt_array = array(
                    'name' => esc_html__( 'Expired on', 'jobhunt-indeed-jobs' ),
                    'desc' => '',
                    'hint_text' => esc_html__( 'Enter number of days (numeric format) for expiray date after job posted date.', 'jobhunt-indeed-jobs' ),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '0',
                        'cust_id' => 'expire_days',
                        'cust_name' => 'expire_days',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $cs_html_fields->cs_text_field( $cs_opt_array );

                $cs_users_list = array();
                $cs_users = get_users( 'orderby=nicename&role=cs_employer' );
                foreach ( $cs_users as $user ) {
                    $cs_users_list[$user->ID] = $user->display_name;
                }
                $cs_opt_array = array(
                    'name' => esc_html__( 'Posted by', 'jobhunt-indeed-jobs' ),
                    'desc' => '',
                    'hint_text' => esc_html__( 'Choose import jobs posted username from this dropdown', 'jobhunt-indeed-jobs' ),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'job_username',
                        'cust_name' => 'job_username',
                        'classes' => 'chosen-select-no-single',
                        'options' => $cs_users_list,
                        'return' => true,
                    ),
                );

                $cs_html_fields->cs_select_field( $cs_opt_array );
                ?>
                <div class="form-elements">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <?php
                        $cs_opt_btn_array = array(
                            'id' => '',
                            'std' => esc_html__( 'Import Indeed Jobs', 'jobhunt-indeed-jobs' ),
                            'cust_id' => "import-indeed-jobs",
                            'cust_name' => "import-indeed-jobs",
                            'cust_type' => 'button',
                            'classes' => 'import-indeed-jobs',
                            'extra_atr' => 'onclick="javascript:jobhunt_import_indeed_jobs_submit(\'' . esc_js( admin_url( 'admin-ajax.php' ) ) . '\');" ',
                            'return' => true,
                        );
                        echo $cs_form_fields2->cs_form_text_render( $cs_opt_btn_array );
                        ?>
                        <div id="loading"><img src="<?php echo esc_url( JOBHUNT_INDEED_JOBS_PLUGIN_URL . '/assets/images/ajax-loader.gif' ); ?>" /></div>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }

    /**
     * Get Job Type
     */
    public function get_job_type( $type ) {
        switch ( $type ) {
            case 'fulltime' :
                $type = esc_html__( 'Full Time', 'jobhunt-indeed-jobs' );
                break;
            case 'parttime' :
                $type = esc_html__( 'Part Time', 'jobhunt-indeed-jobs' );
                break;
            case 'contract' :
                $type = esc_html__( 'Contract', 'jobhunt-indeed-jobs' );
                break;
            case 'internship' :
                $type = esc_html__( 'Internship', 'jobhunt-indeed-jobs' );
                break;
            case 'temporary' :
                $type = esc_html__( 'Temporary', 'jobhunt-indeed-jobs' );
                break;
        }
        return $type;
    }

    /**
     * Importing jobs in jobs post type
     */
    public function jobhunt_import_indeed_jobs() {
        $publisher_number = stripslashes( $_POST['publisher_number'] );
        $search_keywords = sanitize_text_field( stripslashes( $_POST['search_keywords'] ) );
        $search_country = sanitize_text_field( stripslashes( $_POST['search_country'] ) );
        $search_location = sanitize_text_field( stripslashes( $_POST['search_location'] ) );
        $job_type = sanitize_text_field( $_POST['job_type'] );
        $start = sanitize_text_field( $_POST['start'] );
		$limit = sanitize_text_field( $_POST['limit'] );
        $sort_by = sanitize_text_field( $_POST['sort_by'] );
        $job_username = sanitize_text_field( $_POST['job_username'] );

		$limit = $limit ? $limit : 10;
		$start = $start ? ($start-1) : 0;
        $api_args = array(
            'publisher' => $publisher_number,
            'q' => $search_keywords ? $search_keywords : 'all',
            'l' => $search_location,
            'co' => $search_country,
            'jt' => $job_type,
            'sort' => $sort_by,
            'start' => $start ? ($start-1) : 0,
			'limit' => $limit ? $limit : 10,
        );
		
        $indeed_jobs = Job_Hunt_Indeed_API::get_jobs_from_indeed( $api_args );
        $json = array();
        if ( isset( $indeed_jobs['error'] ) && $indeed_jobs['error'] != '' ) {
            $json['type'] = 'error';
            $json['message'] = $indeed_jobs['error'];
        } elseif ( empty( $indeed_jobs ) ) {
            $json['type'] = 'error';
            $json['message'] = esc_html__( 'Sorry! There are no jobs found for your search query.', 'jobhunt-indeed-jobs' );
        } else {
			$user_id = get_current_user_id();
            foreach ( $indeed_jobs as $indeed_job ) {
                $indeed_job = (object) $indeed_job;
                $post_data = array(
                    'post_type' => 'jobs',
                    'post_title' => $indeed_job->jobtitle,
                    'post_content' => $indeed_job->snippet,
                    'post_status' => 'publish',
                    'post_author' => $user_id
                );
                // Insert the job into the database
                $post_id = wp_insert_post( $post_data );

                $data = array();

                // Insert job username meta key
                add_post_meta( $post_id, 'cs_job_username', $job_username, true );
                $data['cs_job_username'] = $job_username;

                // Insert job posted on meta key
                $date = date( 'd-m-Y H:i:s', strtotime( $indeed_job->date ) );
                add_post_meta( $post_id, 'cs_job_posted', strtotime( $date ), true );
                $data['cs_job_posted'] = strtotime( $date );

                // Insert job expired on meta key
                $expire_days = $_POST['expire_days'];
                $expired_date = date( 'd-m-Y H:i:s', strtotime( "$expire_days days", strtotime( $indeed_job->date ) ) );
                add_post_meta( $post_id, 'cs_job_expired', strtotime( $expired_date ), true );
                add_post_meta( $post_id, 'cs_application_closing_date', strtotime( $expired_date ), true );
                $data['cs_job_expired'] = strtotime( $expired_date );

                // Insert job status meta key
                add_post_meta( $post_id, 'cs_job_status', 'active', true );
                $data['cs_job_status'] = 'active';

                // Insert job address meta key
                $address = array();
                if ( $indeed_job->city != '' ) {
                    $address[] = $indeed_job->city;
                }
                if ( $indeed_job->state != '' ) {
                    $address[] = $indeed_job->state;
                }
                if ( $indeed_job->country != '' ) {
                    $indeed_country = $indeed_job->country;
                    $countries = Job_Hunt_Indeed_API::indeed_api_countries();
                    $address[] = $countries[strtolower( $indeed_country )];
                }
                if ( ! empty( $address ) ) {
                    $address = implode( ', ', $address );
                    add_post_meta( $post_id, 'cs_post_loc_address', $address, true );
                    $data['cs_post_loc_address'] = $address;
                    add_post_meta( $post_id, 'cs_post_comp_address', $address, true );
                    $data['cs_post_comp_address'] = $address;
                }

                // Insert job latitude meta key
                add_post_meta( $post_id, 'cs_post_loc_latitude', esc_attr( $indeed_job->latitude ), true );
                $data['cs_post_loc_latitude'] = esc_attr( $indeed_job->latitude );

                // Insert job longitude meta key
                add_post_meta( $post_id, 'cs_post_loc_longitude', esc_attr( $indeed_job->longitude ), true );
                $data['cs_post_loc_longitude'] = esc_attr( $indeed_job->longitude );

                // Insert job referral meta key
                $cs_job_referral = esc_html__( 'indeed', 'jobhunt-indeed-jobs' );
                add_post_meta( $post_id, 'cs_job_referral', $cs_job_referral, true );
                $data['cs_job_referral'] = $cs_job_referral;

                // Insert job detail url meta key
                add_post_meta( $post_id, 'cs_job_detail_url', esc_url( $indeed_job->url ), true );
                $data['cs_job_detail_url'] = esc_url( $indeed_job->url );

                // Insert job comapny name meta key
                add_post_meta( $post_id, 'cs_company_name', $indeed_job->company, true );
                $data['cs_company_name'] = esc_attr( $indeed_job->company );
                
                add_post_meta($post_id, 'cs_job_featured', 'no');
                $data['cs_job_featured'] = 'no';
                
                update_post_meta( $post_id, 'cs_array_data', $data );

                // Create and assign taxonomy to post
                $job_type = $_POST['job_type'];
                if ( $job_type ) {
                    $job_type = self::get_job_type( $job_type );
                    $term = get_term_by( 'name', $job_type, 'job_type' );
                    if ( $term == '' ) {
                        wp_insert_term( $job_type, 'job_type' );
                        $term = get_term_by( 'name', $job_type, 'job_type' );
                    }
                    wp_set_post_terms( $post_id, $term->term_id, 'job_type' );
                }
            }
            $json['type'] = 'success';
			$json['msg'] = sprintf(__( '%s indeed jobs are imported successfully.', 'jobhunt-indeed-jobs' ), count($indeed_jobs));
        }
        echo json_encode( $json );
        die();
    }

    /**
     * Jobs shortcode admin default arguments
     */
    public function jobs_shortcode_admin_default_attributes( $defaults ) {
        $defaults['cs_job_type'] = 'all';
        return $defaults;
    }

    /**
     * Jobs shortcode admin fields
     */
    public function jobs_shortcode_admin_fields( $attrs ) {
        global $cs_html_fields;

        $cs_opt_array = array(
            'name' => esc_html__( 'Job Type', 'jobhunt-indeed-jobs' ),
            'desc' => '',
            'hint_text' => esc_html__( 'Choose job type for view only indeed or all jobs', 'jobhunt-indeed-jobs' ),
            'echo' => true,
            'field_params' => array(
                'std' => $attrs['cs_job_type'],
                'id' => 'job_type',
                'cust_name' => 'cs_job_type[]',
                'classes' => 'dropdown chosen-select',
                'options' => array(
                    'all' => esc_html__( 'All', 'jobhunt-indeed-jobs' ),
                    'indeed' => esc_html__( 'Inddeed Only', 'jobhunt-indeed-jobs' ),
                ),
                'return' => true,
            ),
        );

        $cs_html_fields->cs_select_field( $cs_opt_array );
    }

    /**
     * Jobs shortcode save admin fields
     */
    public function save_jobs_shortcode_admin_fields( $shortcode, $_result, $cs_job_counter ) {
        if ( isset( $_result['cs_job_type'][$cs_job_counter] ) && $_result['cs_job_type'][$cs_job_counter] != '' ) {
            $shortcode .= 'cs_job_type="' . htmlspecialchars( $_result['cs_job_type'][$cs_job_counter] ) . '" ';
        }
        return $shortcode;
    }

    /**
     * Jobs shortcode fontend default arguments
     */
    public function jobs_shortcode_frontend_default_attributes( $defaults ) {
        $defaults['cs_job_type'] = 'all';
        return $defaults;
    }

    /**
     * Jobs listing filter
     */
    public function indeed_jobs_listing_parameters( $args, $attr ) {

        if ( isset( $attr['cs_job_type'] ) && $attr['cs_job_type'] == 'indeed' ) {
            $filter_arr = array(
                'key' => 'cs_job_referral',
                'value' => $attr['cs_job_type'],
                'compare' => '=',
            );
            $args['meta_query'][] = $filter_arr;
        }

        return $args;
    }

}

new Job_Hunt_Indeed_Jobs();
