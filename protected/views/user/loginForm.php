<?=CHtml::form(); ?>


    <fieldset>
        <div class="field-wrapper">
            <label for=username>Username</label>
            <?php if((isset($form->errors['login'])))
            {
                print '<div class="alert alert-error">
                                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                                          <strong>Warning! </strong>';
                foreach($form->errors['login'] as $err)
                {
                    print_r($err);
                }
                print '</div>';
            }
            ?>

            <input type="text" name="User[login]" id="username" autofocus="autofocus" autocorrect="off" autocapitalize="off">
        </div>
        <div class="field-wrapper">
            <label for=password>Password</label>
            <?php if((isset($form->errors['password'])))
            {
                print '<div class="alert alert-error">
                                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                                          <strong>Warning! </strong>';
                foreach($form->errors['password'] as $err)
                {
                    print_r($err);
                }
                print '</div>';
            }
            ?>

            <input type="password" name="User[password]" id="password"  autocorrect="off" autocapitalize="off">
        </div>
        <div class="below24 clear-both">
            <div class="size1of2">
                <button type="submit" value="Login" class="login size1of1">Log in</button>
            </div>
            <div class="size1of2 squaredTwo">
                <input type="checkbox" class="pull-left" value="yes" id="squaredTwo" name="User[staySignedIn]" />
                <label for="squaredTwo" class="pull-left">Stay signed in</label>
            </div>
        </div>
        <div class="clear-both"></div>
    </fieldset>
<?=CHtml::endForm(); ?>