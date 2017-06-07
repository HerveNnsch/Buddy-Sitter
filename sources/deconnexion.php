<?php
session_start();
$_SESSION=[];
session_destroy();
header('Location: index.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

