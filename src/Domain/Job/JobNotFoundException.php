<?php
declare(strict_types=1);

namespace App\Domain\Job;

use App\Domain\DomainException\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The job you requested does not exist.';
}
