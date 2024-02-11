<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\ApplicationRepository;

class ApplicationService
{

    public function __construct(
        protected ApplicationRepository $applicationRepository,
    )
    {}

    /**
     * @return array
     */
    public function getApplications(): array
    {
        $applications = $this->applicationRepository->findAll();
        $result = [];

        foreach ($applications as $application) {
            $result[] =
                [
                    'id' => $application->getId(),
                    'topic' => $application->getTopic(),
                    'message' => $application->getMessage()
                ];
        }

        return $result;
    }
}