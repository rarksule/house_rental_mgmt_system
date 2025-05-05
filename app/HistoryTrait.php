<?php

namespace App;

use App\Models\UserHistory;
use App\Models\User;
use App\Models\House;

trait HistoryTrait
{
    public function recordHistory($type,$userId,$houseId=null){
        $user = User::find($userId);
        $house = null;
        if($houseId!=null){
            $house = House::find($houseId);
        }
        switch($type){
            case RENTED:
                $message = $user->name.__('message.rented').'house located at'.$house->address.'with'.$house->price.'Birr';
                break;
            case REGISTERED:
                $message = $user->name.'joined the website';
                break;
            case ADDED:
                $message = $user->name.'added house located at'.$house->address.'for price'.$house->price.'Birr';
                break;
            case RELEASED:
                $message = $user->name.'release the house rented at'.$house->address;
                break;
            case REMOVED:
                $message = $user->name.'removed the house at the location'.$house->address;
                break;
            default:
                $message = $user->name.'visited the house rented at'.$house->address.'with id of'.$house->id;
        }

        UserHistory::create([
            'house_id'=>$houseId,
            'user_id'=>$userId,
            'content'=>$message,
            'type'=>$type,
        ]);
    }
}
