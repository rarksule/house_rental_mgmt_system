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
                $message = __("message.history_description",["name"=>$user->name , "status" => __('message.rented'), "address" =>  $house->address, "price"=> $house->price]);
                break;
            case REGISTERED:
                $message = __("message.joined_website",["name" => $user->name]);
                break;
            case ADDED:
                $message = __("message.history_description",["name"=>$user->name , "status" => __('message.added'), "address" =>  $house->address, "price"=> $house->price]); 
                break;
            case RELEASED:
                $message = __("message.history_description",["name"=>$user->name , "status" => __('message.left'), "address" =>  $house->address, "price"=> $house->price]);
                break;
            case REMOVED:
                $message = __("message.history_description",["name"=>$user->name , "status" => __('message.removed'), "address" =>  $house->address, "price"=> $house->price]);;
                break;
            default:
                $message = __("message.history_description",["name"=>$user->name , "status" => __('message.visited'), "address" =>  $house->address, "price"=> $house->price]);
        }

        UserHistory::create([
            'house_id'=>$houseId,
            'user_id'=>$userId,
            'content'=>$message,
            'type'=>$type,
        ]);
    }
}
