<?php

namespace App\Services;

use CodeIgniter\Config\Services;

class AuthService
{
    protected $client;
    protected $baseUrl;
    public function __construct()
    {
        $this->client = Services::curlrequest(['http_errors' => false]);
        $this->baseUrl = env("AUTH_SERVICE");
        // $this->login();
    }

    public function getMe()
    {
        $response = $this->client->get("{$this->baseUrl}/me");

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to retrieve signed in user from Auth Service :' . $response->getStatusCode());
        }
    }

    public function getUser($id)
    {
        $response = $this->client->get("{$this->baseUrl}/show/" . $id);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to retrieve signed in user from Auth Service :' . $response->getStatusCode());
        }
    }

    public function getTest()
    {
        $response = $this->client->get("{$this->baseUrl}/test");

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to retrieve signed in user from Auth Service :' . $response->getStatusCode());
        }
    }

    public function LoginMicroService($data)
    {
        // $response = $this->client->post("{$this->baseUrl}/login", [
        //     ['headers' => ['Content-Type' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest'], 'json' => $data]
        // ]);
        $response = $this->client->request("POST", "{$this->baseUrl}/login", [
            'headers' => ['Content-Type' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest'], 'json' => $data
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while sending login data :' . $response->getStatusCode());
    }

    public function MeMicroService($data)
    {
        $response = $this->client->request("GET", "{$this->baseUrl}/auth/me", [
            'headers' => ['Authorization' => 'Bearer ' . $data['token']]
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while sending token data :' . $response->getStatusCode());
    }

    public function MeGroupMicroService($data)
    {
        $response = $this->client->request("GET", "{$this->baseUrl}/auth/me-group", [
            'headers' => ['Authorization' => 'Bearer ' . $data['token']]
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while sending token data :' . $response->getStatusCode());
    }

    public function getCheckPermissionMicroService($data)
    {
        $response = $this->client->request("POST", "{$this->baseUrl}/auth/check-permission", [
            'headers' => ['Authorization' => 'Bearer ' . $data['token']], 'json' => ['permission' => $data['permission']]
        ]);
        // $response = $this->client->post("{$this->baseUrl}/auth/check-permission", [
        //     'headers' => ['Authorization' => 'Bearer ' . $data['token']], 'json' => ['permission' => $data['permission']]
        // ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while sending token data :' . $response->getStatusCode());
    }

    public function LogoutMicroService($data)
    {
        $response = $this->client->request("GET", "{$this->baseUrl}/auth/logout", ['headers' => ['Authorization' => 'Bearer ' . $data['token']]]);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody());
        } else {
            throw new \Exception('Failed to log out : ' . $response->getStatusCode());
        }
    }

    public function ShowUsersMicroService($data = null)
    {
        $response = $this->client->request(
            "POST",
            "{$this->baseUrl}/finduser",
            [
                'json' => $data
            ]
        );

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        } elseif ($response->getStatusCode() == 404) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while requesting data :' . $response->getStatusCode());
    }

    public function FindUserMicroService($data = null)
    {
        $response = $this->client->request(
            "POST",
            "{$this->baseUrl}/finduser",
            [
                'json' => $data
            ]
        );

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        } elseif ($response->getStatusCode() == 404) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while requesting data :' . $response->getStatusCode());
    }

    public function RegisterUserMicroService($data)
    {
        $response = $this->client->request(
            "POST",
            "{$this->baseUrl}/registeruser",
            [
                'json' => $data
            ]
        );

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while sending data :' . $response->getStatusCode());
    }

    public function DeleteUserMicroService($data)
    {
        $response = $this->client->request(
            "POST",
            "{$this->baseUrl}/deleteuser",
            [
                'json' => $data
            ]
        );

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while deleting data :' . $response->getStatusCode());
    }
}
