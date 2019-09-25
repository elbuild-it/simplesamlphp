<?php

namespace SimpleSAML\Test\Auth;

use SimpleSAML\Auth\SourceFactory;
use SimpleSAML\Test\Utils\ClearStateTestCase;

/**
 * Tests for \SimpleSAML\Auth\Source
 */
class SourceTest extends ClearStateTestCase
{
    /**
     * @return void
     */
    public function testParseAuthSource()
    {
        $class = new \ReflectionClass('\SimpleSAML\Auth\Source');
        $method = $class->getMethod('parseAuthSource');
        $method->setAccessible(true);

        // test direct instantiation of the auth source object
        $authSource = $method->invokeArgs(null, ['test', ['SimpleSAML\Test\Auth\TestAuthSource']]);
        $this->assertInstanceOf('SimpleSAML\Test\Auth\TestAuthSource', $authSource);

        // test instantiation via an auth source factory
        $authSource = $method->invokeArgs(null, ['test', ['SimpleSAML\Test\Auth\TestAuthSourceFactory']]);
        $this->assertInstanceOf('SimpleSAML\Test\Auth\TestAuthSource', $authSource);
    }
}

class TestAuthSource extends \SimpleSAML\Auth\Source
{
    /**
     * @return void
     */
    public function authenticate(array &$state) : void
    {
    }
}

class TestAuthSourceFactory implements SourceFactory
{
    /**
     * @return \SimpleSAML\Test\Auth\TestAuthSource
     */
    public function create(array $info, array $config) : \SimpleSAML\Auth\Source
    {
        return new TestAuthSource($info, $config);
    }
}
