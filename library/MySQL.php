<?php
include_once("config/config.php");
include_once("library/Singleton.php");

class MySQL extends Singleton {

    private $_db;

    protected function __construct()
    {
        $this->_db = new PDO('mysql:host=' . HOST . ';dbname=' . DB_NAME . '', '' . USER . '', '' . PASS . '');
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql) {
        return $this->_db->query($sql);
    }

    public function fetch($sql) {
        return $this->_db->query($sql)->fetch();
    }
}