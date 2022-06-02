<?php

declare(strict_types=1);
require_once(__DIR__ . "/../utils/session.php");

function drawPopUp(Session $session)
{
    if ($session->getMessages() == null)
        return;
    $message = $session->getMessages()[0];
?>
    <section id="popup" opening>
        <img src="/pictures/ubereats_icon.png" width="50" height="50" class="popup-img">
        <button class="popup-close">X</button>
            <p class="popup-text"><?= $message["type"]?></p>
            <p class="popup-text"><?= $message["text"] ?></p>
    </section>

<?php
}
?>