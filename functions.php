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
    $hndl = fopen($file, 'a+');
    if (!fwrite($hndl, $jsoned_array . PHP_EOL)) {
        die('не получилась запись в файл');
    };
    fclose($hndl);

    $tmp_file = file_get_contents($file);
    $tmp_file = json_decode($tmp_file);
    count($tmp_file);
    $random = mt_rand(0, count($tmp_file));
    $tmp_file[$random] = "asdfasdfsdf";
    $file2 = "output2.json";
    $hndl = fopen($file2, 'a+');
    if (!fwrite($hndl, $tmp_file . PHP_EOL)) {
        die('не получилась запись в файл');
    };
    fclose($hndl);

    $file = file_get_contents($file);
    $file2 = file_get_contents($file2);
    $file = json_decode($file);
    $file2 = json_decode($file2);

    for ($i = 0; $i <= count($file); $i++) {
        if ($file[$i] !== $file2[$i]) {
            echo "отличающийся элемент = $i - ый: {$file['$i']} !== {$file2[$i]} ";
        }
    }
}