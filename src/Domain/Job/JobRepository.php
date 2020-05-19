<?php
declare(strict_types=1);

namespace App\Domain\Job;

interface JobRepository
{
    /**
     * @return Job[]
     */
    public function findAll(): ?object;

    /**
     * @param int $id
     * @return Job
     * @throws JobNotFoundException
     */
    public function findJobOfId(int $id);
}
