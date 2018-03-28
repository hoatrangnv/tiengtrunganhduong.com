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
    <title>Tiếng Trung Ánh Dương</title>
    <style type="text/css">
         <?php
         require_once 'slider.css';
         require_once 'style.css';
         ?>
         html {
             background-image: url("<?= Yii::getAlias('@web/img/landing/banner.jpg') ?>");
             background-position: top center;
             background-size: 100%;
             background-repeat: no-repeat;
             background-attachment: fixed;
         }
         html:before {
             content: "";
             position: absolute;
             display: block;
             width: 100%;
             height: 100%;
             background-color: #fff;
             opacity: 0.5;
         }
         .white-background {
             background: #fff;
         }
    </style>
    <script src="//hammerjs.github.io/dist/hammer.min.js" type="text/javascript"></script>
    <script src="//rawgit.com/vanquyettran/slider/master/slider.js" type="text/javascript"></script>
    <script type="text/javascript">
        <?php require_once 'script.js'; ?>
    </script>
</head>
<body>
<div id="header" class="container clr">
    <div class="left">
        <div class="slogan-wrapper">
            <div class="slogan">
                Khuyến mại sốc:
                ❅Tặng tài khoản học online, bộ đề thi HSK3,4 online trị giá 1500K
                ❅Tặng giáo trình học, giáo trình nghe bổ sung
                ❅Tặng Poster 1500 chữ Hán
            </div>
        </div>
    </div>
    <div class="right">
        <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['class' => 'apply-form']]); ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'phone_number') ?>

        <?= $form->field($model, 'message')->textarea(['rows' => 2]) ?>

        <?= $form->field($model, 'course_name')->dropDownList($course_list) ?>

        <div class="form-group">
            <button type="submit">Đăng ký</button>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="white-background">

