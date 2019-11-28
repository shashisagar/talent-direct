<?php

/**
 * File Type: Send Mail Job Apply Successfully Templates
 */
if ( ! class_exists('job_appied_candidate_notification_template') ) {

    class job_appied_candidate_notification_template {

        public $email_template_type;
        public $email_default_template;
        public $email_template_variables;
        public $email_template_index;
        public $is_email_sent;
        public $employer_name;
        public $candidate_email;
        public $job_title;
        public $template_group;
        public $job_url;

        public function __construct($args = '') {
            $this->email_template_type = 'Job Applied Notfication for Candidate';
            $this->email_default_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"><div style="background-color: #eeeeef; padding: 50px 0;"><table style="max-width: 640px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td style="padding: 40px 30px 30px 30px;" align="center" bgcolor="#33333e"><h1 style="color: #fff;">Job Applied Notfication for Candidate</h1></td></tr><tr><td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td width="260" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>Employer name: [EMPLOYER_NAME]Candidate email: [CANDIDATE_EMAIL]</td></tr><tr><td style="padding: 10px 0 0 0;">Job Title: [JOB_TITLE]Job url: [JOB_URL]</td></tr></table></td></tr></table></td></tr><tr><td style="background-color: #ffffff; padding: 30px 30px 30px 30px;"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td style="font-family: Arial, sans-serif; font-size: 14px;">&reg; [SITE_NAME], 2019</td></tr></tbody></table></td></tr></tbody></table></div></body></html>';

            $this->email_template_variables = array(
                array(
                    'tag' => 'EMPLOYER_NAME',
                    'display_text' => __('Employer name', 'jobhunt'),
                    'value_callback' => array( $this, 'get_employer_name' ),
                ),
                array(
                    'tag' => 'CANDIDATE_EMAIL',
                    'display_text' => __('Candidate email', 'jobhunt'),
                    'value_callback' => array( $this, 'get_candidate_email' ),
                ),
                array(
                    'tag' => 'JOB_TITLE',
                    'display_text' => __('Job Title', 'jobhunt'),
                    'value_callback' => array( $this, 'get_job_title' ),
                ),
                array(
                    'tag' => 'JOB_URL',
                    'display_text' => __('Job url', 'jobhunt'),
                    'value_callback' => array( $this, 'get_job_url' ),
                ),
            );
            $this->template_group = 'Candidate';
            $this->email_template_index = 'job-applied-candidate-notification-template';
            add_action('init', array( $this, 'add_email_template' ), 5);
            add_filter('jobhunt_email_template_settings', array( $this, 'template_settings_callback' ), 12, 1);
            add_action('job_applied_candidate_notification', array( $this, 'job_apply_candidate_callback' ));
        }

        public function job_apply_candidate_callback($arg) {

            $post_id = $arg['job_id'];
            $candidate_id = $arg['candidate_id'];
            $employer_id = $arg['user_id'];
            $post_data = get_post($post_id);
            $candidate_user = get_userdata($candidate_id);
            $emp_user = get_userdata($employer_id);

            $this->employer_name = $emp_user->display_name;
            $this->candidate_email = $candidate_user->user_email;
            $this->job_title = $post_data->post_title;
            $this->job_url = $post_data->guid;

            $template = $this->get_template();
            // checking email notification is enable/disable
            if ( isset($template['email_notification']) && $template['email_notification'] == 1 ) {

                $blogname = get_option('blogname');
                $admin_email = get_option('admin_email');
                // getting template fields
                $subject = (isset($template['subject']) && $template['subject'] != '' ) ? $template['subject'] : __("Job has been Applied Successfully!", "jobhunt");
                $from = (isset($template['from']) && $template['from'] != '') ? $template['from'] : esc_attr($blogname) . ' <' . $admin_email . '>';
                $recipients = (isset($template['recipients']) && $template['recipients'] != '') ? $template['recipients'] : $candidate_user->user_email;
                $email_type = (isset($template['email_type']) && $template['email_type'] != '') ? $template['email_type'] : 'html';

                $args = array(
                    'to' => $recipients,
                    'subject' => $subject,
                    'from' => $from,
                    'message' => $template['email_template'],
                    'email_type' => $email_type,
                );
                do_action('jobhunt_send_mail', $args);
            }
        }

        public function template_settings_callback($email_template_options) {

            $email_template_options["types"][] = $this->email_template_type;

            $email_template_options["templates"][$this->email_template_type] = $this->email_default_template;

            $email_template_options["variables"][$this->email_template_type] = $this->email_template_variables;

            return $email_template_options;
        }

        public function get_template() {
            return wp_jobhunt::get_template($this->email_template_index, $this->email_template_variables, $this->email_default_template);
        }

        function get_employer_name() {
            return $this->employer_name;
        }

        function get_candidate_email() {
            return $this->candidate_email;
        }

        function get_job_title() {
            return $this->job_title;
        }

        function get_job_url() {
            return $this->job_url;
        }

        public function add_email_template() {
            $email_templates = array();
            $email_templates[$this->template_group] = array();
            $email_templates[$this->template_group][$this->email_template_index] = array(
                'title' => $this->email_template_type,
                'template' => $this->email_default_template,
                'email_template_type' => $this->email_template_type,
                'is_recipients_enabled' => TRUE,
                'description' => __('This template is used sending email when job applied successfully', 'jobhunt'),
                'jh_email_type' => 'html',
            );
            do_action('jobhunt_load_email_templates', $email_templates);
        }

    }

    return new job_appied_candidate_notification_template();
}
