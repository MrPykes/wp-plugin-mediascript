<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div>
        <div>
            <p><strong>From: </strong>newcontent@mediascript.com <newcontent@mediascript.com>
            </p>
            <p><strong>Sent: </strong><?php echo date("l j F Y g:i a"); ?></p>
            <p><strong>To: </strong>newcontent@mediascript.com</p>
            <p><strong>Subject: </strong>Content Upload by <?php echo get_user_meta(get_current_user_id(), 'first_name', true) . ' ' . get_user_meta(get_current_user_id(), 'last_name', true) ?> has uploaded <?php echo count($file_data) ?> file(s) for the Story Easey Street: podcast</p>
        </div>
        <div>
            <p><?php echo get_user_meta(get_current_user_id(), 'first_name', true) . ' ' . get_user_meta(get_current_user_id(), 'last_name', true) ?> has uploaded <?php echo count($file_data) ?> file(s) to Mediascript Express</p>
            <p>Story: <?php echo $project . ": " . $client ?></p>
            <p>Email to: <?php echo get_option('uploaders_new_upload_email') ?></p>
            <p>CC: </p>
            <p>Priority: <?php echo strtoupper($UploadFileOptions) ?></p>
        </div>
        <div>
            <?php foreach ($file_data as $key => $file) { ?>
                <div style='display: flex;column-gap: 20px;'>
                    <div>
                        <p><?php echo $key + 1 ?></p>
                    </div>
                    <div>
                        <p>Filename: <?php echo $file['file_name'] ?></p>
                        <p>Filesize: Expected: <?php echo $file['file_size'] ?> Actual: <?php echo $file['file_size'] ?></p>
                        <p>Duration: <?php echo $file['durations'] ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <h2>Special Instructions - Comments</h2>
        <p>Hi Team. This one initially. Please don't worry too much about my questions or his ums etc. Thanks and best wishes.</p>
    </div>
</body>

</html>