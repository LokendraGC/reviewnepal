<?php

namespace App\View\Components\Backend\Post;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainSection extends Component
{
    public $title;
    public $slug;
    public $content;
    public $titleLabel;
    public $placeholder;

    /**
     * Create a new component instance.
     */
    public function __construct($title = NULL, $slug = NULL, $content = NULL, $titleLabel = 'Title', $placeholder = 'Add title')
    {
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $content;
        $this->titleLabel = $titleLabel;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend.post.main-section');
    }
}
