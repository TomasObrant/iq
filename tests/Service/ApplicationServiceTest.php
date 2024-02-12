<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\ApplicationService;
use App\Repository\ApplicationRepository;
use App\Repository\ApplicationStatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\ApplicationStatus;
use App\Entity\Application;

class ApplicationServiceTest extends TestCase
{
    protected ApplicationService $applicationService;
    protected EntityManagerInterface $entityManager;
    protected ApplicationRepository $applicationRepository;
    protected ApplicationStatusRepository $applicationStatusRepository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->applicationRepository = $this->createMock(ApplicationRepository::class);
        $this->applicationStatusRepository = $this->createMock(ApplicationStatusRepository::class);

        $this->applicationService = new ApplicationService(
            $this->entityManager,
            $this->applicationRepository,
            $this->applicationStatusRepository
        );
    }

    public function testCreateApplication()
    {
        $user = new User();
        $data = ['topic' => 'Test Topic', 'message' => 'Test Message'];

        $statusNew = new ApplicationStatus();

        $this->applicationStatusRepository
            ->method('find')
            ->willReturn($statusNew);

        $result = $this->applicationService->createApplication($user, $data);

        $this->assertEquals(['result' => true], $result);
    }
}