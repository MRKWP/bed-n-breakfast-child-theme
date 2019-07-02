<?php

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    wp_enqueue_style('divi', get_template_directory_uri() . '/style.css');
}


/**
 * Disable new divi crazy crap code for CPT
 **/
function disable_cptdivi()
{
    remove_action('wp_enqueue_scripts', 'et_divi_replace_stylesheet', 99999998);
}
add_action('init', 'disable_cptdivi');

if (is_admin()) {
    include_once get_stylesheet_directory() . '/class.mrkwp.plugin.dependency.php';
    $dependency_checker = new MRKWP_Plugin_Dependency();

    $plugins = [
        [
            'name'     => 'One Click Demo Import',
            'slug'     => 'one-click-demo-import/one-click-demo-import.php',
            'url'      => 'https://wordpress.org/plugins/one-click-demo-import/',
            'trial' => false,
        ],
        [
            'name'     => 'Bed & Breakfast Rooms Plugin',
            'slug'     => 'df-bed-and-breakfast-rooms-plugin/df-bed-and-breakfast-rooms-plugin.php',
            'url'   => 'https://github.com/MRKWP/df-bed-and-breakfast-rooms-plugin',
            'trial' => false,
        ],
        [
            'name'     => 'Custom List Module For Divi',
            'slug'     => 'custom-list-module-for-divi/custom-list-module-for-divi.php',
            'url'   => 'https://github.com/MRKWP/custom-list-module-for-divi',
            'trial' => false,
        ],
        [
            'name'     => 'Extra Icons Plugin for Divi',
            'slug'     => 'mrkwp-extra-icons-divi/mrkwp-extra-icons-divi.php',
            'url'      => 'https://wordpress.org/plugins/mrkwp-extra-icons-divi',
            'trial' => false,
        ],
        [
            'name'     => 'FAQ Plugin',
            'slug'     => 'divi-framework-faq-premium/divi-framework-faq.php',
            'url'      => 'https://www.mrkwp.com/wp/faq-plugin/',
            'trial' => true,
        ],
        [
            'name'     => 'Testimonials for Divi',
            'slug'     => 'df-testimonials-premium/df-testimonials.php',
            'url'      => 'https://www.mrkwp.com/wp/testimonials-plugin/',
            'trial' => true,
        ],
        [
            'name'     => 'Footer Plugin for Divi',
            'slug'     => 'mrkwp-footer-for-divi/mrkwp-footer-for-divi.php',
            'url'      => 'https://wordpress.org/plugins/mrkwp-footer-for-divi/',
            'trial' => false,
        ],
        [
            'name'     => 'Restaurant Menu for Divi',
            'slug'     => 'df-menu-items-premium/df-menu-items.php',
            'url'   => 'https://www.mrkwp.com/wp/restaurant-menu-plugin/',
            'trial' => true,
        ],
        [
            'name'     => 'Video Toolkit for Divi',
            'slug'     => 'df-video-toolkit-premium/df-video-toolkit.php',
            'url'   => 'https://www.mrkwp.com/wp/video-toolkit-module-plugin/',
            'trial' => true,
        ],
        [
            'name'     => 'VR Viewer for Divi',
            'slug'     => 'df-vr-view-premium/df-vr-view.php',
            'url'   => 'https://www.mrkwp.com/wp/divi-vr-view-module/',
            'trial' => true,
        ],
    ];

    foreach ($plugins as $plugin) {
        if (!$dependency_checker->is_plugin_active($plugin['slug'])) {
            $message = sprintf(
                'Plugin `%s` needs to be installed and activated. Get the plugin from <a target="_blank" href="%s">%s</a>',
                $plugin['name'],
                $plugin['url'],
                $plugin['url']
            );

            if ($plugin['trial']) {
                $message .= ". This plugin has a 7 day free trial!";
            }

            $dependency_checker->add_notification($message);
        }
    }
}


