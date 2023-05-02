<h1>Settings</h1>
<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" name="SettingsForm" id="SettingsForm" enctype="multipart/form-data">
    <input type="hidden" name="action" value="SettingsForm">
    <input type="hidden" id="_wpnonce_create-user" name="_wpnonce_create-user" value="14fdda33c7">
    <input type="hidden" name="_wp_http_referer" value="/wp-admin/user-new.php">
    <table class="form-table" role="presentation">
        <tbody>
            <tr class="form-field">
                <th scope=" row"><label for="loggedin_user_email">Loggedin User Email</label></th>
                <td><input name="loggedin_user_email" type="text" id="loggedin_user_email" value="<?= get_option('uploaders_loggedin_user_email')  ?>" aria-required="true" autocapitalize="none" autocorrect="off" autocomplete="off" maxlength="60"></td>
            </tr>
            <tr class="form-field">
                <th scope=" row"><label for="new_user_email">Add New User Email</label></th>
                <td><input name="new_user_email" type="text" id="new_user_email" value="<?= get_option('uploaders_new_user_email') ?>" aria-required="true" autocapitalize="none" autocorrect="off" autocomplete="off" maxlength="60"></td>
            </tr>
            <tr class="form-field">
                <th scope=" row"><label for="new_upload_email">Upload File Email</label></th>
                <td><input name="new_upload_email" type="text" id="new_upload_email" value="<?= get_option('uploaders_new_upload_email')  ?>" aria-required="true" autocapitalize="none" autocorrect="off" autocomplete="off" maxlength="60"></td>
            </tr>
        </tbody>
    </table>
    <button type="submit" class="button eeButton" name="settings_form" id="settings_form">Update</button>
</form>