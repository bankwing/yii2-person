<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use andahrm\person\models\Title;
use kuakling\datepicker\DatePicker;
use andahrm\setting\models\WidgetSettings;
?>
<div class="form-person">
    <div class="row">
        <?= $form->field($model, 'citizen_id', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'title_id', ['options' => ['class' => 'form-group col-sm-3']])->dropDownList(ArrayHelper::map(Title::find()->all(), 'id', 'name')) ?>
        
        <?= $form->field($model, 'firstname_th', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'lastname_th', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="row">
        <?= $form->field($model, 'firstname_en', ['options' => ['class' => 'form-group col-sm-3 col-sm-offset-6']])->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'lastname_en', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="row">
        <?= $form->field($model, 'gender', ['options' => ['class' => 'form-group col-sm-3']])->inline()->radioList($model->getGenders()) ?>
        
        <?= $form->field($model, 'tel', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'phone', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'birthday', ['options' => ['class' => 'form-group col-sm-3']])->widget(DatePicker::className()) ?>
        
    </div>
</div>

<?php
if($model->isNewRecord) {
$firstname_en_id = Html::getInputId($model, "firstname_en");
$username_id = Html::getInputId($modelUser, "username");

$citizen_id_id =  Html::getInputId($model, "citizen_id");
$password_id = Html::getInputId($modelUser, "newPassword");
$passwordConfirm_id = Html::getInputId($modelUser, "newPasswordConfirm");
$js[] = <<< JS
$(document).on('change', '#{$firstname_en_id}', function(event){ var val = $(this).val().toLowerCase(); $('#$username_id').val(val); });
$(document).on('change', '#{$citizen_id_id}', function(event){ var val = $(this).val().toLowerCase(); $('#$password_id').val(val); $('#$passwordConfirm_id').val(val); });
JS;


$this->registerJs(implode("\n", $js));
}