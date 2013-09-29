<?php
    namespace Doctrine\OXM;

    require_once($_SERVER['DOCUMENT_ROOT']."/libs/Module.php");

    class Guestbook extends Module {

//======================================================================================================================
        public function showMain() {
            $this->selectData();
            $this->layout->assign('data', "test");
            return $this->layout->display($_SERVER['DOCUMENT_ROOT']."/views/show_all_book.tpl");
        }

//======================================================================================================================
        public function showAdd() {

        }

//======================================================================================================================
        public function add() {

        }
    }