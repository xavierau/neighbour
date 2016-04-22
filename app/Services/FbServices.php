<?php
/**
 * Author: Xavier Au
 * Date: 21/4/2016
 * Time: 7:05 PM
 */

namespace App\Services;


use Facebook\Facebook;
use Facebook\Facebook\Exceptions\FacebookResponseException;
use Facebook\Facebook\Exceptions\FacebookSDKException;
use Facebook\FacebookApp;

class FbServices
{
    private $token;
    /**
     * FacebookServices constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
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

}