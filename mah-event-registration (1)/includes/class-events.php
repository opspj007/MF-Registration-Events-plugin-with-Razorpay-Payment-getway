<?php
if (!defined('ABSPATH')) exit;
class MAH_ER_Events {
    public static function init() {}
    public static function create($data) {
        global $wpdb; $t=$wpdb->prefix.'mah_events';
        return $wpdb->insert($t,[
            'title'=>sanitize_text_field($data['title']??''),
            'description'=>wp_kses_post($data['description']??''),
            'event_date'=>sanitize_text_field($data['event_date']??''),
            'start_time'=>sanitize_text_field($data['start_time']??''),
            'venue'=>sanitize_text_field($data['venue']??''),
            'address'=>sanitize_textarea_field($data['address']??''),
            'registration_fee'=>max(0,(float)($data['registration_fee']??0)),
            'status'=>'draft','created_at'=>current_time('mysql')
        ]);
    }
}
