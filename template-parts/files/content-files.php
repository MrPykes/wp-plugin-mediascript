<?php
$user = wp_get_current_user();
$args_ = array();
$roles = (array) $user->roles;
if ($roles[0] == 'staff') {
    printf('<a href="/files/new">Add New</a>');
    $args_['meta_query'] = array(
        array(
            'key' => 'assigned_staff_user',
            'value' => get_current_user_id(),
            'compare' => '=',
        )
    );
} elseif (($roles[0] == 'uploader')) {
    $args_['author__in'] = array(get_current_user_id());
}
?>

<table id="transcribe-content">
    <thead>
        <th>Name</th>
        <th>Size</th>
        <th>Options</th>
    </thead>
    <tbody>
        <?php
        global $post;

        $uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'transcribe';
        $args = array(
            'post_type' => 'transcribe',
            'post_per_page' => -1,
            // 'author__in' => array(get_current_user_id())

        );
        $args = array_merge($args_, $args);
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $fileUploadName = get_post_meta(get_the_ID(), 'file_name', true);
                printf('<tr id="%d">', get_the_ID());
                printf('<th>
                            <span>%s<span>
                            <div class="row-actions">
                                <a href="/files/edit?id=' . get_the_ID() . '">Edit</a></span>
                                <span><a id="delete" data-id="' . get_the_ID() . '" href="">Delete</a></span>
                                <span><a href="/wp-content/uploads/transcribe/' . $fileUploadName . '" download="' . $fileUploadName . '">download</a></span>
                            </div>
                        </th>', get_the_title());
                printf('<th>%s</th>', sizeFilter(get_post_meta(get_the_ID(), 'file_size', true)));
                printf('<th>%s</th>', ucfirst(get_post_meta(get_the_ID(), 'option', true)));
                printf('</tr>');
            }
        }
        ?>
    </tbody>
</table>