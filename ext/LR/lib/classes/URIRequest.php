<?php
  /*****************************************************************************
   *
   * @author: Rahmani Lounis
   * @email:lounis.rahmani@gmail.com
   *
   *
   *****************************************************************************/

  /**
   * URI Request Class
   ************/

class URIRequest
{
    public $lng;
    public $ctr;
    public $act;
    public $user;
    private $get;
    private $request;

    public function __construct ($params = null)
    {
    if ($params === null) {
    $this->get = $_GET;
    $this->request = array_merge ($_GET, $_POST);
    } else {
    $this->get = $params;
    $this->request = $params;
    }
    }

    public function isPost ()
    {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function isGet ()
    {
    return !$this->isPost ();
    }

    public function __get ($key)
    {
    if (array_key_exists ($key, $this->request) &&
    !empty ($this->request[$key]))
    return $this->request[$key];
    return false;
    }

    public function __set ($key, $value)
    {
    $this->request[$key] = $value;
    }

    public function get ($key, $default = '')
    {
    if (!array_key_exists ($key, $this->request))
    return $default;
    return $this->request[$key];
    }


    public function getCookie ($key, $default = '')
    {
    if (!array_key_exists ($key, $_COOKIE))
    return $default;
    return $_COOKIE[$key];
    }

    public function toArray ()
    {
    return $this->request;
    }

    public function getDigit ($key)
    {
    if ((array_key_exists ($key, $this->request)) &&
    (ctype_digit ($this->request[$key])))
    return $this->request[$key];
    return false;
    }

    public static function setLocation ($lng = null, $ctr = '', 
                                  $act = '', $get = '', $locate = true)
    {
        if (is_null ($lng)) {
            $lng = DEFAULT_LANG;
        }

        $link = WWW_ROOT.$lng.'/';
        if ($ctr != '') {
            $link.=$ctr.'/';
        }
        if ($act != '') {
            $link.= $act.'/';
        }
        if ($get != '') {
            $link.= '?';
            if (is_array ($get)) {
                foreach ($get as $key => $val) {
                    $link.= $key.'='.$val;
                    if (next ($get)) {
                      $link.= '&';
                    }
                  }
            } else {
                $link.= $get;
            }
        }
        if (!$locate) {
            return $link;
        }

        @header ("Location: {$link}");
        die ();
    }

    private function getact ($str)
    {
        if (ctype_alpha ($str))
            return $str;
        return '';
    }

    public function getctr ()
    {
        if (isset ($this->get['tpl'])) {
            return $this->get['tpl'];
        }
        if (isset ($this->get['controller'])) {
            return $this->get['controller'];
        }

        return '';
    }

    private function getlng ($str)
    {
        if (ctype_alpha ($str) && strlen ($str) == 2)
            return $str;
        self::setLocation ();
    }

    private function _escape ($str)
    {
        return $str;
    }

    public static function toLink ($url)
    {
        return str_replace (array ('é','è','ë','ê','à',
                               'ä','â','ù','ü','û',
                               'ö','ô','ï','ï','ü',
                               'û','ç', ',', '  ', ' ', '/'),
                        array ('e','e','e','e','a',
                               'a','a','u','u','u',
                               'o','o','i','i','u',
                               'u','c', '', ' ', '-', '-'), strtolower ($url));
    }

    public static function getIP () 
    {
        $ip = getenv("REMOTE_ADDR");
        if ($ip && ((SITE_STATE & SITE_DEBUG) || !self::isPrivateIP($ip))) {
        return $ip;
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        return getenv("HTTP_X_FORWARDED_FOR");
        }
        return "UNKNOWN";
    }

    public static function getCountryCode ()
    {
        $data = @geoip_record_by_name (self::getIP ());
        $code = $data['country_code'];
        //$code = maxmind::checkcountry (self::getIP ());
        return empty ($code) ? 'NC' : $code;
    }

    public function setArray ($arr)
    {
        $this->request = $arr;
    }

    /**
    * Ensures an ip address is in private network range.
    *  classe A : 10.0.0.0 à 10.255.255.255
    *  classe B : 172.16.0.0 à 172.31.255.255
    *  classe C : 192.168.1.0 à 192.168.255.255
    */
    public static function isPrivateIP($ip)
    {
        $ip = ip2long($ip);

        if ($ip !== false && $ip !== -1) {
              // make sure to get unsigned long representation of ip
              // due to discrepancies between 32 and 64 bit OSes and
              // signed numbers (ints default to signed in PHP)
              $ip = sprintf('%u', $ip);
              if (($ip >= 167772160 && $ip <= 184549375) ||
              ($ip >= 2886729728 && $ip <= 2887778303) ||
              ($ip >= 3232235520 && $ip <= 3232301055)) {
                  return true;
              }
        }
        return false;
    }
}
