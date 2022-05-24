<?php

declare(strict_types=1);
require_once("utils/session.php");

function drawPopUp(Session $session)
{
      $message = $session->getMessages()[0];
        if(!$message){
            return;
        }
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