<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use andahrm\datepicker\DatePicker;
use kartik\widgets\Select2;
use andahrm\setting\models\WidgetSettings;
use andahrm\edoc\models\Edoc;
use andahrm\structure\models\Position;
use andahrm\structure\models\PositionOld;
use yii\bootstrap\ActiveForm;
use kartik\widgets\FileInput;
use yii\web\JsExpression;
/* @var $this yii\web\View */

use andahrm\structure\models\PersonType;
use andahrm\insignia\models\PersonInsignia;
use andahrm\insignia\models\InsigniaType;

if($formAction == null){
$this->title = Yii::t('andahrm/person', 'Create Insignia New');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Person'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/person', 'Position'), 'url' => ['view-position', 'id' => $model->user_id]];
//$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
$this->params['breadcrumbs'][] = $this->title;
}
?>
<?php 
  $formOptions['options'] = ['data-pjax' => ''];
  $formOptions['options'] = ['enctype' => 'multipart/form-data'];
  if($formAction !== null)  $formOptions['action'] = $formAction;
  
  $form = ActiveForm::begin($formOptions); 
  ?>
<div class="insignias-form">

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'insignias_dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.insignias-container-items', // required: css class selector
        'widgetItem' => '.insignias-item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.insignias-add-item', // css class
        'deleteButton' => '.insignias-remove-item', // css class
        'model' => $models[0],
        'formId' => $form->id,
        'formFields' => [
            //'user_id',
            'person_type_id',
            'year',
            'gender',
            'certificate_offer_name',
            'insignia_type_id',
            'last_position_id',
            'last_salary',
            //'edoc_id',
        ],
    ]); ?>
    
    <h2 class="page-header dark" style="margin-top: 0; padding-top: 9px;">
        <span class="text-muted"><?=Yii::t('andahrm/person', 'Position History')?></span>
        <button type="button" class="pull-right insignias-add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> <?=Yii::t('andahrm', 'Add List')?></button>
    </h2> 
    
        <div class="insignias-container-items">
            <?php foreach ($models as $index => $model): ?>
            <div class="insignias-item panel panel-default">
                <div class="panel-body" style="padding:8px;">
                    
                    <button type="button" class="pull-right insignias-remove-item btn btn-danger btn-xs">
                        <i class="fa fa-minus"></i>
                    </button>
                    <h4 class="page-header green panel-title-insignias" style="margin-top: 0">
                        <?=Yii::t('andahrm', 'List')?>: <?= ($index + 1) ?>
                    </h4>
                    <div class="clearfix"></div>
                    
                   <div class="row">
                       <?php #echo $form->errorSummary($model); ?>
                        <?php 
                         if (! $model->isNewRecord) {
                            $form->field($model,"[{$index}]user_id")->hiddenInput()->label(false)->hint(false)->error(false);
                        }
                        ?>
                        <?= $form->field($model, "[{$index}]person_type_id",['options' => ['class' => 'form-group col-xs-3 col-sm-3 adjust_date']])
                        ->dropDownList(PersonType::getForInsignia(),[
                            'prompt'=>Yii::t('app','Select'),
                            //'id'=>'ddl-person_type'
                        ]) ?>
                        
                        <?=$form->field($model,"[{$index}]year",['options' => ['class' => 'form-group col-xs-3 col-sm-3 adjust_date']])
                         ->widget(DatePicker::classname(), [              
                          'options' => [
                            'daysOfWeekDisabled' => [0, 6],
                          ],
                        ]);?>
                
                        <?=$form->field($model,"[{$index}]gender",[
                            'options' => ['class' => 'form-group  col-xs-3 col-sm-3'],
                        ])->dropDownList(PersonInsignia::getGenders(),['prompt'=>Yii::t('app','Select')]) ?>
                        
                        
                         <?=$form->field($model,"[{$index}]insignia_type_id",[
                            'options' => ['class' => 'form-group  col-xs-3 col-sm-3'],
                        ])->dropDownList(InsigniaType::getList()) ?>
                        
                    </div>
                    
                    
                     <div class="row">
                         
                         <?=$form->field($model,"[{$index}]last_salary",[
                            'options' => ['class' => 'form-group  col-xs-3 col-sm-3'],
                        ])->textInput(['type'=>'number','min'=>0]) ?>
                        
                        <?=$form->field($model,"[{$index}]last_position_id",[
                            'options' => ['class' => 'form-group  col-xs-3 col-sm-3'],
                        ])->widget(Select2::classname(),
                                [
                                    'data' => Position::getList(),
                                    'options' => ['placeholder' => Yii::t('andahrm/person', 'Search for a position')],
                                    'pluginOptions' => [
                                        //'tags' => true,
                                        //'tokenSeparators' => [',', ' '],
                                        'allowClear'=>true,
                                        'minimumInputLength'=>2,//ต้องพิมพ์อย่างน้อย 3 อักษร ajax จึงจะทำงาน
                                        'ajax'=>[
                                            'url'=>Url::to(['/structure/position/position-list']),
                                            'dataType'=>'json',//รูปแบบการอ่านคือ json
                                            'data'=>new JsExpression('function(params) { return {q:params.term};}')
                                         ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('function(position) { return position.text; }'),
                                        'templateSelection' => new JsExpression('function (position) { return position.text; }'),
                                    ],
                                ]
                            )->hint(false); ?>
<?php   
/*
$toPositionCreate = Url::to(['/structure/position/create']);
$positionInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-success" data-key="{$index}">
        <a href="{$toPositionCreate}" target="_blank"><i class="fa fa-plus"></i></a>
    </span>
</div>
HTML;
?>                        

                         <?=$form->field($model, "[{$index}]position_id",[
                             'inputTemplate' => $positionInputTemplate,
                             'options' => ['class' => 'form-group  col-xs-3 col-sm-3']
                             ])
                            ->widget(Select2::classname(),
                                [
                                    'data' => Position::getList(),
                                    'options' => ['placeholder' => 'Search for a position ...'],
                                    'pluginOptions' => [
                                        //'tags' => true,
                                        //'tokenSeparators' => [',', ' '],
                                        'allowClear'=>true,
                                        'minimumInputLength'=>2,//ต้องพิมพ์อย่างน้อย 3 อักษร ajax จึงจะทำงาน
                                        'ajax'=>[
                                            'url'=>Url::to(['/structure/position/position-list']),
                                            'dataType'=>'json',//รูปแบบการอ่านคือ json
                                            'data'=>new JsExpression('function(params) { return {q:params.term};}')
                                         ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('function(position) { return position.text; }'),
                                        'templateSelection' => new JsExpression('function (position) { return position.text; }'),
                                    ],
                                ]
                            )->hint(false); */?>
                            
                       
<?php                        
$edocInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-success new_edoc" data-key="{$index}">
        <i class="fa fa-plus"></i>
    </span>
</div>
HTML;
?>
                         <?=$form->field($model, "[{$index}]edoc_id",[
                             'inputTemplate' => $edocInputTemplate,
                             'options' => ['class' => 'form-group  col-xs-4 col-sm-4'
                             ]])
                         ->widget(Select2::className(), WidgetSettings::Select2(['data' => Edoc::getList()]));
                        ?>
                    </div>
                    
                        <div class="row">
                            <?php #= $form->errorSummary($modelsEdoc); ?>
                            
                            
                            <div class="new_edoc_area" data-key="<?=$index?>" style="display:none;">
                                
                                <?=$form->field($modelsEdoc[0],"[{$index}]code",[
                                'options' => ['class' => 'form-group col-sm-2']
                                ])->textInput(['disabled'=>'disabled']);?>
                                
                                <?=$form->field($modelsEdoc[0], "[{$index}]date_code",
                                ['options' => ['class' => 'form-group col-sm-2 date_code']])
                                ->widget(DatePicker::classname(), WidgetSettings::DatePicker(['options' => ['disabled'=>'disabled']]));
                                ?>
                                
                                <?=$form->field($modelsEdoc[0],"[{$index}]title",[
                                'options' => ['class' => 'form-group col-sm-4']
                                ])->textInput(['disabled'=>'disabled']);?>
                                
                                
                                
                                 <?= $form->field($modelsEdoc[0], "[{$index}]file",['options' => ['class' => 'form-group col-sm-4']])
                                 ->widget(FileInput::classname(), [
                                    'options' => ['accept' => 'pdf/*,image/*','disabled'=>'disabled'],
                                    'pluginOptions' => [
                                      'previewFileType' => 'pdf',
                                      'elCaptionText' => '#customCaption',
                                      'uploadUrl' => Url::to(['/edoc/default/file-upload']),
                                      'showPreview' => false,
                                      'showCaption' => true,
                                      'showRemove' => true,
                                      'showUpload' => false,
                                    ],
                                    
                                ]);?>
                                
                                <?php #echo $edocInputId = Html::getInputId($modelsEdoc, "[{$index}]file");?>
                        </div>
                        
                        
                        
                        
                    </div><!-- end:row -->

                    
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php DynamicFormWidget::end(); ?>
    
     <div class="form-group">
         <?= Html::submitButton( Yii::t('andahrm', 'Save') , ['class' =>  'btn btn-success' ]) ?>
    </div>
</div>

    <?php ActiveForm::end(); ?>
<?php
$this->registerJs("
function initSelect2Loading(a,b){ initS2Loading(a,b); }
function initSelect2DropStyle(id, kvClose, ev){ initS2Open(id, kvClose, ev); }", 
$this::POS_HEAD);


$listLabel = Yii::t('andahrm', 'List');
$js[] = <<< JS
bindBtnAddEdoc();
jQuery(".insignias_dynamicform_wrapper").on('afterInsert', function(e, item) {
    
    
    $( ".adjust_date" ).each(function() {
           $(this).find('input').datepicker({
               "language":"th-th",
               "autoclose":true,
               "daysOfWeekDisabled":[0,6],
            });
      });   
      
      $( ".date_code" ).each(function() {
           $(this).find('input').datepicker({
               "language":"th-th",
               "autoclose":true,
               "daysOfWeekDisabled":[0,6],
            });
      }); 
      
    $(".insignias_dynamicform_wrapper .panel-title-insignias").each(function(index) {
        jQuery(this).html("{$listLabel}: " + (index + 1));
    });
    
    
    bindBtnAddEdoc();
    
});

jQuery(".insignias_dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".insignias_dynamicform_wrapper .panel-title-insignias").each(function(index) {
        jQuery(this).html("{$listLabel}: " + (index + 1));
    });
});


