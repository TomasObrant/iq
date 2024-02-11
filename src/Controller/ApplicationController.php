<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\API\ResponseService;
use App\Service\ApplicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ApplicationController extends AbstractController
{
    public function __construct(
        protected ResponseService $responseService,
    ) {}

//    #[IsGranted("ROLE_USER")]
    public function createApplication(#[CurrentUser] ?User $user, Request $request, ApplicationService $applicationService): JsonResponse
    {
        try {
            $result = $applicationService->createApplication($user, $request->toArray());
            return $this->responseService->setData($result)->getResponse();
        } catch (Exception $e) {
            return $this->responseService->exception($e)->getResponse();
        }
    }

//    #[IsGranted("ROLE_MANAGER")]
    public function getAllApplications(ApplicationService $applicationService): JsonResponse
    {
        try {
            $result = $applicationService->getAllApplications();
            return $this->responseService->setData($result)->getResponse();
        } catch (Exception $e) {
            return $this->responseService->exception($e)->getResponse();
        }
    }

//    #[IsGranted("ROLE_USER")]
    public function getUserApplications(#[CurrentUser] ?User $user, ApplicationService $applicationService): JsonResponse
    {
        try {
            $result = $applicationService->getUserApplications($user);
            return $this->responseService->setData($result)->getResponse();
        } catch (Exception $e) {
            return $this->responseService->exception($e)->getResponse();
        }
    }

//    #[IsGranted("ROLE_USER")]
    public function getApplication(int $id, ApplicationService $applicationService): JsonResponse
    {
        try {
            $result = $applicationService->getApplication($id);
            return $this->responseService->setData($result)->getResponse();
        } catch (Exception $e) {
            return $this->responseService->exception($e)->getResponse();
        }
    }

//    #[IsGranted("ROLE_USER")]
    public function getApplicationStatus(int $id, ApplicationService $applicationService): JsonResponse
    {
        try {
            $result = $applicationService->getApplicationStatus($id);
            return $this->responseService->setData($result)->getResponse();
        } catch (Exception $e) {
            return $this->responseService->exception($e)->getResponse();
        }
    }

//    #[IsGranted("ROLE_MANAGER")]
    public function editApplicationStatus(Request $request, ApplicationService $applicationService): JsonResponse
    {
        try {
            $result = $applicationService->editApplicationStatus($request->toArray());
            return $this->responseService->setData($result)->getResponse();
        } catch (Exception $e) {
            return $this->responseService->exception($e)->getResponse();
        }
    }
}
