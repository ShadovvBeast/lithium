<?php
/**
 * Created by PhpStorm.
 * User: Asaf
 * Date: 23/03/2015
 * Time: 23:12
 */

class DBController {
    public $db;
    public function __construct()
    {
        $this->db = new PDO('mysql:host=mysql.ihostwell.com;dbname=u644371590_goji;charset=utf8', 'u644371590_goji', '!gs420GS!');
    }
} 