<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Feed\Writer\Extension\ITunes;

use Zend\Feed\Writer;

/**
* @group Zend_Feed
* @group Zend_Feed_Writer
*/
class FeedTest extends \PHPUnit_Framework_TestCase
{
    public function testSetBlock()
    {
        $feed = new Writer\Feed;
        $feed->setItunesBlock('yes');
        $this->assertEquals('yes', $feed->getItunesBlock());
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetBlockThrowsExceptionOnNonAlphaValue()
    {
        $feed = new Writer\Feed;
        $feed->setItunesBlock('123');
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetBlockThrowsExceptionIfValueGreaterThan255CharsLength()
    {
        $feed = new Writer\Feed;
        $feed->setItunesBlock(str_repeat('a', 256));
    }

    public function testAddAuthors()
    {
        $feed = new Writer\Feed;
        $feed->addItunesAuthors(['joe', 'jane']);
        $this->assertEquals(['joe', 'jane'], $feed->getItunesAuthors());
    }

    public function testAddAuthor()
    {
        $feed = new Writer\Feed;
        $feed->addItunesAuthor('joe');
        $this->assertEquals(['joe'], $feed->getItunesAuthors());
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testAddAuthorThrowsExceptionIfValueGreaterThan255CharsLength()
    {
        $feed = new Writer\Feed;
        $feed->addItunesAuthor(str_repeat('a', 256));
    }

    public function testSetCategories()
    {
        $feed = new Writer\Feed;
        $cats = [
            'cat1',
            'cat2' => ['cat2-1', 'cat2-a&b']
        ];
        $feed->setItunesCategories($cats);
        $this->assertEquals($cats, $feed->getItunesCategories());
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetCategoriesThrowsExceptionIfAnyCatNameGreaterThan255CharsLength()
    {
        $feed = new Writer\Feed;
        $cats = [
            'cat1',
            'cat2' => ['cat2-1', str_repeat('a', 256)]
        ];
        $feed->setItunesCategories($cats);
        $this->assertEquals($cats, $feed->getItunesAuthors());
    }

    public function testSetImageAsPngFile()
    {
        $feed = new Writer\Feed;
        $feed->setItunesImage('http://www.example.com/image.png');
        $this->assertEquals('http://www.example.com/image.png', $feed->getItunesImage());
    }

    public function testSetImageAsJpgFile()
    {
        $feed = new Writer\Feed;
        $feed->setItunesImage('http://www.example.com/image.jpg');
        $this->assertEquals('http://www.example.com/image.jpg', $feed->getItunesImage());
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetImageThrowsExceptionOnInvalidUri()
    {
        $feed = new Writer\Feed;
        $feed->setItunesImage('http://');
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetImageThrowsExceptionOnInvalidImageExtension()
    {
        $feed = new Writer\Feed;
        $feed->setItunesImage('http://www.example.com/image.gif');
    }

    public function testSetDurationAsSeconds()
    {
        $feed = new Writer\Feed;
        $feed->setItunesDuration(23);
        $this->assertEquals(23, $feed->getItunesDuration());
    }

    public function testSetDurationAsMinutesAndSeconds()
    {
        $feed = new Writer\Feed;
        $feed->setItunesDuration('23:23');
        $this->assertEquals('23:23', $feed->getItunesDuration());
    }

    public function testSetDurationAsHoursMinutesAndSeconds()
    {
        $feed = new Writer\Feed;
        $feed->setItunesDuration('23:23:23');
        $this->assertEquals('23:23:23', $feed->getItunesDuration());
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetDurationThrowsExceptionOnUnknownFormat()
    {
        $feed = new Writer\Feed;
        $feed->setItunesDuration('abc');
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetDurationThrowsExceptionOnInvalidSeconds()
    {
        $feed = new Writer\Feed;
        $feed->setItunesDuration('23:456');
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetDurationThrowsExceptionOnInvalidMinutes()
    {
        $feed = new Writer\Feed;
        $feed->setItunesDuration('23:234:45');
    }

    public function testSetExplicitToYes()
    {
        $feed = new Writer\Feed;
        $feed->setItunesExplicit('yes');
        $this->assertEquals('yes', $feed->getItunesExplicit());
    }

    public function testSetExplicitToNo()
    {
        $feed = new Writer\Feed;
        $feed->setItunesExplicit('no');
        $this->assertEquals('no', $feed->getItunesExplicit());
    }

    public function testSetExplicitToClean()
    {
        $feed = new Writer\Feed;
        $feed->setItunesExplicit('clean');
        $this->assertEquals('clean', $feed->getItunesExplicit());
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetExplicitThrowsExceptionOnUnknownTerm()
    {
        $feed = new Writer\Feed;
        $feed->setItunesExplicit('abc');
    }

    public function testSetKeywords()
    {
        $feed = new Writer\Feed;
        $words = [
            'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10', 'a11', 'a12'
        ];
        $feed->setItunesKeywords($words);
        $this->assertEquals($words, $feed->getItunesKeywords());
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetKeywordsThrowsExceptionIfMaxKeywordsExceeded()
    {
        $feed = new Writer\Feed;
        $words = [
            'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10', 'a11', 'a12', 'a13'
        ];
        $feed->setItunesKeywords($words);
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetKeywordsThrowsExceptionIfFormattedKeywordsExceeds255CharLength()
    {
        $feed = new Writer\Feed;
        $words = [
            str_repeat('a', 253), str_repeat('b', 2)
        ];
        $feed->setItunesKeywords($words);
    }

    public function testSetNewFeedUrl()
    {
        $feed = new Writer\Feed;
        $feed->setItunesNewFeedUrl('http://example.com/feed');
        $this->assertEquals('http://example.com/feed', $feed->getItunesNewFeedUrl());
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetNewFeedUrlThrowsExceptionOnInvalidUri()
    {
        $feed = new Writer\Feed;
        $feed->setItunesNewFeedUrl('http://');
    }

    public function testAddOwner()
    {
        $feed = new Writer\Feed;
        $feed->addItunesOwner(['name' => 'joe', 'email' => 'joe@example.com']);
        $this->assertEquals([['name' => 'joe', 'email' => 'joe@example.com']], $feed->getItunesOwners());
    }

    public function testAddOwners()
    {
        $feed = new Writer\Feed;
        $feed->addItunesOwners([['name' => 'joe', 'email' => 'joe@example.com']]);
        $this->assertEquals([['name' => 'joe', 'email' => 'joe@example.com']], $feed->getItunesOwners());
    }

    public function testSetSubtitle()
    {
        $feed = new Writer\Feed;
        $feed->setItunesSubtitle('abc');
        $this->assertEquals('abc', $feed->getItunesSubtitle());
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetSubtitleThrowsExceptionWhenValueExceeds255Chars()
    {
        $feed = new Writer\Feed;
        $feed->setItunesSubtitle(str_repeat('a', 256));
    }

    public function testSetSummary()
    {
        $feed = new Writer\Feed;
        $feed->setItunesSummary('abc');
        $this->assertEquals('abc', $feed->getItunesSummary());
    }

    /**
     * @expectedException Zend\Feed\Writer\Exception\ExceptionInterface
     */
    public function testSetSummaryThrowsExceptionWhenValueExceeds4000Chars()
    {
        $feed = new Writer\Feed;
        $feed->setItunesSummary(str_repeat('a', 4001));
    }
}
