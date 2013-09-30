<?PHP

    class Module {

        public $layout;

//======================================================================================================================
        public function __construct() {
            $this->layout = new Layout();
        }

//======================================================================================================================
        public function insertDB($data) {
            $rxml = new XMLReader();    //Создание элемента для чтения
            $rxml->open(DB);

            while($rxml->read() && $rxml->name !== 'element');

            while($rxml->name === 'element'){
                $node = new SimpleXMLElement($rxml->readOuterXML());
                $id = $node->id;
                $rxml->next('element');
            }
            $rxml->close();
            $id += 1;

            $xml = new SimpleXMLElement(file_get_contents(DB));
            $newchild = $xml->addChild("element");
            $newchild->addChild("id", $id);
            if (count($data) > 0) {
                foreach ($data as $key => $value) {
                    $newchild->addChild($key, $value);
                }
            }
            $xml->saveXML(DB);

            return true;
        }

//======================================================================================================================
        public function removeDB($id) {
            $dom = new DomDocument;
            $dom->loadXML(file_get_contents(DB));

            $mod = $dom->getElementsByTagName("id");

            foreach ($mod as $element) {
                if ($element->nodeValue == $id) {
                    $element->parentNode->parentNode->removeChild($element->parentNode);
                }
            }
            $dom->save(DB);
            return true;
        }

//======================================================================================================================
        public function selectDB() {
            $doc = new DOMDocument;

            $xmlreader = new XMLReader();
            $xmlreader->open(DB);
            $xmlreader->read();

            $return = simplexml_import_dom($doc->importNode($xmlreader->expand(), true));

            $xmlreader->close();
            return $return;
        }

    }