<?php
/**
 * Created by PhpStorm.
 * User: Asaf
 * Date: 23/03/2015
 * Time: 23:08
 */
include dirname(__FILE__) . "/Classes/DBController.class.php";

$id = $_GET['mid'];
$db = new DBController();
$db = $db->db;
$stmt = $db->prepare("DELETE FROM messages WHERE id = :id");
$stmt->bindParam(":id",$id, PDO::PARAM_INT);
if($stmt->execute())
    echo "OK";
else
    echo "Failed";
