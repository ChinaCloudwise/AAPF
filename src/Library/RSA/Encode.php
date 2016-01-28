<?php

/**
 * Class RSA_Encode
 *
 * @author neeke@php.net
 */
class RSA_Encode
{
    /**
     * @var RSA_Encode
     */
    static public $self = NULL;

    /**
     * @var RSA_Process
     */
    private $oRSAProcess;

    /**
     * @var array
     */
    private $aReplace = array(
        '+' => '**',
        '=' => '!!',
    );

    /**
     * @param $app_id
     *
     * @return RSA_Encode
     */
    static public function instance($app_id)
    {
        if (is_null(self::$self)) {
            self::$self = new self($app_id);
        }

        return self::$self;
    }

    public function __construct($app_id)
    {
        $this->oRSAProcess = RSA_Process::instance($app_id);
    }

    /**
     * 私钥加密
     *
     * @param string $data 要加密的数据
     *
     * @return string 加密后的字符串
     */
    public function privateKeyEncode($data)
    {
        $aEncrypted = array();

        $data = base64_encode($data);
        $len  = strlen($data);
        for ($i = 0; $i < $len; $i += 50) {
            $tmp = substr($data, $i, 50);
            openssl_private_encrypt($tmp, $encrypted, $this->oRSAProcess->getPriKeyId());
            $aEncrypted[] = base64_encode($encrypted);
            unset($tmp);
            unset($encrypted);
        }
        unset($data);

        if (count($aEncrypted) > 0) {
            $enCodeData = base64_encode(json_encode($aEncrypted));
            $enCodeData = str_replace(array_keys($this->aReplace), array_values($this->aReplace), $enCodeData);
            unset($aEncrypted);

            return $enCodeData;
        }

        return NULL;
    }

    /**
     * 公钥加密
     *
     * @param string $data 要加密的数据
     *
     * @return string 加密后的字符串
     */
    public function publicKeyEncode($data)
    {
        $aEncrypted = array();

        $data = base64_encode($data);
        $len  = strlen($data);
        for ($i = 0; $i < $len; $i += 50) {
            $tmp = substr($data, $i, 50);
            openssl_public_encrypt($tmp, $encrypted, $this->oRSAProcess->getPubKeyId());
            $aEncrypted[] = base64_encode($encrypted);
            unset($tmp);
            unset($encrypted);
        }
        unset($data);

        if (count($aEncrypted) > 0) {
            $enCodeData = base64_encode(json_encode($aEncrypted));
            $enCodeData = str_replace(array_keys($this->aReplace), array_values($this->aReplace), $enCodeData);
            unset($aEncrypted);

            return $enCodeData;
        }

        return NULL;
    }

}