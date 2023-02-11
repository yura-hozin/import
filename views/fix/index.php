<?php
$this->title = Yii::t('app', 'Исправление данных');
?>

<h1><?=$this->title?></h1>

<?php
if (!empty($error)){
    foreach ($error as $err) {
        echo "<div class='test'>".$err."</div>";
    }
}

echo "<pre>"; print_r($info); echo "</pre>";
?>