<?php

namespace SilvertipSoftware\RestRouter\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use SilvertipSoftware\RestRouter\RestRouter;

class TestCase extends OrchestraTestCase
{

    $this->action = function () {
    };

    public function setUp(): void
    {
        parent::setUp();
        $this->router = app('router');

        // reset to default/known
        RestRouter::$shallowResources = true;
        $this->router->resourceParameters([]);

        $this->savedPost = new Post(['id'=>rand(1, 1000000)]);
        $this->savedPost->exists = true;
        $this->savedComment = new Comment(['id'=>rand(1, 1000000)]);
        $this->savedComment->exists = true;
    }

    protected function addResourceRoutes($resource = 'posts')
    {
        $this->router->resource($resource, 'GenericController');
    }
}