<?php

class MRKWP_Plugin_Dependency
{
    /**
     * Add notification.
     *
     * @param [type] $message [description]
     */
    public function add_notification($message)
    {
        add_action(
            'admin_notices',
            function () use ($message) {
                $class   = 'notice notice-error is-dismissible';
                printf(
                    '<div class="%1$s"><p>%2$s</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>',
                    $class,
                    $message
                );
            }
        );
    }

    /**
     * Check if plugin exists
     *
     * @param  [type] $slug [description]
     * @return [type] [description]
     */
    public function is_plugin_active($plugin)
    {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
        return is_plugin_active($plugin);
    }
}