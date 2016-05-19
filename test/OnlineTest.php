<?php

class OnlineTest extends PHPUnit_Framework_TestCase {
    function setUp() {
        $this->api = new ImageOptim\API("gnbkrbjhzb");
    }

    public function testFullMonty() {
        $imageData = $this->api->imageFromURL('http://example.com/image.png')->resize(160,100,'crop')->dpr('2x')->getBytes();

        $gdimg = imagecreatefromstring($imageData);
        $this->assertEquals(160*2, imagesx($gdimg));
        $this->assertEquals(100*2, imagesy($gdimg));
    }

    /**
     * @expectedException ImageOptim\AccessDeniedException
     * @expectedExceptionCode 403
     */
    public function testBadKey() {
        $api = new ImageOptim\API("zzzzzzzz");
        $api->imageFromURL('http://example.com/image.png')->dpr('2x')->getBytes();
    }

    /**
     * @expectedException ImageOptim\NotFoundException
     * @expectedExceptionCode 404
     */
    public function testUpstreamError() {
        $this->api->imageFromURL('http://fail.example.com/nope')->getBytes();
    }

}
