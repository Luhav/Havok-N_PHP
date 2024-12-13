<?php

use PHPUnit\Framework\TestCase;
use Luhav\HavokN;

class HavokNTest extends TestCase {
	public function testHavokN8() {
		$havokN = new HavokN();
		$this->assertEquals(1749, $havokN->sum("test",8));
	}
	public function testHavokN16() {
		$havokN = new HavokN();
		$this->assertEquals(285120, $havokN->sum("test",16));
	}
	public function testHavokN16i1() {
		$havokN = new HavokN();
		$this->assertEquals(40971, $havokN->sum("test",16,1));
	}
	public function testHavokN16i2() {
		$havokN = new HavokN();
		$this->assertEquals(326, $havokN->sum("test",16,2));
	}
	public function testHavokN16i16() {
		$havokN = new HavokN();
		$this->assertEquals(54742, $havokN->sum("test",16,16));
	}
	public function testHavokNPrime() {
		$havokN = new HavokN();
		$this->assertIsNotCallable($havokN->is_prime(11));
	}
}
?>
