<?php

namespace App\Services;

use CodeIgniter\Config\Services;

class SubmissionService
{
    protected $client;
    protected $baseUrl;
    public function __construct()
    {
        $this->client = Services::curlrequest(['http_errors' => false]);
        $this->baseUrl = env("SUBMISSION_SERVICE");
    }

    public function addSubmissionMicroService($data)
    {
        $response = $this->client->post("{$this->baseUrl}/add-submission", [
            'json' => $data
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while sending submission data :' . $response->getStatusCode());
    }

    public function getSessSubmissionMicroService($data)
    {
        $response = $this->client->post("{$this->baseUrl}/get-sess-submission", [
            'json' => $data
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        } elseif ($response->getStatusCode() == 404) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while requesting submission data :' . $response->getStatusCode());
    }

    public function getLastSessSubmissionMicroService($data)
    {
        $response = $this->client->post("{$this->baseUrl}/get-last-sess-submission", [
            'json' => $data
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        } elseif ($response->getStatusCode() == 404) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while requesting last submission data :' . $response->getStatusCode());
    }

    public function getSubmissionMicroService($data)
    {
        $response = $this->client->post("{$this->baseUrl}/get-submission", [
            'json' => $data
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        } elseif ($response->getStatusCode() == 404) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while requesting submission data :' . $response->getStatusCode());
    }

    public function getSubmissionByGroupMicroService($data)
    {
        $response = $this->client->post("{$this->baseUrl}/get-submission-by-group", [
            'json' => $data
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        } elseif ($response->getStatusCode() == 404) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while requesting submission data :' . $response->getStatusCode());
    }

    public function updateSubmissionMicroService($data)
    {

        $response = $this->client->post("{$this->baseUrl}/update-submission-by-group", [
            'json' => $data
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while sending submission data :' . $response->getStatusCode());
    }

    public function uploadSubmissionMicroService($data)
    {

        $response = $this->client->post("{$this->baseUrl}/upload-submission", [
            'json' => $data
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while sending submission data :' . $response->getStatusCode());
    }

    public function changeSubmissionMicroService($data)
    {
        $response = $this->client->post("{$this->baseUrl}/change-submission", [
            'json' => $data
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while sending submission data :' . $response->getStatusCode());
    }

    public function resubmitSubmissionMicroService($data)
    {
        $response = $this->client->post("{$this->baseUrl}/resubmit-submission", [
            'json' => $data
        ]);

        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error while sending submission data :' . $response->getStatusCode());
    }
}
