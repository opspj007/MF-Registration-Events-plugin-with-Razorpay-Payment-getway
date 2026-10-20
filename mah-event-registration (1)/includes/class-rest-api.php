<?php
if (!defined('ABSPATH')) exit;
class MAH_ER_REST_API {
    public static function init() {
        add_action('rest_api_init',function(){
            register_rest_route('mah/v1','/register',[
                'methods'=>'POST','callback'=>[__CLASS__,'register'],
                'permission_callback'=>'__return_true'
            ]);
        });
    }
    public static function register(WP_REST_Request $request) {
        if (!wp_verify_nonce($request->get_header('X-WP-Nonce'),'wp_rest')) {
            return new WP_Error('forbidden','Security check failed',['status'=>403]);
        }
        $p=$request->get_params();
        if (empty($p['category']) || empty($p['name']) || empty($p['email']) || empty($p['phone']))
            return new WP_Error('invalid','Required fields are missing',['status'=>400]);
        $allowed=array_keys(MAH_ER_Registration::categories());
        $category=sanitize_key($p['category']);
        if(!in_array($category,$allowed,true)) return new WP_Error('invalid_category','Invalid category',['status'=>400]);
        if (empty($p['terms'])) return new WP_Error('terms_required','Terms acceptance is required',['status'=>400]);
        global $wpdb; $t=$wpdb->prefix.'mah_registrations';
        $rid='MSK-'.strtoupper(substr($category,0,3)).'-'.wp_date('Y').'-'.str_pad((string)wp_rand(1,999999),6,'0',STR_PAD_LEFT);
        $data=[];
        foreach(['name','email','phone','city','state','country','bio','portfolio','event_id'] as $k) if(isset($p[$k])) $data[$k]=is_scalar($p[$k])?sanitize_text_field($p[$k]):'';
        $ok=$wpdb->insert($t,[
            'registration_id'=>$rid,'user_id'=>get_current_user_id()?:null,
            'event_id'=>absint($p['event_id']??0)?:null,'category'=>$category,
            'data'=>wp_json_encode($data),'status'=>'pending',
            'created_at'=>current_time('mysql'),'updated_at'=>current_time('mysql')
        ]);
        if(!$ok) return new WP_Error('db_error','Registration could not be saved',['status'=>500]);
        wp_mail(sanitize_email($p['email']),'Registration Received',"Your registration ID is: $rid");
        return ['success'=>true,'registration_id'=>$rid,'message'=>'Registration submitted successfully.'];
    }
}
