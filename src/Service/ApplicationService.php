<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Application;
use App\Entity\ApplicationStatus;
use App\Entity\User;
use App\Repository\ApplicationRepository;
use App\Repository\ApplicationStatusRepository;
use Doctrine\ORM\EntityManagerInterface;

class ApplicationService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ApplicationRepository $applicationRepository,
        protected ApplicationStatusRepository $applicationStatusRepository,
    )
    {}

    public function createApplication(User $user, array $data): array
    {
        if (!array_key_exists('topic', $data) || !array_key_exists('message', $data)) {
            return ['result' => 'Отсутствуют необходимые данные (topic и message)'];
        }

        $statusNew = $this->applicationStatusRepository->find(ApplicationStatus::NEW);

        $application = new Application();
        $application->setCreator($user);
        $application->setStatus($statusNew);
        $application->setTopic($data['topic']);
        $application->setMessage($data['message']);

        $this->entityManager->persist($application);
        $this->entityManager->flush();

        return ['result' => true];
    }

    /**
     * @return array
     */
    public function getAllApplications(): array
    {
        return $this->applicationRepository->findAllApplications();
    }

    public function getUserApplications(User $user): array
    {
        return $this->applicationRepository->findAllApplications($user->getId());
    }

    public function getApplication(int $id): array
    {
        return $this->applicationRepository->findAllApplications(null, $id);
    }

    public function getApplicationStatus(int $id): array
    {
        /** @var Application|null $application */
        $application = $this->applicationRepository->findOneBy(['id' => $id]);

        if ($application) {
            $status = $application->getStatus();
            return ['result' => $status->getName()];
        }

        return ['result' => false];
    }

    public function editApplicationStatus(array $data): array
    {
        /** @var Application|null $application */
        $application = $this->applicationRepository->findOneBy(['id' => $data['id']]);

        if ($application === null) {
            return ['result' => 'Отсутствует событие по данному id'];
        }

        /** @var ApplicationStatus|null $status */
        $status = $this->applicationStatusRepository->findOneBy(['id' => $data['status']]);

        if ($status === null) {
            return ['result' => 'Отсутствует статус по данному id'];
        }

        $application->setStatus($status);
        $application->setComment($data['comment']);
        $this->entityManager->flush();
        return ['result' => true];
    }
}