<?php
require_once 'core/init.php';

$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
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
                if (Hash::makeHash(Input::get('current_password'), $user->data()->salt) != $user->data()->password) {
                    echo 'Your current password is wrong';
                } else {
                    $salt = Hash::makeSalt(32);
                    $user->update(array(
                        'password' => Hash::makeHash(Input::get('password_new'), $salt),
                        'salt' => $salt,
                    ));

                    Session::flash('home', 'Password has been updated');
                    Redirect::to('index.php');
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
    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
    <button type="submit">Update</button>
</form>
