<?php
require_once 'core/init.php';

$user = new OldUser();
if (!$user->isLoggedIn()) {
    OldRedirect::to('index.php');
}

if (OldInput::exists()) {
    if (OldToken::check(OldInput::get('OldToken'))) {
        $validate = new OldValidate();
        $validation = $validate->check($_POST, array(
            'current_password' => array(
                'required' => true,
                'min' => 6
            ),
            'new_password' => array(
                'required' => true,
                'min' => 6
            ),
            'repeat_new_password' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'new_password'
            )
        ));

        if ($validation->passed()) {
            try {
                if (OldHash::makeHash(OldInput::get('current_password'), $user->data()->salt) != $user->data()->password) {
                    echo 'Your current password is wrong';
                } else {
                    $salt = OldHash::makeSalt(32);
                    $user->update(array(
                        'password' => OldHash::makeHash(OldInput::get('password_new'), $salt),
                        'salt' => $salt,
                    ));

                    OldSession::flash('home', 'Password has been updated');
                    OldRedirect::to('index.php');
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}
?>

<form action="" method="POST">
    <div class="field">
        <label for="current_password">Current password:</label>
        <input id="current_password" type="password" name="current_password">
    </div>
    <div class="field">
        <label for="new_password">New password:</label>
        <input id="new_password" type="password" name="new_password">
    </div>
    <div class="field">
        <label for="repeat_new_password">Repeat new password:</label>
        <input id="repeat_new_password" type="password" name="repeat_new_password">
    </div>
    <input type="hidden" name="token" value="<?php echo OldToken::generate() ?>">
    <button type="submit">Update</button>
</form>
