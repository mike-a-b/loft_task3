<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 21.08.17
 * Time: 3:07
 */

function task1()
{
    $file = file_get_contents('./data.xml');
    $file ? (string)$file : die('Невозможно прочитать xml file для отчета');
    $xml = new SimpleXMLElement($file);
    $attrs = $xml->attributes();
    echo "<hr>";
    echo "№ заказа " . $attrs['PurchaseOrderNumber'] . "<br>";
    echo "Дата выполнения заказа: " . $attrs['OrderDate'] . "<br>";
    echo "<hr>";
    echo "Примечания к заказу: " . $xml->DeliveryNotes[0] . " Оставьте посылку в пристройке у дороги";
    echo "<hr>";
    echo "Адрес доставки: <br>";
    echo "Имя : {$xml->Address[0]->Name}; Улица: {$xml->Address[0]->Street}; Город: {$xml->Address[0]->City};
 Штат: {$xml->Address[0]->State}; Индекс: {$xml->Address[0]->Zip}; Страна:  {$xml->Address[0]->Country} <br><hr>";
    //или if switch
//    foreach ($xml->Address[0] as $item) {
//        if($item === '')
//    }
    echo "Адрес закупки: <br>";
    echo "Имя : {$xml->Address[1]->Name}; Улица: {$xml->Address[1]->Street}; Город: {$xml->Address[1]->City};
    
    Штат: {$xml->Address[1]->State}; Индекс: {$xml->Address[1]->Zip}; Страна:  {$xml->Address[1]->Country} <br><hr>";

    echo "Какие элементы требуется закупить?:<br><hr>";

    foreach ($xml->Items->Item as $item) {
        $attrs = $item->attributes();

        echo "Название продукта: {$item->ProductName} <br>";
        echo "Кол-во закупок данного продукта с PartNumber =  {$attrs['PartNumber']}: {$item->Quantity} <br>";
        echo "Стоимость: {$item->USPrice} <br>";
        if (!((string)$attrs['PartNumber'] === "926-AA")) {
            echo "Учесть комментарий {$item->Comment} <br>";
        } else {
            echo "Дата производства детского монитора должна быть:{$item->ShipDate}";
        }
        echo "<hr>";
    }
}

function task2()
{
    $array_for_change = [
        "CD" => "Baskov",
        "DVD" => "Brat 2",
        "DVD2" => "Requiem for a Dream",
        "Vinil" => "Alla Pugacheva",
        "DVD3" => "Effect of butterfly",
        "CD2" => "Soma fm radio selection",
        "DVD4" => "1 + 1"
    ];

    $jsoned_array = json_encode($array_for_change);

    $file = 'output.json';
    $hndl = fopen($file, 'w');
    if (!fwrite($hndl, $jsoned_array . PHP_EOL)) {
        die('не получилась запись в файл');
    };
    fclose($hndl);

    $tmp_file = file_get_contents($file);
    $tmp_file = (array)json_decode($tmp_file, true);
//решаем рандомно менять элемент массива или нет
    foreach ($tmp_file as &$item) {
        if ((boolean)($change_or_not_flag = rand(0, 1))) {
            $item = strrev((string)$item);
        }
    }
    $tmp_file = json_encode($tmp_file);

//записываем измененный массив - объект в файл *.json
    $file2 = "output2.json";
//    file_put_contents($file2, $tmp_file);
    $hndl = fopen($file2, 'w+');
    if (!fwrite($hndl, $tmp_file.PHP_EOL)) {
        die('не получилась запись в файл');
    };
    fclose($hndl);

    $file1_array = file_get_contents($file);
    $file2_array = file_get_contents($file2);
    $file1_array = (array)json_decode($file1_array, true);
    $file2_array = (array)json_decode($file2_array, true);
//выводим отличия в браузер
    foreach ($file1_array as $k => $v) {
        if (strcmp((string)$file1_array[$k], (string)$file2_array[$k]) != 0) {
            echo "Отличающиеся элементы 'Элемент1' = {$file1_array[$k]}, 'Элемент2' = $file2_array[$k]<br><hr>";
        }
    }
}
