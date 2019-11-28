<?php
/**
 * Jobs detail list
 *
 */
global $wpdb, $cs_plugin_options;
$main_col = '';
if ($a['cs_job_searchbox'] == 'yes') {
    $main_col = 'col-lg-9 col-md-9 col-sm-12 col-xs-12';
}
$cs_search_result_page = isset($cs_plugin_options['cs_search_result_page']) ? $cs_plugin_options['cs_search_result_page'] : '';
$args   = apply_filters( 'jobhunt_jobs_args', $args );
$loops = new WP_Query($args);
$loop = $loops;
$loop = apply_filters('jobhunt_featured_jobs_frontend', $loop, $args);
$found_posts = $loops->found_posts;
$found_posts = apply_filters('jobhunt_feature_count_post', $found_posts);
$count_post = $found_posts;
?>
<div class="hiring-holder <?php echo cs_allow_special_char($main_col); ?>">
    <?php
    include plugin_dir_path(__FILE__) . '../jobs-search-keywords.php';

    if ((isset($a['cs_job_title']) && $a['cs_job_title'] != '') || (isset($a['cs_job_top_search']) && $a['cs_job_top_search'] != "None" && $a['cs_job_top_search'] <> '')) {
        echo ' <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <div class="row">';
        // section title
        if (isset($a['cs_job_title']) && $a['cs_job_title'] != '') {
            echo '<div class="cs-element-title"><h2>' . $a['cs_job_title'] . '</h2>';
            if (isset($a['cs_job_sub_title']) && $a['cs_job_sub_title'] != '') {
                echo '<span>' . $a['cs_job_sub_title'] . '</span>';
            }
            echo '</div>';
        }
        // sub title with total rec 
        if (isset($a['cs_job_top_search']) && $a['cs_job_top_search'] != "None" && $a['cs_job_top_search'] <> '') {

            if (isset($a['cs_job_top_search']) and $a['cs_job_top_search'] == "total_records") {
                echo '<h2>';
                ?><span class="result-count"><?php if (isset($count_post) && $count_post != '') echo esc_html($count_post) . " "; ?></span><?php
                if (isset($specialisms) && is_array($specialisms)) {
                    echo get_specialism_headings($specialisms);
                } else {

                    echo esc_html__("Jobs & Vacancies", "jobhunt");
                }
                echo "</h2>";
            } else if (isset($a['cs_job_top_search']) and $a['cs_job_top_search'] == "Filters") {
                include plugin_dir_path(__FILE__) . '../jobs-sort-filters.php';
            }
        }
        echo '</div></div>';
    }
    ?>
    <ul class="jobs-listing simple">
        <?php
        // getting if record not found
        if ($loop->have_posts()) {
            $flag = 1;
            while ($loop->have_posts()) : $loop->the_post();
                global $post;
                $cs_job_id = $post;
                $cs_job_posted = get_post_meta($cs_job_id, 'cs_job_posted', true);

                $cs_jobs_address = get_user_address_string_for_list($cs_job_id);
                $cs_jobs_thumb_url = '';
                // get employer images at run time
                $cs_job_employer = get_post_meta($cs_job_id, "cs_job_username", true); //
                $cs_job_employer = cs_get_user_id_by_login($cs_job_employer);
                $employer_img = get_the_author_meta('user_img', $cs_job_employer);
                if ($employer_img != '') {
                    $cs_jobs_thumb_url = cs_get_img_url($employer_img, 'cs_media_5');
                }
                $cs_jobs_thumb_url = apply_filters('digitalmarketing_job_image',$cs_jobs_thumb_url,$cs_job_id);
                if (!cs_image_exist($cs_jobs_thumb_url) || $cs_jobs_thumb_url == "") {
                    $cs_jobs_thumb_url = esc_url(wp_jobhunt::plugin_url() . 'assets/images/img-not-found16x9.jpg');
                }
                $cs_job_featured = get_post_meta($cs_job_id, 'cs_job_featured', true);
                // get all job types
                $all_specialisms = get_the_terms($cs_job_id, 'specialisms');
                $specialisms_values = '';
                $specialisms_class = '';
                $specialism_flag = 1;
                if ($all_specialisms != '') {
                    foreach ($all_specialisms as $specialismsitem) {
                        $specialisms_values .= $specialismsitem->name;
                        $specialisms_class .= $specialismsitem->slug;
                        if ($specialism_flag != count($all_specialisms)) {
                            $specialisms_values .= ", ";
                            $specialisms_class .= " ";
                        }
                        $specialism_flag++;
                    }
                }
                ?>
                <li>	<div class="jobs-content">
                        <div class="cs-media">
                            <?php if (isset($cs_jobs_thumb_url) and $cs_jobs_thumb_url <> '') { ?>
                                <figure><a class="hiring-detail-img" href="<?php echo esc_url(get_permalink($cs_job_id)); ?>"><img src="<?php echo esc_url($cs_jobs_thumb_url); ?>" alt=""></a></figure>
                            <?php } ?>
                            <div class="list-options">
                                <?php
                                echo '<div class="cs-shortlist">';
                                if (!is_user_logged_in() || !$login_user_is_employer_flag) {

                                    if (is_user_logged_in()) {
                                        $user = cs_get_user_id();

                                        $finded_result_list = cs_find_index_user_meta_list($cs_job_id, 'cs-user-jobs-wishlist', 'post_id', cs_get_user_id());
                                        if (isset($user) and $user <> '' and is_user_logged_in()) {
                                            if (is_array($finded_result_list) && !empty($finded_result_list)) {
                                                ?>
                                                <a class="cs-color whishlist_icon shortlist" href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="<?php esc_html_e("Added to Shortlist", "jobhunt"); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($cs_job_id); ?>" onclick="cs_removejobs_to('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($cs_job_id); ?>', this)" ><i class="icon-heart6"></i>
                                                    <?php esc_html_e('Shortlisted', 'jobhunt'); ?>
                                                </a> 
                                                <?php
                                            } else {
                                                ?>
                                                <a class="cs-color whishlist_icon shortlist" href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="<?php esc_html_e("Add to Shortlist", "jobhunt"); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($cs_job_id); ?>" onclick="cs_addjobs_to_wish('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($cs_job_id); ?>', this)" ><i class="icon-heart-o"></i> <?php esc_html_e('Shortlist', 'jobhunt'); ?></a> 
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <a class="cs-color whishlist_icon shortlist" href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="<?php esc_html_e("Add to Shortlist", "jobhunt"); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($cs_job_id); ?>" onclick="cs_addjobs_to_wish('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($cs_job_id); ?>', this)" ><i class="icon-heart-o">

                                                    <?php esc_html_e('Shortlist', 'jobhunt'); ?></i>
                                            </a> 	
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <button type="button" class="cs-color heart-btn shortlist" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e("Add to Shortlist", "jobhunt"); ?>" onclick="trigger_func('#btn-header-main-login');"><i class='icon-heart-o'></i></button> <?php esc_html_e('Shortlist', 'jobhunt'); ?>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <a class="cs-color whishlist_icon shortlist" href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="<?php esc_html_e("Add to Shortlist", "jobhunt"); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($cs_job_id); ?>" onclick="show_alert_msg('<?php echo esc_html__("Become a candidate then try again.", "jobhunt"); ?>')" ><i class="icon-heart-o"></i></a>
                                    <?php
                                }
                                echo '</div>';
                                ?>
                            </div>
                        </div>
                        <div class="cs-text">
                            <div class="cs-post-title">
                                <h3><a href="<?php echo esc_url(get_permalink($cs_job_id)); ?>"><?php do_action( 'jobhunt_job_title_start', $cs_job_id ); ?><?php echo esc_html(get_the_title($cs_job_id)); ?></a></h3>
                            </div>
                            <?php if ($cs_job_posted <> '') { ?><span><?php echo esc_html__("Posted:", "jobhunt") . " " . cs_time_elapsed_string($cs_job_posted); ?></span><?php } ?>
                            <?php if ($cs_job_featured == "yes" || $cs_job_featured == 'on') { ?>     
                                <span class="listing-featered"><?php esc_html_e('FEATURED', 'jobhunt'); ?></span>
                            <?php } ?>
                            <?php
                            $job_company_name = apply_filters('jobhunt_feature_company_name', '', $cs_job_id,'detail');
                            echo force_balance_tags($job_company_name);
                            ?>
                            <ul class="payment-detail">
                                <?php
                                $cs_job_cus_fields = get_option("cs_job_cus_fields");
                                if (is_array($cs_job_cus_fields) && sizeof($cs_job_cus_fields) > 0) {

                                    $custom_field_box = 1;

                                    foreach ($cs_job_cus_fields as $cus_field) {
                                        if ($cus_field['meta_key'] != '') {
                                            $data = get_post_meta($cs_job_id, $cus_field['meta_key'], true);
                                            // empty check of value

                                            if ($cus_field['label'] != '')
                                                if ($data != "") {
                                                    ?>  <li> 
                                                    <?php
                                                        if (isset($cus_field['fontawsome_icon']) && $cus_field['fontawsome_icon'] != '') {
                                                            echo '<i class="' . $cus_field['fontawsome_icon'] . '"></i>';
                                                        }
                                                        ?>

                                                        <?php echo esc_html($cus_field['label']); ?>
                                                        <span> <?php
                                                        // check the data is array or not
                                                        if (is_array($data)) {
                                                            $data_flage = 1;
                                                            foreach ( $data as $datavalue ) {
                                                                if ( $cus_field['type'] == 'dropdown' ) {
                                                                    $options = $cus_field['options']['value'];
                                                                    if ( isset($options) ) {
                                                                        $finded_array = array_search($datavalue, $options);
                                                                        $datavalue = isset($finded_array) ? $cus_field['options']['label'][$finded_array] : '';
                                                                    }
                                                                    $comma = esc_html($datavalue);
                                                                    $comma = ', ';
                                                                } else {
                                                                    echo esc_html($datavalue);
                                                                }
                                                                if ( $data_flage != count($data) ) {
                                                                    echo "";
                                                                }
                                                                $data_flage ++;
                                                            }
                                                        } else {
                                                            if ( $cus_field['type'] == 'dropdown' ) {
                                                                $options = $cus_field['options']['value'];
                                                                if ( isset($options) ) {
                                                                    $finded_array = array_search($data, $options);
                                                                    $data = isset($finded_array) ? $cus_field['options']['label'][$finded_array] : '';
                                                                }
                                                                echo esc_html($data);
                                                            } else {
                                                                echo esc_html($data);
                                                            }
                                                        }
                                                        ?> </span>
                                                    </li><?php
                                if (($custom_field_box % 3 == 0 && $custom_field_box > 0) && count($cs_job_cus_fields) != $custom_field_box)
                                    echo '';
                                $custom_field_box++;
                            }
                    }
                }
                if ($custom_field_box % 3 != 0 && $custom_field_box > 0)
                    echo "";
            }
                                    ?>
                            </ul>
                            <p><?php echo wp_trim_words(get_the_content($cs_job_id), 30, '...'); ?></p>
                        </div>
                    </div>
                </li><?php
                        $flag++;
                    endwhile;
                } else {
                    echo '<li class="ln-no-match">';
                    echo '<div class="massage-notfound">
            <div class="massage-title">
             <h6><i class="icon-warning4"></i><strong> ' . esc_html__('Sorry !', 'jobhunt') . '</strong>&nbsp; ' . esc_html__("There are no listings matching your search.", 'jobhunt') . ' </h6>
            </div>
             <ul>
                <li>' . esc_html__("Please re-check the spelling of your keyword", 'jobhunt') . ' </li>
                <li>' . esc_html__("Try broadening your search by using general terms", 'jobhunt') . '</li>
                <li>' . esc_html__("Try adjusting the filters applied by you", 'jobhunt') . '</li>
             </ul>
          </div>';
                    echo '</li>';
                }
                            ?> 
    </ul>
    <?php
//==Pagination Start
    if ($found_posts > $cs_blog_num_post && $cs_blog_num_post > 0 && $a['cs_job_show_pagination'] == "pagination") {
        echo '<nav>';
        echo cs_pagination($found_posts, $cs_blog_num_post, $qrystr, 'Show Pagination', 'page_job');
        echo ' </nav>';
    }//==Pagination End 
    ?>
</div>
