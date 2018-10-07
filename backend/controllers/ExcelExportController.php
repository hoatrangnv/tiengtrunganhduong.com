<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/7/2018
 * Time: 10:51 AM
 */

namespace backend\controllers;

use backend\models\Article;
use yii\helpers\Html;
use yii\web\Controller;

include '../../console/PHPExcel/Classes/PHPExcel/IOFactory.php';

class ExcelExportController extends Controller
{
    public function actionArticles() {
        $request = \Yii::$app->request;

        $req_fields_str = $request->get('fields', '');
        $req_fields = explode('|', $req_fields_str);
        $article = new Article();
        foreach ($req_fields as $req_field) {
            if (!$article->hasAttribute($req_field)) {
                echo 'requested field does not exist: ' . $req_field;
                exit();
            }
        }

        if (count($req_fields) === 0) {
            echo 'No valid fields. Please provide some valid fields to export.';
            echo '<br>';
            echo 'Format: ?fields=field_1|field_2|field_x';
            echo '<br>';
            echo 'There are all valid fields:';
            echo '<ul>';
            foreach ($article->attributes() as $field) {
                echo '<li>' . $field . '</li>';
            }
            echo '</ul>';
            exit();
        }

        $page_index = (int) $request->get('page_index', 0);
        $page_size = (int) $request->get('page_size', 0);
        if ($page_index < 0) {
            echo 'page_index must be greater than or equal to 0';
            exit();
        }
        if ($page_size < 0) {
            echo 'page_size must be greater than or equal to 0';
            exit();
        }

        $sql_sort = '';
        $req_sort_str = $request->get('sort', '');
        $req_sorts = explode('|', $req_sort_str);
        foreach ($req_sorts as $req_sort) {
            if ($req_sort !== '') {
                $last_char = $req_sort[0];
                if ($last_char === '-') {
                    $sort_field = substr($req_sort, 1);
                } else {
                    $sort_field = $req_sort;
                }

                if (!$article->hasAttribute($sort_field)) {
                    echo 'ordered field does not exist: ' . $sort_field;
                    exit();
                }

                if ($sql_sort !== '') {
                    $sql_sort .= ', ';
                }

                $sql_sort .= $sort_field . ' ' . ($last_char === '-' ? 'DESC' : 'ASC');
            }
        }

        $excel = new \PHPExcel();
        $excel->setActiveSheetIndex(0);

        $rowCount = 1;
        $column = 'A';
        $excel->getActiveSheet()->setCellValue("$column$rowCount", '#');
        foreach ($req_fields as $field) {
            $column++;
            $excel->getActiveSheet()->setCellValue("$column$rowCount", $article->getAttributeLabel($field));
        }

        $query = Article::find()->orderBy($sql_sort);

        if ($page_size > 0) {
            $query->limit($page_size)->offset($page_index * $page_size);
        }

        $rowCount = 2;
        $total = 0;
        foreach ($query->batch(100) as $articles) {
            foreach ($articles as $article) {
                /**
                 * @var $article Article
                 */
                $column = 'A';
                $total++;

                $excel->getActiveSheet()->setCellValue("$column$rowCount", $total);
                foreach ($req_fields as $field) {
                    $column++;
                    $value = $article->getAttribute($field);
                    switch ($field) {
                        case 'publish_time':
                        case 'create_time':
                        case 'update_time':
                            $value = date('Y-m-d H:i:s', $value);
                            break;
                    }
                    $excel->getActiveSheet()->setCellValue("$column$rowCount", $value);
                }

                $rowCount++;
            }
        }

        $file_name = date('Ymd_His_') . "total_{$total}_pi_{$page_index}_ps_{$page_size}_sort_{$req_sort_str}";

        $writer = new \PHPExcel_Writer_Excel2007($excel);
        $writer->save(\Yii::getAlias("@webroot/excel_export/$file_name.xlsx"));

        echo Html::a('Download ' . $file_name, \Yii::getAlias("@web/excel_export/$file_name.xlsx"));
        exit();
    }

    public function actionArticlesForm() {
        return $this->render('articlesForm');
    }
}
