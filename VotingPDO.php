<?php

class VotingPDO extends PDO
{
    private $pdo_target = "mysql:host=localhost;port=3306;dbname=s16125";
    private $pdo_user = "s16125";
    private $pdo_pass = "Wit.Werd";

    public function __construct()
    {
        parent::__construct($this->pdo_target, $this->pdo_user, $this->pdo_pass);
    }
}
