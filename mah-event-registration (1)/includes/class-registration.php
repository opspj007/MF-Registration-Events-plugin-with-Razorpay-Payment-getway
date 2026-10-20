<?php
if (!defined('ABSPATH')) exit;
class MAH_ER_Registration {
    public static function init() {
        add_shortcode('mah_registration',[__CLASS__,'shortcode']);
        add_shortcode('mah_events',[__CLASS__,'events_shortcode']);
    }
    public static function categories() {
        return [
            'model'=>'Model','dancer'=>'Dancer','singer'=>'Singer',
            'fashion_designer'=>'Fashion Designer','makeup_artist'=>'Makeup Artist',
            'sponsor'=>'Sponsor','brand'=>'Brand'
        ];
    }
    public static function shortcode($atts=[]) {
        $atts=shortcode_atts(['event_id'=>0],$atts);
        ob_start(); ?>
        <div class="mah-er-card">
            <h2>Event & Talent Registration</h2>
            <form id="mah-er-form" enctype="multipart/form-data">
                <?php wp_nonce_field('mah_er_register','mah_er_nonce'); ?>
                <label>Registration Type</label>
                <select name="category" required>
                    <option value="">Select type</option>
                    <?php foreach(self::categories() as $k=>$v): ?>
                    <option value="<?php echo esc_attr($k); ?>"><?php echo esc_html($v); ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Event</label>
                <select name="event_id">
                    <option value="0">No specific event</option>
                    <?php
                    global $wpdb; $table=$wpdb->prefix.'mah_events';
                    $events=$wpdb->get_results("SELECT id,title FROM $table WHERE status='published' ORDER BY event_date ASC");
                    foreach($events as $e) echo '<option value="'.esc_attr($e->id).'" '.selected((int)$atts['event_id'],(int)$e->id,false).'>'.esc_html($e->title).'</option>';
                    ?>
                </select>
                <div class="mah-grid">
                    <div><label>Full Name / Professional Name</label><input name="name" required></div>
                    <div><label>Email</label><input type="email" name="email" required></div>
                    <div><label>Mobile / WhatsApp</label><input name="phone" required></div>
                    <div><label>City</label><input name="city"></div>
                    <div><label>State</label><input name="state"></div>
                    <div><label>Country</label><input name="country" value="India"></div>
                </div>
                <label>Professional Details</label>
                <textarea name="bio" rows="5" placeholder="Experience, specialization, portfolio information..."></textarea>
                <label>Instagram / Portfolio URL</label><input type="url" name="portfolio">
                <label>Profile Photo</label><input type="file" name="profile_photo" accept=".jpg,.jpeg,.png,.webp">
                <label><input type="checkbox" name="terms" value="1" required> I accept the Terms & Conditions and Privacy Policy.</label>
                <button type="submit">Submit Registration</button>
                <div id="mah-er-message"></div>
            </form>
        </div>
        <?php return ob_get_clean();
    }
    public static function events_shortcode() {
        global $wpdb; $t=$wpdb->prefix.'mah_events';
        $events=$wpdb->get_results("SELECT * FROM $t WHERE status='published' ORDER BY event_date ASC");
        ob_start(); echo '<div class="mah-events">';
        foreach($events as $e) {
            echo '<article><h3>'.esc_html($e->title).'</h3><p>'.esc_html($e->event_date).' · '.esc_html($e->venue).'</p><p>'.esc_html(wp_trim_words(wp_strip_all_tags($e->description),30)).'</p></article>';
        }
        echo '</div>'; return ob_get_clean();
    }
}
