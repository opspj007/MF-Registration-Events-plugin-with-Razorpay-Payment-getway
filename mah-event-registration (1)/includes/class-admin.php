<?php
if (!defined('ABSPATH')) exit;
class MAH_ER_Admin {
    public static function init() {
        add_action('admin_menu',[__CLASS__,'menu']);
        add_action('admin_post_mah_er_add_event',[__CLASS__,'add_event']);
    }
    public static function menu() {
        add_menu_page('Mah Registration','Mah Registration','manage_options','mah-er',[__CLASS__,'dashboard'],'dashicons-groups',25);
        add_submenu_page('mah-er','Registrations','Registrations','manage_options','mah-er-registrations',[__CLASS__,'registrations']);
        add_submenu_page('mah-er','Events','Events','manage_options','mah-er-events',[__CLASS__,'events']);
    }
    public static function dashboard() {
        global $wpdb; $r=$wpdb->prefix.'mah_registrations'; $e=$wpdb->prefix.'mah_events';
        echo '<div class="wrap"><h1>Mahashankh Registration Manager</h1><div class="mah-admin-grid">';
        foreach(['Registrations'=>$wpdb->get_var("SELECT COUNT(*) FROM $r"),'Events'=>$wpdb->get_var("SELECT COUNT(*) FROM $e"),'Pending'=>$wpdb->get_var("SELECT COUNT(*) FROM $r WHERE status=\'pending\'")] as $k=>$v)
            echo '<div class="card"><strong>'.esc_html($v).'</strong><span>'.esc_html($k).'</span></div>';
        echo '</div><p>Use <code>[mah_registration]</code> for the registration form and <code>[mah_events]</code> for published events.</p></div>';
    }
    public static function registrations() {
        global $wpdb; $t=$wpdb->prefix.'mah_registrations';
        $rows=$wpdb->get_results("SELECT registration_id,category,status,created_at FROM $t ORDER BY id DESC LIMIT 200");
        echo '<div class="wrap"><h1>Registrations</h1><table class="widefat striped"><thead><tr><th>ID</th><th>Category</th><th>Status</th><th>Date</th></tr></thead><tbody>';
        foreach($rows as $r) echo '<tr><td>'.esc_html($r->registration_id).'</td><td>'.esc_html($r->category).'</td><td>'.esc_html($r->status).'</td><td>'.esc_html($r->created_at).'</td></tr>';
        echo '</tbody></table></div>';
    }
    public static function events() {
        echo '<div class="wrap"><h1>Events</h1><form method="post" action="'.esc_url(admin_url('admin-post.php')).'">';
        wp_nonce_field('mah_er_add_event'); echo '<input type="hidden" name="action" value="mah_er_add_event">';
        echo '<p><input name="title" class="regular-text" placeholder="Event name" required></p>';
        echo '<p><input name="event_date" type="date" required></p>';
        echo '<p><input name="venue" class="regular-text" placeholder="Venue"></p>';
        echo '<p><input name="registration_fee" type="number" step="0.01" min="0" placeholder="Fee in INR (0 = free)"></p>';
        echo '<p><textarea name="description" class="large-text" placeholder="Description"></textarea></p>';
        echo '<p><button class="button button-primary">Create Event</button></p></form></div>';
    }
    public static function add_event() {
        if(!current_user_can('manage_options')) wp_die('Unauthorized');
        check_admin_referer('mah_er_add_event');
        MAH_ER_Events::create($_POST);
        wp_safe_redirect(admin_url('admin.php?page=mah-er-events&created=1')); exit;
    }
}
