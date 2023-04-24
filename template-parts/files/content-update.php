<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" name="UpdateForm" id="UpdateForm" enctype="multipart/form-data">
    <h2 class="UploadFilesTitle">Update Files</h2>
    <table id="FileInputDetails" class="">
        <thead>
            <tr>
                <td>Name</td>
                <td>Size</td>
                <td>Duration</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $id = $_GET['id'];
            $post = get_post($id);
            $filename = $post->post_title;
            $option = get_post_meta($id, 'option', true);
            $client = get_post_meta($id, 'client', true);
            $story = get_post_meta($id, 'story', true);
            $project = get_post_meta($id, 'project', true);
            $email = get_post_meta($id, 'email', true);
            $duration = get_post_meta($id, 'duration', true);
            $file_size = get_post_meta($id, 'file_size', true);
            $file_type = get_post_meta($id, 'file_type', true);
            $hour = $duration['hour'];
            $minute = $duration['minute'];
            $second = $duration['second'];

            ?>
            <tr>
                <td>
                    <div>
                        <input type="text" class="duration" name="file_name" value="<?php echo $filename ?>" />
                        <input type="text" hidden class="duration" name="id" value="<?php echo $id ?>" />
                        <input type="text" hidden class="duration" name="file_type" value="<?php echo $file_type ?>" />
                    </div>
                </td>
                <td>
                    <span><?php echo sizeFilter($file_size) ?></span>
                    <!-- <input type="text" disabled class="duration" name="file_size" value="" /> -->

                </td>
                <td>
                    <div>
                        <input type="number" min="0" max="999" class="duration" name="Duration_hr" placeholder="Hour" value="<?php echo $hour ?>" placeholder="Hour" />
                        <input type="number" min="0" max="59" class="duration" name="Duration_min" placeholder="Minutes" value="<?php echo $minute ?>" placeholder="Minutes" />
                        <input type="number" min="0" max="59" class="duration" name="Duration_sec" placeholder="Seconds" value="<?php echo $second ?>" placeholder="Seconds" />
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div>
        <input class="button" type="text" name="project" id="project" value="<?php echo $project ?>" placeholder="Project" />
        <input class="button" type="text" name="story" id="story" value="<?php echo $story ?>" placeholder="Story" />
        <input class="button" type="text" name="client" id="client" value="<?php echo $client ?>" placeholder="Client" />
    </div>

    <input class="button" type="text" name="email" id="email" value="<?php echo $email ?>" placeholder="Transcript to be emailed to" />

    <select name="UploadFileOptions" id="UploadFileOptions">
        <option value="standard" <?php echo $option == 'standard' ? 'selected' : '' ?>>Standard</option>
        <option value="urgent" <?php echo $option == 'urgent' ? 'selected' : '' ?>>Urgent</option>
    </select>

    <input type="hidden" name="action" value="UpdateForm">

    <button type="submit" class="button eeButton" name="update" id="update">Update</button>

</form>