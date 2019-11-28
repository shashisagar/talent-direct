<?php
/**
 * 
 * @return html
 *
 */
/*
 *
 * Start Function how to employer page using html
 *
 */
if ( ! function_exists('jobcareer_pb_employer') ) {

    function jobcareer_pb_employer($die = 0) {
        global $cs_node, $cs_html_fields, $cs_form_fields2, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $cs_counter = $_POST['counter'];
        if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'cs_employer';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array( 'cs_employer_all_companies'=> '', 'column_size' => '1/1', 'cs_employer_title' => '', 'cs_employer_sub_title' => '', 'cs_employer_view' => 'simple', 'cs_employer_boxsize' => '1', 'cs_employer_searchbox' => 'yes', 'cs_employer_searchbox_top' => 'no', 'cs_employer_show_pagination' => 'pagination', 'cs_employer_pagination' => '10' );
        if ( isset($output['0']['atts']) )
            $atts = $output['0']['atts'];
        else
            $atts = array();
        $employer_element_size = '25';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) )
                $$key = $atts[$key];
            else
                $$key = $values;
        }
        $name = 'jobcareer_pb_employer';
        $coloumn_class = 'column_' . $employer_element_size;
        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        ?>

        <div id="<?php echo esc_attr($name . $cs_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="employer" data="<?php echo element_size_data_array_index($employer_element_size) ?>">

            <?php cs_element_setting($name, $cs_counter, $employer_element_size); ?>
            <div class="cs-wrapp-class-<?php echo intval($cs_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $cs_counter); ?>" data-shortcode-template="[cs_employer {{attributes}}]"  style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php esc_html_e('JC: Employer Options', 'jobhunt') ?></h5>
                    <a href="javascript:cs_remove_overlay('<?php echo esc_attr($name . $cs_counter) ?>','<?php echo esc_attr($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <?php
                        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                            cs_shortcode_element_size();
                        }

                        $cs_opt_array = array(
                            'name' => esc_html__('Element Title', 'jobhunt'),
                            'desc' => '',
                            'hint_text' => esc_html__("Enter element title here.", "jobhunt"),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $cs_employer_title,
                                'id' => 'employer_title',
                                'cust_name' => 'cs_employer_title[]',
                                'return' => true,
                            ),
                        );

                        $cs_html_fields->cs_text_field($cs_opt_array);

                        $cs_opt_array = array(
                            'name' => esc_html__('Element Sub Title', 'jobhunt'),
                            'desc' => '',
                            'hint_text' => esc_html__("Enter element sub title here.", "jobhunt"),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $cs_employer_sub_title,
                                'id' => 'employer_sub_title',
                                'cust_name' => 'cs_employer_sub_title[]',
                                'return' => true,
                            ),
                        );

                        $cs_html_fields->cs_text_field($cs_opt_array);

                        $cs_opt_array = array(
                            'name' => esc_html__('Search Box (sidebar)', 'jobhunt'),
                            'desc' => '',
                            'hint_text' => esc_html__("ON/OFF sidebar search box with this dropdown.", "jobhunt"),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $cs_employer_searchbox,
                                'id' => 'employer_searchbox',
                                'cust_name' => 'cs_employer_searchbox[]',
                                'options' => array( 'yes' => esc_html__('Yes', 'jobhunt'), 'no' => esc_html__('No', 'jobhunt') ),
                                'classes' => 'chosen-select-no-single',
                                'return' => true,
                            ),
                        );

                        $cs_html_fields->cs_select_field($cs_opt_array);


                        $cs_opt_array = array(
                            'name' => esc_html__('Alphabatical Filter (top)', 'jobhunt'),
                            'desc' => '',
                            'hint_text' => esc_html__("ON/OFF top alphabatical filter with this dropdown.", "jobhunt"),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $cs_employer_searchbox_top,
                                'id' => 'employer_searchbox_top',
                                'cust_name' => 'cs_employer_searchbox_top[]',
                                'classes' => 'chosen-select-no-single',
                                'options' => array( 'yes' => esc_html__('Yes', 'jobhunt'), 'no' => esc_html__('No', 'jobhunt') ),
                                'return' => true,
                            ),
                        );

                        $cs_html_fields->cs_select_field($cs_opt_array);

                        $cs_opt_array = array(
                            'name' => esc_html__('Employer View', 'jobhunt'),
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => $cs_employer_view,
                                'id' => 'employer_view',
                                'cust_name' => 'cs_employer_view[]',
                                'classes' => 'chosen-select-no-single',
                                'extra_atr' => 'onchange="cs_show_row(this.value);"',
                                'options' => array(
                                    'alphabatic' => esc_html__('Alphabatic', 'jobhunt'),
                                    'box' => esc_html__('Box', 'jobhunt'),
                                    'fancy' => esc_html__('Fancy', 'jobhunt'),
                                    'grid' => esc_html__('Grid', 'jobhunt'),
                                    'list' => esc_html__('List', 'jobhunt'),
                                    'simple' => esc_html__('Simple', 'jobhunt'),
                                    'modern' => esc_html__('Modern', 'jobhunt'),
                                ),
                                'return' => true,
                            ),
                        );

                        $cs_html_fields->cs_select_field($cs_opt_array);
                        $column_show = '';
                        if ( $cs_employer_view == 'modern' ) {
                            $column_show = 'style="display: block;"';
                        } else {
                            $column_show = 'style="display: none;"';
                        }

                        $all_companies_show = '';
                        if ( $cs_employer_view == 'box' || $cs_employer_view == 'fancy' || $cs_employer_view == 'grid' || $cs_employer_view == 'modern' ) {
                            $all_companies_show = 'style="display: block;"';
                        } else {
                            $all_companies_show = 'style="display: none;"';
                        }


                        $cs_opt_array = array(
                            'name' => esc_html__('Columns Size', 'jobhunt'),
                            'desc' => '',
                            'hint_text' => '',
                            'id' => 'cs_box_row',
                            'echo' => true,
                            'field_params' => array(
                                'std' => $cs_employer_boxsize,
                                'id' => 'employer_boxsize',
                                'cust_name' => 'cs_employer_boxsize[]',
                                'classes' => 'chosen-select-no-single',
                                'options' => array(
                                    '12' => esc_html__('1 Columns', 'jobhunt'),
                                    '4' => esc_html__('3 Columns', 'jobhunt'),
                                    '3' => esc_html__('4 Columns', 'jobhunt'),
                                    '2' => esc_html__('6 Columns', 'jobhunt'),
                                ),
                                'return' => true,
                            ),
                        );
                        echo '<div class="column_size" ' . $column_show . '>';
                        $cs_html_fields->cs_select_field($cs_opt_array);
                        echo '</div>';
                        $cs_opt_array = array(
                            'name' => esc_html__('See All Companies url', 'jobhunt'),
                            'desc' => '',
                            'hint_text' => esc_html__("Enter url of the all companies", "jobhunt"),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $cs_employer_all_companies,
                                'id' => 'cs_employer_all_companies',
                                'cust_name' => 'cs_employer_all_companies[]',
                                'return' => true,
                            ),
                        );
                        echo '<div class="all-companies" ' . $all_companies_show . '>';
                        $cs_html_fields->cs_text_field($cs_opt_array);
                        echo '</div>';
                        $cs_opt_array = array(
                            'name' => esc_html__('Pagination', 'jobhunt'),
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => $cs_employer_show_pagination,
                                'id' => 'employer_show_pagination',
                                'cust_name' => 'cs_employer_show_pagination[]',
                                'classes' => 'chosen-select-no-single',
                                'options' => array( 'pagination' => esc_html__('Pagination', 'jobhunt'), 'single_page' => esc_html__('Single Page', 'jobhunt') ),
                                'return' => true,
                            ),
                        );

                        $cs_html_fields->cs_select_field($cs_opt_array);

                        $cs_opt_array = array(
                            'name' => esc_html__('Post Per Page', 'jobhunt'),
                            'desc' => '',
                            'hint_text' => esc_html__('To display all the records, leave this field blank', 'jobhunt'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $cs_employer_pagination,
                                'id' => 'employer_pagination',
                                'cust_name' => 'cs_employer_pagination[]',
                                'return' => true,
                            ),
                        );

                        $cs_html_fields->cs_text_field($cs_opt_array);
                        ?>
                        <script type="text/javascript">
                            function cs_show_row(selected_val) {

                                if (selected_val == 'box' || selected_val == 'fancy' || selected_val == 'grid' || selected_val == 'modern') {
                                    $('.column_size').show();
                                } else {
                                    $('.column_size').hide();
                                }

                                if (selected_val == 'modern') {
                                    $('.all-companies').show();
                                } else {
                                    $('.all-companies').hide();
                                }

                            }
                        </script>
                        <?php
                        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                            ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('jobcareer_pb_', '', $name)); ?>', '<?php echo esc_js($name . $cs_counter); ?>', '<?php echo esc_js($filter_element); ?>')" ><?php esc_html_e('Insert', 'jobhunt') ?></a> </li>
                            </ul>
                            <div id="results-shortocde"></div>
                            <?php
                        } else {
                            $cs_opt_array = array(
                                'name' => '',
                                'id' => '',
                                'desc' => '',
                                'echo' => true,
                                'fields_list' => array(
                                    array( 'type' => 'hidden', 'field_params' => array(
                                            'std' => 'employer',
                                            'id' => '',
                                            'cust_id' => '',
                                            'cust_name' => 'cs_orderby[]',
                                            'cust_type' => '',
                                            'classes' => '',
                                            'return' => true,
                                        ),
                                    ),
                                    array( 'type' => 'text', 'field_params' => array(
                                            'std' => esc_html__("Save", "jobhunt"),
                                            'id' => '',
                                            'cust_type' => 'button',
                                            'cust_id' => '',
                                            'cust_name' => '',
                                            'return' => true,
                                            'extra_atr' => 'style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" ',
                                        ),
                                    ),
                                ),
                            );
                            $cs_html_fields->cs_multi_fields($cs_opt_array);
                        }
                        ?>
                    </div>
                </div>

                <script>
                    /*
                     * modern selection box function
                     */
                    jQuery(document).ready(function ($) {
                        chosen_selectionbox();

                    });
                    /*
                     * modern selection box function
                     */
                </script> 
            </div>
        </div>

        <?php
        if ( $die <> 1 )
            die();
    }

    add_action('wp_ajax_jobcareer_pb_employer', 'jobcareer_pb_employer');
}
/*
 *
 * Start Function how to employer page using html
 *
 */