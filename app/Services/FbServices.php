<?php
/**
 * Author: Xavier Au
 * Date: 21/4/2016
 * Time: 7:05 PM
 */

namespace App\Services;


use App\FacebookUser;
use App\User;
use App\UserType;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

class FbServices
{
    private $token;
    private $fbUser;

    /**
     * FacebookServices constructor.
     * @param $fbUser
     */
    public function __construct($fbUser)
    {
        $this->fbUser = $fbUser;
        $this->token = $this->fbUser->token;
    }

    public function get($endPoint)
    {
        $fb = new Facebook([
            'app_id'                => config("services.facebook.client_id"),
            'app_secret'            => config("services.facebook.client_secret"),
            'default_graph_version' => config("services.facebook.default_graph_version"),
        ]);
        try {
            return $fb->get($endPoint, $this->token);
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    public function getAvatar($userId)
    {
        $response = $this->get("/{$userId}/picture?height=120&width=120");
        return $response->getHeaders()["Location"];
    }

    public function fetchOrCreateAppUserFromFacebookUserGraph(): User
    {
        $user = User::whereEmail($this->fbUser->email)->first();

        if(!$user){
            $userTypeId = UserType::whereType(\App\Enums\UserType::FACEBOOK)->firstOrFail()->id;

            $user = $this->createUser($userTypeId);

            $this->createFacebookUser($user);
        }
        return $user;
    }

    public function fetchFeedFromGroup()
    {
        $response = $this->get("/1170712616312556/feed");

        $bodyObject = json_decode($response->getBody(), true);
        $feeds = $bodyObject['data'];
        $feedDetail = [];
        foreach ($feeds as $feed){
            if(array_key_exists('message',$feed)){
                $temp = [
                    'created_at' =>$feed['updated_time'],
                    'id' =>$feed['id'],
                    'message' =>$feed['message'],
                ];
                $response = $this->get("/".$feed['id']."/?fields=from");
                $responseArray = json_decode($response->getBody(), true);
                $temp['sender'] = $responseArray['from']['name'];
                $temp['sender_id'] = $responseArray['from']['id'];
                $feedDetail[] = $temp;
            }
        }
    }

    /**
     * @param $avatar
     * @param $userTypeId
     * @return \App\User
     */
    private function createUser($userTypeId)
    {
        $avatar = $this->getAvatar($this->fbUser->id);
        $user = new User();
        $nameArray = preg_split("/ /", $this->fbUser->name);

        $user->first_name = $nameArray[0];
        $user->last_name = end($nameArray);
        $user->email = $this->fbUser->email;
        $user->avatar = $avatar;
        $user->user_type_id = $userTypeId;
        $user->user_status_id = 2;
        $user->clan_id = 1;
        $user->city_id = 1;
        $user->password = str_random(16);
        $user->save();

        return $user = User::findOrFail($user->id);
    }

    /**
     * @param $avatar
     * @param $user
     */
    private function createFacebookUser($user)
    {
        $avatar = $this->getAvatar($this->fbUser->id);

        $newFbUser = new FacebookUser();
        $newFbUser->id = $this->fbUser->id;
        $newFbUser->token = $this->fbUser->token;
        $newFbUser->name = $this->fbUser->name;
        $newFbUser->email = $this->fbUser->email;
        $newFbUser->avatar = $avatar;
        $newFbUser->gender = $this->fbUser->user["gender"];
        $newFbUser->user_id = $user->id;
        $newFbUser->save();
    }

}