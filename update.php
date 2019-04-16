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
            'name' => array(
                'required' => true,
            )
        ));

        if ($validation->passed()) {
            try {
                $user->update(array(
                    'name' => OldInput::get('name')
                ));

                OldSession::flash('home', 'Details have been updated');
                OldRedirect::to('index.php');
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
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="<?php echo escape($user->data()->name) ?>">
    </div>
    <input type="hidden" name="token" value="<?php echo OldToken::generate() ?>">
    <button type="submit">Update</button>
</form>
