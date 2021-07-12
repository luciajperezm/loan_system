<?php

    /*--- Here we manage the database connection using PDO ---*/
    const SERVER = "localhost";
    const DB = "loan_system";
    const USER = "root";
    const PASS = "";

    /*--- DBM: DataBase Manager ---*/
    const DBM = "mysql:host=".SERVER.";dbname=".DB;

    /*--- constant values used to encrypt passwords and other values ---*/
    const METHOD = "AES-256-CBC";
    const SECRET_KEY = '$LOANS@2021';
    const SECRET_IV = "231296";