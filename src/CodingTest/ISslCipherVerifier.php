<?php
/**
 * Created by PhpStorm.
 * User: dcunited08
 * Date: 3/1/2017
 * Time: 14:08
 */

namespace CodingTest;

interface ISslCipherVerifier
{
    /**
     * ISslCipherVerifier constructor.
     * Define server to test
     *
     * @param string $hostname
     * @param string $name
     */
    public function __construct($hostname, $name);

    /**
     * Run verification of SSL setting
     *
     * @return string
     */
    public function verify();
}