<?php
require_once 'core/init.php';

// TODO make the validation input a lot shorter
if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'unique' => 'users',
                'max' => 32,
                'min' => 3
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password2' => array(
                'required' => true,
                'matches' => 'password'
            )
        ));

        if ($validation->passed()) {
            $user = new User();
            $salt = Hash::makeSalt(32);

            try {
                $user->create(array(
                   //'email' => ,
                   'username' => Input::get('username'),
                   'password' => Hash::makeHash(Input::get('password'), $salt),
                   'salt' => $salt,
                   //'name' => '',
                   'joined' => date('Y-m-d H:i:s'),
                   'role' => 1
                ));

                // TODO Something like redirect withFlash
                Session::flash('home', 'You have been registered and can now login');
                Redirect::to(404);
            } catch (Exception $e) {
                // TODO Better error handling
                die($e->getMessage());
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error;
            }
        }
    }
}
?>

<form action="" method="POST">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')) ?>"
               autocomplete="off">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" value="">
    </div>
    <div class="field">
        <label for="password2">Password</label>
        <input type="password" name="password2" id="password2" value="">
    </div>
    <!-- TODO Make this sexier -->
    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
    <button type="submit">Submit</button>
</form>