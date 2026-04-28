<?php

namespace App\Traits;

use App\Models\Backend\Template;
use Illuminate\Support\Facades\View;

trait TemplateViewTrait
{
    public function getTemplateView($request)
    {
        $data = Template::where('id', $request->template)->firstOrFail();
        $slug = $data->slug;

        return View::make('backend.templates-pages.'.$slug);
    }
}
