<?php

namespace App\Shortcodes;

use App\Models\Post;
use App\Helpers\MediaHelper;

class WikiShortcode
{
    public function register($atts, $compiler, $name)
    {
        // Ensure $atts is an array before accessing its elements
        $atts = $atts ? $atts->id : null;

        $html = '';

        if ( $atts ) {

            $wiki = Post::query()
                ->where('id', $atts)
                ->where('post_type', 'wiki')
                ->where('post_status', 'publish')
                ->first();

            if ( $wiki ) {

                $request = request();

                if ( $request->segment(2) == 'post' || $request->segment(3) == 'news' || $request->segment(3) == 'wiki' ) {

                    $postMeta = $wiki->postMeta->pluck('meta_value', 'meta_key')->toArray();

                    if ( isset($postMeta['featured_image']) && ( $image = MediaHelper::getImageById($postMeta['featured_image']) ) ) {

                        $img = '';
                        $img .= '<img src="'.asset('storage/' . $image->file_name).'" />';
                    }
                    else {
                        $img = null;
                    }

                    $dynamicContent = [
                        // 'imageSrc' => 'http://sajilopatrika.test/storage/uploads/2024/10/annapurna-tourist-1730178791.jpg',
                        'imageSrc' => $img,
                        'imageAlt' => $wiki->post_title,
                        'linkHref' => '/wiki/'.$wiki->slug,
                        'linkText' => $wiki->post_title,
                        'description' => $wiki->post_excerpt,
                    ];
                    $descriptionHtml = !empty($wiki->post_excerpt) ? '<p>' . $wiki->post_excerpt . '</p>' : '';

                    $containerContent = sprintf(
                        '<div class="wiki-popup"><a href="%s" class="tooltip-link">%s<span>%s</span></a>%s</div>',
                        // $dynamicContent['imageSrc'],
                        // $dynamicContent['imageAlt'],
                        $dynamicContent['linkHref'],
                        $dynamicContent['imageSrc'] ?? null,
                        $dynamicContent['linkText'],
                        // $dynamicContent['description']
                        $descriptionHtml
                    );

                    $html = sprintf(
                        '<a class="wiki-link" data-tooltip-id="wiki-tooltip" data-tooltip-html="%s">%s</a>',
                        htmlspecialchars($containerContent, ENT_QUOTES, 'UTF-8'),
                        $wiki->post_title
                    );


                    }
                    else {

                        $html .= $wiki->post_title;
                    }
            }

        }

        return $html;
    }
}