<!-- COURSES -->
<div class="container" id="courses">
    <div class="heading">
        <h2 class="title">Các khóa học</h2>
    </div>
    <div class="body aspect-ratio __16x9">
        <div class="slider"
             data-page-size-large="2"
             data-page-size-small="1"
             data-slide-time="200"
             data-display-arrows="true"
             data-preview-left="0.25"
             data-preview-right="0.25"
             data-preview-left-small="0.1"
             data-preview-right-small="0.1"
             data-repeat-at-last="true"
        >
            <div class="inner">
                <div class="course-detail">
                    <div class="image">
                        <span><img src="<?= Yii::getAlias('@web/img/landing/') ?>course1.jpg"></span>
                    </div>
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
                            <strong>Mục tiêu đầu ra:</strong> Nắm vững hệ thống phiên âm la tinh tiếng Trung, phát âm chuẩn, đồng thời có thể nghe nói đọc viết và thực hành được những đoạn giao tiếp thông thường trong sinh hoạt hàng ngày. Kết thúc khóa học bạn có thể tích lũy đủ kiến thức để tham gia thi chứng chỉ HSK1.
                        </li>
                    </ul>
                    <div class="tuition">
                        <strong>Học phí:</strong> 1.000.000 VNĐ
                    </div>
                    <button type="button" class="apply-button">Đăng ký</button>
                </div>
            </div>
            <div class="inner">
                <div class="course-detail">
                    <div class="image">
                        <span><img src="<?= Yii::getAlias('@web/img/landing/') ?>course1.jpg"></span>
                    </div>
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
                            <strong>Mục tiêu đầu ra:</strong> Phát triển mở rộng từ vựng và các chủ đề giao tiếp trong cuộc sống. Nắm được hệ thống ngữ pháp cơ bản trong tiếng Hán kết hợp với những chủ đề hội thoại giao tiếp thông thường. Tăng kĩ năng nhận đọc chữ Hán theo đoạn văn ngắn. Kết thúc khóa học bạn có thể tích lũy đủ kiến thức để tham gia thi chứng chỉ HSK2.
                        </li>
                    </ul>
                    <div class="tuition">
                        <strong>Học phí:</strong> 1.100.000 VNĐ
                    </div>
                    <button type="button" class="apply-button">Đăng ký</button>
                </div>
            </div>
            <div class="inner">
                <div class="course-detail">
                    <div class="image">
                        <span><img src="<?= Yii::getAlias('@web/img/landing/') ?>course1.jpg"></span>
                    </div>
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
                            <strong>Mục tiêu đầu ra:</strong> Củng cố kiến thức lớp hán ngữ 2, Tiếp tục phát triển mở rộng từ vựng và các chủ đề giao tiếp. Học viên nắm và vận dụng được các cấu trúc và hiện tượng ngữ pháp khó trong giáo trình, đồng thời đọc được các đoạn văn dài, và có phản xạ nghe nói tốt với nhiều chủ đề thường dùng trong cuộc sống. Kết thúc khóa học bạn có thể tích lũy đủ kiến thức để tham gia thi chứng chỉ HSK3.
                        </li>
                    </ul>
                    <div class="tuition">
                        <strong>Học phí:</strong> 1.400.000 VNĐ
                    </div>
                    <button type="button" class="apply-button">Đăng ký</button>
                </div>
            </div>
            <div class="inner">
                <div class="course-detail">
                    <div class="image">
                        <span><img src="<?= Yii::getAlias('@web/img/landing/') ?>course1.jpg"></span>
                    </div>
                    <h3 class="name">Hán ngữ 4</h3>
                    <ul class="intro">
                        <li>
                            <strong>Đối tượng:</strong> Đây là khóa học dành cho học viên đã học xong và nắm vững được kiến thức của khóa học Hán Ngữ 3. Các bạn dự định tham dự kỳ thi lấy chứng chỉ HSK4, HSK5
                        </li>
                        <li>
                            <strong>Giáo trình:</strong> Hán ngữ 4, sách luyện nghe bổ sung, bài tập, bài kiểm tra online
                        </li>
                        <li>
                            <strong>Thời lượng:</strong> 25 buổi học, mỗi tuần 3 buổi, mỗi buổi 2 giờ
                        </li>
                        <li>
                            <strong>Mục tiêu đầu ra:</strong> Mở rộng và làm dày thêm vốn từ vựng về cho người học. Học viên nắm chắc và vận dụng các hiện tượng và cấu trúc ngữ pháp trong giáo trình, tự tin giao tiếp được những mẫu câu dài về các chủ để thường dùng trong giao tiếp hàng ngày. Kết thúc khóa học tích lũy đủ kiến thức để tham gia thi chứng chỉ HSK4
                        </li>
                    </ul>
                    <div class="tuition">
                        <strong>Học phí:</strong> 1.600.000 VNĐ
                    </div>
                    <button type="button" class="apply-button">Đăng ký</button>
                </div>
            </div>
            <div class="inner">
                <div class="course-detail">
                    <div class="image">
                        <span><img src="<?= Yii::getAlias('@web/img/landing/') ?>course1.jpg"></span>
                    </div>
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
                            <strong>Mục tiêu đầu ra:</strong> Phát triển mạnh lượng từ vựng cũng như cách sử dụng từ, từ đó có thể mở rộng giao tiếp được nhiều chủ đề liên quan tới cuộc sống, tình yêu, triết lý, khoa học, công việc. Kết thúc khóa học tích lũy đủ kiến thức để tham gia thi chứng chỉ HSK4
                        </li>
                    </ul>
                    <div class="tuition">
                        <strong>Học phí:</strong> 2.000.000 VNĐ
                    </div>
                    <button type="button" class="apply-button">Đăng ký</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- FEATURED -->
