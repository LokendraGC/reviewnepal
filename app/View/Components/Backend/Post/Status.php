<?php

namespace App\View\Components\Backend\Post;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Status extends Component
{
    public $post;
    public $route;
    public $button;

    /**
     * Create a new component instance.
     */
    public function __construct($post = NULL, $route = NULL, $button = NULL)
    {
        $this->post = $post;
        $this->route = $route;
        $this->button = $button;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend.post.status');
    }
}
