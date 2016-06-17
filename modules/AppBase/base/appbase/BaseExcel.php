<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/15
 * Time: 10:06
 */
namespace app\modules\AppBase\base\appbase;
use app\modules\Admin\Custom\models\Customs;
class BaseExcel
{
    public function import($file, $role,$class_id)
    {
        $fn = $file->tempName;
        $data = \moonland\phpexcel\Excel::import($fn, [
            'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
            'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
            'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
        ]);
        return (new Customs())->batchaddCustom($data, $role,$class_id);
    }
}