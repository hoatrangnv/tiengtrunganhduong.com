<?php
//  Include PHPExcel_IOFactory
include '../Classes/PHPExcel/IOFactory.php';

$inputFileName = 'Book1.xlsx';

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = 'D';//$sheet->getHighestColumn();


$result = [];
//  Loop through each row of the worksheet in turn
for ($row = 1; $row <= $highestRow; $row++){ 
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
    //  Insert row data array into your database of choice here
    $result[] = [
        $rowData[0][0],
        $rowData[0][1],
        $rowData[0][2],
        $rowData[0][3],
    ];
}

$file = fopen('single_words.json', 'w');
fwrite($file, json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
fclose($file);
