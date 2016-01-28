<?php

/**
 * Class RSA_Decode
 *
 * @author neeke@php.net
 */
class RSA_Decode
{
    /**
     * @var RSA_Decode
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
     * @return RSA_Decode
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
     * 用公钥解密私钥加密内容
     *
     * @param string $data 要解密的数据
     *
     * @return string 解密后的字符串
     */
    public function decodePrivateEncode($data)
    {
        $data = str_replace(array_values($this->aReplace), array_keys($this->aReplace), $data);
        $data = json_decode(base64_decode($data));

        $result = '';
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $tmp) {
                openssl_public_decrypt(base64_decode($tmp), $decrypted, $this->oRSAProcess->getPubKeyId());
                $result .= $decrypted;
                unset($tmp);
            }
        }

        unset($data);

        if (strlen($result) > 0) {
            return base64_decode($result);
        }

        return NULL;
    }

    /**
     * 用私钥解密公钥加密内容
     *
     * @param string $data 要解密的数据
     *
     * @return string 解密后的字符串
     */
    public function decodePublicEncode($data)
    {
        $data = str_replace(array_values($this->aReplace), array_keys($this->aReplace), $data);
        $data = json_decode(base64_decode($data));

        $result = '';
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $tmp) {
                openssl_private_decrypt(base64_decode($tmp), $decrypted, $this->oRSAProcess->getPriKeyId());
                $result .= $decrypted;
                unset($tmp);
            }
        }

        unset($data);

        if (strlen($result) > 0) {
            return base64_decode($result);
        }

        return NULL;
    }
}