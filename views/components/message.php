<?php
/**
 * @var string $type
 * @var array<string> $messages
 */
?>
<ul class="message message_<?php echo $type; ?>">
    <img src="/img/<?php echo $type; ?>.png">
    <div class="message__content">
        <?php foreach ($messages as $message) { ?>
            <li><?php echo $message; ?></li>
        <?php } ?>
    </div>
</ul>