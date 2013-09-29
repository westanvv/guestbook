<?PHP
    namespace Doctrine\OXM;
use Doctrine\OXM\Marshaller\Marshaller;
use Doctrine\OXM\Storage\Storage;
use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\OXM\Proxy\ProxyFactory;

    require_once(__DIR__."/Layout.php");
    require_once(__DIR__."/Doctrine/Common/Persistence/ObjectManager.php");
    require_once(__DIR__."/Doctrine/OXM/XmlEntityManager.php");



    class Module {

        public $layout;

//======================================================================================================================
        public function __construct() {
            $this->layout = new Layout();
        }

//======================================================================================================================
        public function insertData($value) {
        }

//======================================================================================================================
        public function selectData() {
            $class = new XmlEntityManager();
            $user = new User();
            $user->setId(1);
            $user->setName("Malcolm Reynolds");
            $user->setOccupation("Space Cowboy");

            $class->persist($user);
            $class->flush();
        }

    }