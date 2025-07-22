<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="rv-affiliate-dashboard">
        <div class="rv-affiliate-stats">
            <div class="rv-affiliate-stat-box">
                <h3>Active Providers</h3>
                <?php
                global $wpdb;
                $active_providers = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}rv_affiliate_providers WHERE is_active = 1");
                ?>
                <p class="stat-number"><?php echo esc_html($active_providers); ?></p>
            </div>
            
            <div class="rv-affiliate-stat-box">
                <h3>Total Providers</h3>
                <?php
                $total_providers = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}rv_affiliate_providers");
                ?>
                <p class="stat-number"><?php echo esc_html($total_providers); ?></p>
            </div>
        </div>

        <div class="rv-affiliate-quick-actions">
            <h2>Quick Actions</h2>
            <a href="<?php echo esc_url(admin_url('admin.php?page=rv-affiliate-providers')); ?>" class="button button-primary">
                Manage Providers
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=rv-affiliate-settings')); ?>" class="button">
                Settings
            </a>
        </div>
    </div>
</div> 