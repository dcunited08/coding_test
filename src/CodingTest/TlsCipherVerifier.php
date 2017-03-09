<?php
/**
 * Created by PhpStorm.
 * User: dcunited08
 * Date: 3/1/2017
 * Time: 13:37
 */

namespace CodingTest;

/**
 * Class TlsCipherVerifier
 *
 * Validates that the provided host meets all TLS version requirements.
 *
 * @package CodingTest
 */
class TlsCipherVerifier implements ISslCipherVerifier
{

    /**
     * @var string
     */
    protected $hostname;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $ciphersRequired = array('TLSv1.0', 'TLSv1.1', 'TLSv1.2');


    /**
     * ISslCipherVerifier constructor.
     * Define server to test
     *
     * @param string $hostname
     * @param string $name
     */
    public function __construct($hostname, $name) {
        $this->hostname = $hostname;
        $this->name = $name;
    }

    /**
     * Run verification of SSL setting
     *
     * @return string
     */
    public function verify() {
        $response = $this->runNmap($this->hostname);

        $response = $this->cleanupResponse($response);

        $isValid = $this->validateResponse($response);

        return $this->createOutput($isValid);
    }

    /**
     * @param string $hostname
     * @return array
     */
    protected function runNmap($hostname) {
        $cmd = "nmap --script ssl-enum-ciphers -p 443 ".escapeshellarg($hostname);
        exec($cmd, $response);

        return $response;
    }

    /**
     * @param bool $isValid
     * @return string
     */
    protected function createOutput($isValid) {
        return ($isValid)? 'PASS:'.$this->hostname : "FAILURE:".$this->hostname."-".$this->name;
    }

    /**
     * @param $response
     * @return array
     */
    protected function cleanupResponse($response) {
        $response = array_map(function ($line) {
            return trim(rtrim(ltrim($line, '|'), ':'));
        }, $response);
        return $response;
    }

    /**
     * @param array $response
     * @return bool
     */
    protected function validateResponse($response) {
        foreach($this->ciphersRequired as $item) {
            if(!in_array($item, $response)) {
                return false;
            }
        }

        return true;
    }
}