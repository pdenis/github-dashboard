<?php

namespace App\Repository;

use Github\Client;

class OrganizationRepository
{
    /**
     * @var Client
     */
    private $client;

    /**
     * OrganizationRepository constructor.
     *
     * @param Client $client
     * @param string $token
     */
    public function __construct(Client $client, string $token)
    {
        $this->client = $client;
        $this->client->authenticate($token, '', Client::AUTH_HTTP_TOKEN);
    }

    /**
     * @param $organizationName
     * @param bool $withDetails
     *
     * @return []
     */
    public function findRepositories($organizationName, $withDetails = true)
    {
        $repositories = $this->client->api('organization')->repositories($organizationName);

        if (!$withDetails) {
            return $repositories;
        }

        foreach ($repositories as $key => $repository) {
            $repositories[$key]['details'] = $this->findRepositoryDetails($organizationName, $repository['name']);
        }

        usort($repositories, function ($a, $b) {
            return count($a['details']['pull_requests']) < count($b['details']['pull_requests']);
        });

        return $repositories;
    }

    public function findRepositoryDetails($organizationName, $repositoryName)
    {
        $details = [];

        $details['pull_requests']  = $this->client->api('pull_request')->all($organizationName, $repositoryName);
        try {
            $details['latest_release'] = $this->client->api('repo')->releases()->latest($organizationName, $repositoryName);
        } catch(\Exception $e) {
            $details['latest_release']['tag_name'] = 'none';
        }

        return $details;
    }
}
