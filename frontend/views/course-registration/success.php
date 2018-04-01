<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/1/2018
 * Time: 8:26 PM
 */

/**
 * @var string $name
 * @var string $course_name
 */
?>
<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký thành công khóa học <?= $course_name ?> | Tiếng Trung Ánh Dương</title>
    <style>
        html {
            font-size: 16px;
        }
        * {
            font-family: Helvetica, Arial, sans-serif;
        }
        h1 {
            color: #6a3;
            text-align: center;
            margin-top: 4rem;
            margin-bottom: 2rem;
            font-size: 1.8em;
        }
        p {
            font-size: 18px;
            text-align: center;
            line-height: 1.5em;
        }
        strong {
            color: #F47A20;
        }
        .links > * {
            margin: 0.25em;
        }
    </style>
</head>
<body>
    <h1>Đăng ký thành công!</h1>
    <p>
        Chúc mừng bạn <strong><?= $name ?></strong> đã đăng ký thành công khóa học <strong><?= $course_name ?></strong>
    </p>
    <p>
        <strong>Tiếng Trung Ánh Dương</strong> sẽ liên hệ với bạn trong thời gian sớm nhất.
    </p>
    <p>
        Bạn vui lòng chú ý điện thoại nhé!
    </p>
    <p class="links">
        <span>Quay lại</span>
        <a href="<?= \yii\helpers\Url::home() ?>" title="tiengtrunganhduong.com">Trang chủ</a>
        <a href="<?= \yii\helpers\Url::to(['course-registration/index']) ?>" title="Các khóa học tiếng Trung giao tiếp cơ bản và nâng cao">Khóa học</a>
    </p>
</body>
</html>

