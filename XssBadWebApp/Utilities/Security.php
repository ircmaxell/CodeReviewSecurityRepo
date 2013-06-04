<?php
/**
 * A Bad Web Application.  Note that this is intentionally vulnerable to several
 * security vulnerabilities.  DO NOT INSTALL THIS ON A PUBLIC SERVER!
 * 
 * WARNING: FOR RESEARCH USE ONLY!  DO NOT USE!
 * 
 * DISCLAIMER: This application is for education use only.  Installing it on a 
 * public facing server will expose the server to several security vulnerabilities
 * The author takes absolutely no resposibility for any damage that may occur
 * from the use or misuse of any of this code.
 *
 * PHP version 5.3
 *
 * @category   XssBadWebApp
 * @package    Utilities
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 */

namespace XssBadWebApp\Utilities;

Security::init();

class Security {
    protected static $seed = 'abcdefghijklmnopqrstuvwxyz
                              ABCDEFGHIJKLMNOPQRSTUVWXYZ
                              0123456789-?/.,)(*^%$#@!~';
    
    public static function init() {
        static::$seed = preg_replace('/\s/', '', static::$seed);
    }
    
    public static function makeRandomString($length = 64) {
        $result = '';
        $seedLength = strlen(static::$seed);
        for ($i = 0; $i < $length; $i++) {
            $result .= static::$seed[mt_rand(0, $seedLength - 1)];
        }
        return $result;
    }
    
    /**
     * Hash the supplied data using the PBKDF2 key derivation method
     *
     * @param string $data       The data to hash
     * @param string $salt       The salt to use when hashing
     * @param string $algo       The hash algorithm to use
     * @param int    $cycles     The number of times to run the algorithm (increases output length)
     * @param int    $iterations The number of hash iterations to use for each run
     * 
     * @return string The hashed data
     */
    public static function PBKDF2($data, $salt, $algo = 'sha256', $cycles = 2, $iterations = 5000) {
        $result = '';
        for ($i = 0; $i < $cycles; $i++) {
            $temp = hash_hmac($algo, $salt . pack('N', $i), $data, true);
            $res = $temp;
            for ($j = 1; $j < $iterations; $j++) {
                $temp = hash_hmac($algo, $temp, $data, true);
                $res ^= $temp;
            }
            $result .= $res;
        }
        return $result;
    }
    
}
