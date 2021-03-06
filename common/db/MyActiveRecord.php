<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 12:26 AM
 */

namespace common\db;

use common\models\Audio;
use PHPHtmlParser\Dom;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use vanquyet\queryTemplate\QueryTemplate;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use common\models\Image;

abstract class MyActiveRecord extends ActiveRecord
{
    /**
     * @param null $text
     * @param array $options
     * @param array $urlParams
     * @return string
     */
    public function a($text = null, array $options = [], array $urlParams = [])
    {
        if (!method_exists($this, 'getUrl')) {
            return '';
        }
        if (!$text) {
            if ($this->hasAttribute('name')) {
                $text = $this->getAttribute('name');
            } else if ($this->hasAttribute('title')) {
                $text = $this->getAttribute('title');
            } else if ($this->hasAttribute('caption')) {
                $text = $this->getAttribute('caption');
            } else {
                $text = '';
            }
        }
        return Html::a($text, $this->getUrl($urlParams), $options);
    }

    /**
     * @param null $size
     * @param array $options
     * @param array $srcOptions
     * @return string
     */
    public function img($size = null, array $options = [], array $srcOptions = [])
    {
        if (!isset($options['alt'])) {
            if ($this->hasAttribute('name')) {
                $options['alt'] = $this->getAttribute('name');
            } else if ($this->hasAttribute('title')) {
                $options['alt'] = $this->getAttribute('title');
            } else if ($this->hasAttribute('caption')) {
                $options['alt'] = $this->getAttribute('caption');
            } else {
                $options['alt'] = '';
            }
        }

        if (!isset($options['title'])) {
            $options['title'] = $options['alt'];
        }

        if ($this instanceof Image) {
            return $this->img($size, $options, $srcOptions);
        }

        /**
         * @var Image $image
         */
        if (method_exists($this, 'getImage') && $image = $this->getImage()->oneActive()) {
            return $image->img($size, $options, $srcOptions);
        }

        return '';
    }

    /**
     * @param $input
     * @return array|string
     */
    public static function castToArray($input)
    {
        if (!is_array($input)) {
            if ($input && is_string($input)) {
                $input = implode(',', $input);
            } else {
                $input = [];
            }
        }
        return $input;
    }

    /**
     * @param $attribute
     */
    public function castValueToArray($attribute)
    {
        $this->$attribute = self::castToArray($this->$attribute);
    }

    /**
     * @return MyActiveQuery
     */
    public function getAllChildren()
    {
        if (method_exists($this, 'getChildren')) {
            /**
             * @var MyActiveRecord[] $allChildren
             */
            $allChildren = $this->getChildren();
            foreach ($allChildren as $item) {
                $allChildren = array_merge($allChildren, $item->getAllChildren());
            }
            $query = static::find();
            $query->where(['in', 'id', ArrayHelper::getColumn($allChildren, 'id')]);
            $query->multiple = true;
            return $query;
        }
        throw new MethodNotFoundException('Method getChildren was not found.', self::className(), null);
    }

    /**
     * @return array
     */
    public static function listAsId2Name()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }

    /**
     * @return MyActiveQuery
     */
    public static function find()
    {
        return new MyActiveQuery(get_called_class());
    }

    /**
     * @param $methodName
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function callTemplateMethod($methodName, $arguments)
    {
        if (method_exists($this, 'templateMethods')) {
            $methods = $this->templateMethods();
        } else {
            throw new \Exception("There is not any template method in \"" . get_class($this) . "\"");
        }
        if (!isset($methods[$methodName])) {
            throw new \Exception("Template method \"$methodName\" does not exist in \"" . get_class($this) . "\"");
        }
        return call_user_func_array($methods[$methodName], $arguments);
    }

    public $templateLastMethod = '';

    public $templateLogMessage = '';

    public function templateToHtml($attributes = null)
    {
        if (__METHOD__ === $this->templateLastMethod) {
            return false;
        }

        if (!$attributes) {
            $attributes = ['content', 'long_description'];
        }

        foreach ($attributes as $attribute) {
            if (!$this->hasAttribute($attribute)) {
                continue;
            }
            $html = QueryTemplate::widget([
                'content' => $this->$attribute,
                'queries' => [
                    'Image' => function ($id) {
                        return Image::find()->where(['id' => $id])->one();
                    },
                    'Audio' => function ($id) {
                        return Audio::find()->where(['id' => $id])->one();
                    }
                ],
                'enableDebugMode' => false,
            ]);
            $this->$attribute = $html;
            $this->templateLogMessage .= VarDumper::dumpAsString(QueryTemplate::$errors) . "\n";
        }

        $this->templateLastMethod = __METHOD__;

        return true;
    }

    public function htmlToTemplate($attributes = null)
    {
        if (__METHOD__ === $this->templateLastMethod) {
            return false;
        }

        if (!$attributes) {
            $attributes = ['content', 'long_description'];
        }

        foreach ($attributes as $attribute) {
            /**
             * @var \DOMElement $imgTag
             * @var \DOMElement $audioTag
             */
            if (!$this->hasAttribute($attribute)) {
                continue;
            }
            $html = $this->$attribute;
