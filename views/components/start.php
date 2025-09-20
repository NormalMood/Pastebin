<?php
/**
 * @var \Pastebin\Kernel\View\ViewInterface $view
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $view->title(); ?></title>
    <script src="/scripts/confirm_post_deletion.js" defer></script>
    <script src="/scripts/confirm_account_deletion.js" defer></script>
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
