<?php

namespace App\Entity;

class Organization
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $repositories;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getRepositories(): array
    {
        return $this->repositories;
    }

    /**
     * @param array $repositories
     */
    public function setRepositories(array $repositories): void
    {
        $this->repositories = $repositories;
    }
}
