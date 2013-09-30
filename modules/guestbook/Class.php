<?
    require_once($_SERVER['DOCUMENT_ROOT']."/libs/Module.php");

    class Guestbook extends Module {

//======================================================================================================================
        public function showMain() {
            $this->layout->assign('posts', $this->selectDB());
            return $this->layout->display(__DIR__."/views/show_all.tpl.php");
        }

//======================================================================================================================
        public function showAdd() {
            return $this->layout->display(__DIR__."/views/show_add.tpl.php");
        }

//======================================================================================================================
        public function add($request) {
            $data['name'] = $request['name'];
            $data['txt'] = $request['txt'];
            $data['time'] = time();
            return $this->insertDB($data);
        }

//======================================================================================================================
        public function del($request) {
            return $this->removeDB($request['id']);
        }
    }