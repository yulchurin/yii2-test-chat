<?php

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\IdentityInterface;

$this->title = 'CHAT';
$this->params['breadcrumbs'][] = $this->title;
$model = new \app\models\ChatForm();


?>
<div class="chat">
    <h1><?= Html::encode($this->title) ?></h1>

    <div id="chat">
        <?php
        if (Yii::$app->user->getId() === '1') {
            $rows = (new \yii\db\Query())
            ->select(['id', 'userID', 'message', 'timestamp','ban'])
            ->from('chat')
            ->limit(30)
            ->orderBy('timestamp')
            ->all();
        } else {
            $rows = (new \yii\db\Query())
            ->select(['id', 'userID', 'message', 'timestamp','ban'])
            ->from('chat')
            ->where(['ban' => null])
            ->limit(30)
            ->orderBy('timestamp')
            ->all();
        }

        foreach ($rows as $row) {
            if (($row['userID']) === '1') {
                echo '<span class="text-danger">';
            }
            echo $row['timestamp'], ':</strong> ', $row['message'];
            if (($row['userID']) === '1') {
                echo '</span>';
            }

            if (Yii::$app->user->getId() === '1') {
                $banbutton = ActiveForm::begin(['id' => 'ban_form']);
                $msg_id = $row['id'];
                ?>
                <div class="form-group">
                    <?= Html::hiddenInput('ban_butt', $msg_id) ?>

                    <?php
                    if ($row['ban'] !== '1') {
                        echo Html::submitButton('забанить сообщение', ['class' => 'btn btn-primary', 'name' => 'ban']);
                    } else {
                        echo Html::submitButton('разбанить сообщение', ['class' => 'btn btn-primary', 'name' => 'unban']);
                    }

                    ?>
                </div>
                <?php
                ActiveForm::end();
            }
            echo '<br>';
        }

        ?>
    </div>

    <?php
    if (isset(Yii::$app->request->post()['submit'])) {
        $model->sendChatMessage((Yii::$app->request->post('ChatForm')['message']));
    }
    if (isset(Yii::$app->request->post()['ban'])) {
        $model->banMessage(Yii::$app->request->post()['ban_butt']);
    }
    if (isset(Yii::$app->request->post()['unban'])) {
        $model->unbanMessage(Yii::$app->request->post()['ban_butt']);
    }   
    ?>


    <?php
    $form = ActiveForm::begin(['id' => 'message-form']);
    if (!Yii::$app->user->isGuest) { ?>
    <?= $form->field($model, 'message')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Написать в чат', ['class' => 'btn btn-primary', 'name' => 'submit']) ?>
    </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>
</div>