function bindBtnAddEdoc(){
    $(".insignias_dynamicform_wrapper .new_edoc").each(function(index) {
        $(this).attr('data-key',index);
        //var key = index;
        var area = $(".insignias_dynamicform_wrapper .new_edoc_area:eq("+index+")").attr('data-key',index);
        
        
        $(this).unbind('click');
        $(this).bind('click',function(){
            if(!$(this).is('.shown')){
                $(this).find("i").removeClass('fa-plus');
                $(this).find("i").addClass('fa-minus');
                $(this).addClass('shown');
                $(area).find('input').attr('disabled',false);
                $(area).find("#edoc-"+index+"-file").attr('disabled',false);
                $(area).find("#edoc-"+index+"-file").fileinput('refresh');
                $(area).show();
            }else{
                 $(this).removeClass('shown');
                 $(this).find("i").addClass('fa-plus');
                 $(this).find("i").removeClass('fa-minus');
                 $(area).find('input').attr('disabled',true);
                $(area).find("#edoc-"+index+"-file").attr('disabled',true);
                $(area).find("#edoc-"+index+"-file").fileinput('refresh');
                $(area).hide();
            }
        });
    });
}
JS;
    
$this->registerJs(implode("\n", $js), $this::POS_END);



///Surakit
if($formAction !== null) {
$js[] = <<< JS
$(document).on('submit', '#{$form->id}', function(e){
  e.preventDefault();
  var form = $(this);
  var formData = new FormData(form[0]);
  // alert(form.serialize());
  
  $.ajax({
    url: form.attr('action'),
    type : 'POST',
    data: formData,
    contentType:false,
    cache: false,
    processData:false,
    dataType: "json",
    success: function(data) {
      if(data.success){
        callbackPosition(data.result);
      }else{
        alert('Fail');
      }
    }
  });
});
JS;

$this->registerJs(implode("\n", $js));
}
?>