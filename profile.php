<?php
include_once 'core/init.php';

if (!$username = OldInput::get('OldUser')) {
    OldRedirect::to('index.php');
} else {
    $user = new OldUser($username);
    if (!$user->exists()) {
        OldRedirect::to(404);
    } else {
        $data = $user->data();

        ?>
        <h3><?php echo escape($data->username) ?></h3>
        <p><?php echo escape($data->name) ?></p>
        <?php
    }
}