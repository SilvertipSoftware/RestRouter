<?php

namespace SilvertipSoftware\RestRouter\Tests;

use SilvertipSoftware\RestRouter\RestRouter;
use SilvertipSoftware\RestRouter\Tests\PostsController;

class SingleObjectRoutesTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->addResourceRoutes();
    }

    public function testSimpleShowRoute()
    {
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/posts/' . $this->savedPost->id,
            RestRouter::path($this->savedPost)
        );
    }

    public function testUsesResourceParameterGlobalNameInRoute()
    {
        $this->router->resourceParameters(['comments'=>'foo']);
        $this->addResourceRoutes('comments');
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/comments/' . $this->savedComment->id,
            RestRouter::path($this->savedComment)
        );
    }

    public function testNestedShowRoute()
    {
        RestRouter::$shallowResources = false;
        $this->addResourceRoutes('posts.comments');
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/posts/' . $this->savedPost->id 
                . '/comments/' . $this->savedComment->id,
            RestRouter::path($this->savedPost, $this->savedComment)
        );
    }

    public function testCanOverrideShallowOption()
    {
        $this->addResourceRoutes('posts.comments');
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/posts/' . $this->savedPost->id 
                . '/comments/' . $this->savedComment->id,
            RestRouter::path(
                $this->savedPost,
                $this->savedComment,
                ['shallow'=>false]
            )
        );
    }

    public function testNamespacedShowRoute()
    {
        $this->router->name('admin.')->group(
            function () {
                $this->addResourceRoutes('comments');
            }
        );
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/comments/' . $this->savedComment->id,
            RestRouter::path('admin', $this->savedComment)
        );
    }

    public function testTakesEditActionAsLastArg()
    {
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/posts/' . $this->savedPost->id . '/edit',
            RestRouter::path($this->savedPost, 'edit')
        );
    }
}
