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
        <button class="popup-close">X</button>
            <p class="popup-text-type"><?= $message["type"]?></p>
            <p class="popup-text-msg"><?= $message["text"] ?></p>
    </section>

<?php
}
?>