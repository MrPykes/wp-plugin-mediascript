<?php

if (!defined('ABSPATH')) {
    exit;
}

// Define the custom table class
class Transcribe_List_Table extends WP_List_Table
{

    // Define the constructor
    function __construct()
    {
        parent::__construct(array(
            'singular' => 'transcribe',
            'plural' => 'transcribes',
            'ajax' => false
        ));
        // add_action('admin_action_edit', array($this, 'handle_custom_column_actions'));
        // add_filter('manage_transcribe_posts_columns', array($this, 'manage_custom_columns'));
        // add_action('manage_transcribe_posts_custom_column', array($this, 'manage_custom_column_content', 10, 2));
        // add_filter('post_row_actions', array($this, 'manage_custom_column_actions', 10, 2));
    }

    // Define the columns
    function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'transcribe'),
            'file_name' => __('File Name', 'transcribe'),
            'file_size' => __('File Size', 'transcribe'),
            'file_type' => __('File Type', 'transcribe'),
            'email' => __('Email', 'transcribe'),
            'project' => __('Project', 'transcribe'),
            'story' => __('Story', 'transcribe'),
            'client' => __('Client', 'transcribe'),
            'option' => __('Option', 'transcribe'),
            'duration' => __('Duration', 'transcribe'),
            'assigned_staff_user' => __('Assign to Staff User', 'transcribe')
        );
    }




    // Define the sortable columns
    function get_sortable_columns()
    {
        return array(
            'title' => array('title', false),
            'file_name' => array('file_name', false),
            'file_size' => array('file_size', false),
            'file_type' => array('file_type', false),
            'email' => array('email', false),
            'project' => array('project', false),
            'story' => array('story', false),
            'client' => array('client', false),
            'option' => array('option', false),
            'duration' => array('duration', false),
        );
    }

    // Define the table data
    function prepare_items()
    {

        // Define the columns and the corresponding meta keys
        $columns = $this->get_columns();
        $meta_keys = array(
            'file_name',
            'file_size',
            'file_type',
            'email',
            'project',
            'story',
            'client',
            'option',
            'duration'
        );

        // Define the query arguments
        $query_args = array(
            'post_type' => 'transcribe',
            'posts_per_page' => -1
        );

        // Get the posts
        $posts = get_posts($query_args);

        // Loop through the posts and build the data array
        $data = array();
        foreach ($posts as $post) {

            // Get the meta data
            $meta = array();
            foreach ($meta_keys as $key) {
                $meta[$key] = get_post_meta($post->ID, $key, true);
            }

            // Construct the duration value
            $duration = '';
            if (!empty($meta['duration']['hour'])) {
                $duration .= $meta['duration']['hour'] . ':';
            }
            if (!empty($meta['duration']['minute'])) {
                $duration .= $meta['duration']['minute'] . ':';
            }
            if (!empty($meta['duration']['second'])) {
                $duration .= $meta['duration']['second'];
            }

            // Build the row data array
            $data[] = array(
                'id' => $post->ID,
                'title' => $post->post_title,
                'file_name' => $meta['file_name'],
                'file_size' => $meta['file_size'],
                'file_type' => $meta['file_type'],
                'email' => $meta['email'],
                'project' => $meta['project'],
                'story' => $meta['story'],
                'client' => $meta['client'],
                'option' => $meta['option'],
                'duration' => $duration
            );
        }

        // Define the sortable columns
        $sortable_columns = $this->get_sortable_columns();
        $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'title';
        $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc';
        usort($data, function ($a, $b) use ($orderby, $order) {
            $result = strcasecmp($a[$orderby], $b[$orderby]);
            return ($order === 'asc') ? $result : -$result;
        });

        // Define the pagination
        $per_page = 20;
        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $total_pages = ceil($total_items / $per_page);
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => $total_pages
        ));
        $data = array_slice($data, (($current_page - 1) * $per_page), $per_page);

        // Assign the data and the columns
        $this->_column_headers = array($columns, array(), $sortable_columns);
        $this->items = $data;
    }
    // Define the content of each column
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'title':
                return $item->post_title;
            case 'file_name':
                return get_post_meta($item['id'], 'file_name', true);
            case 'file_size':
                return get_post_meta($item['id'], 'file_size', true);
            case 'file_type':
                return get_post_meta($item['id'], 'file_type', true);
            case 'email':
                return get_post_meta($item['id'], 'email', true);
            case 'project':
                return get_post_meta($item['id'], 'project', true);
            case 'story':
                return get_post_meta($item['id'], 'story', true);
            case 'client':
                return get_post_meta($item['id'], 'client', true);
            case 'option':
                return get_post_meta($item['id'], 'option', true);
            case 'assigned_staff_user':
                $assigned_user_id = get_post_meta($item['id'], 'assigned_staff_user', true);
                $assigned_user = get_userdata($assigned_user_id);
                if ($assigned_user) {
                    return $assigned_user->display_name;
                }
            default:
                return '';
        }
    }
    // function column_staff_user($item)
    // {
    //     $staff_users = get_users(array('role' => 'staff'));
    //     $assigned_user = get_post_meta($item['id'], 'assigned_staff_user', true);
    //     $output = '<select name="staff_user[' . $item['id'] . ']">';
    //     $output .= '<option value="">- None -</option>';
    //     foreach ($staff_users as $staff_user) {
    //         $selected = ($assigned_user == $staff_user->ID) ? 'selected="selected"' : '';
    //         $output .= '<option value="' . $staff_user->ID . '" ' . $selected . '>' . $staff_user->display_name . '</option>';
    //     }
    //     $output .= '</select>';
    //     return $output;
    // }

    // Define the content of the title column
    function column_title($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="%s">%s</a>', get_edit_post_link($item['id']), __('Edit', 'transcribe')),
            'delete' => sprintf('<a href="%s" onclick="return confirm(\'%s\');">%s</a>', wp_nonce_url(add_query_arg(array('action' => 'delete', 'id' => $item['id']), admin_url('admin-post.php')), 'transcribe_delete'), __('Are you sure you want to delete this item?', 'transcribe'), __('Delete', 'transcribe'))
        );
        $actions['edit_assigned_staff_user'] = '<a href="post.php?post_id=' . $item['id'] . '&action=edit&staff_user=true">' . __('Edit Staff User', 'transcribe') . '</a>';
        return sprintf('%1$s %2$s', '<strong>' . $item['title'] . '</strong>', $this->row_actions($actions));
    }

    // Define the content of the checkbox column
    function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="id[]" value="%s" />', $item['id']);
    }
}