function ocdi_import_files()
{
    return array(
        array(
            'import_file_name'           => 'Divi Bed & Breakfast Child Theme Import',
            'categories' => array('Divi Bed & Breakfast Child Theme Import'),
            'import_file_url'            =>  get_template_directory_uri() . '/data/content.xml',
            'import_widget_file_url'     =>  get_template_directory_uri() . '/data/widgets.wie',
            'import_customizer_file_url' =>  get_template_directory_uri() . '/data/customizer.dat',
            'import_notice' => __('Please wait for a few minutes. Do not close the window or refresh the page until the data is imported.', 'your_theme_name'),

        ),
    );
}
add_filter('pt-ocdi/import_files', 'ocdi_import_files');

// Reset the standard WordPress widgets
function ocdi_before_widgets_import($selected_import)
{
    if (!get_option('acme_cleared_widgets')) {
        update_option('sidebars_widgets', array());
        update_option('acme_cleared_widgets', true);
    }
}
add_action('pt-ocdi/before_widgets_import', 'ocdi_before_widgets_import');

function ocdi_after_import_setup()
{
    $main_menu = get_term_by('name', 'Main Menu', 'nav_menu');
    $secondary_menu = get_term_by('name', 'Secondary Menu', 'nav_menu');
    set_theme_mod(
        'nav_menu_locations', array(
        'primary-menu' => $main_menu->term_id,
        'secondary-menu' => $secondary_menu->term_id,
        )
    );

    // Assign home page and posts page (blog page).
    $front_page_id = get_page_by_title('Home');
    update_option('show_on_front', 'page');
    update_option('page_on_front', $front_page_id->ID);

    $et_divi = json_decode('{"static_css_custom_css_safety_check_done":true,"2_5_flush_rewrite_rules":"done","3_0_flush_rewrite_rules_2":"done","divi_previous_installed_version":"3.14","divi_latest_installed_version":"3.15","divi_skip_font_subset_force":true,"divi_1_3_images":"checked","et_pb_layouts_updated":true,"library_removed_legacy_layouts":true,"divi_2_4_documentation_message":"triggered","divi_email_provider_credentials_migrated":true,"divi_logo":"\/wp-content\/uploads\/2018\/09\/kadina-bnb-logo-kaylah.png","divi_favicon":"","divi_fixed_nav":"on","divi_gallery_layout_enable":"false","divi_color_palette":"#000000|#ffffff|#f25f5c|#fbfcfd|#f4f6f2|#5c5c5c|#292e31|#ffffff","divi_grab_image":"false","divi_blog_style":"false","divi_sidebar":"et_right_sidebar","divi_shop_page_sidebar":"et_right_sidebar","divi_show_facebook_icon":"on","divi_show_twitter_icon":"on","divi_show_google_icon":"false","divi_show_linkedin_icon":"false","divi_show_youtube_icon":"false","divi_show_instagram_icon":"false","divi_show_tripadvisor_icon":"on","divi_show_rss_icon":"false","divi_facebook_url":"#","divi_twitter_url":"#","divi_google_url":"#","divi_linkedin_url":"#","divi_youtube_url":"#","divi_instagram_url":"#","divi_tripadvisor_url":"","divi_rss_url":"","divi_woocommerce_archive_num_posts":9,"divi_catnum_posts":6,"divi_archivenum_posts":5,"divi_searchnum_posts":5,"divi_tagnum_posts":5,"divi_date_format":"M j, Y","divi_use_excerpt":"false","divi_responsive_shortcodes":"on","divi_gf_enable_all_character_sets":"false","divi_back_to_top":"on","divi_smooth_scroll":"false","divi_disable_translations":"false","divi_minify_combine_scripts":"on","divi_minify_combine_styles":"on","divi_custom_css":"span.border-orange {\r\n    display: inline-block;\r\n    border-top-style: solid !important;\r\n    border-top-width: 3px !important;\r\n    border-top-color: #f25f5c !important;\r\n    width: 8% !important;\r\n    margin-top: 8px !important;\r\n\tpadding-bottom: 8px !important;}\r\n\r\narticle.post_type_room{\r\n\tmargin-bottom:0px !important;\r\n}\r\nbody.et_pb_button_helper_class .et_pb_button, \r\nbody.et_pb_button_helper_class.et-db #et-boc .et_pb_button{\r\n\tcolor: #ffffff !important;\r\n}","divi_enable_dropdowns":"on","divi_home_link":"on","divi_sort_pages":"post_title","divi_order_page":"asc","divi_tiers_shown_pages":3,"divi_enable_dropdowns_categories":"on","divi_categories_empty":"on","divi_tiers_shown_categories":3,"divi_sort_cat":"name","divi_order_cat":"asc","divi_disable_toptier":"false","divi_scroll_to_anchor_fix":"false","et_pb_static_css_file":"on","et_pb_css_in_footer":"off","et_pb_product_tour_global":"on","divi_postinfo2":["author","date","categories","comments"],"divi_show_postcomments":"on","divi_thumbnails":"on","divi_page_thumbnails":"false","divi_show_pagescomments":"false","divi_postinfo1":["author","date","categories"],"divi_thumbnails_index":"on","divi_seo_home_title":"false","divi_seo_home_description":"false","divi_seo_home_keywords":"false","divi_seo_home_canonical":"false","divi_seo_home_titletext":"","divi_seo_home_descriptiontext":"","divi_seo_home_keywordstext":"","divi_seo_home_type":"BlogName | Blog description","divi_seo_home_separate":" | ","divi_seo_single_title":"false","divi_seo_single_description":"false","divi_seo_single_keywords":"false","divi_seo_single_canonical":"false","divi_seo_single_field_title":"seo_title","divi_seo_single_field_description":"seo_description","divi_seo_single_field_keywords":"seo_keywords","divi_seo_single_type":"Post title | BlogName","divi_seo_single_separate":" | ","divi_seo_index_canonical":"false","divi_seo_index_description":"false","divi_seo_index_type":"Category name | BlogName","divi_seo_index_separate":" | ","divi_integrate_header_enable":"on","divi_integrate_body_enable":"on","divi_integrate_singletop_enable":"on","divi_integrate_singlebottom_enable":"on","divi_integration_head":"","divi_integration_body":"","divi_integration_single_top":"","divi_integration_single_bottom":"","divi_468_enable":"false","divi_468_image":"","divi_468_url":"","divi_468_adsense":"","footer_widget_text_color":"#ffffff","footer_widget_link_color":"#ffffff","body_font_size":16,"body_font_height":1.8,"body_header_size":40,"body_header_height":1.2,"heading_font":"Work Sans","body_font":"Open Sans","link_color":"#f25f5c","font_color":"#292e31","header_color":"#f25f5c","accent_color":"#f25f5c","show_search_icon":false,"primary_nav_font_size":15,"primary_nav_font":"Open Sans","secondary_nav_font":"Open Sans","menu_link":"rgba(41,46,49,0.8)","menu_link_active":"#f25f5c","primary_nav_dropdown_line_color":"#f25f5c","primary_nav_dropdown_link_color":"rgba(41,46,49,0.8)","secondary_nav_bg":"#292e31","secondary_nav_dropdown_bg":"#292e31","fixed_primary_nav_font_size":15,"fixed_secondary_nav_bg":"#292e31","fixed_menu_link":"rgba(41,46,49,0.8)","fixed_menu_link_active":"#f25f5c","header_email":"email@example.com","footer_bg":"#292e31","footer_widget_header_color":"#ffffff","footer_widget_bullet_color":"#ffffff","bottom_bar_background_color":"rgba(41,46,49,0.32)","custom_footer_credits":"Site by <a href=\"https:\/\/www.diviframework.com\/\">Divi Framework<\/a> | Copyright \u00a9 2018 Bed &amp; Breakfast ","all_buttons_font_size":17,"all_buttons_bg_color":"#f25f5c","all_buttons_border_color":"#f25f5c","all_buttons_border_radius":26,"all_buttons_font":"Open Sans","all_buttons_selected_icon":"$","all_buttons_bg_color_hover":"#f25f5c","all_buttons_border_color_hover":"#f25f5c","all_buttons_border_radius_hover":3,"phone_number":"02 2222 2222","bottom_bar_font_style":"","et_pb_post_type_integration":{"page":"on","post":"on","project":"on","df_post_builder":"off","post_type_room":"on"},"show_header_social_icons":true,"all_buttons_border_width":4,"all_buttons_font_style":"","product_tour_status":{"3":"off"},"et_fb_pref_settings_bar_location":"bottom","et_fb_pref_builder_animation":"true","et_fb_pref_builder_display_modal_settings":"false","et_fb_pref_builder_enable_dummy_content":"true","et_fb_pref_event_mode":"hover","et_fb_pref_hide_disabled_modules":"false","et_fb_pref_history_intervals":1,"et_fb_pref_page_creation_flow":"default","et_fb_pref_modal_preference":"default","et_fb_pref_modal_snap_location":"false","et_fb_pref_modal_snap":"false","et_fb_pref_modal_fullscreen":"false","et_fb_pref_modal_dimension_width":400,"et_fb_pref_modal_dimension_height":400,"et_fb_pref_modal_position_x":30,"et_fb_pref_modal_position_y":50,"et_fb_pref_toolbar_click":"false","et_fb_pref_toolbar_desktop":"true","et_fb_pref_toolbar_grid":"false","et_fb_pref_toolbar_hover":"false","et_fb_pref_toolbar_phone":"true","et_fb_pref_toolbar_tablet":"true","et_fb_pref_toolbar_wireframe":"true","et_fb_pref_toolbar_zoom":"true","divi_show_fa-instagram_icon":"on","divi_show_fa-youtube-square_icon":"on","divi_show_fa-pinterest_icon":"false","divi_show_fa-linkedin_icon":"false","divi_show_fa-skype_icon":"false","divi_show_fa-flickr_icon":"false","divi_show_fa-dribbble_icon":"false","divi_show_fa-vimeo_icon":"false","divi_show_fa-500px_icon":"false","divi_show_fa-behance_icon":"false","divi_show_fa-github_icon":"false","divi_show_fa-bitbucket_icon":"false","divi_show_fa-deviantart_icon":"false","divi_show_fa-medium_icon":"false","divi_show_fa-meetup_icon":"false","divi_show_fa-slack_icon":"false","divi_show_fa-snapchat_icon":"false","divi_show_fa-tripadvisor_icon":"on","divi_show_fa-twitch_icon":"false","divi_fa-instagram_url":"#","divi_fa-youtube-square_url":"#","divi_fa-pinterest_url":"#","divi_fa-linkedin_url":"#","divi_fa-skype_url":"#","divi_fa-flickr_url":"#","divi_fa-dribbble_url":"#","divi_fa-vimeo_url":"#","divi_fa-500px_url":"#","divi_fa-behance_url":"#","divi_fa-github_url":"#","divi_fa-bitbucket_url":"#","divi_fa-deviantart_url":"#","divi_fa-medium_url":"#","divi_fa-meetup_url":"#","divi_fa-slack_url":"#","divi_fa-snapchat_url":"#","divi_fa-tripadvisor_url":"#","divi_fa-twitch_url":"#","et_pb_clear_templates_cache":true}', true);


    update_option('et_divi', $et_divi);
}
add_action('pt-ocdi/after_import', 'ocdi_after_import_setup');

add_filter('pt-ocdi/disable_pt_branding', '__return_true');


function ocdi_plugin_intro_text($default_text)
{
    $default_text .= '<div class="ocdi__intro-text">One click import of demo data, Divi theme customizer settings and WordPress widgets for the <b>Divi Bed & Breakfast Child Theme</b></div>';

    return $default_text;
}
add_filter('pt-ocdi/plugin_intro_text', 'ocdi_plugin_intro_text');
