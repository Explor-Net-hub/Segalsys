<?php
/*
 *  Segal System Version Definition
 *  Developed by Dadeh Pardazan Ovrin Segal
 */
if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
    exit();
} else {
    $_SESSION["v"] = "1.0.0 (Segal System - ovrinsegal.ir)";
}