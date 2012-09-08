<?php
echo $form->create(null,array('method'=>'post','action'=>'captcha_test'));
echo $html->image("captcha/".$captcha_src);
echo $form->input('User.ver_code');
echo $form->submit(__('Test Captcha',true));
echo $form->end();
?>