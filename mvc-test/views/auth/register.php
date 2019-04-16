<h3>Register page</h3>

<form action="" method="POST">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(OldInput::get('username')) ?>"
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
    <input type="hidden" name="token" value="<?php echo OldToken::generate() ?>">
    <button type="submit">Submit</button>
</form>