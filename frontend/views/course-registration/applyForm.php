<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/16/2019
 * Time: 10:02 AM
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/**
 * @var $model \frontend\models\CourseRegistrationForm
 * @var $course_list array
 */

?>
<?php $form = ActiveForm::begin([
    'id' => 'apply-form',
    'action' => Url::to(['course-registration/ajax-save-contact']),
    'enableAjaxValidation' => true,
    'validateOnChange' => true,
    'enableClientValidation' => false,
    'validationUrl' => Url::to(['course-registration/ajax-validate-contact']),
    'options' => ['class' => 'apply-form']
]); ?>

<div class="heading">
    <h1 class="title">Tiếng Trung Ánh Dương</h1>
</div>

<div class="body">
    <input type="hidden" name="ref" value="<?= Yii::$app->request->get('ref') ?>">

    <?= $form->field($model, 'course_name')->dropDownList($course_list)->label('Bạn quan tâm đến khóa học nào?') ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'phone_number') ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 2]) ?>

    <div class="form-group">
        <button type="submit">Nhận tư vấn miễn phí</button>
    </div>

</div>

<?php ActiveForm::end(); ?>

<script>
window.addEventListener('load', function () {
    var $form = $('#apply-form');
    $form.on('beforeSubmit', function () {
        $form.addClass('loading-opacity');
        var data = new FormData($form.get(0));
        var xhr = new XMLHttpRequest();
        xhr.onload = function () {
            var res = JSON.parse(xhr.responseText);
            if (res.error) {
                popup(JSON.stringify(res.error));
                return;
            }
            fbq('track', 'CompleteRegistration');
            popup('Đăng ký học thành công!');
            $form.get(0).reset();
            setTimeout(function () {
                var successUrlTml = <?= json_encode(Url::to(['course-registration/success', 'name' => '__NAME__', 'course_name' => '__COURSE_NAME__'])) ?>;
                location.href = successUrlTml
                    .replace('__NAME__', res.model.name)
                    .replace('__COURSE_NAME__', res.model.course_name);
            }, 1000);
        };
        xhr.onerror = function () {
            popup(xhr.statusText);
        };
        xhr.onloadend = function () {
            $form.removeClass('loading-opacity');
        };
        xhr.open($form.attr('method'), $form.attr('action'));
        xhr.send(data);
        return false; // Cancel form submitting.
    });
});
</script>
