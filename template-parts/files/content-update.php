<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" name="UploadForm" id="UploadForm" enctype="multipart/form-data">
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

            echo "<pre>";
            print_r(get_post($_GET['id']));
            echo "</pre>";
            ?>
            <tr>
                <td>
                    <div>
                        <input type="text" class="duration" name="file_name" value="" />
                    </div>
                </td>
                <td>
                    <div class="">
                        <input type="number" class="duration" name="file_size" value="" />
                    </div>
                </td>

                <div>
                    <input type="number" min="0" max="999" class="duration" name="Duration_hr" placeholder="Hour" />
                    <input type="number" min="0" max="59" class="duration" name="Duration_min" placeholder="Minutes" />
                    <input type="number" min="0" max="59" class="duration" name="Duration_sec" placeholder="Seconds" />

                </div>
                <div>
                    <input class="button" type="text" name="project" id="project" placeholder="Project" />
                    <input class="button" type="text" name="story" id="story" placeholder="Story" />
                    <input class="button" type="text" name="client" id="client" placeholder="Client Name" />
                </div>

                <input class="button" type="text" name="TranscriptEmail" id="TranscriptEmail" placeholder="Transcript to be emailed to" />

                <select name="UploadFileOptions" id="UploadFileOptions">
                    <option value="standard">Standard</option>
                    <option value="urgent">Urgent</option>
                </select>
            </tr>
        </tbody>
    </table>
    <input type="hidden" name="action" value="UploadForm">

    <button type="submit" class="button eeButton" name="UploadGo" id="UploadGo">Upload</button>

</form>