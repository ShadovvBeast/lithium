<?php
include dirname(__FILE__) . "/Classes/SmsMessage.class.php";
/**
 * Created by PhpStorm.
 * User: Asaf
 * Date: 22/03/2015
 * Time: 17:58
 */
$db = new PDO('mysql:host=mysql.ihostwell.com;dbname=u644371590_goji;charset=utf8', 'u644371590_goji', '!gs420GS!');

try {
    //connect as appropriate as above
    $result = $db->query('SELECT * FROM messages WHERE datesent = null');
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    var_dump($result);
    die();
    $msg = new SmsMessage();
} catch(PDOException $ex) {

}

