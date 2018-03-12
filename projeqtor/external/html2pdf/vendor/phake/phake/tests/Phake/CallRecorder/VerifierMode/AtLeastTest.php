<?php
/* 
 * Phake - Mocking Framework
 * 
 * Copyright (c) 2010-2012, Mike Lively <m@digitalsandwich.com>
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 
 *  *  Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 * 
 *  *  Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 * 
 *  *  Neither the name of Mike Lively nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * @category   Testing
 * @package    Phake
 * @author     Mike Lively <m@digitalsandwich.com>
 * @copyright  2010 Mike Lively <m@digitalsandwich.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       http://www.digitalsandwich.com/
 */

/**
 * Tests the functionality of the AtLeast class.
 */
class Phake_CallRecorder_VerifierMode_AtLeastTest extends PHPUnit_Framework_TestCase
{
    private $verifierModeAtLeast;

    public function setUp()
    {
        $this->verifierModeAtLeast = new Phake_CallRecorder_VerifierMode_AtLeast(1);
    }

    /**
     * Tests that the verifier passes if there are exactly enough items.
     */
    public function testVerifyMatches()
    {
        // Will throw an exception if it wasn't working
        $matchedCalls = array('1item');
        $this->assertTrue($this->verifierModeAtLeast->verify($matchedCalls)->getVerified());
    }

    /**
     * Tests that the verifier passes if there are more than enough items.
     */
    public function testVerifyOver()
    {
        $matchedCalls = array('1item', '2items');
        $this->assertTrue($this->verifierModeAtLeast->verify($matchedCalls)->getVerified());
    }

    /**
     * Tests that the verifier fails if there weren't enough items.
     */
    public function testVerifyUnder()
    {
        $matchedCalls = array();
        $result       = $this->verifierModeAtLeast->verify($matchedCalls);
        $this->assertFalse($result->getVerified());
        $this->assertEquals('actually called <0> times', $result->getFailureDescription());
    }

    public function testToString()
    {
        $this->assertEquals("at least <1> times", $this->verifierModeAtLeast->__toString());
    }
}
