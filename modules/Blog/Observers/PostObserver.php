<?php

namespace Modules\Blog\Observers;

use Illuminate\Support\Str;
use Modules\Blog\Models\Post;

class PostObserver
{
    public function creating(Post $post): void
    {
        $this->setMetaTagTitle($post);
        $this->setMetaTagDescription($post);
    }

    private function setMetaTagTitle(Post $post): void
    {
        if (! request()->has('meta_tag_title') or empty(request('meta_tag_title'))) {
            $post->meta_tag_title = Str::limit($post->title, 60, '');
        }
    }

    private function setMetaTagDescription(Post $post): void
    {
        if (! request()->has('meta_tag_description') or empty(request('meta_tag_description'))) {
            $description = strip_tags((string) $post->content);

            // Add a space after punctuation, with exceptions for digits and ellipsis
            $pattern = [
                '/(\.\.\.)(?=[^\s])/u',  // Match ellipsis not followed by a space
                '/(?<!\.\.)(?<!\d)([.!?])(?=[^\s.!?])/u',  // Match punctuation not preceded by digit/ellipsis and not followed by space/punctuation
            ];

            $replace = [
                '$1 ',  // Add a space after ellipsis
                '$1 ',  // Add a space after punctuation
            ];

            $description = preg_replace($pattern, $replace, $description);

            $post->meta_tag_description = Str::limit($description, 160, '');
        }
    }
}
