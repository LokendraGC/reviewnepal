<?php

namespace App\View\Components\Backend\Post;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Excerpt extends Component
{
    public $content;

    /**
     * Create a new component instance.
     */
    public function __construct($content = NULL)
    {
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend.post.excerpt');
    }
}
