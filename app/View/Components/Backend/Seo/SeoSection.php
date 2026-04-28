<?php

namespace App\View\Components\Backend\Seo;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SeoSection extends Component
{
    public $metaDatas;

    /**
     * Create a new component instance.
     */
    public function __construct($metaDatas = NULL)
    {
        $this->metaDatas = $metaDatas;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend.seo.seo-section');
    }
}
