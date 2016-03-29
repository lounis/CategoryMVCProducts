<?php

           $LANGUAGE_CODE = 'en';
            $navigatorLanguage = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? 
                        explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']): array();
            if(!empty($navigatorLanguage)) {
                $navigatorLanguage = strtolower(substr(chop($navigatorLanguage[0]),0,2));
                if (array_key_exists($navigatorLanguage, $GLOBALS['LANGUAGES'])) {
                    $LANGUAGE_CODE = $navigatorLanguage;
                }
            }
    
            $cookie_domain = '.'. WWW_ROOT;
            if (false) { // TODO User Is not Guest
                $user = array();
                if ($langcode = $_REQUEST['hl']) {
                    if (strlen($langcode) == 2) {
                        if ($user->language_code != $langcode) {
                            $user->Register()->set('language_code', $langcode)->update();
                        }
                    }
                } else if (isset($user->language_code) && !empty($user->language_code)) {
                    $langcode = $user->language_code;
                } else if (isset($_COOKIE['hl'])) {
                    $langcode = $_COOKIE['hl'];
                }
                if (strlen($langcode) == 2 && $langcode != @$_COOKIE['hl']) {
                    setcookie('hl', '', null, '/', $cookie_domain);
                    setcookie('hl', $langcode, time()+(24*3600), '/');
                }
            } else if (isset($_REQUEST['hl']) ) {
                $langcode = $_REQUEST['hl'];
                if (strlen($langcode) == 2 && $langcode != @$_COOKIE['hl']) {
                     setcookie('hl', '', null, '/', $cookie_domain);
                    setcookie('hl', $langcode, time()+(24*3600), '/');
                }
            } else if(isset($_COOKIE['hl']) && !is_null($_COOKIE['hl'])) {
                 $langcode = $_COOKIE['hl'];
            }
    
            if (isset($langcode)) {
                $LANGUAGE_CODE = $langcode;
            }

            setlocale(LC_ALL,   $LANGUAGE_CODE);
            bindtextdomain('django',  'locales');
            textdomain('django');
            bind_textdomain_codeset('django', 'UTF-8');
