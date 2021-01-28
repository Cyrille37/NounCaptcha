<?php
namespace Cyrille\NounCaptcha ;

/**
 * Common stuff for this plugin, shared by Public & Admin side.
 */
class Utils
{
    const TRANSIENT_PREFIX = 'cyrille37-wp-utils';
    const EMAIL_EOL = "\r\n" ;

    public static function isDebug()
    {
        static $debug = null ;
        if( $debug == null )
        {
            $debug = (defined('WP_DEBUG')
                ? (WP_DEBUG?true:false)
                : false );
        }
        return $debug ;
    }

    public static function debug( ...$items )
    {
        if( ! self::isDebug() )
            return ;

        $msg = '' ;
        foreach( $items as $item )
        {
            switch ( gettype($item))
            {
                case 'boolean' :
                    $msg.= ($item ? 'true':'false');
                    break;
                case 'NULL' :
                    $msg.= 'null';
                    break;
                case 'integer' :
                case 'double' :
                case 'float' :
                case 'string' :
                    $msg.= $item ;
                    break;
                default:
                    $msg .= var_export($item,true) ;
            }
            $msg.=' ';
        }
        error_log( $msg );
    }

    public static function getSiteName()
    {
        if ( is_multisite() ) {
            $site_name = get_network()->site_name;
        } else {
            /*
             * The blogname option is escaped with esc_html on the way into the database
             * in sanitize_option we want to reverse this for the plain text arena of emails.
             */
            $site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
        }
        return $site_name ;
    }

    public static function getRequestParam( $key, $default=null )
    {
        if( isset($_REQUEST[$key]) )
            return $_REQUEST[$key];
        return $default ;
    }

    public static function getCurrentUrl( $query_args = [])
    {
        global $wp ;
        return home_url( add_query_arg( $query_args, $wp->request ) );
    }

    public static function redirectSelf()
    {
        //wp_redirect( $_SERVER["HTTP_REFERER"], 302, 'WordPress' );
        if( isset($_SERVER["HTTP_REFERER"]) )
        {
            wp_safe_redirect( $_SERVER["HTTP_REFERER"] );
        }
        else
        {
            global $wp;
            $current_url = home_url( add_query_arg( array(), $wp->request ) );
            wp_safe_redirect( $current_url );    
        }
        exit;
    }

    public static function displayFlash()
    {
        $k = self::getTransientKeyForSession(self::TRANSIENT_PREFIX.'-flash');
        $status = get_transient( $k );
        if( empty($status) || (empty($status['errors']) && empty($status['success'])) )
        {
            return ;
        }
        ?>

        <div id="wp-utils-status">
            <?php
            foreach( $status['errors'] as $key => $error )
            {
            ?>
                <div class="error">
                    <p><?php echo $error; ?></p>
                </div>
            <?php
            }
            foreach( $status['success'] as $key => $success )
            {
            ?>
                <div class="success">
                    <p><?php echo $success; ?></p>
                </div>
            <?php
            }
        ?>
        </div><!-- /#wp-utils-status -->

        <?php
        delete_transient( $k );
    }

    /**
     * Search for some unique user ID cookie.
     * Create one if none found.
     */
    public static function getSessionId()
    {
        static $id = null ;
        if( ! empty($id) )
            return $id ;

        if( isset($_COOKIE[session_name()]))
        {
            // the php session cookie only present if php session started.
            //error_log('SESSION FROM COOKIE session_name');
            $id = $_COOKIE[session_name()];
        }
        else if( isset($_COOKIE['_gid']))
        {
            // "_gid" cookie from Google Analytics responsible for tracking user behavior, it expires after 24h of inactivity.
            //error_log('SESSION FROM COOKIE _gid');
            $id = $_COOKIE['_gid'];
        }
        else if( isset($_COOKIE['wp-utils-id']))
        {
            // Our cookie
            //error_log('SESSION FROM COOKIE wp-utils-id');
            $id = $_COOKIE['wp-utils-id'];
        }
        else
        {
            // Create a id cookie
            //error_log('CREATE COOKIE wp-utils-id');
            $id = uniqid() . random_int(10000,99999) ;
            setcookie( 'wp-utils-id', $id, time() + 30 * DAY_IN_SECONDS, '/' );
    
        }
        return $id ;
    }

    public static function getTransientKeyForSession( $key )
    {
        return $key.'_'.self::getSessionId() ;
    }

    public static function flashError( $msg, $key = null )
    {
        self::addFlash( $msg, $key, true );
    }

    public static function flashSucess( $msg, $key = null )
    {
        self::addFlash( $msg, $key, false );
    }

