<?php

use App\User;
use App\Models\Setting;

if (!function_exists('admin_url')) {
  function admin_url($path)
  {
    return url('admin-management/' . $path);
  }
}

if (!function_exists('member_url')) {
  function member_url($path)
  {
    return url($path);
  }
}

if (!function_exists('getSetting')) {
  function getSetting($key = '')
  {
    if (empty($key)) {
      return '';
    }

    $setting = Setting::where('key', $key)->pluck('value')->toArray();
    return $setting[0];
  }
}

if (!function_exists('classActivePath')) {
  function classActivePath($path, $segment = 1)
  {
    $path = explode('.', $path);
    foreach ($path as $p) {
      if ((request()->segment($segment) == $p) == false) {
        return '';
      }
      $segment++;
    }
    return 'active';
  }
}

if (!function_exists('dateformat')) {
  function dateformat($date)
  {
    return date('d-m-Y h:i A', strtotime($date));
  }
}


if (!function_exists('currency_format')) {
  function currency_format($value = '', $currency = 'RM') {
    if(empty($value)) {
      $value = 0;
    }
    return '<small><b>'.$currency.'</b></small> '.number_format((float) $value, 2, '.', ',');
  }
}


if (!function_exists('date_history')) {
  function date_history($date)
  {
    return date('Ymd/Hi', strtotime($date));
  }
}

if (!function_exists('showOrDash')) {
  function showOrDash($text)
  {
    echo (!empty($text)) ? $text : '-';
  }
}

if (!function_exists('getCurrency')) {
  function getCurrency()
  {
    if (Auth::guard('admin')->user()) {
      return strtoupper(Auth::guard('admin')->user()->currency);
    } else {
      return strtoupper(Auth::user()->createdByDetail->currency);
    }
  }
}

if (!function_exists('getRandomWeightedElement')) {
  function getRandomWeightedElement(array $weightedValues)
  {
    $rand = mt_rand(1, (int) array_sum($weightedValues));

    foreach ($weightedValues as $key => $value) {
      $rand -= $value;
      if ($rand <= 0) {
        return $key;
      }
    }
  }
}


if (!function_exists('shuffle_assoc')) {
  function shuffle_assoc($list)
  {
    if (!is_array($list)) return $list;

    $keys = array_keys($list);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key) {
      $random[$key] = $list[$key];
    }
    return $random;
  }
}
