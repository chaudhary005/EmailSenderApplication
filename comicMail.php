<?php

require __DIR__. '/partials/_dbconnect.php';
$sql = "SELECT * FROM `users` WHERE `sub` = 'y' AND `status` = 'active'";
$result = mysqli_query($conn, $sql);
$numUsers = mysqli_num_rows($result);
if ($numUsers>0) {

    // code for fetching the image
    $url = 'https://c.xkcd.com/random/comic/';
    $header = get_headers($url);
    $string = $header[8];
    $prefix = '.com/';
    $index = strpos($string, $prefix) + strlen($prefix);
    $num = substr($string, $index);

    $api_url = 'http://xkcd.com/'.$num.'info.0.json';

    // Read JSON file
    $json_data = file_get_contents($api_url);

    // Decode JSON data into PHP array
    $response_data = json_decode($json_data);

    // All user data exists in 'data' object
    $user_data = $response_data->img;
    $image = 'images/Comic_Image.jpg';
    file_put_contents($image, file_get_contents($user_data));

    // code for mail begins here
    $fileName = 'images/Comic_Image.jpg';
    while ($row=mysqli_fetch_assoc($result)) {
        $subject = 'Comic Image';

        $mailto = $row['email'];

        // $content1 = base64_encode($content);
        $content = chunk_split(base64_encode(file_get_contents($fileName)));

        // a random hash will be necessary to send mixed content
        $separator = md5(time());

        // carriage return type (RFC)
        $eol = '\r\n';

        // standard mail header
        $headers = 'MIME-Version: 1.0' . $eol;

        // declaring mail will have multiple parts
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
        $headers .= 'This is a MIME encoded message.' . $eol;

        // plain text message
        $body = '--' . $separator . $eol;
        $body .= 'Content-Type: text/html; charset=UTF-8' . $eol.
        'Content-Transfer-Encoding: 7bit' . $eol.
                '<html>
                    <head>
                            <style> p {color:green} </style>
                    </head>
                    <body>
                        <br>
                        <img src="cid:Comic_Image.jpg">
                        <br>
                    </body>                
                </html>'.'\n\n';

        // attachment
        $body .= '--' . $separator . $eol;
        $body .= "Content-Type: application/octet-stream; name=\"" . $fileName . "\"" . $eol;
        $body .= 'Content-Transfer-Encoding: base64' . $eol;
        $body .= "Content-Disposition: attachment; filename=\"".$fileName . $eol;
        $body .= $content . $eol;

        $body .= '--' . $separator . $eol;
        $body .= 'Content-Type: text/html; charset=UTF-8' . $eol.
        'Content-Transfer-Encoding: 7bit' . $eol.
                '<html>
                    <body>
                        <a href="http://localhost/rtCamp/_unsub.php">Unsubscribe</a>
                    </body>
                    </html>'.'\n\n';

        // inline image
        $body .= '--' . $separator . $eol;
        $body .= "Content-Type: image/jpeg; name=\"" . $fileName . "\"" . $eol;
        $body .= 'Content-Transfer-Encoding: base64' . $eol;
        $body .= 'Content-ID: <Comic_Image.jpg>'.$eol;
        $body .= $content . $eol;
        $body .= '--' . $separator . '--';

        //SEND Mail
        mail($mailto, $subject, $body, $headers);
    }
}