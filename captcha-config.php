<?php
$captcha = new Element\Captcha('captcha');
$image = new Captcha\Image(array(
    'imgDir' => 'public/img/captcha',
    'imgUrl' => '/public/img/captcha'
));
$image->setFontSize(38);
$image->setWordlen(4);
$image->setFont('data/font/arial.ttf');
$image->setHeight(75);
$image->setWidth(150);
$image->setDotNoiseLevel(80);

$captcha->setCaptcha($image);
$captcha->setAttributes(array('class'=> 'form-control'));
$this->add($captcha);

//
echo '<div class="form-group">';
$captcha = $form->get('captcha');
echo $this->formLabel($captcha, $this->translate('Ověření (na velikosti nezáleží)*'));
echo $this->formElement($captcha);
echo $this->formElementErrors($captcha);
echo '</div>' . PHP_EOL;