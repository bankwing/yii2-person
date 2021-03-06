<?php
use yii\bootstrap\Html;
use dmstr\widgets\Menu;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

 $this->beginContent('@app/views/layouts/main.php'); 
 $module = $this->context->module->id;
$controller = Yii::$app->controller->id;

?>
<div class="row">
    <div class="col-md-12">
        
        
      
        <div class="x_panel tile">
            <div class="x_title">
                <h2><?= $this->title; ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                <?php
         $menuItems[] =  [
            "label" => Yii::t('andahrm/competency','Set Competency'),
            "url" => ["/person/competency-information/index",'file'=>1],
            "icon" => "fa fa-users",
            //'active' => (strpos($this->context->route,'report/person') !== false)?true:false
        ];
        $menuItems[] =  [
            "label" => Yii::t('andahrm/competency','Main Competency'),
            "url" => ["/person/competency-information/index",'file'=>2],
            "icon" => "fa fa-users",
            //'active' => (strpos($this->context->route,'report/person') !== false)?true:false
        ];
        $menuItems[] =  [
            "label" => Yii::t('andahrm/competency','Manager Competency'),
            "url" => ["/person/competency-information/index",'file'=>3],
            "icon" => "fa fa-users",
            //'active' => (strpos($this->context->route,'report/person') !== false)?true:false
        ];
        $menuItems[] =  [
            "label" => Yii::t('andahrm/competency','Line Competency'),
            "url" => ["/person/competency-information/index",'file'=>4],
            "icon" => "fa fa-users",
            //'active' => (strpos($this->context->route,'report/person') !== false)?true:false
        ];
        
        
        //NavBar::begin();
        echo Nav::widget(
                [
                //'options' => ['class' => 'navbar-nav'],
                 'options' => ['class' => 'nav nav-pills'],
                 //'submenuTemplate' => "\n<ul class='nav child_menu' {show}>\n{items}\n</ul>\n",
                 //'activeCssClass' => 'current-page',
                 //'encodeLabels' => true,
                    //"activeCssClass" => "current-page",
                    "items" => $menuItems,
                ]
            );
        //NavBar::end();
            ?>
                
                
                <?php echo $content; ?>
                <div class="clearfix"></div>
            </div>
        </div>
      
    </div>
</div>

<?php $this->endContent(); ?>
