<?php
/**
 * @var $model \frontend\models\CourseRegistrationForm
 * @var String[] $course_list
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Khóa học tiếng Trung cơ bản và nâng cao tại tiếng Trung Ánh Dương với phương pháp đào tạo trực quan, sinh động, môi trường học tập thân thiện, giao tiếp thường xuyên với người bản ngữ giúp bạn làm chủ tiếng Trung dễ dàng hơn bao giờ hết">
    <meta name="keywords" content="khóa học tiếng trung cơ bản, khóa học tiếng trung giao tiếp">
    <meta name="robots" content="index, follow">
    <meta name="robots" content="NOODP, NOYDIR">
    <title>Khóa học tiếng Trung cơ bản, tiếng Trung giao tiếp-Trung tâm tiếng Trung Ánh Dương</title>
    <link href="<?= \yii\helpers\Url::to(['course-registration/index'], true) ?>" rel="canonical">
    <style type="text/css">
         <?php
         require_once 'slider.css';
         require_once 'style.css';
         ?>
         html {
             background-image: url("<?= Yii::getAlias('@web/img/landing/banners/banner_x.jpg') ?>");
         }
        @media screen and (max-width: 599px) {
             html {
                 background-image: url("<?= Yii::getAlias('@web/img/landing/banners/banner_small_x.jpg') ?>");
             }
        }
    </style>
    <script src="//hammerjs.github.io/dist/hammer.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        <?php require_once 'slider.js'; ?>
        <?php require_once 'script.js'; ?>
    </script>
</head>
<body>
<div id="header" class="container clr">
    <div class="left">
        <div class="slogan-wrapper">
            <div class="slogan">
                <div class="title">
                    KHUYẾN MÃI SỐC
                </div>
                <ul class="content">
                    <li>❅ Tặng tài khoản học online 1.500.000đ</li>
                    <li>❅ Tặng giáo trình học, giáo trình nghe</li>
                    <li>❅ Tặng poster 1500 chữ Hán</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="right">
        <?php $form = ActiveForm::begin(['id' => 'apply-form', 'options' => ['class' => 'apply-form']]); ?>

        <div class="heading">
            <h1 class="title">Tiếng Trung Ánh Dương</h1>
        </div>

        <div class="body">
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
    </div>
</div>

<!-- COURSES -->
<div class="container" id="courses">
    <div class="heading">
        <h2 class="title">Các khóa học</h2>
    </div>
    <div class="body aspect-ratio __16x9">
        <div class="slider"
             data-page-size-large="2"
             data-page-size-small="1"
             data-slide-time="110"
             data-display-arrows="true"
             data-preview-left="0.25"
             data-preview-right="0.25"
             data-preview-left-small="0"
             data-preview-right-small="0"
             data-item-aspect-ratio="adjust-by-active-items"
        >
            <div class="inner" data-clickable="true">
                <div class="course-detail course-1">
                    <h3 class="name">Hán ngữ 1</h3>
                    <ul class="intro">
                        <li>
                            <strong>Đối tượng:</strong> Dành cho người bắt đầu học tiếng Trung
                        </li>
                        <li>
                            <strong>Giáo trình:</strong> Hán ngữ 1, sách tập viết, sách luyện nghe bổ sung, bài tập, bài kiểm tra online
                        </li>
                        <li>
                            <strong>Thời lượng:</strong> 20 buổi học, mỗi tuần 3 buổi, mỗi buổi 2 giờ
                        </li>
                        <li>
                            <strong>Mục tiêu đầu ra:</strong> Nắm vững hệ thống phiên âm la tinh tiếng Trung, phát âm chuẩn, có khả năng nghe nói đọc viết và thực hành được những đoạn giao tiếp thông thường. Kết thúc khóa học bạn có thể tích lũy đủ kiến thức để tham gia thi chứng chỉ HSK1.
                            <a href="https://tiengtrunganhduong.com/lop-han-ngu-1-danh-cho-cac-ban-bat-dau-hoc-tieng-trung.htm" title="Hán ngữ 1" target="_blank">
                                <span>Xem chi tiết</span>
                                <i class="icon external-link-icon"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="tuition">
                        <strong>Học phí:</strong> 1.200.000 VNĐ
                    </div>
                    <button type="button"
                            class="apply-button"
                            onclick="goToApplyForm('HAN_NGU_1')"
                    >Nhận tư vấn miễn phí</button>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="course-detail course-2">
                    <h3 class="name">Hán ngữ 2</h3>
                    <ul class="intro">
                        <li>
                            <strong>Đối tượng:</strong> Đã hoàn thành khóa học Hán ngữ 1
                        </li>
                        <li>
                            <strong>Giáo trình:</strong> Hán ngữ 2, sách tập viết theo giáo trình, sách luyện nghe bổ sung, bài tập, bài kiểm tra online
                        </li>
                        <li>
                            <strong>Thời lượng:</strong> 20 buổi học, mỗi tuần 3 buổi, mỗi buổi 2 giờ
                        </li>
                        <li>
                            <strong>Mục tiêu đầu ra:</strong> Phát triển mở rộng từ vựng về các chủ đề giao tiếp trong cuộc sống. Nắm được hệ thống ngữ pháp cơ bản trong tiếng Hán. Tăng kỹ năng nhận đọc chữ Hán theo đoạn văn ngắn. Kết thúc khóa học bạn có thể tích lũy đủ kiến thức để tham gia thi chứng chỉ HSK2.
                            <a href="https://tiengtrunganhduong.com/lop-han-ngu-2.htm" title="Hán ngữ 2" target="_blank">
                                <span>Xem chi tiết</span>
                                <i class="icon external-link-icon"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="tuition">
                        <strong>Học phí:</strong> 1.300.000 VNĐ
                    </div>
                    <button
                        type="button"
                        class="apply-button"
                        onclick="goToApplyForm('HAN_NGU_2')"
                    >Nhận tư vấn miễn phí</button>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="course-detail course-3">
                    <h3 class="name">Hán ngữ 3</h3>
                    <ul class="intro">
                        <li>
                            <strong>Đối tượng:</strong> Đã hoàn thành khóa học Hán ngữ 2 hoặc giáo trình Boya 1
                        </li>
                        <li>
                            <strong>Giáo trình:</strong> Hán ngữ 2, sách tập viết theo giáo trình, sách luyện nghe bổ sung, bài tập, bài kiểm tra online
                        </li>
                        <li>
                            <strong>Thời lượng:</strong> 24 buổi học, mỗi tuần 3 buổi, mỗi buổi 2 giờ
                        </li>
                        <li>
                            <strong>Mục tiêu đầu ra:</strong> Tiếp tục phát triển mở rộng từ vựng và các chủ đề giao tiếp. Nắm và vận dụng được các cấu trúc và hiện tượng ngữ pháp khó, đọc được các đoạn văn dài, phản xạ nghe nói tốt. Kết thúc khóa học bạn có thể tích lũy đủ kiến thức để tham gia thi chứng chỉ HSK3.
                            <a href="https://tiengtrunganhduong.com/lop-han-ngu-3.htm" title="Hán ngữ 3" target="_blank">
                                <span>Xem chi tiết</span>
                                <i class="icon external-link-icon"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="tuition">
                        <strong>Học phí:</strong> 1.500.000 VNĐ
                    </div>
                    <button
                        type="button"
                        class="apply-button"
                        onclick="goToApplyForm('HAN_NGU_3')"
                    >Nhận tư vấn miễn phí</button>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="course-detail course-4">
                    <h3 class="name">Hán ngữ 4</h3>
                    <ul class="intro">
                        <li>
                            <strong>Đối tượng:</strong> Các học viên đã học xong và nắm vững được kiến thức của khóa học Hán Ngữ 3. Các bạn dự định tham dự kỳ thi lấy chứng chỉ HSK4, HSK5
                        </li>
                        <li>
                            <strong>Giáo trình:</strong> Hán ngữ 4, sách luyện nghe bổ sung, bài tập, bài kiểm tra online
                        </li>
                        <li>
                            <strong>Thời lượng:</strong> 25 buổi học, mỗi tuần 3 buổi, mỗi buổi 2 giờ
                        </li>
                        <li>
                            <strong>Mục tiêu đầu ra:</strong> Làm dày thêm vốn từ vựng về cho người học. Tự tin giao tiếp được những mẫu câu dài về các chủ để thường dùng trong giao tiếp hàng ngày. Tích lũy đủ kiến thức để tham gia thi chứng chỉ HSK4.
                            <a href="https://tiengtrunganhduong.com/lop-han-ngu-4.htm" title="Hán ngữ 4" target="_blank">
                                <span>Xem chi tiết</span>
                                <i class="icon external-link-icon"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="tuition">
                        <strong>Học phí:</strong> 1.600.000 VNĐ
                    </div>
                    <button
                        type="button"
                        class="apply-button"
                        onclick="goToApplyForm('HAN_NGU_4')"
                    >Nhận tư vấn miễn phí</button>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="course-detail course-5">
                    <h3 class="name">Hán ngữ 5</h3>
                    <ul class="intro">
                        <li>
                            <strong>Đối tượng:</strong> Đã học hết Hán ngữ 4. Các bạn dự định tham dự kỳ thi lấy chứng chỉ HSK5
                        </li>
                        <li>
                            <strong>Giáo trình:</strong> Hán ngữ 2, sách tập viết theo giáo trình, sách luyện nghe bổ sung, bài tập, bài kiểm tra online
                        </li>
                        <li>
                            <strong>Thời lượng:</strong> 27 buổi học, mỗi tuần 3 buổi, mỗi buổi 2 giờ
                        </li>
                        <li>
                            <strong>Mục tiêu đầu ra:</strong> Phát triển mạnh lượng từ vựng cũng như cách sử dụng từ, từ đó có thể mở rộng giao tiếp được nhiều chủ đề liên quan tới đời sống, tình yêu, triết lý, khoa học, công việc. Kết thúc khóa học tích lũy đủ kiến thức để tham gia thi chứng chỉ HSK4.
                            <a href="https://tiengtrunganhduong.com/lop-han-ngu-5.htm" title="Hán ngữ 5" target="_blank">
                                <span>Xem chi tiết</span>
                                <i class="icon external-link-icon"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="tuition">
                        <strong>Học phí:</strong> 2.000.000 VNĐ
                    </div>
                    <button
                        type="button"
                        class="apply-button"
                        onclick="goToApplyForm('HAN_NGU_5')"
                    >Nhận tư vấn miễn phí</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- FEATURED -->
<div class="container clr" id="featured">
    <div class="heading">
        <h2 class="title title-smaller">Tại sao bạn nên chọn Tiếng Trung Ánh Dương</h2>
    </div>
    <div class="body">
        <div class="slider"
             data-page-size-large="2"
             data-slide-time="110"
             data-display-arrows="true"
             data-preview-left="0.25"
             data-preview-right="0.25"
             data-preview-left-small="0"
             data-preview-right-small="0"
             data-item-aspect-ratio="adjust-by-active-items"
        >
            <div class="inner" data-clickable="true">
                <div class="featured-item">
                    <h3 class="name clr">
                        <i class="icon mortarboard-icon"></i>
                        <span><?= date('Y') - 2010 ?> năm đào tạo Tiếng Trung giao tiếp</span>
                    </h3>
                    <div class="desc">Với hàng nghìn học viên đã được đào tạo, chúng tôi thấu hiểu những khó khăn gặp phải của người Việt khi học tiếng Trung. Qua đó đưa ra lộ trình và phương pháp học tối ưu.</div>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="featured-item">
                    <h3 class="name clr">
                        <i class="icon teacher-icon"></i>
                        <span>Giáo viên trong nước kết hợp bản ngữ</span>
                    </h3>
                    <div class="desc">Đội ngũ giáo viên tốt nghiệp đại học chính quy chuyên ngành tiếng Trung trong và ngoài nước, có nhiệt huyết, kỹ năng sư phạm, chuyên môn tốt. Các giáo viên Bản ngữ được kết hợp để nâng cao khả năng giao tiếp của học viên.</div>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="featured-item">
                    <h3 class="name clr">
                        <i class="icon diploma-icon"></i>
                        <span>Cam kết về chất lượng đầu ra của học viên</span>
                    </h3>
                    <div class="desc">Tiếng Trung Ánh Dương luôn đặt uy tín, chất lượng lên hàng đầu. Các học viên được cam kết đầu ra theo đúng yêu cầu của mỗi khóa học.</div>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="featured-item">
                    <h3 class="name clr">
                        <i class="icon online-icon"></i>
                        <span>Học tiếng Trung online FREE</span>
                    </h3>
                    <div class="desc">Học viên được học tập MIỄN PHÍ bất cứ lúc nào thông qua “hệ sinh thái tiếng Trung” được xây dựng bởi Tiếng Trung Ánh Dương. Các kênh học tập được duy trì hàng ngày điển hình bao gồm hệ thống học trực tuyến nihao.vn, fanpage facebook, kênh youtube, Zalo...</div>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="featured-item">
                    <h3 class="name clr">
                        <i class="icon landscape-icon"></i>
                        <span>Hoạt động ngoại khóa phong phú</span>
                    </h3>
                    <div class="desc">Thường xuyên tổ chức các hoạt động giao lưu, tham quan, dã ngoại với người bản địa để tạo môi trường học tập, nâng cao khả năng giao tiếp sử dụng tiếng Trung trong môi trường thực tế.</div>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="featured-item">
                    <h3 class="name clr">
                        <i class="icon books-icon"></i>
                        <span>Được tiếp cận kho tài liệu học tập khổng lồ</span>
                    </h3>
                    <div class="desc">Các học viên cũng có cơ hội tiếp cận kho tài liệu tiếng Trung khổng lồ phục vụ mục đích học tập, nghiên cứu được sưu tầm và lưu trữ qua nhiều năm tại trung tâm.</div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- TEACHERS -->
<div class="container" id="teachers">
    <div class="heading">
        <h2 class="title">Đội ngũ giảng viên ưu tú</h2>
    </div>
    <div class="body aspect-ratio __1x1">
        <div class="slider"
             data-page-size-large="2"
             data-slide-time="110"
             data-display-arrows="true"
             data-preview-left="0.25"
             data-preview-right="0.25"
             data-preview-left-small="0"
             data-preview-right-small="0"
             data-item-aspect-ratio="adjust-by-active-items"
        >
            <div class="inner" data-clickable="true">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>teachers/gv_co_thoan.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Thoan</h3>
                    <ul class="intro">
                        <li>Thạc sĩ đại học Ngoại Ngữ Quốc Gia, 7 năm kinh nghiệm dạy học.</li>
                        <li>Phương pháp dạy học cực dễ hiểu, linh hoạt, dạy học kết hợp trò chơi, tranh ảnh giúp bài học thêm sinh động và học sinh có thể nhớ ngay kiến thức trên lớp.</li>
                    </ul>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>teachers/gv_co_huyen.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Huyền</h3>
                    <ul class="intro">
                        <li>Tốt nghiệp trường đại học Ngoại Ngữ Quốc Gia. Có 3 năm kinh nghiệm dạy học.</li>
                        <li>Dạy học nhiệt tình, cách giảng bài dễ hiểu, thường xuyên tổ chức trò chơi tạo bầu không khí học tập vui nhộn.</li>
                        <li>Khá nghiêm khắc, bạn nào lười học vào lớp cô Huyền là chăm chỉ học luôn.</li>
                    </ul>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>teachers/gv_co_nham.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Nhâm</h3>
                    <ul class="intro">
                        <li>Tốt nghiệp đại học Ngoại Ngữ Quốc Gia cả 2 chuyên ngành tiếng Trung và tiếng Anh.</li>
                        <li>Nhiệt tình, phương pháp giảng dạy sáng tạo, luôn biết cách tạo cảm hứng cho học viên.</li>
                        <li>Cô giáo cực tâm lí, hay mua đồ ăn cho học sinh ăn chống đói, động viên, nhắc nhở học viên ôn tập bài ở nhà.</li>
                        <li>Cô giáo khá nghiêm khắc, bạn nào lười học là bị ăn mắng ngay.</li>
                    </ul>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>teachers/gv_co_ly.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Ly</h3>
                    <ul class="intro">
                        <li>Tốt nghiệp đại học Ngoại Ngữ Quốc Gia, cô Ly có 4 năm kinh nghiệm dạy học.</li>
                        <li>Xinh xắn, dễ thương, giảng bài dễ hiểu, cuốn hút, cô giáo phát âm rất hay.</li>
                        <li>Cô giáo xinh xắn nên có thể khiến một số bạn học sinh nam hơi phân tán tư tưởng trong giờ học  (^^).</li>
                    </ul>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>teachers/gv_co_hang.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Hằng</h3>
                    <ul class="intro">
                        <li>Tốt nghiệp đại học Ngoại Ngữ Quốc Gia, đã có 5 năm kinh nghiệm dạy học.</li>
                        <li>Giọng nói hay, phát âm chuẩn, giảng bài cực dễ hiểu, cô giáo rất tích cực cho học sinh luyện khẩu ngữ, đặc biệt là hay hát, tham gia lớp học cô Hằng các em sẽ được thưởng thức giọng hát vàng của cô.</li>
                    </ul>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>teachers/gv_co_thuong.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Thương</h3>
                    <ul class="intro">
                        <li>Tốt nghiệp đại học Ngoại Thương, cô có 2 năm kinh nghiệm dạy học.</li>
                        <li>Kiến thức tiếng Trung rất vững, dạy học nhiệt tình dễ hiểu, giọng nói to rõ ràng. Dạy khẩu ngữ là điểm mạnh của cô Thương.</li>
                    </ul>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>teachers/gv_co_quynh.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Quỳnh</h3>
                    <ul class="intro">
                        <li>Tốt nghiệp đại học Ngoại Ngữ Quốc Gia, có 3 năm kinh nghiệm dạy học.</li>
                        <li>Cô giáo xinh xắn, giảng bài rất tỉ mỉ và dễ hiểu. Cô cũng thường xuyên tổ chức trò chơi trong buổi học, khiến buổi học trở lên sôi động, vui vẻ.</li>
                        <li>Cô giáo hơi hiền, cô hay say sưa giảng bài nên thỉnh thoảng lớp tan học muộn.</li>
                    </ul>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>teachers/gv_co_lam.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Lâm</h3>
                    <ul class="intro">
                        <li>Cô Lâm đến từ tỉnh Tứ Xuyên Trung Quốc, chủ yếu cô dạy các lớp giao tiếp tiếng Trung.</li>
                        <li>Cô giáo phát âm chuẩn, giọng nói hay, hơn nữa cô giáo rất vui tính, thân thiện,  phương pháp dạy học sôi động, lôi cuốn.</li>
                        <li>Ngoài giờ học trên lớp, các bạn học viên cũng có thể luyện tập tiếng Trung cùng cô và các bạn Trung Quốc của cô qua những buổi giao lưu,đi chơi thực tế.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- STUDENTS -->
<div class="container" id="students">
    <div class="heading">
        <h2 class="title">Cảm nhận của học viên</h2>
    </div>
    <div class="body aspect-ratio __1x1">
        <div class="slider"
             data-page-size-large="3"
             data-slide-time="110"
             data-display-arrows="true"
             data-preview-left="0.25"
             data-preview-right="0.25"
             data-preview-left-small="0"
             data-preview-right-small="0"
             data-item-aspect-ratio="adjust-by-active-items"
        >
            <div class="inner" data-clickable="true">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>students/hv_01.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Nguyễn Minh Anh</h3>
                    <div class="review">
                        Em đang học khóa Hán Ngữ 1 tại tiếng Trung Ánh Dương. Em cảm thấy trung tâm rất thân thiện, cách dạy của cô giáo dễ hiểu, cô giáo dạy rất nhiệt tình. Em rất vui và muốn đến trung tâm học mỗi ngày. Em sẽ cố gắng học đến cùng! ^^
                    </div>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>students/hv_02.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Minh Thành</h3>
                    <div class="review">
                        Em thấy đến lớp rất vui, cô giáo tâm lý, dạy dễ hiểu và cẩn thận. Em rất thích học ở trung tâm, chúc trung tâm ngày càng phát triển :))
                    </div>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>students/hv_03.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Thu Trang</h3>
                    <div class="review">
                        Mỗi ngày đến lớp là một niềm vui. Cô giáo dạy học nhiệt huyết, lại hay dùng tranh ảnh để dạy và cho cả lớp luyện nói nhiều nên mình thường nhớ bài trên lớp, về chỉ việc ôn lại là được. Nói chung mình thấy học ở trung tâm Ánh Dương rất tốt.
                    </div>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>students/hv_04.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Hữu Thiện</h3>
                    <div class="review">
                        Học tại trung tâm em biết thêm rất nhiều kiến thức, lớp học lại không đông nên mỗi bạn trong lớp đều có nhiều cơ hội để thực hành. Em đã từng học khóa Hán Ngữ 1 ở trung tâm khác, em thấy tiếc vì không lựa chọn trung tâm Ánh Dương ngay từ đầu.
                    </div>
                </div>
            </div>
            <div class="inner" data-clickable="true">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>students/hv_05.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Ngọc Hân</h3>
                    <div class="review">
                        Đến với Trung tâm e thấy rất vui và thoải mái. Cô giáo kiến thức rộng, dạy học lại rất dễ hiểu. em học lớp Hán Ngữ 4 có nhiều ngữ pháp khó, nhưng phương pháp giảng bài của cô giúp em hiểu bài ngay trên lớp. Em cảm ơn cô giáo và trung tâm rất nhiều. Hihi!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- GALLERY -->
<div class="container" id="gallery">
    <div class="heading">
        <h2 class="title">Ảnh lớp học</h2>
    </div>
    <div class="body">
        <div class="slider"
             data-slide-time="110"
             data-display-arrows="true"
             data-item-aspect-ratio="adjust-by-active-items"
             data-display-thumbnails="true"
             data-display-thumbnails-small="false"
             data-display-navigator="true"
        >
            <?php
            for ($i = 0; $i < 10; $i++) {
                ?>
                <div class="inner" data-clickable="true">
                    <img src="<?= Yii::getAlias('@web/img/landing/') ?>gallery/<?= $i ?>.jpg" alt="ảnh lớp học">
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<footer class="container">
    <div class="body">
        <h2>Trung Tâm Tiếng Trung Ánh Dương</h2>
        <ul>
            <li>Địa chỉ: Số 12, ngõ 39, Hồ Tùng Mậu, Mai Dịch, Cấu Giấy, Hà Nội</li>
            <li>
                Email: <a href="mailto:tiengtrunganhduong@gmail.com">tiengtrunganhduong@gmail.com</a>
                <span class="sm-hidden">-</span> <br class="sm-only"/>
                Hotline: <a href="tel:097.5158.419">097.5158.419</a>
            </li>
        </ul>
        <div class="socials">
            <a href="https://www.facebook.com/tiengtrunganhduong" target="_blank"><b class="icon facebook-icon"></b></a>
            <a href="https://twitter.com/tiengtrung247" target="_blank"><b class="icon twitter-icon"></b></a>
            <a href="https://plus.google.com/+tiengtrunganhduong" target="_blank"><b class="icon google-plus-icon"></b></a>
            <a href="https://www.youtube.com/tiengtrunganhduong" target="_blank"><b class="icon youtube-icon"></b></a>
        </div>
    </div>
</footer>

</body>
</html>

<script type="text/javascript">
    <?php
    if (Yii::$app->session->hasFlash('success')) {
    ?>
    popup("<?= Yii::$app->session->getFlash('success') ?>");
    <?php
    } else if (Yii::$app->session->hasFlash('error')) {
    ?>
    popup("<?= Yii::$app->session->getFlash('error') ?>");
    <?php
    }
    ?>
    [].forEach.call(document.querySelectorAll(".slider"), initSlider);
    function goToApplyForm(course_name) {
        var form = document.querySelector("#apply-form");
        var course_name_input = form.querySelector("#<?= Html::getInputId($model, 'course_name') ?>");
        course_name_input.value = course_name;
        var name_input = form.querySelector("#<?= Html::getInputId($model, 'name') ?>");
        name_input.focus();
    }
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P88Z7R2');</script>
<!-- End Google Tag Manager -->

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P88Z7R2"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Google Analytics -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-100860436-1', 'auto');
    ga('send', 'pageview');
</script>

<!-- Google Code dành cho Thẻ tiếp thị lại -->
<!--------------------------------------------------
Không thể liên kết thẻ tiếp thị lại với thông tin nhận dạng cá nhân hay đặt thẻ tiếp thị lại trên các trang có liên quan đến danh mục nhạy cảm. Xem thêm thông tin và hướng dẫn về cách thiết lập thẻ trên: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 981760178;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<style>
    iframe[name="google_conversion_frame"] {
        position: absolute !important;
        height: 0 !important;
        margin: 0;
        padding: 0;
    }
</style>
<noscript>
    <img height="1" width="1" alt="google ads double click" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/981760178/?value=0&guid=ON&script=0"/>
</noscript>

<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');

    fbq('init', '299656173576600');
    fbq('track', "PageView");
    // document.querySelector('#apply-form').addEventListener('submit', function (ev) {
    //     fbq('track', 'CompleteRegistration');
    // });
</script>
<noscript><img height="1" width="1" alt="facebook pixel code" src="https://www.facebook.com/tr?id=299656173576600&ev=PageView&noscript=1"
    /></noscript>
<!-- End Facebook Pixel Code -->