//            $doc = new \DOMDocument('1.0', 'UTF-8');
            $doc = new \DOMDocument();

            /**
             * @TODO: Disable warning, which will be inserted into content
             * Warning: DOMDocument::loadHTML(): Unexpected end tag: 'example' in Entity
             * https://stackoverflow.com/questions/11819603/dom-loadhtml-doesnt-work-properly-on-a-server
             */
            libxml_use_internal_errors(true);

            try {
                $doc->loadHTML(
                    mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8')
//                    , LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
                );

                // Img
                $imgTags = $doc->getElementsByTagName('img');
                $i = 0;
                while ($imgTag = $imgTags->item($i)) {
                    if (!$imgTag) {
                        $i++;
                        continue;
                    }
                    $src = $imgTag->getAttribute('src');
                    $id = null;
                    if (strpos($src, '?image_id=') === false && strpos($src, '&image_id=') === false) {
                        $i++;
                        continue;
                    }
                    $parts = parse_url($src);
                    if (isset($parts['query'])) {
                        parse_str($parts['query'], $query);
                        if (isset($query['image_id'])) {
                            $id = $query['image_id'];
                        }
                    }
                    if (!$id) {
                        $i++;
                        continue;
                    }

                    $opts = [];
                    $width = null;
                    $height = null;
                    foreach (['width', 'height', 'id', 'class', 'style', 'alt', 'title'] as $attr) {
                        $val = $imgTag->getAttribute($attr);
                        if ($val) {
                            $opts[$attr] = $val;
                            if (in_array($attr, ['width', 'height'])) {
                                $$attr = $val;
                            }
                        }
                    }
                    $opts_str = json_encode($opts);
                    if (is_numeric($width) && is_numeric($height)) {
                        $size = "{$width}x{$height}";
                    } else {
                        $size = null;
                    }
                    $size_str = json_encode($size);

                    $node = $doc->createTextNode(
                        QueryTemplate::__FUNC_OPEN
                        . " Image($id)" . QueryTemplate::__OBJECT_OPERATOR . "imgTag($size_str, $opts_str) "
                        . QueryTemplate::__FUNC_CLOSE
                    );

                    $imgTag->parentNode->replaceChild($node, $imgTag);
                }

                // Audio
                $audioTags = $doc->getElementsByTagName('audio');
                $i = 0;
                while ($audioTag = $audioTags->item($i)) {
                    if (!$audioTag) {
                        $i++;
                        continue;
                    }
                    $src = $audioTag->getAttribute('src');
                    $id = null;
                    if (strpos($src, '?audio_id=') === false && strpos($src, '&audio_id=') === false) {
                        $i++;
                        continue;
                    }
                    $parts = parse_url($src);
                    if (isset($parts['query'])) {
                        parse_str($parts['query'], $query);
                        if (isset($query['audio_id'])) {
                            $id = $query['audio_id'];
                        }
                    }
                    if (!$id) {
                        $i++;
                        continue;
                    }

                    $opts = [];
                    $width = null;
                    $height = null;
                    foreach (['controls', 'controlslist', 'loop', 'autoplay', 'muted', 'preload', 'id', 'class', 'style'] as $attr) {
                        $val = $audioTag->getAttribute($attr);
                        if ($val) {
                            $opts[$attr] = $val;
                        }
                    }
                    $opts_str = json_encode($opts);

                    $node = $doc->createTextNode(
                        QueryTemplate::__FUNC_OPEN
                        . " Audio($id)" . QueryTemplate::__OBJECT_OPERATOR . "audioTag($opts_str) "
                        . QueryTemplate::__FUNC_CLOSE
                    );

                    $audioTag->parentNode->replaceChild($node, $audioTag);
                }

                $doc->saveHTML();
                $bodies = $doc->getElementsByTagName('body');
                if (isset($bodies[0])) {
                    $this->$attribute = self::DOMinnerHTML($bodies[0]);
                } else {
                    $this->templateLogMessage .= "Body tag was not found\n";
                    return false;
                }

                // audio inline
                $preg_open = preg_quote("[(");
                $preg_close = preg_quote(")]");
                $preg_pattern_template = "/open([\\s\\S]*?)close/";
                $preg_pattern = str_replace(['open', 'close'], [$preg_open, $preg_close], $preg_pattern_template);

                $preg_callback = function ($matches) {
                    return QueryTemplate::__FUNC_OPEN
                    . " Audio(" . $matches[1]. ")" . QueryTemplate::__OBJECT_OPERATOR . "inlineButton() "
                    . QueryTemplate::__FUNC_CLOSE;
                };
                $this->$attribute = preg_replace_callback($preg_pattern, $preg_callback, $this->$attribute);


            } catch (\Exception $e) {
                $this->templateLogMessage .= $e->getMessage() . "\n";
                return false;
            }
        }

        $this->templateLastMethod = __METHOD__;

        return true;
    }

    public $allowedTemplateActions = ['index', 'create', 'update'];

    public function beforeSave($insert)
    {
        if (\Yii::$app->controller
            && \Yii::$app->controllerNamespace === 'backend\\controllers'
            && in_array(\Yii::$app->controller->action->id, $this->allowedTemplateActions)
        ) {
            $success = $this->htmlToTemplate();

            $this->templateLogMessage
                .= ($success ? 'success' : 'failure')
                . ': html to template | ' . __METHOD__ . "\n\n";
        }

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();

        if (\Yii::$app->controller
            && \Yii::$app->controllerNamespace === 'backend\\controllers'
            && in_array(\Yii::$app->controller->action->id, $this->allowedTemplateActions)
        ) {
            $success = $this->templateToHtml();

            $this->templateLogMessage
                .= ($success ? 'success' : 'failure')
                . ': template to html | ' . __METHOD__ . "\n\n";
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (\Yii::$app->controller
            && \Yii::$app->controllerNamespace === 'backend\\controllers'
            && in_array(\Yii::$app->controller->action->id, $this->allowedTemplateActions)
        ) {
            $success = $this->templateToHtml();

            $this->templateLogMessage
                .= ($success ? 'success' : 'failure')
                . ': template to html | ' . __METHOD__ . "\n\n";
        }
    }

    public static function DOMinnerHTML(\DOMNode $element)
    {
        $innerHTML = "";
        $children  = $element->childNodes;

        foreach ($children as $child)
        {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return $innerHTML;
    }
}