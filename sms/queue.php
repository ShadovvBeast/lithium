<?php
include dirname(__FILE__) . "/Classes/SmsMessage.class.php";
include dirname(__FILE__) . "/Classes/DBController.class.php";
/**
 * Created by PhpStorm.
 * User: Asaf
 * Date: 22/03/2015
 * Time: 17:58
 */

$db = new DBController();
$db = $db->db;

try {
    //connect as appropriate as above
    $result = $db->query('SELECT * FROM messages');
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    $jsonarray = array();
    foreach ($result as $resultlet)
    {
        if ($resultlet['datesent'] == null)
            $jsonarray[] = $resultlet;
    }
    echo json_encode($jsonarray);
    $msg = new SmsMessage();
} catch(PDOException $ex) {

}

