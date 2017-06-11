<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 12:26 AM
 */

namespace common\models;

use PHPHtmlParser\Dom;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use vanquyet\queryTemplate\QueryTemplate;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;

abstract class MyActiveRecord extends ActiveRecord implements iMyActiveRecord
{
    public function a($text = null, array $options = [], array $urlParams = [])
    {
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
            return $this->getImgTag($size, $options, $srcOptions);
        }

        if ($this->hasMethod('getImage') && $image = $this->getImage()->oneActive()) {
            return $image->getImgTag($size, $options, $srcOptions);
        }

        return '';
    }

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

    public function castValueToArray($attribute)
    {
        $this->$attribute = self::castToArray($this->$attribute);
    }

    public function getAllChildren()
    {
        if ($this->hasMethod('getChildren')) {
            $allChildren = $this->getChildren();
            foreach ($allChildren as $item) {
                $allChildren = array_merge($allChildren, $item->getAllChildren());
            }
            $query = static::find();
            $query->where(['in', 'id', ArrayHelper::getColumn($allChildren, 'id')]);
            $query->multiple = true;
            return $query;
        }
        throw new MethodNotFoundException('Method getChildren not found.', self::className(), null);
    }

    public static function listAsId2Name()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }

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
        if ($this->hasMethod('templateMethods')) {
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

    public function templateToHtml()
    {
        if (__METHOD__ === $this->templateLastMethod
            || !\Yii::$app->controller
            || !in_array(\Yii::$app->controller->action->id, ['index', 'update', 'create'])
        ) {
            return false;
        }

        $attributes = ['content', 'long_description'];
        foreach ($attributes as $attribute) {
            if (!$this->hasAttribute($attribute)) {
                continue;
            }
            $html = QueryTemplate::widget([
                'content' => $this->$attribute,
                'queries' => [
                    'Article' => function ($id) {
                        return Article::find()->where(['id' => $id])->onePublished();
                    },
                    'Image' => function ($id) {
                        return Image::find()->where(['id' => $id])->oneActive();
                    },
                ],
            ]);
            if (empty(QueryTemplate::$errors)) {
                $this->$attribute = $html;
            } else {
                $this->templateLogMessage .= VarDumper::dumpAsString(QueryTemplate::$errors) . "\n";
            }
        }

        $this->templateLastMethod = __METHOD__;

        return true;
    }

    public function htmlToTemplate()
    {
        if (__METHOD__ === $this->templateLastMethod
            || !\Yii::$app->controller
            || !in_array(\Yii::$app->controller->action->id, ['create', 'update', 'create'])
        ) {
            return false;
        }

        $attributes = ['content', 'long_description'];
        foreach ($attributes as $attribute) {
            /**
             * @var \DOMElement $imgTag
             */
            if (!$this->hasAttribute($attribute)) {
                continue;
            }
            $html = $this->$attribute;
            $doc = new \DOMDocument();

            /**
             * @TODO: Disable warning, which will be inserted into content
             * Warning: DOMDocument::loadHTML(): Unexpected end tag: 'example' in Entity
             * https://stackoverflow.com/questions/11819603/dom-loadhtml-doesnt-work-properly-on-a-server
             */
            libxml_use_internal_errors(true);

            try {
                $doc->loadHTML(
                    mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'),
                    LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
                );
                $imgTags = $doc->getElementsByTagName('img');
                $i = 0;
                while ($imgTag = $imgTags->item($i)) {
                    if (!$imgTag) {
                        $i++;
                        continue;
                    }
                    $src = $imgTag->getAttribute('src');
                    $id = null;
                    if (strpos($src, '?id=') === false && strpos($src, '&id=')) {
                        $i++;
                        continue;
                    }
                    $parts = parse_url($src);
                    if (isset($parts['query'])) {
                        parse_str($parts['query'], $query);
                        if (isset($query['id'])) {
                            $id = $query['id'];
                        }
                    }
                    if (!$id) {
                        $i++;
                        continue;
                    }
                    $tmpl = $doc->createElement("tmpl:func");
                    $tmpl->textContent = "Image($id)" . QueryTemplate::__OBJECT_OPERATOR . "imgTag()";
                    $imgTag->parentNode->replaceChild($tmpl, $imgTag);
                }
                $this->$attribute = $doc->saveHTML();
            } catch (\Exception $e) {
                $this->templateLogMessage .= $e->getMessage() . "\n";
                return false;
            }
        }

        $this->templateLastMethod = __METHOD__;

        return true;
    }

    public function beforeSave($insert)
    {
        $success = $this->htmlToTemplate();

        $this->templateLogMessage
            .= ($success ? 'success' : 'failure')
            . ': html --> template | ' . __METHOD__ . "\n\n";

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();

        $success = $this->templateToHtml();

        $this->templateLogMessage
            .= ($success ? 'success' : 'failure')
            . ': template --> html | ' . __METHOD__ . "\n\n";
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $success = $this->templateToHtml();

        $this->templateLogMessage
            .= ($success ? 'success' : 'failure')
            . ': template --> html | ' . __METHOD__ . "\n\n";
    }
}