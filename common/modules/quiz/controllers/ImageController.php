<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/29/2017
 * Time: 11:24 AM
 */

namespace common\modules\quiz\controllers;


use yii\web\Controller;
use common\modules\quiz\models\Image;

class ImageController extends Controller
{
    public function actionSearch($q, $page = 1)
    {
        /**
         * @var Image[] $images
         */

        $images = Image::find()
            ->where(['like', 'name', $q])
            ->andWhere(['=', 'active', 1])
            ->offset($page - 1)
            ->limit(3)
            ->orderBy('create_time desc')
            ->all();

        $result = [
            'items' => [],
            'total_count' => Image::find()
                ->where(['like', 'name', $q])
                ->andWhere(['=', 'active', 1])
                ->count()
        ];

        foreach ($images as $image) {
            $result['items'][] = [
                'id' => $image->id,
                'name' => $image->name,
                'width' => $image->width,
                'height' => $image->height,
                'aspect_ratio' => $image->aspect_ratio,
                'source' => $image->getSource(),
            ];
        }

        return json_encode($result);
    }
}