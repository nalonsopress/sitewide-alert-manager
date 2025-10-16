<?php
/**
 * Plugin Name: Sitewide Alert Manager
 * Description: Adds a dismissible sitewide alert bar with admin settings.
 * Version: 1.0
 * Author: Nelson Alonso
 */

defined('ABSPATH') or die('No script kiddies please!');

class SitewideAlertManager {
    private $option_name = 'sam_alert_settings';

    public function __construct() {
        add_action('admin_menu', [$this, 'register_admin_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_footer', [$this, 'render_alert']);
    }

    public function register_admin_page() {
        add_options_page('Alert Manager', 'Alert Manager', 'manage_options', 'sitewide-alert-manager', [$this, 'settings_page']);
    }

    public function register_settings() {
        register_setting('sam_settings_group', $this->option_name);
        add_settings_section('sam_main_section', 'Alert Settings', null, 'sitewide-alert-manager');
        add_settings_field('message', 'Alert Message', [$this, 'message_field'], 'sitewide-alert-manager', 'sam_main_section');
    }

    public function message_field() {
        $options = get_option($this->option_name);
        echo '<input type="text" name="'.$this->option_name.'[message]" value="'.esc_attr($options['message'] ?? '').'" style="width: 100%;" />';
    }

    public function settings_page() {
        echo '<div class="wrap"><h1>Sitewide Alert Manager</h1>';
        echo '<form method="post" action="options.php">';
        settings_fields('sam_settings_group');
        do_settings_sections('sitewide-alert-manager');
        submit_button();
        echo '</form></div>';
    }

    public function enqueue_scripts() {
        wp_enqueue_script('sam-dismiss', plugin_dir_url(__FILE__) . 'js/sam-dismiss.js', [], '1.0', true);
        wp_enqueue_style('sam-style', plugin_dir_url(__FILE__) . 'js/sam-style.css');
    }

    public function render_alert() {
        $options = get_option($this->option_name);
        if (!empty($options['message'])) {
            echo '<div id="sam-alert" style="background: #222; color: #fff; padding: 10px; text-align: center;">
                '.esc_html($options['message']).'
                <button id="sam-close" style="margin-left: 20px;">Dismiss</button>
            </div>';
        }
    }
}

new SitewideAlertManager();
?>
