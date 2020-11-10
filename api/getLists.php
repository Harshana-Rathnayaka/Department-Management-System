<?php

require_once '../includes/dbOperations.php';

    // db object
    $db = new DbOperations();

    // department list
    $departments = $db->getDepartments();

    // users list
    $users = $db->getUsers();


