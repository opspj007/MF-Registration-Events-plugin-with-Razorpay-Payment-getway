<?php
/**
 * Plugin Name: Mahashankh Event & Talent Registration Manager
 * Description: Multi-role talent, sponsor, brand and event registration with Razorpay-ready payment architecture.
 * Version: 1.0.0
 * Author: Mahashankh Design & Technology
 * Requires at least: 6.0
 * Requires PHP: 8.0
 */
if (!defined('ABSPATH')) exit;

define('MAH_ER_VERSION','1.0.0');
define('MAH_ER_FILE',__FILE__);
define('MAH_ER_DIR',plugin_dir_path(__FILE__));
define('MAH_ER_URL',plugin_dir_url(__FILE__));

require_once MAH_ER_DIR.'includes/class-database.php';
require_once MAH_ER_DIR.'includes/class-registration.php';
require_once MAH_ER_DIR.'includes/class-events.php';
require_once MAH_ER_DIR.'includes/class-admin.php';
require_once MAH_ER_DIR.'includes/class-rest-api.php';

register_activation_hook(__FILE__, ['MAH_ER_Database','activate']);
register_deactivation_hook(__FILE__, ['MAH_ER_Database','deactivate']);

function mah_er_init() {
    MAH_ER_Registration::init();
    MAH_ER_Events::init();
    MAH_ER_Admin::init();
    MAH_ER_REST_API::init();
}
add_action('plugins_loaded','mah_er_init');

add_action('wp_enqueue_scripts', function(){
    wp_enqueue_style('mah-er', MAH_ER_URL.'public/css/registration.css', [], MAH_ER_VERSION);
    wp_enqueue_script('mah-er', MAH_ER_URL.'public/js/registration.js', ['jquery'], MAH_ER_VERSION, true);
    wp_localize_script('mah-er','MAHER',[
        'rest'=>esc_url_raw(rest_url('mah/v1/')),
        'nonce'=>wp_create_nonce('wp_rest')
    ]);
});
