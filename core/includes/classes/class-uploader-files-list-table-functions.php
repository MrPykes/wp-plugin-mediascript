<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;


class Uploaders_File_List_Table_Function
{

    /**
     * The plugin name
     *
     * @var		string
     * @since   1.0.0
     */
    private $plugin_name;

    /**
     * Our Transcribe_Settings constructor 
     * to run the plugin logic.
     *
     * @since 1.0.0
     */
    function __construct()
    {

        $this->plugin_name = TRANSCRIBE_NAME;
        $this->add_hooks();
    }

    /**
     * ######################
     * ###
     * #### Register to Admin Menu
     * ###
     * ######################
     */

    private function add_hooks()
    {
        add_action('admin_post_nopriv_save_assigned_staff_user', array($this, 'save_assigned_staff_user'));
        add_action('admin_post_save_assigned_staff_user', array($this, 'save_assigned_staff_user'));
        add_action('admin_action_edit', array($this, 'handle_custom_column_actions'));
        add_filter('manage_transcribe_posts_columns', array($this, 'manage_custom_columns'));
        add_action('manage_transcribe_posts_custom_column', array($this, 'manage_custom_column_content', 10, 2));
        add_filter('post_row_actions', array($this, 'manage_custom_column_actions', 10, 2));
    }

    function manage_custom_column_actions($actions, $post)
    {
        $actions['edit_assigned_staff_user'] = '<a href="post.php?post_id=' . $post->ID . '&action=edit&staff_user=true">' . __('Edit Staff User', 'transcribe') . '</a>';
        return $actions;
    }

    function handle_custom_column_actions()
    {
        if (isset($_REQUEST['action']) && $_REQUEST['staff_user'] == 'true') {
            $post_id = intval($_REQUEST['post_id']);
            $staff_users = get_users(['role__in' => ['staff']]);
            $assigned_user = get_post_meta($post_id, 'assigned_staff_user', true);

            wp_nonce_field('save_assigned_staff_user', 'assigned_staff_user_nonce');

            echo '<form action="' . esc_url(admin_url('admin-post.php')) . '" method="POST" enctype="multipart/form-data">';
            echo '<input type="hidden" name="action" value="save_assigned_staff_user" />';
            echo '<input type="hidden" name="post_id" value="' . $post_id . '" />';
            echo '<select name="staff_user">';
            echo '<option value="">- None -</option>';
            foreach ($staff_users as $staff_user) {
                $selected = ($assigned_user == $staff_user->ID) ? 'selected="selected"' : '';
                echo '<option value="' . $staff_user->ID . '" ' . $selected . '>' . $staff_user->display_name . '</option>';
            }
            echo '</select>';
            echo '<button class="button" type="submit">' . __('Save', 'transcribe') . '</button>';
            echo '</form>';
            exit;
        }
    }

    function save_assigned_staff_user($post_id)
    {
        if (!empty($_POST['staff_user'])) {
            update_post_meta($_POST['post_id'], 'assigned_staff_user', $_POST['staff_user']);
        } else {
            delete_post_meta($_POST['post_id'], 'assigned_staff_user');
        }
        wp_redirect(admin_url('admin.php?page=transcribe'));
    }
}
