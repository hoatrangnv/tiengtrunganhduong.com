<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * CourseRegistrationForm is the model behind the contact form.
 */
class CourseRegistrationForm extends Model
{
    public $name;
    public $email;
    public $phone_number;
    public $message;
    public $course_name;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, phone_number, subject and body are required
            [['name', 'email', 'phone_number'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
//            ['verifyCode', 'captcha'],
            [['course_name', 'message'], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 32],
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }

    public function saveContact()
    {
        $contact = new Contact();
        $contact->name = $this->name;
        $contact->email = $this->email;
        $contact->phone_number = $this->phone_number;
        $contact->subject = "[ĐĂNG KÝ KHÓA HỌC] $this->course_name";
        $contact->body = $this->message;
        $contact->status = Contact::STATUS_NEW;
        $contact->type = Contact::TYPE_COURSE_REGISTRATION;
        return $contact->save();
    }
}
