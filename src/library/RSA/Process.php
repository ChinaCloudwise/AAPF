<?php

/**
 * Class RSA_Process
 *
 * @author neeke@php.net
 */
class RSA_Process
{
    const CERTIFICATE_PATH = 'certificate';

    /**
     * @var RSA_Process
     */
    static public $self = NULL;

    /**
     * @param $app_id
     *
     * @return RSA_Process
     */
    static public function instance($app_id)
    {
        if (is_null(self::$self)) {
            self::$self = new self($app_id);
        }

        return self::$self;
    }

    private $config = array(
        "digest_alg"       => 'md5',
        'encrypt_key'      => TRUE,
        'x509_extensions'  => 'v3_ca',
        "private_key_bits" => 512,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    private $dn = array(
        'countryName'            => 'CN',
        'stateOrProvinceName'    => 'China',
        'localityName'           => 'BeiJing',
        'organizationName'       => 'CloudWise',
        'organizationalUnitName' => 'R&D',
        'commonName'             => 'Neeke.Gao',
        'emailAddress'           => 'neeke@php.net',
    );

    /**
     * 私钥密码
     *
     * @var string
     */
    private $sPrivKeyPass = 'CloudWise';

    /**
     * 有效时长
     *
     * @var int
     */
    private $iNumberOfDays = 36500;

    /**
     * app证书目录
     *
     * @var null
     */
    private $sCertAppPath = NULL;

    /**
     * 公钥证书
     *
     * @var null
     */
    private $sCerPath = NULL;

    /**
     * 密钥证书
     *
     * @var null
     */
    private $sPfxPath = NULL;

    /**
     * 私钥
     *
     * @var null
     */
    private $priKeyId = NULL;

    /**
     * 公钥
     *
     * @var null
     */
    private $pubKeyId = NULL;

    /**
     * app_id为空,则新建证书, 否则读取原有证书
     *
     * @param $app_id
     *
     * @throws Exception
     */
    public function __construct($app_id)
    {
        if (!function_exists('openssl_pkey_new') || !function_exists('openssl_pkcs12_read')) {
            throw new Exception('Can not install php openssl.');
        }

        if ($app_id == NULL) {
            throw new Exception('App_id Can not empty.');
        }

        try {

            $this->processCertPath($app_id);

            if (!file_exists($this->sCerPath)) {
                $this->process();
            }

            $this->readPfxReady();
        } catch (Exception $e) {
            throw $e;
        }

        return TRUE;
    }

    private function processCertPath($app_id)
    {
        $dirName = dirname(__FILE__);

        $this->sCertAppPath = $dirName . '/' . self::CERTIFICATE_PATH . '/' . $app_id;
        $this->sCerPath     = $this->sCertAppPath . '/key.cer';
        $this->sPfxPath     = $this->sCertAppPath . '/key.pfx';

        if (!is_dir($this->sCertAppPath)) {
            mkdir($this->sCertAppPath, 0755, TRUE);
        }
    }

    /**
     * 生成证书
     */
    private function process()
    {

        $privkey = openssl_pkey_new($this->config);

        $csr = openssl_csr_new($this->dn, $privkey);

        $sscert = openssl_csr_sign($csr, NULL, $privkey, $this->iNumberOfDays);
        openssl_x509_export($sscert, $csrkey);
        openssl_pkcs12_export($sscert, $privatekey, $privkey, $this->sPrivKeyPass);

        //生成公钥证书
        $fp = fopen($this->sCerPath, "w");
        fwrite($fp, $csrkey);
        fclose($fp);

        //生成密钥证书
        $fp = fopen($this->sPfxPath, "w");
        fwrite($fp, $privatekey);
        fclose($fp);
    }

    /**
     * 读取证书\准备
     */
    private function readPfxReady()
    {
        $priv_key = file_get_contents($this->sPfxPath);
        openssl_pkcs12_read($priv_key, $certs, $this->sPrivKeyPass);

        $this->pubKeyId = $certs['cert'];
        $this->priKeyId = $certs['pkey'];
    }

    public function getPriKeyId()
    {
        return $this->priKeyId;
    }

    public function getPubKeyId()
    {
        return $this->pubKeyId;
    }
}