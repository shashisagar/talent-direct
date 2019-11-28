<?php

/**
 *  File Type: Custom Fields Class
 */
if ( ! class_exists('cs_employer_custom_fields_options') ) {

    class cs_employer_custom_fields_options {

        /**
         * Start How to crate Construct function
         */
        public function __construct() {
            add_action('wp_ajax_jobcareer_pb_employer_text', array( &$this, 'jobcareer_pb_employer_text' ));
            add_action('wp_ajax_jobcareer_pb_employer_textarea', array( &$this, 'jobcareer_pb_employer_textarea' ));
            add_action('wp_ajax_jobcareer_pb_employer_dropdown', array( &$this, 'jobcareer_pb_employer_dropdown' ));
            add_action('wp_ajax_jobcareer_pb_employer_date', array( &$this, 'jobcareer_pb_employer_date' ));
            add_action('wp_ajax_jobcareer_pb_employer_email', array( &$this, 'jobcareer_pb_employer_email' ));
            add_action('wp_ajax_jobcareer_pb_employer_url', array( &$this, 'jobcareer_pb_employer_url' ));
            add_action('wp_ajax_jobcareer_pb_employer_range', array( &$this, 'jobcareer_pb_employer_range' ));
            add_action('wp_ajax_cs_check_employer_fields_avail', array( &$this, 'cs_check_employer_fields_avail' ));
        }

        /**
         * Start How to add Employer Text Fields Function
         */
        public function jobcareer_pb_employer_text($die = 0, $cs_return = false) {
            global $cs_f_counter, $cs_employer_cus_fields;
            $cs_fields_markup = '';
            if ( isset($_REQUEST['counter']) ) {
                $cs_counter = $_REQUEST['counter'];
            } else {
                $cs_counter = $cs_f_counter;
            }
            if ( isset($cs_employer_cus_fields[$cs_counter]) ) {
                $cs_title = isset($cs_employer_cus_fields[$cs_counter]['label']) ? sprintf(esc_html__('Text : %s', 'jobhunt'), $cs_employer_cus_fields[$cs_counter]['label']) : '';
            } else {
                $cs_title = esc_html__('Text', 'jobhunt');
            }
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_text[required]',
                'title' => esc_html__('Required', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_text[label]',
                'title' => esc_html__('Title', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_text[meta_key]',
                'title' => esc_html__('Meta Key', 'jobhunt'),
                'check' => true,
                'std' => '',
                'hint' => esc_html__('Please enter Meta Key without special character and space.', 'jobhunt'),
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_text[placeholder]',
                'title' => esc_html__('Place Holder', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_text[enable_srch]',
                'title' => esc_html__('Enable Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_text[default_value]',
                'title' => esc_html__('Default Value', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_text[collapse_search]',
                'title' => esc_html__('Collapse in Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_fontawsome_icon_employer(array(
                'id' => '',
                'name' => 'cs_employer_cus_field_text[fontawsome_icon]',
                'title' => esc_html__('Icon', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields = array( 'cs_counter' => $cs_counter, 'cs_name' => 'text', 'cs_title' => $cs_title, 'cs_markup' => $cs_fields_markup );
            $cs_output = $this->cs_fields_layout($cs_fields);
            if ( $cs_return == true ) {
                return force_balance_tags($cs_output, true);
            } else {
                echo force_balance_tags($cs_output, true);
            }
            if ( $die <> 1 )
                die();
        }

        /**
         * Start How to add Employer Textarea Fields Function
         */
        public function jobcareer_pb_employer_textarea($die = 0, $cs_return = false) {
            global $cs_f_counter, $cs_employer_cus_fields;
            $cs_fields_markup = '';
            if ( isset($_REQUEST['counter']) ) {
                $cs_counter = $_REQUEST['counter'];
            } else {
                $cs_counter = $cs_f_counter;
            }
            if ( isset($cs_employer_cus_fields[$cs_counter]) ) {
                $cs_title = isset($cs_employer_cus_fields[$cs_counter]['label']) ? sprintf(esc_html__('Text Area : %s', 'jobhunt'), $cs_employer_cus_fields[$cs_counter]['label']) : '';
            } else {
                $cs_title = esc_html__('Text Area', 'jobhunt');
            }
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_textarea[required]',
                'title' => esc_html__('Required', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_textarea[label]',
                'title' => esc_html__('Title', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_textarea[meta_key]',
                'title' => esc_html__('Meta Key', 'jobhunt'),
                'check' => true,
                'std' => '',
                'hint' => esc_html__('Please enter Meta Key without special character and space', 'jobhunt'),
            ));
            $cs_fields_markup .= $this->cs_fields_input_textarea(array(
                'id' => '',
                'name' => 'employer_cus_field_textarea[help]',
                'title' => esc_html__('Help Text', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_textarea[placeholder]',
                'title' => esc_html__('Place Holder', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_textarea[rows]',
                'title' => esc_html__('Rows', 'jobhunt'),
                'std' => '5',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_textarea[cols]',
                'title' => esc_html__('Columns', 'jobhunt'),
                'std' => '25',
                'hint' => esc_html__('Please enter Meta Key without special character and space', 'jobhunt'),
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_textarea[default_value]',
                'title' => esc_html__('Default Value', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_textarea[collapse_search]',
                'title' => esc_html__('Collapse in Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_fontawsome_icon_employer(array(
                'id' => '',
                'name' => 'cs_employer_cus_field_textarea[fontawsome_icon]',
                'title' => esc_html__('Icon', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields = array( 'cs_counter' => $cs_counter, 'cs_name' => 'textarea', 'cs_title' => $cs_title, 'cs_markup' => $cs_fields_markup );
            $cs_output = $this->cs_fields_layout($cs_fields);
            if ( $cs_return == true ) {
                return force_balance_tags($cs_output, true);
            } else {
                echo force_balance_tags($cs_output, true);
            }
            if ( $die <> 1 )
                die();
        }

        /**
         * Start How to add Dropdown in  Employer Function
         */
        public function jobcareer_pb_employer_dropdown($die = 0, $cs_return = false) {
            global $cs_f_counter, $cs_form_fields2, $cs_employer_cus_fields;
            $cs_fields_markup = '';
            if ( isset($_REQUEST['counter']) ) {
                $cs_counter = $_REQUEST['counter'];
            } else {
                $cs_counter = $cs_f_counter;
            }
            if ( isset($cs_employer_cus_fields[$cs_counter]) ) {
                $cs_title = isset($cs_employer_cus_fields[$cs_counter]['label']) ? sprintf(esc_html__('Dropdown : %s', 'jobhunt'), $cs_employer_cus_fields[$cs_counter]['label']) : '';
            } else {
                $cs_title = esc_html__('Dropdown', 'jobhunt');
            }
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_dropdown[required]',
                'title' => esc_html__('Required', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_dropdown[label]',
                'title' => esc_html__('Title', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_dropdown[meta_key]',
                'title' => esc_html__('Meta Key', 'jobhunt'),
                'check' => true,
                'std' => '',
                'hint' => esc_html__('Please enter Meta Key without special character and space', 'jobhunt'),
            ));
            $cs_fields_markup .= $this->cs_fields_input_textarea(array(
                'id' => '',
                'name' => 'employer_cus_field_dropdown[help]',
                'title' => esc_html__('Help Text', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_dropdown[enable_srch]',
                'title' => esc_html__('Enable Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_dropdown[multi]',
                'title' => esc_html__('Enable Multi Select', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_dropdown[post_multi]',
                'title' => esc_html__('Post Multi Select', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_dropdown[first_value]',
                'title' => esc_html__('First Value', 'jobhunt'),
                'std' => esc_html__('- select -', 'jobhunt'),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_dropdown[collapse_search]',
                'title' => esc_html__('Collapse in Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_fontawsome_icon_employer(array(
                'id' => '',
                'name' => 'cs_employer_cus_field_dropdown[fontawsome_icon]',
                'title' => esc_html__('Icon', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= '<div class="form-elements">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_html__('Options', 'jobhunt') . '</label>
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            if ( isset($cs_employer_cus_fields[$cs_f_counter]['options']['value']) ) {
                $cs_opt_counter = 0;
                $cs_radio_counter = 1;
                foreach ( $cs_employer_cus_fields[$cs_f_counter]['options']['value'] as $cs_option ) {
                    $cs_checked = (int) $cs_employer_cus_fields[$cs_f_counter]['options']['select'][0] == (int) $cs_radio_counter ? ' checked="checked"' : '';
                    $cs_opt_label = $cs_employer_cus_fields[$cs_f_counter]['options']['label'][$cs_opt_counter];
                    $cs_fields_markup .= '
					<div class="pbwp-clone-field">';

                    $cs_opt_array = array(
                        'cust_id' => 'employer_cus_field_dropdown_selected_' . absint($cs_counter),
                        'cust_name' => 'employer_cus_field_dropdown[selected][' . absint($cs_counter) . '][]',
                        'cust_type' => 'radio',
                        'extra_atr' => $cs_checked,
                        'std' => $cs_radio_counter,
                        'classes' => 'input-small',
                        'return' => true,
                    );
                    $cs_fields_markup .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

                    $cs_opt_array = array(
                        'cust_id' => 'employer_cus_field_dropdown_options_' . absint($cs_counter),
                        'cust_name' => 'employer_cus_field_dropdown[options][' . absint($cs_counter) . '][]',
                        'extra_atr' => ' data-type="option"',
                        'std' => $cs_opt_label,
                        'classes' => 'input-small',
                        'return' => true,
                    );
                    $cs_fields_markup .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

                    $cs_opt_array = array(
                        'cust_id' => 'employer_cus_field_dropdown_options_values_' . absint($cs_counter),
                        'cust_name' => 'employer_cus_field_dropdown[options_values][' . absint($cs_counter) . '][]',
                        'std' => $cs_option,
                        'classes' => 'input-small',
                        'return' => true,
                    );
                    $cs_fields_markup .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

                    $cs_fields_markup .= '
						<img src="' . esc_url(wp_jobhunt::plugin_url() . '/assets/images/add.png') . '" class="pbwp-clone-field" alt="' . esc_html__('add another choice', 'jobhunt') . '" style="cursor:pointer; margin:0 3px;">
						<img src="' . esc_url(wp_jobhunt::plugin_url() . '/assets/images/remove.png') . '" alt="' . esc_html__('remove this choice', 'jobhunt') . '" class="pbwp-remove-field" style="cursor:pointer;">
					</div>';
                    $cs_opt_counter ++;
                    $cs_radio_counter ++;
                }
            } else {
                $cs_fields_markup .= '
				<div class="pbwp-clone-field">';

                $cs_opt_array = array(
                    'cust_id' => 'employer_cus_field_dropdown_selected_' . absint($cs_counter),
                    'cust_name' => 'employer_cus_field_dropdown[selected][' . absint($cs_counter) . '][]',
                    'cust_type' => 'radio',
                    'extra_atr' => ' checked="checked"',
                    'std' => '1',
                    'return' => true,
                );
                $cs_fields_markup .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

                $cs_opt_array = array(
                    'cust_id' => 'employer_cus_field_dropdown_options_' . absint($cs_counter),
                    'cust_name' => 'employer_cus_field_dropdown[options][' . absint($cs_counter) . '][]',
                    'extra_atr' => ' data-type="option"',
                    'std' => '',
                    'classes' => 'input-small',
                    'return' => true,
                );
                $cs_fields_markup .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

                $cs_opt_array = array(
                    'cust_id' => 'employer_cus_field_dropdown_options_values_' . absint($cs_counter),
                    'cust_name' => 'employer_cus_field_dropdown[options_values][' . absint($cs_counter) . '][]',
                    'std' => '',
                    'classes' => 'input-small',
                    'return' => true,
                );
                $cs_fields_markup .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

                $cs_fields_markup .= '<img src="' . esc_url(wp_jobhunt::plugin_url() . '/assets/images/add.png') . '" class="pbwp-clone-field" alt="' . esc_html__('add another choice', 'jobhunt') . '" style="cursor:pointer; margin:0 3px;">
					<img src="' . esc_url(wp_jobhunt::plugin_url() . '/assets/images/remove.png') . '" alt="' . esc_html__('remove this choice', 'jobhunt') . '" class="pbwp-remove-field" style="cursor:pointer;">
				</div>';
            }
            $cs_fields_markup .= '	
				</div>
			</div>';
            $cs_fields = array( 'cs_counter' => $cs_counter, 'cs_name' => 'dropdown', 'cs_title' => $cs_title, 'cs_markup' => $cs_fields_markup );
            $cs_output = $this->cs_fields_layout($cs_fields);
            if ( $cs_return == true ) {
                return force_balance_tags($cs_output, true);
            } else {
                echo force_balance_tags($cs_output, true);
            }
            if ( $die <> 1 )
                die();
        }

        /**
         * Start How to add Custom field in  Employer Function
         */
        public function jobcareer_pb_employer_date($die = 0, $cs_return = false) {
            global $cs_f_counter, $cs_employer_cus_fields;
            $cs_fields_markup = '';
            if ( isset($_REQUEST['counter']) ) {
                $cs_counter = $_REQUEST['counter'];
            } else {
                $cs_counter = $cs_f_counter;
            }
            if ( isset($cs_employer_cus_fields[$cs_counter]) ) {
                $cs_title = isset($cs_employer_cus_fields[$cs_counter]['label']) ? sprintf(esc_html__('Date : %s', 'jobhunt'), $cs_employer_cus_fields[$cs_counter]['label']) : '';
            } else {
                $cs_title = esc_html__('Date', 'jobhunt');
            }
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_date[required]',
                'title' => esc_html__('Required', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_date[label]',
                'title' => esc_html__('Title', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_date[meta_key]',
                'title' => esc_html__('Meta Key', 'jobhunt'),
                'check' => true,
                'std' => '',
                'hint' => esc_html__('Please enter Meta Key without special character and space.', 'jobhunt'),
            ));
            $cs_fields_markup .= $this->cs_fields_input_textarea(array(
                'id' => '',
                'name' => 'employer_cus_field_date[help]',
                'title' => esc_html__('Help Text', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_date[enable_srch]',
                'title' => esc_html__('Enable Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_date[date_format]',
                'title' => esc_html__('Date Format', 'jobhunt'),
                'std' => 'd.m.Y H:i',
                'hint' => esc_html__('Date Format', 'jobhunt') . ': d.m.Y H:i, Y/m/d',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_date[collapse_search]',
                'title' => esc_html__('Collapse in Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_fontawsome_icon_employer(array(
                'id' => '',
                'name' => 'cs_employer_cus_field_date[fontawsome_icon]',
                'title' => esc_html__('Icon', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields = array( 'cs_counter' => $cs_counter, 'cs_name' => 'date', 'cs_title' => $cs_title, 'cs_markup' => $cs_fields_markup );
            $cs_output = $this->cs_fields_layout($cs_fields);
            if ( $cs_return == true ) {
                return force_balance_tags($cs_output, true);
            } else {
                echo force_balance_tags($cs_output, true);
            }
            if ( $die <> 1 )
                die();
        }

        /**
         * Start Function How to add email fields  in  Employer from 
         */
        public function jobcareer_pb_employer_email($die = 0, $cs_return = false) {
            global $cs_f_counter, $cs_employer_cus_fields;
            $cs_fields_markup = '';
            if ( isset($_REQUEST['counter']) ) {
                $cs_counter = $_REQUEST['counter'];
            } else {
                $cs_counter = $cs_f_counter;
            }
            if ( isset($cs_employer_cus_fields[$cs_counter]) ) {
                $cs_title = isset($cs_employer_cus_fields[$cs_counter]['label']) ? sprintf(esc_html__('Email : %s', 'jobhunt'), $cs_employer_cus_fields[$cs_counter]['label']) : '';
            } else {
                $cs_title = esc_html__('Email', 'jobhunt');
            }
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_email[required]',
                'title' => esc_html__('Required', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_email[label]',
                'title' => esc_html__('Title', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_email[meta_key]',
                'title' => esc_html__('Meta Key', 'jobhunt'),
                'check' => true,
                'std' => '',
                'hint' => esc_html__('Please enter Meta Key without special character and space.', 'jobhunt'),
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_email[placeholder]',
                'title' => esc_html__('Place Holder', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_textarea(array(
                'id' => '',
                'name' => 'employer_cus_field_email[help]',
                'title' => esc_html__('Help Text', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_email[enable_srch]',
                'title' => esc_html__('Enable Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_email[default_value]',
                'title' => esc_html__('Default Value', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_email[collapse_search]',
                'title' => esc_html__('Collapse in Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_fontawsome_icon_employer(array(
                'id' => '',
                'name' => 'cs_employer_cus_field_email[fontawsome_icon]',
                'title' => esc_html__('Icon', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields = array( 'cs_counter' => $cs_counter, 'cs_name' => 'email', 'cs_title' => $cs_title, 'cs_markup' => $cs_fields_markup );
            $cs_output = $this->cs_fields_layout($cs_fields);
            if ( $cs_return == true ) {
                return force_balance_tags($cs_output, true);
            } else {
                echo force_balance_tags($cs_output, true);
            }
            if ( $die <> 1 )
                die();
        }

        /**
         * Start Function How to add employer custom fields  Employer from 
         */
        public function jobcareer_pb_employer_url($die = 0, $cs_return = false) {
            global $cs_f_counter, $cs_employer_cus_fields;
            $cs_fields_markup = '';
            if ( isset($_REQUEST['counter']) ) {
                $cs_counter = $_REQUEST['counter'];
            } else {
                $cs_counter = $cs_f_counter;
            }
            if ( isset($cs_employer_cus_fields[$cs_counter]) ) {
                $cs_title = isset($cs_employer_cus_fields[$cs_counter]['label']) ? sprintf(esc_html__('Url : %s', 'jobhunt'), $cs_employer_cus_fields[$cs_counter]['label']) : '';
            } else {
                $cs_title = esc_html__('Url', 'jobhunt');
            }
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_url[required]',
                'title' => esc_html__('Required', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_url[label]',
                'title' => esc_html__('Title', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_url[meta_key]',
                'title' => esc_html__('Meta Key', 'jobhunt'),
                'check' => true,
                'std' => '',
                'hint' => esc_html__('Please enter Meta Key without special character and space.', 'jobhunt'),
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_url[placeholder]',
                'title' => esc_html__('Place Holder', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_textarea(array(
                'id' => '',
                'name' => 'employer_cus_field_url[help]',
                'title' => esc_html__('Help Text', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_url[enable_srch]',
                'title' => esc_html__('Enable Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_url[default_value]',
                'title' => esc_html__('Default Value', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_url[collapse_search]',
                'title' => esc_html__('Collapse in Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_fontawsome_icon_employer(array(
                'id' => '',
                'name' => 'cs_employer_cus_field_url[fontawsome_icon]',
                'title' => esc_html__('Icon', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields = array( 'cs_counter' => $cs_counter, 'cs_name' => 'url', 'cs_title' => $cs_title, 'cs_markup' => $cs_fields_markup );
            $cs_output = $this->cs_fields_layout($cs_fields);
            if ( $cs_return == true ) {
                return force_balance_tags($cs_output, true);
            } else {
                echo force_balance_tags($cs_output, true);
            }
            if ( $die <> 1 )
                die();
        }

        /**
         * Start Function How to add employer range In  Employer from 
         */
        public function jobcareer_pb_employer_range($die = 0, $cs_return = false) {
            global $cs_f_counter, $cs_employer_cus_fields;
            $cs_fields_markup = '';
            if ( isset($_REQUEST['counter']) ) {
                $cs_counter = $_REQUEST['counter'];
            } else {
                $cs_counter = $cs_f_counter;
            }
            if ( isset($cs_employer_cus_fields[$cs_counter]) ) {
                $cs_title = isset($cs_employer_cus_fields[$cs_counter]['label']) ? sprintf(esc_html__('Range : %s', 'jobhunt'), $cs_employer_cus_fields[$cs_counter]['label']) : '';
            } else {
                $cs_title = esc_html__('Range', 'jobhunt');
            }
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_range[required]',
                'title' => esc_html__('Required', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_range[label]',
                'title' => esc_html__('Title', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_range[meta_key]',
                'title' => esc_html__('Meta Key', 'jobhunt'),
                'check' => true,
                'std' => '',
                'hint' => esc_html__('Please enter Meta Key without special character and space.', 'jobhunt'),
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_range[placeholder]',
                'title' => esc_html__('Place Holder', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_textarea(array(
                'id' => '',
                'name' => 'employer_cus_field_range[help]',
                'title' => esc_html__('Help Text', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_range[min]',
                'title' => esc_html__('Minimum Value', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_range[max]',
                'title' => esc_html__('Maximum Value', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_range[increment]',
                'title' => esc_html__('Increment Step', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_range[enable_srch]',
                'title' => esc_html__('Enable Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_range[enable_inputs]',
                'title' => esc_html__('Enable Inputs', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_range[srch_style]',
                'title' => esc_html__('Search Style', 'jobhunt'),
                'std' => '',
                'options' => array( 'input' => esc_html__('Input', 'jobhunt'), 'slider' => esc_html__('Slider', 'jobhunt'), 'input_slider' => esc_html__('Input + Slider', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_input_text(array(
                'id' => '',
                'name' => 'employer_cus_field_range[default_value]',
                'title' => esc_html__('Default Value', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_select(array(
                'id' => '',
                'name' => 'employer_cus_field_range[collapse_search]',
                'title' => esc_html__('Collapse in Search', 'jobhunt'),
                'std' => '',
                'options' => array( 'no' => esc_html__('No', 'jobhunt'), 'yes' => esc_html__('Yes', 'jobhunt') ),
                'hint' => '',
            ));
            $cs_fields_markup .= $this->cs_fields_fontawsome_icon_employer(array(
                'id' => '',
                'name' => 'cs_employer_cus_field_range[fontawsome_icon]',
                'title' => esc_html__('Icon', 'jobhunt'),
                'std' => '',
                'hint' => '',
            ));
            $cs_fields = array( 'cs_counter' => $cs_counter, 'cs_name' => 'range', 'cs_title' => $cs_title, 'cs_markup' => $cs_fields_markup );
            $cs_output = $this->cs_fields_layout($cs_fields);
            if ( $cs_return == true ) {
                return force_balance_tags($cs_output, true);
            } else {
                echo force_balance_tags($cs_output, true);
            }
            if ( $die <> 1 )
                die();
        }

        /**
         * Start Function add fields layout
         */
        public function cs_fields_layout($cs_fields) {

            global $cs_form_fields2;
            $cs_defaults = array( 'cs_counter' => '1', 'cs_name' => '', 'cs_title' => '', 'cs_markup' => '' );
            extract(shortcode_atts($cs_defaults, $cs_fields));
            $cs_html = '<div class="pb-item-container">
				<div class="pbwp-legend">';

            $cs_opt_array = array(
                'cust_id' => 'cs_employer_cus_field_title',
                'cust_name' => 'cs_employer_cus_field_title[]',
                'cust_type' => 'hidden',
                'std' => $cs_name,
                'return' => true,
            );
            $cs_html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

            $cs_opt_array = array(
                'cust_id' => 'cs_employer_cus_field_id',
                'cust_name' => 'cs_employer_cus_field_id[]',
                'cust_type' => 'hidden',
                'std' => $cs_counter,
                'return' => true,
            );
            $cs_html .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

            if ( $cs_name == 'textarea' ) {
                $cs_show_icon = 'icon-text';
            } else if ( $cs_name == 'dropdown' ) {
                $cs_show_icon = 'icon-download10';
            } else if ( $cs_name == 'date' ) {
                $cs_show_icon = 'icon-calendar-o';
            } else if ( $cs_name == 'email' ) {
                $cs_show_icon = 'icon-envelope4';
            } else if ( $cs_name == 'url' ) {
                $cs_show_icon = 'icon-link4';
            } else if ( $cs_name == 'range' ) {
                $cs_show_icon = 'icon-target5';
            } else {
                $cs_show_icon = 'icon-file-text-o';
            }

            $cs_html .= '<div class="pbwp-label"><i class="' . $cs_show_icon . '"></i> ' . esc_attr($cs_title) . ' </div>
					<div class="pbwp-actions">
						<a class="pbwp-remove" href="#"><i class="icon-times"></i></a>
						<a class="pbwp-toggle" href="#"><i class="icon-sort-down"></i></a>
					</div>
				</div>
				<div class="pbwp-form-holder" style="display:none;">';
            $cs_html .= $cs_markup;
            $cs_html .= '	
				</div>
			</div>';
            return force_balance_tags($cs_html, true);
        }

        /**
         * Start Function add custom fields in employer form
         */
        public function cs_fields_input_text($params = '') {
            global $cs_f_counter, $cs_form_fields2, $cs_html_fields, $cs_employer_cus_fields;
            $cs_output = '';
            $cs_output .= '<script>jQuery(document).ready(function($) {
                                cs_check_employer_fields_avail();
                            });</script>';
            extract($params);
            $cs_label = substr($name, strpos($name, '['), strpos($name, ']'));
            $cs_label = str_replace(array( '[', ']' ), array( '', '' ), $cs_label);
            if ( isset($cs_employer_cus_fields[$cs_f_counter]) ) {
                $cs_value = isset($cs_employer_cus_fields[$cs_f_counter][$cs_label]) ? $cs_employer_cus_fields[$cs_f_counter][$cs_label] : '';
            }
            if ( isset($cs_value) && $cs_value != '' ) {
                $value = $cs_value;
            } else {
                $value = $std;
            }
            $cs_rand_id = time();
            $html_id = $id != '' ? 'cs_' . sanitize_html_class($id) . '' : '';
            $html_name = 'cs_' . CS_FUNCTIONS()->cs_special_chars($name) . '[]';
            $cs_check_con = '';
            if ( isset($check) && $check == true ) {
                $html_id = ' id="check_field_name_' . $cs_rand_id . '"';
            }

            $cs_output .= $cs_html_fields->cs_opening_field(array(
                'name' => $title,
                'hint_text' => $hint,
            ));

            $cs_opt_array = array(
                'id' => $id,
                'cust_id' => $html_id,
                'cust_name' => $html_name,
                'std' => $value,
                'return' => true,
            );

            $cs_output .= $cs_form_fields2->cs_form_text_render($cs_opt_array);

            $cs_output .= '<span class="name-checking"></span>';

            $cs_output .= $cs_html_fields->cs_closing_field(array(
                'desc' => '',
            ));

            return force_balance_tags($cs_output);
        }

        /**
         * Start Function how to input textarea in employer form
         */
        public function cs_fields_input_textarea($params = '') {
            global $cs_f_counter, $cs_form_fields2, $cs_html_fields, $cs_employer_cus_fields;
            $cs_output = '';
            extract($params);
            $cs_label = substr($name, strpos($name, '['), strpos($name, ']'));
            $cs_label = str_replace(array( '[', ']' ), array( '', '' ), $cs_label);
            $cs_output .= '<script>jQuery(document).ready(function($) {
                                cs_check_employer_fields_avail();
                            });</script>';
            if ( isset($cs_employer_cus_fields[$cs_f_counter]) ) {
                $cs_value = isset($cs_employer_cus_fields[$cs_f_counter][$cs_label]) ? $cs_employer_cus_fields[$cs_f_counter][$cs_label] : '';
            }
            if ( isset($cs_value) && $cs_value != '' ) {
                $value = $cs_value;
            } else {
                $value = $std;
            }
            $html_id = $id != '' ? 'cs_' . sanitize_html_class($id) . '' : '';
            $html_name = 'cs_' . CS_FUNCTIONS()->cs_special_chars($name) . '[]';

            $cs_output .= $cs_html_fields->cs_opening_field(array(
                'name' => $title,
                'hint_text' => $hint,
            ));

            $cs_opt_array = array(
                'id' => $id,
                'cust_id' => $html_id,
                'cust_name' => $html_name,
                'std' => $value,
                'return' => true,
            );

            $cs_output .= $cs_form_fields2->cs_form_textarea_render($cs_opt_array);

            $cs_output .= $cs_html_fields->cs_closing_field(array(
                'desc' => '',
            ));

            return force_balance_tags($cs_output);
        }

        /**
         * Start Function how to Select fields in  employer form
         */
        public function cs_fields_select($params = '') {

            global $cs_f_counter, $cs_form_fields2, $cs_html_fields, $cs_employer_cus_fields;
            $cs_output = '';
            extract($params);
            $cs_output .= '<script>jQuery(document).ready(function($) {
                                cs_check_employer_fields_avail();
                            });</script>';
            $cs_label = substr($name, strpos($name, '['), strpos($name, ']'));
            $cs_label = str_replace(array( '[', ']' ), array( '', '' ), $cs_label);
            if ( isset($cs_employer_cus_fields[$cs_f_counter]) ) {
                $cs_value = isset($cs_employer_cus_fields[$cs_f_counter][$cs_label]) ? $cs_employer_cus_fields[$cs_f_counter][$cs_label] : '';
            }
            if ( isset($cs_value) && $cs_value != '' ) {
                $value = $cs_value;
            } else {
                $value = $std;
            }
            $html_id = $id != '' ? 'cs_' . sanitize_html_class($id) . '' : '';
            $html_name = 'cs_' . CS_FUNCTIONS()->cs_special_chars($name) . '[]';
            $html_class = 'chosen-select-no-single';

            $cs_output .= $cs_html_fields->cs_opening_field(array(
                'name' => $title,
                'hint_text' => $hint,
            ));

            $cs_opt_array = array(
                'id' => $id,
                'cust_id' => $html_id,
                'cust_name' => $html_name,
                'std' => $value,
                'classes' => $html_class,
                'options' => $options,
                'return' => true,
            );

            $cs_output .= $cs_form_fields2->cs_form_select_render($cs_opt_array);

            $cs_output .= $cs_html_fields->cs_closing_field(array(
                'desc' => '',
            ));

            return force_balance_tags($cs_output);
        }

        /**
         * Start function how to create post custom icon fields
         */
        public function cs_fields_fontawsome_icon_employer($params = '') {
            global $cs_f_counter, $cs_form_fields2, $cs_html_fields, $cs_employer_cus_fields;
            $cs_output = '';
            extract($params);
            $cs_output .= '';
            $rand_id = rand(0, 999999);
            $cs_label = substr($name, strpos($name, '['), strpos($name, ']'));
            $cs_label = str_replace(array( '[', ']' ), array( '', '' ), $cs_label);
            if ( isset($cs_employer_cus_fields[$cs_f_counter]) ) {
                $cs_value = isset($cs_employer_cus_fields[$cs_f_counter][$cs_label]) ? $cs_employer_cus_fields[$cs_f_counter][$cs_label] : '';
            }
            if ( isset($cs_value) && $cs_value != '' ) {
                $value = $cs_value;
            } else {
                $value = $std;
            }
            $html_id = $id != '' ? 'cs_' . sanitize_html_class($id) . '' : '';
            $html_name = 'cs_' . CS_FUNCTIONS()->cs_special_chars($name) . '[]';
            $html_class = 'chosen-select-no-single';

            $cs_output .= $cs_html_fields->cs_opening_field(array(
                'name' => $title,
                'hint_text' => $hint,
            ));
            $cs_output .= cs_iconlist_plugin_options($value, $id . $cs_f_counter . $rand_id, $name);

            $cs_output .= $cs_html_fields->cs_closing_field(array(
                'desc' => '',
            ));

            return force_balance_tags($cs_output);
        }

        /**
         * Start Function how to Save fields in  employer form
         */
        public function cs_save_array($cs_counter = 0, $cs_type = '', $employer_cus_field_array = array()) {
            $cs_fields = array( 'required', 'label', 'meta_key', 'placeholder', 'enable_srch', 'default_value', 'fontawsome_icon', 'help', 'rows', 'cols', 'multi', 'post_multi', 'first_value', 'collapse_search', 'date_format', 'min', 'max', 'increment', 'enable_inputs', 'srch_style' );
            $employer_cus_field_array['type'] = $cs_type;
            foreach ( $cs_fields as $field ) {
                if ( isset($_POST["cs_employer_cus_field_{$cs_type}"][$field][$cs_counter]) ) {
                    $employer_cus_field_array[$field] = $_POST["cs_employer_cus_field_{$cs_type}"][$field][$cs_counter];
                }
            }
            return $employer_cus_field_array;
        }

        /**
         * Start Function how to Update Fields in  employer form
         */
        public function cs_update_custom_fields() {
            $cs_obj = new cs_employer_custom_fields_options();
            $text_counter = $textarea_counter = $dropdown_counter = $date_counter = $email_counter = $url_counter = $range_counter = $employer_cus_field_counter = $error = 0;
            $error_msg = '';
            $employer_cus_field = array();
            if ( isset($_POST['cs_employer_cus_field_id']) && sizeof($_POST['cs_employer_cus_field_id']) > 0 ) {
                foreach ( $_POST['cs_employer_cus_field_id'] as $keys => $values ) {

                    $cs_rand_numb = rand(1342121, 9974532);
                    if ( $values != '' ) {
                        $employer_cus_field_array = array();
                        $cs_type = isset($_POST["cs_employer_cus_field_title"][$employer_cus_field_counter]) ? $_POST["cs_employer_cus_field_title"][$employer_cus_field_counter] : '';
                        switch ( $cs_type ) {
                            case('text'):
                                $employer_cus_field_array = $cs_obj->cs_save_array($text_counter, $cs_type, $employer_cus_field_array);
                                $text_counter ++;
                                break;
                            case('textarea'):
                                $employer_cus_field_array = $cs_obj->cs_save_array($textarea_counter, $cs_type, $employer_cus_field_array);
                                $textarea_counter ++;
                                break;
                            case('dropdown'):
                                $employer_cus_field_array = $cs_obj->cs_save_array($dropdown_counter, $cs_type, $employer_cus_field_array);
                                if ( isset($_POST["employer_cus_field_{$cs_type}"]['options_values'][$values]) && (strlen(implode($_POST["employer_cus_field_{$cs_type}"]['options_values'][$values])) != 0) ) {
                                    $employer_cus_field_array['options'] = array();
                                    $option_counter = 0;
                                    foreach ( $_POST["employer_cus_field_{$cs_type}"]['options_values'][$values] as $option ) {
                                        if ( $option != '' ) {
                                            $option = ltrim(rtrim($option));
                                            if ( $_POST["employer_cus_field_{$cs_type}"]['options'][$values][$option_counter] != '' ) {
                                                $employer_cus_field_array['options']['select'][] = isset($_POST["employer_cus_field_{$cs_type}"]['selected'][$values][$option_counter]) ? $_POST["employer_cus_field_{$cs_type}"]['selected'][$values][$option_counter] : '';
                                                $employer_cus_field_array['options']['label'][] = isset($_POST["employer_cus_field_{$cs_type}"]['options'][$values][$option_counter]) ? $_POST["employer_cus_field_{$cs_type}"]['options'][$values][$option_counter] : '';
                                                $employer_cus_field_array['options']['value'][] = isset($option) && $option != '' ? strtolower(str_replace(" ", "-", $option)) : '';
                                            }
                                        }
                                        $option_counter ++;
                                    }
                                } else {
                                    $error = 1;
                                    $error_msg .= sprintf(esc_html__("Please select atleast one option for '%s' field.", 'jobhunt'), $employer_cus_field_array['label']);
                                }
                                $dropdown_counter ++;
                                break;
                            case('date'):
                                $employer_cus_field_array = $cs_obj->cs_save_array($date_counter, $cs_type, $employer_cus_field_array);
                                $date_counter ++;
                                break;
                            case('email'):
                                $employer_cus_field_array = $cs_obj->cs_save_array($email_counter, $cs_type, $employer_cus_field_array);
                                $email_counter ++;
                                break;
                            case('url'):
                                $employer_cus_field_array = $cs_obj->cs_save_array($url_counter, $cs_type, $employer_cus_field_array);
                                $url_counter ++;
                                break;
                            case('range'):
                                $employer_cus_field_array = $cs_obj->cs_save_array($range_counter, $cs_type, $employer_cus_field_array);
                                $range_counter ++;
                                break;
                        }
                        $employer_cus_field[$cs_rand_numb] = $employer_cus_field_array;
                        $employer_cus_field_counter ++;
                    }
                }
            }
            if ( $error == 0 ) {
                update_option("cs_employer_cus_fields", $employer_cus_field);
                $error = 0;
                $error_msg = esc_html__('All Settings Saved', 'jobhunt');
            }
            $return_arr = array( 'error' => $error, 'error_msg' => $error_msg );
            return $return_arr;
        }

        /**
         * Start Function how to Check employer form fields in  employer form
         */
        public function cs_check_employer_fields_avail() {
            $cs_employer_cus_fields = get_option("cs_employer_cus_fields");
            $cs_json = array();
            $cs_temp_names = array();
            $cs_temp_names_1 = array();
            $cs_temp_names_2 = array();
            $cs_temp_names_3 = array();
            $cs_temp_names_4 = array();
            $cs_temp_names_5 = array();
            $cs_temp_names_6 = array();
            $cs_field_name = $_REQUEST['name'];
            $form_field_names = isset($_REQUEST['cs_employer_cus_field_text']['meta_key']) ? $_REQUEST['cs_employer_cus_field_text']['meta_key'] : array();
            $form_field_names_1 = isset($_REQUEST['cs_employer_cus_field_textarea']['meta_key']) ? $_REQUEST['cs_employer_cus_field_textarea']['meta_key'] : array();
            $form_field_names_2 = isset($_REQUEST['cs_employer_cus_field_dropdown']['meta_key']) ? $_REQUEST['cs_employer_cus_field_dropdown']['meta_key'] : array();
            $form_field_names_3 = isset($_REQUEST['cs_employer_cus_field_date']['meta_key']) ? $_REQUEST['cs_employer_cus_field_date']['meta_key'] : array();
            $form_field_names_4 = isset($_REQUEST['cs_employer_cus_field_email']['meta_key']) ? $_REQUEST['cs_employer_cus_field_email']['meta_key'] : array();
            $form_field_names_5 = isset($_REQUEST['cs_employer_cus_field_url']['meta_key']) ? $_REQUEST['cs_employer_cus_field_url']['meta_key'] : array();
            $form_field_names_6 = isset($_REQUEST['cs_employer_cus_field_range']['meta_key']) ? $_REQUEST['cs_employer_cus_field_range']['meta_key'] : array();
            $form_field_names = array_merge($form_field_names, $form_field_names_1, $form_field_names_2, $form_field_names_3, $form_field_names_4, $form_field_names_5, $form_field_names_6);
            $length = count(array_keys($form_field_names, $cs_field_name));
            if ( $cs_field_name == '' ) {
                $cs_json['type'] = 'error';
                $cs_json['message'] = '<i class="icon-times"></i> ' . esc_html__('Field name is required.', 'jobhunt');
            } else {
                if ( is_array($cs_employer_cus_fields) && sizeof($cs_employer_cus_fields) > 0 ) {
                    $success = 1;
                    foreach ( $cs_employer_cus_fields as $field_key => $cs_field ) {
                        if ( isset($cs_field['type']) ) {
                            if ( preg_match('/\s/', $cs_field_name) ) {
                                $cs_json['type'] = 'error';
                                $cs_json['message'] = '<i class="icon-times"></i> ' . esc_html__('Whitespaces not allowed', 'jobhunt');
                                echo json_encode($cs_json);
                                die();
                            }
                            if ( preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬]/', $cs_field_name) ) {
                                // one or more of the 'special characters' found in $string
                                $cs_json['type'] = 'error';
                                $cs_json['message'] = '<i class="icon-times"></i> ' . esc_html__('Special character not allowed but only (_,-).', 'jobhunt');
                                echo json_encode($cs_json);
                                die();
                            }
                            if ( trim($cs_field['type']) == trim($cs_field_name) ) {
                                if ( in_array(trim($cs_field_name), $form_field_names) && $length > 1 ) {
                                    $cs_json['type'] = 'error';
                                    $cs_json['message'] = '<i class="icon-times"></i> ' . esc_html__('Name already exist.', 'jobhunt');
                                    echo json_encode($cs_json);
                                    die();
                                }
                            } else {
                                if ( in_array(trim($cs_field_name), $form_field_names) && $length > 1 ) {
                                    $cs_json['type'] = 'error';
                                    $cs_json['message'] = '<i class="icon-times"></i> ' . esc_html__('Name already exist.', 'jobhunt');
                                    echo json_encode($cs_json);
                                    die();
                                }
                            }
                        }
                    }
                    $cs_json['type'] = 'success';
                    $cs_json['message'] = '<i class="icon-checkmark6"></i> ' . esc_html__('Name Available.', 'jobhunt');
                } else {
                    if ( preg_match('/\s/', $cs_field_name) ) {
                        $cs_json['type'] = 'error';
                        $cs_json['message'] = '<i class="icon-times"></i> ' . esc_html__('Whitespaces not allowed.', 'jobhunt');
                        echo json_encode($cs_json);
                        die();
                    }
                    if ( preg_match('/[\'^£$%&*()}{@#~?><>,|=+]/', $cs_field_name) ) {
                        // one or more of the 'special characters' found in $string
                        $cs_json['type'] = 'error';
                        $cs_json['message'] = '<i class="icon-times"></i> ' . esc_html__('Special character not allowed but only (_,-).', 'jobhunt');
                        echo json_encode($cs_json);
                        die();
                    }
                    if ( in_array(trim($cs_field_name), $form_field_names) && $length > 1 ) {
                        $cs_json['type'] = 'error';
                        $cs_json['message'] = '<i class="icon-times"></i> ' . esc_html__('Name already exist.', 'jobhunt');
                    } else {
                        $cs_json['type'] = 'success';
                        $cs_json['message'] = '<i class="icon-checkmark6"></i> ' . esc_html__('Name Available.', 'jobhunt');
                    }
                }
            }
            echo json_encode($cs_json);
            die();
        }

    }

    $cs_employer_custom_fields_obj = new cs_employer_custom_fields_options();
}
