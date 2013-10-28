<h1>Registration</h1>


<?=CHtml::form(); ?>

<?=CHtml::errorSummary($form); ?><br>

    <table id="form2" border="0" width="400" cellpadding="10" cellspacing="10">
         <tr>

            <td width="150"><?=CHtml::activeLabel($form, 'login'); ?></td>
            <td><?=CHtml::activeTextField($form, 'login') ?></td>
         </tr>
        <tr>

            <td><?=CHtml::activeLabel($form, 'password'); ?></td>
            <td><?=CHtml::activePasswordField($form, 'password') ?></td>
         </tr>
        <tr>

            <td><?php $this->widget('CCaptcha', array('buttonLabel' => '<br>[new code]')); ?></td>
             <td><?=CHtml::activeTextField($form,'verifyCode'); ?></td>
        </tr>
        <tr>
            <td></td>

             <td><?=CHtml::submitButton('Register', array('id' => "submit")); ?></td>
        </tr>
    </table>

 <?=CHtml::endForm(); ?>