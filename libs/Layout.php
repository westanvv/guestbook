<?PHP
    class Layout {
        private $vars;

//======================================================================================================================
        public function assign($key, $value) {
            $this->vars[$key] = $value;
        }

//======================================================================================================================
        public function display($path) {
            ob_start();

            $tpl = $this->vars;
            include($path);

            $tpl = ob_get_contents();
            ob_end_clean();

            return $tpl;
        }
    }