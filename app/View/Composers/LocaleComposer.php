<?php
namespace App\View\Composers;

use Illuminate\View\View;

class LocaleComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with([
            'currentLocale'    => 'en',
            'currentDirection' => 'ltr',
            'availableLocales' => ['en' => ['name' => 'English', 'dir' => 'ltr']],
            'isRTL'            => false,
        ]);
    }
}
