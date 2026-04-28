<?php

namespace App\View\Components\Backend\Post;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Category extends Component
{
    public $title;
    public $name;
    public $type;
    public $categories;
    public $post;
    public $required;
    public $custom;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $name, $type, $categories, $post = NULL, $required = null, $custom = '')
    {
        $this->title = $title;
        $this->name = $name;
        $this->type = $type;
        $this->categories = $categories;
        $this->post = $post;
        $this->required = $required;
        $this->custom = $custom;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend.post.category');
    }
}
