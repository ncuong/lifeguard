<?php

    $confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-registration', 'key' => $user->auth_key]);
?>

<p>Hello,<p>

<p> Thank you for registering with Lifeguard! To complete your registration, please click on the link below or paste it into a browser to confirm your e-mail address. You will then be redirected to Lifeguard</p>

<p><?php echo $confirmLink; ?></p>

<p> Please do not email this to the webmaster or reply to this message</p>

<p>With best wishes,</p>
<p>Lifeguard.</p>