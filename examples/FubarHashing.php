<?php
 
    if( ! function_exists('hash_password'))
    {
        function hash_password($password = NULL, $salt = NULL, $salt2)
        {
            if($password === NULL)
                return FALSE;
 
            if($salt === NULL)
                $salt = config_item('encryption_key');
 
            $password = (string) $password;
            $salt = (string) $salt;
 
            $ci =& get_instance();
 
            $ci->load->library('encrypt');
 
            $salt2 = $ci->encrypt->decode(base64_decode($salt2), config_item('encryption_key2'));
 
            return crypt(hash_hmac('whirlpool', $password, hash('sha512', crypt($salt, '$6$rounds=100[000$' . hash('sha256', $salt)) . '$')), '$2y$12$'. $salt2 .'$');
        }
    }