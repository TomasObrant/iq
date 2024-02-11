<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\API\ResponseService;
use App\Service\ApplicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class ApplicationController extends AbstractController
{
    public function __construct(
        protected ResponseService $responseService,
    ) {}

    public function getAllApplications(ApplicationService $applicationService): JsonResponse
    {
        try {
            $result = $applicationService->getApplications();
            return $this->responseService->setData($result)->getResponse();
        } catch (Exception $e) {
            return $this->responseService->exception($e)->getResponse();
        }
    }
}
