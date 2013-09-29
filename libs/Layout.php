<?PHP
namespace Doctrine\OXM;

    class Layout {
        private $vars;

//======================================================================================================================
        public function assign($key, $value) {
            $this->vars[$key] = $value;
        }

//======================================================================================================================
        public function display($path) {
            $tpl = @file_get_contents($path);
            foreach ($this->vars as $key => $value) {
                $tpl = preg_replace("/{".$key."}/", $value, $tpl);
            }
            unset($this->vars);
            return $tpl;
        }
    }