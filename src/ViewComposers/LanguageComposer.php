<?php

namespace Administr\ViewComposers;

use Administr\Localization\Models\Language;
use Illuminate\View\View;

class LanguageComposer
{
    public function compose(View $view)
    {
        if( !config('administr.hasLanguages') ) {
            return;
        }

        $languages = \Cache::rememberForever('languages_list', function() {
            if (substr(app()::VERSION, 0, 3) < '5.3') {
                return Language::lists('code', 'id');
            }

            return Language::pluck('code', 'id');
        });

        $view->with('languages', $languages);
    }
}