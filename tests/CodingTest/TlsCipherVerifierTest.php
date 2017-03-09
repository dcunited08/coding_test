<?php
/**
 * Created by PhpStorm.
 * User: jdcook
 * Date: 3/1/2017
 * Time: 13:38
 */

namespace CodingTest;

require_once dirname(__FILE__) . '/../../bootstrap.php';

class TlsCipherVerifierTest extends \PHPUnit_Framework_TestCase
{

    function testConstruct() {
        $tmp = new TlsCipherVerifier('','');
        $this->assertInstanceOf('\CodingTest\TlsCipherVerifier', $tmp);
    }

    /**
     * @param $hostname
     * @param $name
     * @param $expected
     * @dataProvider verifyProvider
     */
    function testVerify($hostname, $name, $expected) {
        $tmp = new TlsCipherVerifier($hostname, $name);
        $this->assertEquals($expected, $tmp->verify());
    }

    function verifyProvider(){
        return array(
          array('ssb.epcc.edu', 'SSB', 'FAILURE:ssb.epcc.edu-SSB'),
          array('yahoo.com', 'Yahoo', 'PASS:yahoo.com'),
          array('msn.com', 'MSN', 'PASS:msn.com'),
        );
    }

}
