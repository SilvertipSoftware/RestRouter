<?php

namespace SilvertipSoftware\RestRouter\Tests;

use SilvertipSoftware\RestRouter\RestRouter;

class ModificationTest extends TestCase
{

    public function testTakesRouteParameters()
    {
        $this->router->get('/{foo}/posts/{post}', $this->action)->name('posts.show');
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/123/posts/' . $this->savedPost->id,
            RestRouter::path($this->savedPost, ['foo'=>123])
        );
    }

    public function testTakesQueryParameters()
    {
        $this->addResourceRoutes();
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/posts/' . $this->savedPost->id . '?mode=full',
            RestRouter::path($this->savedPost, ['mode'=>'full'])
        );
    }

    public function testTakesFormatForExtension()
    {
        $this->addResourceRoutes();
        $this->router->getRoutes()->refreshNameLookups();

        $this->assertEquals(
            '/posts/' . $this->savedPost->id . '.json',
            RestRouter::path($this->savedPost, ['format'=>'json'])
        );
    }
}