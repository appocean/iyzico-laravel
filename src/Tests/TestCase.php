<?php

namespace Tests;

use PHPUnit_Framework_TestCase as BaseTestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    use CreatesApplication;
}
