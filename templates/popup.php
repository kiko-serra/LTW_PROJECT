<?php

declare(strict_types=1);
require_once( __DIR__ . "/../utils/session.php");

function drawPopUp(Session $session)
{
    if($session->getMessages() == null)
        return;
      $message = $session->getMessages()[0];
        ?>
    <section class="pop-up-container">
        <a class="pop-up-link" href="">X</a>
        <section class="pop-up">
            <p><?=$message["type"]?></p>
            <p><?=$message["text"]?></p>
        </section>
    </section>
<?php
}
?>