<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller {
  public function setLocale($locale='en'){

    if (!in_array($locale, ['en', 'zh'])){
        $locale = 'en';
    }
    \Session::put('locale', $locale);

    return redirect(url( \URL::previous()));
  }

  public function setLocaleApi($locale='en'){
    if (!in_array($locale, ['en', 'zh'])){
        $locale = 'en';
    }
    \Session::put('locale', $locale);
  }
}