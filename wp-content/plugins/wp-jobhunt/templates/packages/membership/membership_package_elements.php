<?php
/*
 *
 * @Shortcode Name : Job Package
 * @retrun
 */
$cs_jh_scodes['membership_package'] = array(
    'title' => esc_html__('Apply Job Package', 'jobhunt'),
    'name' => 'membership_package',
    'icon' => 'icon-table',
    'categories' => 'loops misc',
    'attributes' => array(
        'membership_package_title' => '',
        'membership_package_style' => '',
        'membership_packages' => '',
        'membership_package_columns' => '',
    )
);

/*
 * Start Function how to Create job package
 */
if ( ! function_exists('jobcareer_pb_membership_package') ) {
    function jobcareer_pb_membership_package($die = 0) {
        global $cs_node, $cs_html_fields, $post, $cs_form_fields2;
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
            $PREFIX = 'cs_membership_package';
            $parseObject = new ShortcodeParse();
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $output = $parseObject->cs_shortcodes($output, $shortcode_str, true, $PREFIX);
           
        }
        $defaults = array(
            'membership_package_title' => '',
            'membership_package_style' => '',
            'membership_packages' => '',
            'membership_package_columns' => '',
        );

        if ( isset($output['0']['atts']) )
            $atts = $output['0']['atts'];
        else
            $atts = array();
        if ( isset($output['0']['content']) )
            $membership_package_content = $output['0']['content'];
        else
            $membership_package_content = '';
        $membership_package_element_size = '50';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) )
                $$key = $atts[$key];
            else
                $$key = $values;
        }
        $name = 'jobcareer_pb_membership_package';
        $coloumn_class = 'column_' . $membership_package_element_size;
        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }

        $cs_rand_id = rand(13441324, 93441324);
        ?>

        <div id="<?php echo esc_attr($name . $cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="membership_package" data="<?php echo cs_element_size_data_array_index($membership_package_element_size) ?>" >
            <?php cs_element_setting($name, $cs_counter, $membership_package_element_size, '', 'ellipsis-h', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo intval($cs_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $cs_counter) ?>" data-shortcode-template="[cs_membership_package {{attributes}}]{{content}}[/cs_membership_package]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php esc_html_e('JC: Apply Job Package OPTION', 'jobhunt'); ?></h5>
                    <a href="javascript:removeoverlay('<?php echo esc_js($name . $cs_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
                    
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <?php
                        echo "<pre>";
                        print_r($shortcode_view);
                        echo "</pre>";
                        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                            jobcareer_shortcode_element_size();
                        }
                        $cs_opt_array = array(
                            'name' => esc_html__('Element Title', 'jobhunt'),
                            'desc' => '',
                            'hint_text' => esc_html__('Add Job packages title here.', 'jobhunt'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $membership_package_title,
                                'id' => 'membership_package_title',
                                'cust_name' => 'membership_package_title[]',
                                'return' => true,
                            ),
                        );

                        $cs_html_fields->cs_text_field($cs_opt_array);

                        $cs_opt_array = array(
                            'name' => esc_html__('Columns', 'jobhunt'),
                            'desc' => '',
                            'echo' => true,
                            'hint_text' => esc_html__("Select column for display view", "jobhunt"),
                            'field_params' => array(
                                'std' => esc_attr($membership_package_columns),
                                'cust_id' => 'membership_package_columns',
                                'cust_name' => 'membership_package_columns[]',
                                'classes' => 'chosen-select-no-single select-medium',
                                'options' => array(
                                    '2' => esc_html__('Two Columns', 'jobhunt'),
                                    '3' => esc_html__('Three Columns', 'jobhunt'),
                                    '4' => esc_html__('Four Columns', 'jobhunt'),
                                ),
                                'return' => true,
                            ),
                        );
                        $cs_html_fields->cs_select_field($cs_opt_array);


                        $cs_opt_array = array(
                            'name' => esc_html__('Style', 'jobhunt'),
                            'desc' => '',
                            'hint_text' => esc_html__('Choose packages style with this dropdown.', 'jobhunt'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $membership_package_style,
                                'id' => 'membership_package_style',
                                'classes' => 'dropdown chosen-select',
                                'cust_name' => 'membership_package_style[]',
                                'options' => array(
                                    'advance' => esc_html__('Box', 'jobhunt'),
                                    //'basic' => esc_html__('Basic', 'jobhunt'),
                                    'classic' => esc_html__('Classic', 'jobhunt'),
                                    'fancy' => esc_html__('Fancy', 'jobhunt'),
                                    'modern' => esc_html__('Modern', 'jobhunt'),
                                    //'simple' => esc_html__('Simple', 'jobhunt'),
                                ),
                                'return' => true,
                            ),
                        );

                        $cs_html_fields->cs_select_field($cs_opt_array);

                        $cs_plugin_options = get_option('cs_plugin_options');
                        
                        $cs_membership_packages_options = isset($cs_plugin_options['cs_membership_pkgs_options']) ? $cs_plugin_options['cs_membership_pkgs_options'] : '';
                        $membership_packages = explode(',', $membership_packages);
                        if ( ! is_array($membership_packages) ) {
                            $membership_packages = array();
                        }

                        if ( is_array($cs_membership_packages_options) && sizeof($cs_membership_packages_options) > 0 ) {

                            $cs_membership_pkgs_options = '';
                            foreach ( $cs_membership_packages_options as $package_key => $package ) {
                                if ( isset($package_key) && $package_key <> '' ) {
                                    $package_id = isset($package['membership_pkg_id']) ? $package['membership_pkg_id'] : '';
                                    $package_title = isset($package['memberhsip_pkg_title']) ? $package['memberhsip_pkg_title'] : '';
                                    $cs_selected = in_array($package_id, $membership_packages) ? ' selected="selected"' : '';

                                    $cs_membership_pkgs_options .= '<option' . $cs_selected . ' value="' . absint($package_id) . '">' . CS_FUNCTIONS()->cs_special_chars($package_title) . '</option>' . "\n";
                                }
                            }

                            $cs_opt_array = array(
                                'name' => esc_html__('Packages', 'jobhunt'),
                                'desc' => '',
                                'hint_text' => esc_html__('Select packages which do you want show. If you don’t have any package create new from Dashboard >> Jobs >> Settings >> Packages.', 'jobhunt'),
                                'multi' => true,
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $membership_packages,
                                    'id' => 'membership_packages',
                                    'cust_name' => 'membership_packages[' . $cs_rand_id . '][]',
                                    'options_markup' => true,
                                    'options' => $cs_membership_pkgs_options,
                                    'return' => true,
                                ),
                            );

                            $cs_html_fields->cs_select_field($cs_opt_array);
                        }
                        ?>

                    </div>
                    <?php if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
                        <ul class="form-elements insert-bg">
                            <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo str_replace('jobcareer_pb_', '', $name); ?>', '<?php echo esc_js($name . $cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php esc_html_e('Insert', 'jobhunt'); ?></a> </li>
                        </ul>
                        <div id="results-shortocde"></div>
                    <?php } else { ?>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                                <?php
                                $cs_opt_array = array(
                                    'id' => '',
                                    'std' => 'membership_package',
                                    'cust_id' => "",
                                    'cust_name' => "cs_orderby[]",
                                );

                                $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                                $cs_opt_array = array(
                                    'id' => '',
                                    'std' => absint($cs_rand_id),
                                    'cust_id' => "",
                                    'cust_name' => "cs_membershi_pkg_id[]",
                                );

                                $cs_form_fields2->cs_form_hidden_render($cs_opt_array);
                                $cs_opt_array = array(
                                    'id' => '',
                                    'std' => esc_html__('Save', 'jobhunt'),
                                    'cust_id' => "",
                                    'cust_name' => "",
                                    'cust_type' => 'button',
                                    'extra_atr' => 'style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))"',
                                );

                                $cs_form_fields2->cs_form_text_render($cs_opt_array);
                                ?>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
        <script>
            /*
             * popup over 
             */
            popup_over();

            /*
             * modern selection box function
             */
            jQuery(document).ready(function ($) {
                chosen_selectionbox();
            });
        </script> 
        <?php
        if ( $die <> 1 )
            die();
    }

    add_action('wp_ajax_jobcareer_pb_membership_package', 'jobcareer_pb_membership_package');
}