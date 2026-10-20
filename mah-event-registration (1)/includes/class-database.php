<?php
if (!defined('ABSPATH')) exit;
class MAH_ER_Database {
    public static function activate() {
        global $wpdb;
        require_once ABSPATH.'wp-admin/includes/upgrade.php';
        $c=$wpdb->get_charset_collate();
        $events=$wpdb->prefix.'mah_events';
        $regs=$wpdb->prefix.'mah_registrations';
        $payments=$wpdb->prefix.'mah_payments';
        $sql=[];
        $sql[]="CREATE TABLE $events (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL, description LONGTEXT NULL,
            event_date DATE NULL, start_time TIME NULL, end_time TIME NULL,
            venue VARCHAR(255) NULL, address TEXT NULL, city VARCHAR(120) NULL,
            registration_start DATETIME NULL, registration_end DATETIME NULL,
            participant_limit INT UNSIGNED NULL, registration_fee DECIMAL(12,2) NOT NULL DEFAULT 0,
            status VARCHAR(20) NOT NULL DEFAULT 'draft',
            created_at DATETIME NOT NULL,
            PRIMARY KEY(id), KEY status(status), KEY event_date(event_date)
        ) $c;";
        $sql[]="CREATE TABLE $regs (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            registration_id VARCHAR(40) NOT NULL,
            user_id BIGINT UNSIGNED NULL, event_id BIGINT UNSIGNED NULL,
            category VARCHAR(40) NOT NULL, data LONGTEXT NOT NULL,
            status VARCHAR(20) NOT NULL DEFAULT 'pending',
            created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL,
            PRIMARY KEY(id), UNIQUE KEY registration_id(registration_id),
            KEY event_id(event_id), KEY category(category), KEY status(status)
        ) $c;";
        $sql[]="CREATE TABLE $payments (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            registration_id VARCHAR(40) NOT NULL,
            order_id VARCHAR(100) NULL, payment_id VARCHAR(100) NULL,
            signature VARCHAR(255) NULL, amount DECIMAL(12,2) NOT NULL DEFAULT 0,
            currency VARCHAR(10) NOT NULL DEFAULT 'INR',
            status VARCHAR(20) NOT NULL DEFAULT 'pending',
            raw_response LONGTEXT NULL, created_at DATETIME NOT NULL,
            PRIMARY KEY(id), KEY registration_id(registration_id), KEY order_id(order_id)
        ) $c;";
        foreach($sql as $q) dbDelta($q);
    }
    public static function deactivate() {}
}