    public static function addFlash( $msg, $key = null, $isError=false )
    {
        $k = self::getTransientKeyForSession(self::TRANSIENT_PREFIX.'-flash');
        $status = get_transient( $k );

        if( ! is_array($status) )
        {
            $status = [
                'success' => [],
                'errors' => [],
            ];
        }

        //$arr =& $isError ? $status['errors'] : $status['success'] ;
        if( $isError )
            $arr =& $status['errors'];
        else
            $arr =& $status['success'];

        if( $key )
            $arr[$key] = $msg ;
        else
            $arr[] = $msg ;

        set_transient( $k, $status );
    }

    /**
     *
     * @param int $date Unix timestamp
     * @return string
     */
    public static function renderDaysAgo($date, $gmt = false)
    {
        if( ! is_numeric($date) )
        {
            $date = strtotime($date);
        }
        $current = current_time('timestamp', $gmt);

        $seconds_ago = floor($current - $date);
        if( $seconds_ago <= 0 )
            return __('il y a quelques instants');
        if( $seconds_ago < 60 )
            return sprintf(_n('il y a 1 seconde', 'il y a %d secondes', $seconds_ago), $seconds_ago);

        $minutes_ago = floor($seconds_ago / 60);
        if( $minutes_ago < 60 )
            return sprintf(_n('il y a 1 minute', 'il y a %d minutes', $minutes_ago), $minutes_ago);

        $hours_ago = floor($minutes_ago / 60);
        if( $hours_ago < 24 )
            return sprintf(_n('il y a 1 heure', 'il y a %d heures', $hours_ago), $hours_ago);

        $days_ago = floor($hours_ago / 24);
        if( $days_ago < 7 )
            return sprintf(_n('il y a 1 jour', 'il y a %d jours', $days_ago), $days_ago);

        $weeks_ago = floor($days_ago / 7);
        if( $weeks_ago < 4 )
            return sprintf(_n('il y a 1 semaine', 'il y a %d semaines', $weeks_ago), $weeks_ago);

        $months_ago = floor($weeks_ago / 4);
        if( $months_ago < 12 )
            return sprintf(_n('il y a 1 mois', 'il y a %d mois', $months_ago), $months_ago);

        $years_ago = floor($months_ago / 12);
        return sprintf(_n('il y a 1 an', 'il y a %d ans', $years_ago), $years_ago);
    }

    //const OPENSSL_CIPHER = OPENSSL_CIPHER_AES_128_CBC ;
    const OPENSSL_CIPHER = 'aes-128-ctr' ;

    /**
     * options is a bitwise disjunction of the flags
     * - OPENSSL_RAW_DATA (bool) If OPENSSL_RAW_DATA is set in the openssl_encrypt() or openssl_decrypt(), the returned data is returned as-is. When it is not specified, Base64 encoded data is returned to the caller. 
     * @see https://www.php.net/manual/en/openssl.constants.other.php
     */
    const OPENSSL_OPTIONS = OPENSSL_RAW_DATA ;

    /**
     * Encrypts (but does not authenticate) a message
     * 
     * @param string $message - plaintext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encode - set to TRUE to return a base64-encoded 
     * @return string (raw binary)
     */
    public static function encrypt($message, $key, $encode = true)
    {
        $nonceSize = openssl_cipher_iv_length(self::OPENSSL_CIPHER);
        $nonce = openssl_random_pseudo_bytes($nonceSize);

        $ciphertext = openssl_encrypt(
            $message,
            self::OPENSSL_CIPHER,
            $key,
            self::OPENSSL_OPTIONS,
            $nonce
        );

        // Now let's pack the IV and the ciphertext together
        // Naively, we can just concatenate
        if ($encode) {
            return base64_encode($nonce.$ciphertext);
        }
        return $nonce.$ciphertext;
    }

    /**
     * Decrypts (but does not verify) a message
     * 
     * @param string $message - ciphertext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encoded - are we expecting an encoded string?
     * @return string
     */
    public static function decrypt($message, $key, $encoded = true)
    {
        if ($encoded) {
            $message = base64_decode($message, true);
            if ($message === false) {
                throw new Exception('Encryption failure');
            }
        }

        $nonceSize = openssl_cipher_iv_length(self::OPENSSL_CIPHER);
        $nonce = mb_substr($message, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($message, $nonceSize, null, '8bit');

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::OPENSSL_CIPHER,
            $key,
            self::OPENSSL_OPTIONS,
            $nonce
        );

        return $plaintext;
    }

}
