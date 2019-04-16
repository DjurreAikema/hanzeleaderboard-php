<?php
require_once 'core/init.php';

if (OldInput::exists()) {
    if (OldToken::check(OldInput::get('OldToken'))) {
        $validate = new OldValidate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true),
        ));

        if ($validation->passed()) {
            $user = new OldUser();

            $remember = (OldInput::get('remember') == 'on') ? true : false;
            $login = $user->login(OldInput::get('username'), OldInput::get('password'), $remember);

            if ($login) {
                OldRedirect::to('index.php');
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
        <label for="username">Username</label>
        <input type="text" name="username" id="username" autocomplete="off">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>
    <div class="field">
        <label for="remember">
            <input type="checkbox" name="remember" id="remember">Remember me
        </label>
    </div>
    <input type="hidden" name="token" value="<?php echo OldToken::generate(); ?>">
    <button type="submit">Login</button>
</form>