<?php

namespace App\View\Components\Backend\Post;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeaturedImage extends Component
{
    public $metaDatas;
    public $required;

    /**
     * Create a new component instance.
     */
    public function __construct($metaDatas = NULL, $required = null)
    {
        $this->metaDatas = $metaDatas;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend.post.featured-image');
    }
}
