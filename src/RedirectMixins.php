<?php

namespace SilvertipSoftware\RestRouter;

use Illuminate\Support\Facades\URL;

/**
 * Smart redirects using models.
 *
 * Only handles the basic case of not specifying status code, headers, etc. If you need that,
 * use redirect()->to(...) directly and use URL::url(...) as the url param.
 */
class RedirectMixins
{

    public function url()
    {
        return function (...$models) {
            return $this->to(URL::url(...$models));
        };
    }

    public function path()
    {
        return function (...$models) {
            return $this->to(URL::path(...$models));
        };
    }
}
