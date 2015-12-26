<?php
namespace F3CMS;

class Module
{
    /**
     * _escape
     * @param mixed $array - obj need to escape
     * @return mixed
     */
    static protected function _escape($array, $quote = true)
    {
        if (is_array($array)) {
            while (list($k,$v) = each($array)) {
                if (is_string($v)) {
                    if ($quote) {
                        $array[$k] =  f3()->get('DB')->quote(htmlspecialchars(trim($v)));
                    }
                    else {
                        $array[$k] =  htmlspecialchars(trim($v));
                    }
                }
                else if (is_array($v)) {
                    $array[$k] = $this->_escape($v, $quote);
                }
            }
        }
        else {
            if ($quote) {
                $array = f3()->get('DB')->quote(htmlspecialchars(trim($array)));
            }
            else {
                $array = htmlspecialchars(trim($array));
            }
        }

        return $array;
    }

    static function _shift($name, $target)
    {
        $name = str_replace(array('F3CMS\\', '\\'), array('', ''), $name);

        list($type, $className) = preg_split("/(?<=[rfo])(?=[A-Z])/", $name);

        return '\\F3CMS\\' . \F3CMS_Autoloader::getPrefix()[$target] . $className;
    }

    /**
     * handle angular post data
     * @return array - post data
     */
    static function _getReq()
    {
        return json_decode(f3()->get('BODY'), true);
    }

    static public function _slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
