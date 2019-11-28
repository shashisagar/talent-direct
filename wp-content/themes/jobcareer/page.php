<?php
/**
 * The template for displaying all pages
 */
get_header();
$var_arrays = array('post', 'member_column', 'jobcareer_node', 'jobcareer_sidebarLayout', 'jobcareer_xmlObject', 'cs_blog_cat', 'jobcareer_node_id', 'jobcareer_column_atts', 'jobcareer_paged_id');
$page_global_vars = CS_JOBCAREER_GLOBALS()->globalizing($var_arrays);
extract($page_global_vars);
$cs_post_id = isset($post->ID) ? $post->ID : '';
if (isset($cs_post_id) and $cs_post_id <> '') {
    $cs_postObject = get_post_meta($post->ID, 'cs_full_data', true);
} else {
    $cs_post_id = '';
}
$cs_page_upcoming = isset($cs_postObject['cs_page_upcoming']) ? $cs_postObject['cs_page_upcoming'] : '';
$cs_upcoming_page_description = isset($cs_postObject['cs_upcoming_page_description']) ? $cs_postObject['cs_upcoming_page_description'] : '';
?>
<!-- Main Content Section -->
<?php if (isset($cs_page_upcoming) && $cs_page_upcoming == "on") { ?>
    <div class="container">        
        <!-- Row Start -->
        <div class="row">
    	<div class="col-md-12">
		<?php echo html_entity_decode($cs_upcoming_page_description); ?>
    	</div>
        </div>
    </div>
<?php } else {
    ?>
    <div class="main-section">
	<?php
	$cs_page_sidebar_right = '';
	$cs_page_sidebar_left = '';
	$cs_postObject = get_post_meta($post->ID, 'cs_full_data', true);
	$cs_page_layout = get_post_meta($post->ID, 'cs_page_layout', true);
	$cs_page_sidebar_right = get_post_meta($post->ID, 'cs_page_sidebar_right', true);
	$cs_page_sidebar_left = get_post_meta($post->ID, 'cs_page_sidebar_left', true);
	$jobcareer_page_bulider = get_post_meta($post->ID, "cs_page_builder", true);
	$section_container_width = '';

	$page_element_size = 'page-content-fullwidth';

	if (!isset($cs_page_layout) || $cs_page_layout == "" || $cs_page_layout == "none") {
	    $page_element_size = 'page-content-fullwidth';
	} else {
	    $page_element_size = 'page-content col-lg-9 col-md-9 col-sm-12 col-xs-12';
	}
	$jobcareer_xmlObject = '';

	if (isset($jobcareer_page_bulider) && $jobcareer_page_bulider <> '') {
	    $jobcareer_xmlObject = new SimpleXMLElement($jobcareer_page_bulider);
	}
	if (isset($cs_page_layout)) {
	    $jobcareer_sidebarLayout = $cs_page_layout;
	}
	$pageSidebar = false;
	if ($jobcareer_sidebarLayout == 'left' || $jobcareer_sidebarLayout == 'right') {
	    $pageSidebar = true;
	}

	if (!empty($jobcareer_xmlObject[0])) {
	    $count = count($jobcareer_xmlObject) > 1;
	} else {
	    $count = '';
	}
	if (isset($jobcareer_xmlObject) && !empty($jobcareer_xmlObject) && $count) {
	    if (isset($cs_page_layout)) {
		$cs_page_sidebar_right = $cs_page_sidebar_right;
		$cs_page_sidebar_left = $cs_page_sidebar_left;
	    }
	    $cs_counter_node = $column_no = 0;
	    $fullwith_style = '';
	    $section_container_style_elements = ' ';
	    if (isset($cs_page_layout) && $jobcareer_sidebarLayout <> '' and $jobcareer_sidebarLayout <> "none") {

		$fullwith_style = 'style="width:100%;"';
		$section_container_style_elements = ' width: 100%;';
		echo '<div class="container">';
		echo '<div class="row">';
		if (isset($cs_page_layout) && $jobcareer_sidebarLayout <> '' and $jobcareer_sidebarLayout <> "none" and $jobcareer_sidebarLayout == 'left') :
		    ?>
		    <aside class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<?php
			if (is_active_sidebar(jobcareer_get_sidebar_id($cs_page_sidebar_left))) {
			    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_page_sidebar_left)) : endif;
			}
			?>
		    </aside>
		    <?php
		endif;
		echo '<div class="' . ($page_element_size) . '">';
	    }

	    if (post_password_required()) {
		echo '<header class="heading"><h6 class="transform">' . get_the_title() . '</h6></header>';
		echo jobcareer_password_form();
	    } else {
		$width = 840;
		$height = 328;
		$image_url = jobcareer_get_post_img_src($post->ID, $width, $height);
		wp_reset_postdata();

		if (get_the_content() <> '') {
		    if ($pageSidebar != true) {
			?>
		        <div class="page-section">
		    	<!-- Container Start -->
		    	<div class="container">
		    	    <div class="row">
		    		<div class="col-md-12 lightbox">
					<?php
				    }
				    if (isset($cs_page_upcoming) && $cs_page_upcoming == "on") {
					
				    } else {
					if (isset($image_url) && $image_url != '') {
					    ?>
					    <a  href="<?php echo esc_url($image_url); ?>" data-rel="prettyPhoto" data-title="">
						<figure>
						    <div class="page-featured-image">
							<img class="img-thumbnail cs-page-thumbnail" title="" alt="thumbnail" data-src="" src="<?php echo esc_url($image_url); ?>">
						    </div>
						</figure>
					    </a>
					    <?php
					}
				    }
				    the_content();
				    wp_link_pages(array(
					'before' => '<div class="page-content-links"><strong class="page-links-title">' . esc_html__('Pages:', 'jobcareer') . '</strong>',
					'after' => '</div>',
					'link_before' => '<span>',
					'link_after' => '</span>',
					'pagelink' => '%',
					'separator' => '',
				    ));
				    if ($pageSidebar != true) {
					?>
		    		</div>
		    	    </div>
		    	</div>
		        </div>
			<?php
		    }
		}
	    }

	    $cs_page_inline_style = '';
	    if (isset($jobcareer_xmlObject->column_container)) {
		$cs_elem_id = 0;
	    }
	    foreach ($jobcareer_xmlObject->column_container as $column_container) {

		$cs_section_bg_image = $cs_section_bg_image_position = $cs_section_bg_image_repeat = $cs_section_bg_color = $cs_section_padding_top = $cs_section_padding_bottom = $cs_section_custom_style = $cs_section_css_id = $cs_layout = $cs_sidebar_left = $cs_sidebar_right = $css_bg_image = '';
		$section_style_elements = '';
		$section_container_style_elements = '';
		$section_video_element = '';
		$cs_section_bg_color = '';
		$cs_section_view = 'container';
		$cs_section_rand_id = rand(123456, 987654);
		if (isset($column_container)) {

		    $jobcareer_column_atts = $column_container->attributes();
		    $column_class = $jobcareer_column_atts->class;
		    $parallax_class = '';
		    $parallax_data_type = '';
		    $cs_section_background_option = $jobcareer_column_atts->cs_section_background_option;

		    $cs_section_parallax = $jobcareer_column_atts->cs_section_parallax;
		    if (isset($cs_section_parallax) && (string) $cs_section_parallax == 'yes' && isset($cs_section_background_option) && $cs_section_background_option == 'section-custom-background-image') {
			echo '<script>jQuery(document).ready(function($){cs_parallax_func()});</script>';
			$parallax_class = ($cs_section_parallax == 'yes') ? 'parallex-bg' : '';
			$parallax_data_type = ' data-type="background"';
		    }
		    $cs_section_margin_top = $jobcareer_column_atts->cs_section_margin_top;
		    $cs_section_margin_bottom = $jobcareer_column_atts->cs_section_margin_bottom;
		    $cs_section_padding_top = $jobcareer_column_atts->cs_section_padding_top;
		    $cs_section_padding_bottom = $jobcareer_column_atts->cs_section_padding_bottom;
		    $cs_section_view = $jobcareer_column_atts->cs_section_view;
		    $cs_section_border_color = $jobcareer_column_atts->cs_section_border_color;
		    if (isset($cs_section_border_color) && $cs_section_border_color != '') {
			$section_style_elements .= '';
		    }
		    if (isset($cs_section_margin_top) && $cs_section_margin_top != '') {
			$section_style_elements .= 'margin-top: ' . $cs_section_margin_top . 'px;';
		    }
		    if (isset($cs_section_padding_top) && $cs_section_padding_top != '') {
			$section_style_elements .= 'padding-top: ' . $cs_section_padding_top . 'px;';
		    }
		    if (isset($cs_section_padding_bottom) && $cs_section_padding_bottom != '') {
			$section_style_elements .= 'padding-bottom: ' . $cs_section_padding_bottom . 'px;';
		    }
		    if (isset($cs_section_margin_bottom) && $cs_section_margin_bottom != '') {
			$section_style_elements .= 'margin-bottom: ' . $cs_section_margin_bottom . 'px;';
		    }
		    $cs_section_border_top = $jobcareer_column_atts->cs_section_border_top;
		    $cs_section_border_bottom = $jobcareer_column_atts->cs_section_border_bottom;
		    if (isset($cs_section_border_top) && $cs_section_border_top != '') {
			$section_style_elements .= 'border-top: ' . $cs_section_border_top . 'px ' . $cs_section_border_color . ' solid;';
		    }
		    if (isset($cs_section_border_bottom) && $cs_section_border_bottom != '') {
			$section_style_elements .= 'border-bottom: ' . $cs_section_border_bottom . 'px ' . $cs_section_border_color . ' solid;';
		    }
		    $cs_section_background_option = $jobcareer_column_atts->cs_section_background_option;
		    $cs_section_bg_image_position = $jobcareer_column_atts->cs_section_bg_image_position;
		    if (isset($jobcareer_column_atts->cs_section_bg_color))
			$cs_section_bg_color = $jobcareer_column_atts->cs_section_bg_color;
		    if (isset($cs_section_background_option) && $cs_section_background_option == 'section-custom-background-image') {
			$cs_section_bg_image = $jobcareer_column_atts->cs_section_bg_image;
			$cs_section_bg_image_position = $jobcareer_column_atts->cs_section_bg_image_position;
			$cs_section_bg_imageg = '';
			if (isset($cs_section_bg_image) && $cs_section_bg_image != '') {
			    if (isset($cs_section_parallax) && (string) $cs_section_parallax == 'yes') {
				$cs_section_bg_imageg = 'url(' . $cs_section_bg_image . ') ' . $cs_section_bg_image_position . ' ' . ' fixed';
			    } else {
				$cs_section_bg_imageg = 'url(' . $cs_section_bg_image . ') ' . $cs_section_bg_image_position . ' ';
			    }
			}
			$section_style_elements .= 'background: ' . $cs_section_bg_imageg . ' ' . $cs_section_bg_color . ';';
		    } else if (isset($cs_section_background_option) && $cs_section_background_option == 'section_background_video') {
			$cs_section_video_url = $jobcareer_column_atts->cs_section_video_url;
			$cs_section_video_mute = $jobcareer_column_atts->cs_section_video_mute;
			$cs_section_video_autoplay = $jobcareer_column_atts->cs_section_video_autoplay;
			$mute_flag = $mute_control = '';
			$mute_flag = 'true';
			if ($cs_section_video_mute == 'yes') {
			    $mute_flag = 'false';
			    $mute_control = 'controls muted ';
			}
			$cs_video_autoplay = 'autoplay';
			if ($cs_section_video_autoplay == 'yes') {
			    $cs_video_autoplay = 'autoplay';
			} else {
			    $cs_video_autoplay = '';
			}
			$section_video_class = 'video-parallex';
			$url = parse_url($cs_section_video_url);
			if ($url['host'] == $_SERVER["SERVER_NAME"]) {
			    $file_type = wp_check_filetype($cs_section_video_url);
			    if (isset($file_type['type']) && $file_type['type'] <> '') {
				$file_type = $file_type['type'];
			    } else {
				$file_type = 'video/mp4';
			    }
			    $rand_player_id = rand(6, 555);
			    ?>
			    <script>
				jQuery(document).ready(function ($) {
				    document.getElementById("player<?php echo ($rand_player_id); ?>").controls = false;
				});
			    </script>
			    <?php
			    $section_video_element .= '<video id="player' . $rand_player_id . '" width="100%" height="100%" ' . $cs_video_autoplay . ' loop="true" preload="none" volume="false" class="nectar-video-bg   cs-video-element"  ' . $mute_control . ' >
                                        <source src="' . esc_url($cs_section_video_url) . '" type="' . $file_type . '">
                                    </video>';
			} else {

			    if (isset($cs_section_video_url) && !empty($cs_section_video_url)) {

				$url_parts = parse_url($cs_section_video_url);
				$url_vid = '';
				if (isset($url_parts['query']) && !empty($url_parts['query'])) {
				    $url_vid = $url_parts['query'];
				    $url_vid = str_replace('v=', '', $url_vid);
				}
				$player_string_exists = strpos($cs_section_video_url, 'vimeo.com');
				if ($player_string_exists === true) {
				    $video_path_exists = strpos($url_parts['path'], 'video');
				    if ($video_path_exists === true) {
					$cs_section_video_url = 'https://player.vimeo.com/' . $url_parts['path'] . '';
				    } else {
					$cs_section_video_url = 'https://player.vimeo.com/video/' . $url_parts['path'] . '';
				    }
				}
				$section_video_element = wp_oembed_get($cs_section_video_url, array('height' => '1083'));
				$fram_str = 'i' . 'fr' . 'ame';
				if ($cs_section_video_autoplay == 'yes') {

				    $string_exists = '';
				    $string_exists = strpos($section_video_element, 'vimeo');
				    if ($string_exists === false) {
					$section_video_element = str_replace('feature=oembed', 'feature=oembed&enablejsapi=1&showinfo=0&controls=0&autoplay=1&loop=1&playlist=' . $url_vid . '', $section_video_element); // youtube autoplay


					if ($cs_section_video_mute == 'yes') {



					    $section_video_element = str_replace('<' . $fram_str . '', '<' . $fram_str . ' id="ytplayer" ', $section_video_element); // youtube autoplay
					    ?>
					    <script>
						// 2. This code loads the IFrame Player API code asynchronously.
						var tag = document.createElement('script');

						var freme_api = '<?php echo $fram_str . '_api'; ?>';
						tag.src = "https://www.youtube.com/" + freme_api + "";
						var firstScriptTag = document.getElementsByTagName('script')[0];
						firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

						var player;

						function onYouTubeIframeAPIReady() {
						    player = new YT.Player('ytplayer', {
							events: {
							    'onReady': onPlayerReady
							}
						    });
						}

						function onPlayerReady() {
						    player.playVideo();
						    // Mute!
						    player.mute();
						}
					    </script>
					    <?php
					}
				    } else {
					$doc = new DOMDocument();
					$doc->loadHTML($section_video_element);
					$src = $doc->getElementsByTagName($fram_str)->item(0)->getAttribute('src');
					$section_video_element = str_replace($src, $src . '?autoplay=1&loop=1', $section_video_element); // vimeo autoplay
					$section_video_element = str_replace('<' . $fram_str . '', '<' . $fram_str . ' frameborder="0" id="myvideo" ', $section_video_element); // youtube autoplay
				    }
				}
			    }
			}
		    } else {
			if (isset($cs_section_bg_color) && $cs_section_bg_color != '') {
			    $section_style_elements .= 'background: ' . $cs_section_bg_color . ';';
			}
		    }
		    $cs_section_padding_top = $jobcareer_column_atts->cs_section_padding_top;
		    $cs_section_padding_bottom = $jobcareer_column_atts->cs_section_padding_bottom;
		    if (isset($cs_section_padding_top) && $cs_section_padding_top != '') {
			$section_container_style_elements .= 'padding-top: ' . $cs_section_padding_top . 'px; ';
		    }
		    if (isset($cs_section_padding_bottom) && $cs_section_padding_bottom != '') {
			$section_container_style_elements .= 'padding-bottom: ' . $cs_section_padding_bottom . 'px; ';
		    }
		    $cs_section_custom_style = $jobcareer_column_atts->cs_section_custom_style;
		    $cs_section_css_id = $jobcareer_column_atts->cs_section_css_id;
		    if (isset($cs_section_css_id) && trim($cs_section_css_id) != '') {
			$cs_section_css_id = 'id="' . $cs_section_css_id . '"';
		    }

		    $page_element_size = 'section-fullwidth';
		    $cs_layout = $jobcareer_column_atts->cs_layout;

		    if (!isset($cs_layout) || $cs_layout == '' || $cs_layout == 'none') {
			$cs_layout = "none";
			$page_element_size = 'section-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12';
		    } else {
			$page_element_size = 'section-content col-lg-9 col-md-9 col-sm-12 col-xs-12 ';
		    }
		    $cs_sidebar_left = $jobcareer_column_atts->cs_sidebar_left;
		    $cs_sidebar_right = $jobcareer_column_atts->cs_sidebar_right;
		}
		if (isset($cs_section_bg_image) && $cs_section_bg_image <> '' && $cs_section_background_option == 'section-custom-background-image') {
		    $css_bg_image = 'url(' . $cs_section_bg_image . ')';
		}

		$section_style_element = '';
		if ($section_style_elements) {
		    $section_style_element = 'style="' . $section_style_elements . '"';

		    $cs_page_inline_style .= ".cs-page-sec-{$cs_section_rand_id}{{$section_style_elements}}";
		}
		if ($section_container_style_elements) {
		    $section_container_style_elements = 'style="' . $section_container_style_elements . '"';
		}
		$cs_section_nopadding = $jobcareer_column_atts->cs_section_nopadding;
		$cs_section_nomargin = $jobcareer_column_atts->cs_section_nomargin;

		/*
		 * Addind class for backgroung slider/video functionality
		 */
		$custom_bacground_option_class = '';
		if (isset($cs_section_background_option) && $cs_section_background_option == 'section-custom-slider') {
		    $cs_section_custom_slider = $jobcareer_column_atts->cs_section_custom_slider;
		    if (!empty($cs_section_custom_slider)) {
			$custom_bacground_option_class = ' has-bg-custom-slider';
			;
		    }
		}
		if (isset($cs_section_background_option) && $cs_section_background_option == 'section_background_video') {
		    $cs_section_video_url = $jobcareer_column_atts->cs_section_video_url;
		    if (!empty($cs_section_video_url)) {
			$custom_bacground_option_class = ' has-bg-custom-video';
			;
		    }
		}

        $class_for_aviation = '';
		if($jobcareer_column_atts['section_images_view_page'] == 'aviation'){
        $class_for_aviation = " aviation-banner";
        echo '<div class="night-particles"><canvas id="night_particles_canvas" width="1920" height="609"></canvas></div>';
        ?>
        <script>
            jQuery(document).ready(function () {
                var check_view = jQuery(document).find('.aviation-banner').length;
                if(check_view > 0){
                    jQuery('.btn-post').removeClass('no_circle custom-btn btn-lg bg-color has_icon button-icon-right');
                    jQuery('.btn-post').addClass('btn-hover-effect');
                    jQuery('.btn-post').removeAttr("style");
                    jQuery('.btn-post').parent('.cs-button').addClass('aviation-button');
                }
            });
        </script>
        <style scpoed>
            a.btn-hover-effect:hover{background: #d6ec1f !important;color: #010101 !important;}
            a.btn-hover-effect:hover i{background: #c0d816 !important;color: #010101 !important;}
        </style>
        <?php
        }
        ?>
	        <!-- Page Section -->
	        <div <?php echo jobcareer_special_char($cs_section_css_id); ?> class="page-section<?php echo jobcareer_special_char($custom_bacground_option_class); echo $class_for_aviation;?>  cs-page-sec-<?php echo absint($cs_section_rand_id) ?> <?php echo sanitize_html_class($parallax_class); ?>" <?php echo jobcareer_special_char($parallax_data_type); ?>  <?php //echo jobcareer_special_char($section_style_element);                                 ?> >
		    <?php
		    if (isset($cs_section_background_option) && $cs_section_background_option == 'section_background_video') {
			$cs_section_video_url = $jobcareer_column_atts->cs_section_video_url;
			if (!empty($cs_section_video_url)) {
			    echo '<div class="custom-video-holder">';
			    echo jobcareer_special_char($section_video_element);
			    echo '</div>';
			}
		    }
		    if (isset($cs_section_background_option) && $cs_section_background_option == 'section-custom-slider') {
			$cs_section_custom_slider = $jobcareer_column_atts->cs_section_custom_slider;
			if ($cs_section_custom_slider != '') {
			    echo '<div class="custom-slider-holder">';
			    echo do_shortcode($cs_section_custom_slider);
			    echo '</div>';
			}
		    }

		    if ($cs_page_layout == '' || $cs_page_layout == 'none') {
			if ($cs_section_view == 'container') {
			    $cs_section_view = 'container';
			} else {
			    $cs_section_view = 'wide';
			}
		    } else {
			$cs_section_view = '';
		    }

		    ?>

	    	<!-- Container Start -->
	    	<div class="<?php echo sanitize_html_class($cs_section_view); ?> "> 
			<?php
			if (isset($cs_layout) && ( $cs_layout != '' || $cs_layout != 'none' )) {
			    ?>
			    <div class="row">
				<?php
			    }
			    if (isset($cs_layout) && $cs_layout == "left" && $cs_sidebar_left <> '') {
				echo '<aside class="section-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">';
				if (is_active_sidebar(jobcareer_get_sidebar_id($cs_sidebar_left))) {
				    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left)) : endif;
				}
				echo '</aside>';
			    }
			    $jobcareer_node_id = 0;
			    echo '<div class="' . ($page_element_size) . ' ">';
			    echo '<div class="row">';

			    foreach ($column_container->children() as $column) {
				$column_no ++;
				$jobcareer_node_id ++;
				foreach ($column->children() as $jobcareer_node) {

				    $cs_elem_id ++;
				    if ($jobcareer_node->getName() == "members") {
					$page_element_size = '100';
					if (isset($jobcareer_node->page_element_size))
					    $page_element_size = $jobcareer_node->page_element_size;
					if (jobcareer_pb_element_sizes($page_element_size) == 'element-size-50') {

					    $member_column = 'col-md-12';
					}
					echo '<div class="' . jobcareer_pb_element_sizes($page_element_size) . '">';
					$shortcode = trim((string) $jobcareer_node->cs_shortcode);
					$shortcode = html_entity_decode($shortcode);
					echo do_shortcode($shortcode);
					echo '</div>';
				    } else {
					$page_element_size = '100';

					$var_arrays = array('cs_elem_id');
					$global_cs_elem_id = CS_JOBCAREER_GLOBALS()->globalizing($var_arrays);
					extract($global_cs_elem_id);
					if (isset($jobcareer_node->page_element_size))
					    $page_element_size = $jobcareer_node->page_element_size;
					echo '<div class="' . jobcareer_pb_element_sizes($page_element_size) . '">';
					$shortcode = trim((string) $jobcareer_node->cs_shortcode);

					$shortcode = html_entity_decode($shortcode);
					echo do_shortcode($shortcode);
					echo '</div>';
				    }
				}
			    }

			    echo '</div></div>';

			    if (isset($cs_layout) && $cs_layout == "right" && $cs_sidebar_right <> '') {
				echo '<aside class="section-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">';

				if (is_active_sidebar(jobcareer_get_sidebar_id($cs_sidebar_right))) {
				    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right)) : endif;
				}

				echo '</aside>';
			    }
			    if (isset($cs_layout) && ( $cs_layout != '' || $cs_layout != 'none' )) {
				?>
			    </div>
			    <?php
			}
			?>
	    	</div>
	        </div>
		<?php
		$column_no = 0;
	    }
	    if (isset($cs_page_layout) && $jobcareer_sidebarLayout <> '' and $jobcareer_sidebarLayout <> "none") {
		echo '</div>';
	    }

	    if (isset($cs_page_layout) && $jobcareer_sidebarLayout <> '' and $jobcareer_sidebarLayout <> "none" and $jobcareer_sidebarLayout == 'right') :
		?>
	        <aside class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
		    <?php
		    if (is_active_sidebar(jobcareer_get_sidebar_id($cs_page_sidebar_right))) {
			if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_page_sidebar_right)) : endif;
		    }
		    ?>
	        </aside>
		<?php
	    endif;
	    if (isset($cs_page_layout) && $jobcareer_sidebarLayout <> '' and $jobcareer_sidebarLayout <> "none") {
		echo '</div>';
		echo '</div>';
	    }

	    if ($cs_page_inline_style != '') {
		jobcareer_dynamic_scripts('jobcareer_page_style', 'css', $cs_page_inline_style);
	    }
	} else {
	    ?>
	    <div class="container">        
		<!-- Row Start -->
		<div class="row">
		    <div class="col-md-12">
			<?php
			while (have_posts()) : the_post();
			    echo '<div class="rich-text-editor">';
			    the_content();
			    echo '</div>';
			endwhile;
			wp_link_pages(array(
			    'before' => '<div class="page-content-links"><strong class="page-links-title">' . esc_html__('Pages:', 'jobcareer') . '</strong>',
			    'after' => '</div>',
			    'link_before' => '<span>',
			    'link_after' => '</span>',
			    'pagelink' => '%',
			    'separator' => '',
			));
			?>
			<div id="comment" class="comment-form">
			    <?php
			    comments_template();
			    ?>
			</div>
		    </div>
		</div>
	    </div>
	    <?php
	}
	?>
    </div>
    <?php
}

get_footer();
