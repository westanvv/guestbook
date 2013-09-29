<?PHP
    namespace Doctrine\OXM;

    require_once(__DIR__."/Layout.php");

    class Kernel {

        private $routes = array(
            array(
                'regexp' => "/^$/",
                'module' => "Guestbook",
                'action' => "showMain"
            ),
            array(
                'regexp' => "/^add$/",
                'module' => "Guestbook",
                'action' => "showAdd"
            )
        );

        private $layout;

//======================================================================================================================
        public function __construct() {
            $this->layout = new Layout();
        }

//======================================================================================================================
        public function execute($REQUEST) {
            if (!$this->getAjax($REQUEST)) {
                $this->getData($REQUEST);
            }
            return true;
        }

//======================================================================================================================
        private function getData($REQUEST) {
            for ($index = 0; $index < count($this->routes); $index++) {
                if (preg_match($this->routes[$index]['regexp'], $REQUEST['query'], $result)) {
                    require_once($_SERVER['DOCUMENT_ROOT']."/modules/".$this->routes[$index]['module'].".php");

                    $action = $this->routes[$index]['action'];
                    $class = $this->routes[$index]['module'];
                    $class = new $class($REQUEST);
                    $this->layout->assign('data', $class->$action());
                }
            }
            echo $this->layout->display($_SERVER['DOCUMENT_ROOT']."/views/index.tpl");
        }

//======================================================================================================================
        private function getAjax($REQUEST) {
            if (isset($REQUEST['ajax'])) {
                require_once($_SERVER['DOCUMENT_ROOT']."/modules/".$REQUEST["module"].".php");
                $class = $REQUEST["module"];
                $class = new $class($REQUEST);
                $data = $class->$REQUEST['action']($REQUEST);
                unset($class);
                echo $data;
                return true;
            }
            else {
                return false;
            }
        }
    }