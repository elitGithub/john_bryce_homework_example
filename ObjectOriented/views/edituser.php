<?php
use Elit1\ObjectOriented\Forms\Form;
use Elit1\ObjectOriented\Forms\Submit;
use Elit1\ObjectOriented\Helpers\Navigator;
use Elit1\ObjectOriented\Helpers\SuccessAlert;

$model = new Elit1\ObjectOriented\Users();

$model->id = $_GET['id'];
$model->retrieveEntityInfo();

if (isset($submit)) {
    $model->email = $email ?? $model->email;
    $model->age = $age ?? $model->age;
    $model->name = $name ?? $model->name;
    $model->mode = 'edit';
    if ($model->validate()) {
        if ($model->update()) {
            // This is a convenient way to naturally send the user back to the main page.
            SuccessAlert::echo('User updated successfully!');
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