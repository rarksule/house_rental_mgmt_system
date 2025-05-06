<?php

use App\Models\Language;
use Carbon\Carbon;
use App\Models\Message;

function getSettingImage($option_key = null)
{

    return asset('assets/images/no-image.jpg');

}

function tourRequested($lead = null)
{

    if (isTenant()) {
        return Message::where('sender_id', auth()->user()->id)->where('content', 'Let me see the house in person')->exists();
    } elseif (isOwner() && $lead != null) {
        return Message::where('receiver_id', auth()->user()->id)->where('content', 'Let me see the house in person')->count();
    } else {
        return true;
    }


}


function isAdmin($user = null, $role = null): bool
{
    if ($role == null) {
        return checkUser(USER_ROLE_ADMIN, $user);
    }
    return $role == USER_ROLE_ADMIN;
}

function isOwner($user = null, $role = null): bool
{
    if ($role == null) {
        return checkUser(USER_ROLE_OWNER, $user);
    }
    return $role == USER_ROLE_OWNER;
}
function isTenant($user = null, $role = null): bool
{
    if ($role == null) {
        return checkUser(USER_ROLE_TENANT, $user);
    }
    return $role == USER_ROLE_TENANT;
}

function checkUser($userRole, $requster): bool
{

    $user = $requster ?? auth()->user();
    return $user ? $userRole == $user->role : 0;
}


if (!function_exists('timeAgo')) {
    function timeAgo($dateTime)
    {
        return Carbon::parse($dateTime)->diffForHumans();
    }
}

function getNotificationLimit($user_id)
{
    return [];
}

function selectedLanguage()
{
    $language = '';
    foreach (languages() as $lang) {
        if ($lang->code == app()->getLocale()) {
            $language = $lang;
            break;
        }
    }

    return $language;

}

function userPrefix()
{
    if (isAdmin()) {
        return 'admin';
    } else {
        return isOwner() ? 'owner' : 'tenant';
    }
}

function languages()
{
    return Language::where('status', 1)->get();
}

function isAdminPanel()
{
    if (isAdmin() || isOwner()) {
        $value = false;
        switch (Route::currentRouteName()) {
            case 'home':
                $value = true;
                break;
            case 'house_detail':
                $value = true;
                break;
            case 'privacy':
                $value = true;
                break;
            case 'cookie':
                $value = true;
                break;
            case 'terms':
                $value = true;
                break;
        }
        return !$value;
    } else {
        return false;
    }
}


function noImage()
{
    return asset('assets/images/no-image.jpg');
}

function getAllMedia($model, $collection = 'images', $needAuth = false)
{

    if (!auth()->check() && $needAuth) {
        return noImage();
    }
    if ($model->getMedia() != null) {
        $media = $model->getMedia($collection);
        $imageUrls = [];
        foreach ($media as $image) {
            array_push($imageUrls, $image->getUrl());
        }
        return $imageUrls;
    }
    return [];
}

function getSingleImage($model, $collection = 'images', $needAuth = false)
{
    if ($collection == 'profile_image') {
        return getAllMedia($model, $collection, $needAuth = false)[0] ?? asset('assets/images/user.png');
    }
    return getAllMedia($model, $collection, $needAuth = false)[0] ?? asset('assets/images/no-image.jpg');
}


function getUnreadMessage($user_id = null)
{
    if ($user_id) {
        return Message::where('receiver_id', auth()->user()->id)
            ->where('sender_id', $user_id)
            ->where('isread', false)->count();

    }
    return Message::where('receiver_id', auth()->user()->id)->where('isread', false)->count();
}

