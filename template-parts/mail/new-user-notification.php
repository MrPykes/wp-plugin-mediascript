<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <h1 style='font-family: "Calibri, sans-serif"; font-size: 15px;'>Dear <?= $_POST["first_name"] . ' ' . $_POST["last_name"] ?></h1>

        <p style='font-family: "Calibri, sans-serif"; font-size: 15px;'>I have now registerd you as an uploader to the Media Script Website.:</p>
        <div style='margin-left: 30px;'>
            <a style='font-family: "Calibri, sans-serif"; font-size: 15px;' href="https://www.mediascripts.com/">www.mediascripts.com/</a>
            <p style='font-family: "Calibri, sans-serif"; font-size: 15px;'>
                <span>Username: </span>
                <span><?= $_POST['user_login'] ?></span>
            </p>
            <p style='font-family: "Calibri, sans-serif"; font-size: 15px;'>
                <span>Password: </span>
                <span><?= $_POST['pass1'] ?></span>
            </p>
        </div>
        <p style='font-family: "Calibri, sans-serif"; font-size: 15px;'>You will receive an email on succesful upload and I simultaneously receive an email and the transcription process immediately begins. See below for instructions on uploading:</p>

        <h2 style='font-family: "Calibri, sans-serif"; font-size: 15px;'>Mediascript - transcription</h2>
        <ul style='font-family: "Calibri, sans-serif"; font-size: 15px; list-style-type: none;'>
            <li>- Log on with your assigned username and password.</li>
            <li>- In the Client - Story field type the name of the project.</li>
            <li>- Enter the emial addresses of those who are to receive the finished transcript.</li>
            <li>- The audio file names should be the name of the Story - Interviewee.</li>
            <li>- Enter the duration of each file.</li>
            <li>- Click 'submit' and that's it.</li>
        </ul>
        <p style='font-family: "Calibri, sans-serif"; font-size: 15px; margin-left: 15px;'>
            You will receive an email, confirming the upload was successful.</p>
    </div>
</body>

</html>