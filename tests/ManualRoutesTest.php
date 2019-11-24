<?php

namespace SilvertipSoftware\RestRouter\Tests;

use SilvertipSoftware\RestRouter\RestRouter;
use SilvertipSoftware\RestRouter\Tests\PostsController;

/**
 * Test manually defined routes (ie. not from resource() call) for fallback logic
 */
class ManualRoutesTest extends TestCase
{

    public function testSimpleIndexWithNoActionRoute()
    {
        $this->router->get('/posts', $this->action)->name('posts');
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals('/posts', RestRouter::path(Post::class));
    }

    public function testTakesActionForSaveObject()
    {
        $this->router->delete('/posts/{post}/foo', $this->action)->name('posts.foo');
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/posts/' . $this->savedPost->id . '/foo', 
            RestRouter::path($this->savedPost, ['action'=>'foo'])
        );
    }

    public function testTakesRouteParameter() {
        $this->router->get('/{account_id}/posts/{post}', $this->action)->name('posts.show');
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/111/posts/' . $this->savedPost->id,
            RestRouter::path($this->savedPost, ['account_id' => 111])
        );
    }
    public function testFallsBackToStoreActionForClass()
    {
        $this->router->post('/posts', $this->action)->name('posts.store');
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals('/posts', RestRouter::path(Post::class));
    }

    public function testFallsBackToStoreActionForUnsavedObject()
    {
        $this->router->post('/posts', $this->action)->name('posts.store');
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals('/posts', RestRouter::path(new Post()));
    }

    public function testFallsBackToUpdateRoute()
    {
        $this->router->put('/posts/{post}', $this->action)->name('posts.update');
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/posts/' . $this->savedPost->id,
            RestRouter::path($this->savedPost)
        );
    }

    public function testFallsBackToDestroyRoute()
    {
        $this->router->delete('/posts/{post}', $this->action)->name('posts.destroy');
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/posts/' . $this->savedPost->id,
            RestRouter::path($this->savedPost)
        );
    }
}
