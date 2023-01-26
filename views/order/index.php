<?php

$this->title = 'Order';
if(Yii::$app->user->identity->divisi == 1 || Yii::$app->user->identity->divisi == 2 || Yii::$app->user->identity->divisi == 3){
//restrict action to user
    $this->render('index-admin', [
        'sm' => $sm,
        'dp' => $dp,
    ]);

}else{
    $this->render('index-produksi', [
        'sm' => $sm,
        'dp' => $dp,
    ]);
}
?>