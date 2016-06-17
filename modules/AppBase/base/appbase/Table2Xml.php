<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/14
 * Time: 11:29
 */
namespace app\modules\AppBase\base\appbase;
class Table2Xml
{
    function t2x($resArray, $dbname, $dbtable, $fieldNum, $dbtField)
    {
        $dom = new DOMDocument("1.0", "utf-8");
        // display document in browser as plain text
        // for readability purposes
        header("Content-Type: text/xml");
        // 格式化输出
        $dom->formatOutput = true;
        // 建立根节点root
        $root = $dom->createElement($dbname); //database name
        $dom->appendChild($root);
        foreach ($resArray as $res) {
            // 建立root节点下子节点record
            $record = $dom->createElement($dbtable);
            $root->appendChild($record);
            // 建立record节点下的各项
            for ($i = 0; $i < $fieldNum; $i++) {
                // 表字段
                $node[$i] = $dom->createElement($dbtField[$i]);
                // 表字段的值
                $node[$i]->appendChild($dom->createTextNode($res[$dbtField[$i]]));
                $record->appendChild($node[$i]);
            }
        }
        echo $dom->saveXML();
        $dom->save("leaves.xml");
    }
}