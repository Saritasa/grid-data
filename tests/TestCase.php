<?php namespace Tests;


use Mockery as m;
use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Calls Mockery::close
     */
    public function tearDown()
    {
        m::close();
    }
}