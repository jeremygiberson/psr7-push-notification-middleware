<?php


namespace Unit\Factories;


use PHPUnit_Framework_TestCase as TestCase;
use Psr\Http\Message\RequestInterface;

class RequestStubFactory
{
    /**
     * @param string $path
     * @param TestCase $testCase
     * @return RequestInterface
     */
    public static function fromFixture($path, TestCase $testCase)
    {
        $content = file_get_contents($path);
        $lines = explode("\n", $content);

        $request = $testCase->getMockBuilder(RequestInterface::class)
            ->getMock();

        $line = array_shift($lines);
        list($method, $uri, $ver) = explode(' ', $line);
        $request->expects(TestCase::any())
            ->method('getMethod')
            ->willReturn($method);

        $headerValues = [];
        $headers = [];
        while(($line = array_shift($lines)) != "")
        {
            list($key, $value) = explode(': ', $line);
            $headers[$key] = $value;
            $headerValues[$key] = explode(', ', $value);
        }



        $request->expects(TestCase::any())
            ->method('getHeaders')
            ->willReturn($headerValues);

        $request->expects(TestCase::any())
            ->method('getHeaderLine')
            ->willReturnCallback(function($key) use($headers) {
                return isset($headers[$key]) ? $headers[$key] : null;
            });

        $request->expects(TestCase::any())
            ->method('hasHeader')
            ->willReturnCallback(function($key) use($headers){
                return isset($headers[$key]);
            });

        $request->expects(TestCase::any())
            ->method('getBody')
            ->willReturn($body = join("\n", $lines));

        return $request;
    }
}