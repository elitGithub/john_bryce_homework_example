<?php

use Elit1\ObjectOriented\Forms\Form;
use Elit1\ObjectOriented\Forms\Submit;
use Elit1\ObjectOriented\Helpers\Navigator;
use Elit1\ObjectOriented\Helpers\SuccessAlert;

$model = new Elit1\ObjectOriented\Users();

if (isset($submit)) {
    $model->email = $email ?? '';
    $model->age = $age ?? 0;
    $model->name = $name ?? '';
    if ($model->validate()) {
        if ($model->create()) {
            // This is a convenient way to naturally send the user back to the main page.
            SuccessAlert::echo('User added successfully!');
            Navigator::redirectJs("index.php?route=getusers");
        }
    }
}
echo '<div class="container-fluid">';
$form = Form::begin('', 'post');
echo $form->field($model, 'email');
echo $form->field($model, 'name');
echo $form->field($model, 'age');
Submit::button();
Form::end();
echo '</div>';
