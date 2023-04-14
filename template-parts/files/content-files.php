<a href="/files/new">Add New</a>
<table id="transcribe-content">
    <thead>
        <th>Name</th>
        <th>Size</th>
        <th>Options</th>
    </thead>
    <tbody>
        <?php
        $uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'transcribe';
        $args = array(
            'post_type' => 'transcribe'
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                printf('<tr id="%d">', get_the_ID());
                printf('<th>
                            <span>%s<span>
                            <div class="row-actions">
                                <a href="/files/edit?id=' . get_the_ID() . '">Edit</a></span>
                                <span><a id="delete" data-id="' . get_the_ID() . '" href="">Delete</a></span>
                                <span><a href="/wp-content/uploads/transcribe/' . get_the_title() . '" download="' . get_the_title() . '">download</a></span>
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