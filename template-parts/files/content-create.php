<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" name="UploadForm" id="UploadForm" enctype="multipart/form-data">
    <h2 class="UploadFilesTitle">Upload Files</h2>
    <input class="button" type="file" name="FileInput[]" id="FileInput" onchange="FileInputHandler(this);" multiple />
    <table id="FileInputDetails" class="hide">
        <thead>
            <tr>
                <td>Name</td>
                <td>Size</td>
                <td>Duration</td>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <div>
        <input class="button" type="text" name="project" id="project" placeholder="Project" />
        <input class="button" type="text" name="story" id="story" placeholder="Story" />
        <input class="button" type="text" name="client" id="client" placeholder="Client Name" />
    </div>

    <input class="button" type="text" name="TranscriptEmail" id="TranscriptEmail" placeholder="Transcript to be emailed to" />

    <select name="UploadFileOptions" id="UploadFileOptions" onchange="eeSelectOptions(this)">
        <option value="standard">Standard</option>
        <option value="urgent">Urgent</option>
    </select>
    <input type="hidden" name="action" value="UploadForm">

    <button type="submit" class="button eeButton" name="UploadGo" id="UploadGo">Upload</button>
</form>