<?php

namespace Administr\ViewComposers;

use Administr\Localization\Models\Language;
use Illuminate\View\View;

class LanguageComposer
{
    public function compose(View $view)
    {
        $languages = \Cache::rememberForever('languages_list', function() {
            return Language::lists('code', 'id');
        });

        $view->with('languages', $languages);
    }
}