<div class="container clr" id="featured">
    <div class="heading">
        <h2 class="title">Tại sao bạn nên chọn Tiếng Trung Ánh Dương</h2>
    </div>
    <div class="body">
        <div class="slider"
             data-page-size-large="3"
             data-slide-time="200"
             data-display-arrows="true"
             data-preview-left="0.25"
             data-preview-right="0.25"
             data-preview-left-small="0.1"
             data-preview-right-small="0.1"
        >
            <div class="inner">
                <div class="featured-item">
                    <h3 class="name">06 năm đào tạo Tiếng Trung giao tiếp</h3>
                    <div class="desc">Khởi đầu vào năm 2010, trong suốt quá trình phát triển của mình, chúng tôi thấu hiểu những khó khăn gặp phải của người Việt khi học tiếng Trung. Qua đó đưa ra lộ trình và phương pháp học tối ưu.</div>
                </div>
            </div>
            <div class="inner">
                <div class="featured-item">
                    <h3 class="name">Đội ngũ GV trong nước kết hợp Bản Ngữ</h3>
                    <div class="desc">“Chúng tôi chỉ nhận các GV tốt nghiệp đại học chính quy chuyên ngành tiếng Trung trong và ngoài nước, có nhiệt huyết, kỹ năng sư phạm, chuyên môn tốt. Các giáo viên Bản ngữ được kết hợp để nâng cao khả năng giao tiếp của học viên. Bạn sẽ không thể tìm thấy một nơi thứ 2 với mức học phí như Ánh Dương!</div>
                </div>
            </div>
            <div class="inner">
                <div class="featured-item">
                    <h3 class="name">Cam kết về chất lượng đầu ra của học viên</h3>
                    <div class="desc">Tiếng Trung Ánh Dương luôn đặt uy tín, chất lượng lên hàng đầu. Đến với trung tâm, các học viên được cam kết đầu ra theo đúng yêu cầu của mỗi khóa học, được hỗ trợ trực tiếp về tiếng Trung từ quản lý lớp 24/7 không những trong các vấn đề học tập mà cả những vấn đề gặp phải trong công việc và cuộc sống</div>
                </div>
            </div>
            <div class="inner">
                <div class="featured-item">
                    <h3 class="name">Hoạt động ngoại khóa phong phú</h3>
                    <div class="desc">Nhằm tạo môi trường học tiếng Trung toàn diện cho học viên. Chúng tôi thường xuyên tổ chức các hoạt động giao lưu, tham quan, dã ngoại với người Bản địa.</div>
                </div>
            </div>
            <div class="inner">
                <div class="featured-item">
                    <h3 class="name">Tài liệu học và tham khảo phong phú</h3>
                    <div class="desc">Tiếng Trung được Ánh Dương cung cấp đa dạng các tài liệu học tập trên lớp và ở nhà như giáo trình nghe do trung tâm biên soạn, tài liệu luyện viết chữ Hán, bài tập mở rộng sau mỗi bài học, các bài kiểm tra online định kỳ, hsk…Các học viên cũng có cơ hội tiếp cận kho tài liệu tiếng Trung khổng lồ được lưu sưu tầm và lưu trữ qua nhiều năm tại Trung tâm.</div>
                </div>
            </div>
            <div class="inner">
                <div class="featured-item">
                    <h3 class="name">Dạy tiếng Trung Online Free</h3>
                    <div class="desc">Chúng tôi duy trì hoạt động dạy tiếng Trung online trong suốt quá trình phát triển của mình. Học viên có thể tham gia học tập MIỄN PHÍ bất cứ lúc nào thông qua “hệ sinh thái tiếng Trung” được xây dựng bởi Tiếng Trung Ánh Dương. Các kênh học tập được duy trì hàng ngày điển hình bao gồm hệ thống học trực tuyến nihao.vn, fanpage facebook, kênh youtube, Zalo page, groups, Instagram, Pinterest…</div>
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
             data-page-size-large="3"
             data-slide-time="200"
             data-display-arrows="true"
             data-preview-left="0.25"
             data-preview-right="0.25"
             data-preview-left-small="0.1"
             data-preview-right-small="0.1"
        >
            <div class="inner">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>gv_co_thoan.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Thoan</h3>
                    <ul class="intro">
                        <li>Sinh năm 1987, thạc sĩ đại học Ngoại Ngữ Quốc Gia, có 7 năm kinh nghiệm dạy học.</li>
                        <li>Phương pháp dạy học cực dễ hiểu, linh hoạt, dạy học kết hợp trò chơi, tranh ảnh giúp bài học thêm sinh động và học sinh có thể nhớ ngay kiến thức trên lớp.Cô giáo cũng là người quản lí  của trung tâm, bạn nào có thắc mắc gì về khóa học hay kiến thức có thể hỏi cô giáo, cô sẽ tư vấn nhiệt tình.</li>
                    </ul>
                </div>
            </div>
            <div class="inner">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>gv_co_huyen.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Huyền</h3>
                    <ul class="intro">
                        <li>Sinh năm 1992, tốt nghiệp trường đại học Ngoại Ngữ Quốc Gia.Có 3 năm kinh nghiệm dạy học</li>
                        <li>Dạy học nhiệt tình, cách giảng bài dễ hiểu, thường xuyên tổ chức trò chơi tạo bầu không khí học tập vui nhộn.</li>
                        <li>Khá nghiêm khắc, bạn nào lười học vào lớp cô Huyền là chăm chỉ học luôn</li>
                    </ul>
                </div>
            </div>
            <div class="inner">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>gv_co_nham.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Nhâm</h3>
                    <ul class="intro">
                        <li>Sinh năm 1994, tốt nghiệp đại học Ngoại Ngữ Quốc Gia cả 2 chuyên nghành tiếng Trung và tiếng Anh</li>
                        <li>Cô Nhâm là giáo viên nhiệt tình, phương pháp giảng dạy sáng tạo, luôn biết cách tạo cảm hứng cho học viên. Đặc biệt cô giáo thường xuyên cho học sinh luyện tập khẩu ngữ.Cô giáo cực tâm lí, hay mua đồ ăn cho học sinh ăn chống đói, ngoài giờ học chính trên lớp, cô còn lập lên group học tập để động viên cũng như nhắc nhở học viên ôn tập bài ở nhà.</li>
                        <li>Cô giáo khá nghiêm khắc, bạn nào lười học là bị ăn mắng ngay.</li>
                    </ul>
                </div>
            </div>
            <div class="inner">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>gv_co_ly.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Ly</h3>
                    <ul class="intro">
                        <li>Sinh năm 1992, tốt nghiệp đại học Ngoại Ngữ Quốc Gia, cô Ly có 4 năm kinh nghiệm dạy học</li>
                        <li>Xinh xắn, dễ thương, giảng bài dễ hiểu, cuốn hút, cô giáo phát âm rất hay</li>
                        <li>Cô giáo xinh xắn nên có thể khiến một số bạn học sinh nam hơi phân tán tư tưởng trong giờ học (^^)</li>
                    </ul>
                </div>
            </div>
            <div class="inner">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>gv_co_hang.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Hằng</h3>
                    <ul class="intro">
                        <li>Sinh năm 1990, tốt nghiệp đại học Ngoại Ngữ Quốc Gia, đã có 5 năm kinh nghiệm dạy học</li>
                        <li>Giọng nói hay, phát âm chuẩn, giảng bài cực dễ hiểu, cô giáo rất tích cực cho học sinh luyện khẩu ngữ, đặc biệt là hay hát, tham gia lớp học cô Hằng các em sẽ được thưởng thức giọng hát vàng của cô.</li>
                    </ul>
                </div>
            </div>
            <div class="inner">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>gv_co_thuong.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Thương</h3>
                    <ul class="intro">
                        <li>Sinh năm 1994, tốt nghiệp đại học Ngoại Thương, cô có 2 năm kinh nghiệm dạy học</li>
                        <li>Kiến thức tiếng trung rất vững, dạy học nhiệt tình dễ hiểu, giọng nói to rõ ràng.Dạy khẩu ngữ là điểm mạnh của cô Thương</li>
                        <li>Nghiêm khắc</li>
                    </ul>
                </div>
            </div>
            <div class="inner">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>gv_co_quynh.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Quỳnh</h3>
                    <ul class="intro">
                        <li>Sinh năm 1993, tốt nghiệp đại học Ngoại Ngữ Quốc Gia, có 3 năm kinh nghiệm dạy học</li>
                        <li>Cô giáo xinh xắn, giảng bài rất tỉ mỉ và dễ hiểu.Cô cũng thường xuyên tổ chức trò chơi trong buổi học, khiến buổi học trở lên sôi động, vui vẻ.</li>
                        <li>Cô giáo hơi hiền, cô hay say sưa giảng bài nên thỉnh thoảng lớp tan học muộn.</li>
                    </ul>
                </div>
            </div>
            <div class="inner">
                <div class="teacher">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>gv_co_lam.jpg" alt="teacher">
                        </span>
                    </div>
                    <h3 class="name">Cô Lâm</h3>
                    <ul class="intro">
                        <li>Cô Lâm đến từ tỉnh Tứ Xuyên Trung Quốc, chủ yếu cô dạy các lớp giao tiếp tiếng Trung.</li>
                        <li>Cô giáo phát âm chuẩn, giọng nói hay, hơn nữa cô giáo rất vui tính, thân thiện,  phương pháp dạy học sôi động, lôi cuốn. Ngoài giờ học trên lớp, các bạn học viên cũng có thể luyện tập tiếng Trung cùng cô và các bạn Trung Quốc của cô qua những buổi giao lưu,đi chơi thực tế.</li>
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
             data-slide-time="200"
             data-display-arrows="true"
             data-preview-left="0.25"
             data-preview-right="0.25"
             data-preview-left-small="0.1"
             data-preview-right-small="0.1"
        >
            <div class="inner">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>student1.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Nguyễn Thị Thoa</h3>
                    <div class="review">
                        Nhằm tạo môi trường học tiếng Trung toàn diện cho học viên. Chúng tôi thường xuyên tổ chức các hoạt động giao lưu, tham quan, dã ngoại với người Bản địa.
                    </div>
                </div>
            </div>
            <div class="inner">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>student1.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Nguyễn Thị Thoa</h3>
                    <div class="review">
                        Nhằm tạo môi trường học tiếng Trung toàn diện cho học viên. Chúng tôi thường xuyên tổ chức các hoạt động giao lưu, tham quan, dã ngoại với người Bản địa.
                    </div>
                </div>
            </div>
            <div class="inner">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>student1.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Nguyễn Thị Thoa</h3>
                    <div class="review">
                        Nhằm tạo môi trường học tiếng Trung toàn diện cho học viên. Chúng tôi thường xuyên tổ chức các hoạt động giao lưu, tham quan, dã ngoại với người Bản địa.
                    </div>
                </div>
            </div>
            <div class="inner">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>student1.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Nguyễn Thị Thoa</h3>
                    <div class="review">
                        Nhằm tạo môi trường học tiếng Trung toàn diện cho học viên. Chúng tôi thường xuyên tổ chức các hoạt động giao lưu, tham quan, dã ngoại với người Bản địa.
                    </div>
                </div>
            </div>
            <div class="inner">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>student1.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Nguyễn Thị Thoa</h3>
                    <div class="review">
                        Nhằm tạo môi trường học tiếng Trung toàn diện cho học viên. Chúng tôi thường xuyên tổ chức các hoạt động giao lưu, tham quan, dã ngoại với người Bản địa.
                    </div>
                </div>
            </div>
            <div class="inner">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>student1.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Nguyễn Thị Thoa</h3>
                    <div class="review">
                        Nhằm tạo môi trường học tiếng Trung toàn diện cho học viên. Chúng tôi thường xuyên tổ chức các hoạt động giao lưu, tham quan, dã ngoại với người Bản địa.
                    </div>
                </div>
            </div>
            <div class="inner">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>student1.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Nguyễn Thị Thoa</h3>
                    <div class="review">
                        Nhằm tạo môi trường học tiếng Trung toàn diện cho học viên. Chúng tôi thường xuyên tổ chức các hoạt động giao lưu, tham quan, dã ngoại với người Bản địa.
                    </div>
                </div>
            </div>
            <div class="inner">
                <div class="student">
                    <div class="image">
                        <span>
                            <img src="<?= Yii::getAlias('@web/img/landing/') ?>student1.jpg" alt="student">
                        </span>
                    </div>
                    <h3 class="name">Nguyễn Thị Thoa</h3>
                    <div class="review">
                        Nhằm tạo môi trường học tiếng Trung toàn diện cho học viên. Chúng tôi thường xuyên tổ chức các hoạt động giao lưu, tham quan, dã ngoại với người Bản địa.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <h2>Trung Tâm Tiếng Trung Ánh Dương</h2>
        <ul>
            <li>Địa chỉ: Số 12, ngõ 39, Hồ Tùng Mậu, Mai Dịch, Cấu Giấy, Hà Nội</li>
            <li>Email: <a href="mailto:tiengtrunganhduong@gmail.com">tiengtrunganhduong@gmail.com</a> - Hotline: <a href="tel:097.5158.419">097.5158.419</a></li>
        </ul>
        <div class="socials">
            <a href="https://www.facebook.com/tiengtrunganhduong" target="_blank"><b class="icon facebook-icon"></b></a>
            <a href="https://twitter.com/tiengtrung247" target="_blank"><b class="icon twitter-icon"></b></a>
            <a href="https://plus.google.com/+tiengtrunganhduong" target="_blank"><b class="icon google-plus-icon"></b></a>
            <a href="https://www.youtube.com/tiengtrunganhduong" target="_blank"><b class="icon youtube-icon"></b></a>
        </div>
    </div>
</footer>
</div>

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
</script>