<?php
/**
 * Plugin Name:       Custom CSS & JS Loader
 * Description:       Write custom CSS and JS, and enqueue them separately in the header or footer.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Ahmad Raza
 * Author URI:        https://ahmedraza.dev/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://ahmedraza.dev/
 * Text Domain:       ccjl
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) exit;


// Add Settings link in plugin list
function ccjl_add_settings_link($links) {
    $settings_link = '<a href="' . admin_url('admin.php?page=ccjl-editor') . '">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'ccjl_add_settings_link');

// === Settings Fields ===
add_action('admin_init', function () {
    add_settings_section('ccjl_css_section', '<h2>Custom CSS</h2>', null, 'ccjl-editor');
    add_settings_field('ccjl_custom_css', 'CSS Code', 'ccjl_css_field', 'ccjl-editor', 'ccjl_css_section');
    add_settings_field('ccjl_css_location', 'Enqueue CSS In', 'ccjl_css_location_field', 'ccjl-editor', 'ccjl_css_section');
    register_setting('ccjl_settings_group', 'ccjl_custom_css');
    register_setting('ccjl_settings_group', 'ccjl_css_location');

    add_settings_section('ccjl_js_section', '<h2>Custom JS</h2>', null, 'ccjl-editor');
    add_settings_field('ccjl_custom_js', 'JS Code', 'ccjl_js_field', 'ccjl-editor', 'ccjl_js_section');
    add_settings_field('ccjl_js_location', 'Enqueue JS In', 'ccjl_js_location_field', 'ccjl-editor', 'ccjl_js_section');
    register_setting('ccjl_settings_group', 'ccjl_custom_js');
    register_setting('ccjl_settings_group', 'ccjl_js_location');
});


// === Admin Menu ===
add_action('admin_menu', function () {
    add_menu_page('Custom CSS & JS', 'Custom CSS & JS', 'manage_options', 'ccjl-editor', 'ccjl_settings_page', 'dashicons-editor-code', 80);
});

// === Admin Page ===
function ccjl_settings_page() {
    ?>
    <div class="wrap">
        <h1>Custom CSS & JS Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('ccjl_settings_group');
            do_settings_sections('ccjl-editor');
            submit_button();
            ?>
        </form>

      <script>
jQuery(document).ready(function($) {
    if (typeof wp.codeEditor !== 'undefined' && window.ccjlEditorSettings) {
        wp.codeEditor.initialize($('textarea[name="ccjl_custom_css"]')[0], window.ccjlEditorSettings.css);
        wp.codeEditor.initialize($('textarea[name="ccjl_custom_js"]')[0], window.ccjlEditorSettings.js);
    }
});
</script>

    </div>
    <?php
}

// === Output CSS ===
function ccjl_output_custom_css_header() {
    $css = get_option('ccjl_custom_css');
    $location = get_option('ccjl_css_location');
    if ($css && $location === 'header') {
        echo "<style>$css</style>";
    }
}
add_action('wp_head', 'ccjl_output_custom_css_header');

function ccjl_output_custom_css_footer() {
    $css = get_option('ccjl_custom_css');
    $location = get_option('ccjl_css_location');
    if ($css && $location === 'footer') {
        echo "<style>$css</style>";
    }
}
add_action('wp_footer', 'ccjl_output_custom_css_footer');


// === Output JS ===
function ccjl_output_custom_js_header() {
    $js = get_option('ccjl_custom_js');
    $location = get_option('ccjl_js_location');
    if ($js && $location === 'header') {
        echo "<script>$js</script>";
    }
}
add_action('wp_head', 'ccjl_output_custom_js_header');

function ccjl_output_custom_js_footer() {
    $js = get_option('ccjl_custom_js');
    $location = get_option('ccjl_js_location');
    if ($js && $location === 'footer') {
        echo "<script>$js</script>";
    }
}
add_action('wp_footer', 'ccjl_output_custom_js_footer');







// === Field Callbacks ===

function ccjl_css_field() {
    $css = esc_textarea(get_option('ccjl_custom_css', ''));
    echo "<textarea name='ccjl_custom_css' rows='10' cols='70' style='width:100%;'>$css</textarea>";
}

function ccjl_js_field() {
    $js = esc_textarea(get_option('ccjl_custom_js', ''));
    echo "<textarea name='ccjl_custom_js' rows='10' cols='70' style='width:100%;'>$js</textarea>";
}

function ccjl_css_location_field() {
    $selected = get_option('ccjl_css_location', 'header');
    ?>
    <select name="ccjl_css_location">
        <option value="header" <?php selected($selected, 'header'); ?>>Header</option>
        <option value="footer" <?php selected($selected, 'footer'); ?>>Footer</option>
    </select>
    <?php
}

function ccjl_js_location_field() {
    $selected = get_option('ccjl_js_location', 'footer');
    ?>
    <select name="ccjl_js_location">
        <option value="header" <?php selected($selected, 'header'); ?>>Header</option>
        <option value="footer" <?php selected($selected, 'footer'); ?>>Footer</option>
    </select>
    <?php
}


// Enqueue CodeMirror in Admin
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'toplevel_page_ccjl-editor') return;

    // Get separate settings for CSS & JS
    $css_settings = wp_enqueue_code_editor(['type' => 'text/css']);
    $js_settings  = wp_enqueue_code_editor(['type' => 'application/javascript']);

    wp_enqueue_script('wp-theme-plugin-editor');
    wp_enqueue_style('wp-codemirror');

    // Pass to JS
    wp_add_inline_script('wp-theme-plugin-editor', sprintf(
        'window.ccjlEditorSettings = %s;',
        json_encode([
            'css' => $css_settings,
            'js'  => $js_settings,
        ])
    ));
});

