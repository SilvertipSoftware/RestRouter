<?php

namespace SilvertipSoftware\RestRouter\Tests;

use SilvertipSoftware\RestRouter\RestRouter;
use SilvertipSoftware\RestRouter\Tests\PostsController;

/**
 * Test the collection based routes: index, create, store
 */
class CollectionRoutesTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->addResourceRoutes();
    }

    public function testSimpleIndexRoute()
    {
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals('/posts', RestRouter::path(Post::class));
    }


    public function testTakesCreateActionAsLastArg()
    {
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/posts/create', 
            RestRouter::path(Post::class, 'create')
        );
    }
}