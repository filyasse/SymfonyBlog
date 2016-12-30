<?php
/**
 * Created by PhpStorm.
 * User: ILYASSE
 * Date: 29/12/2016
 * Time: 19:14
 */

namespace Ilyasse\BlogBundle\Tests\Entity;

use Ilyasse\BlogBundle\Entity\Post;

class PostTest extends \PHPUnit_Framework_TestCase
{
    public function testTitle()
    {
        $post = new Post();
        $post->setTitle('Title');
        $this->assertEquals('Title', $post->getTitle());
    }

    public function testContent()
    {
        $post = new Post();
        $post->setContent('Content');
        $this->assertEquals('Content', $post->getContent());
    }
}
