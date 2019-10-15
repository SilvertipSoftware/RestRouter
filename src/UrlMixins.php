<?php

namespace SilvertipSoftware\RestRouter;

/**
 * Smart url construction using routes and models.
 */
class UrlMixins
{

    public function url()
    {
        return function (...$models) {
            return RestRouter::url(...$models);
        };
    }

    public function path()
    {
        return function (...$models) {
            return RestRouter::path(...$models);
        };
    }
}
