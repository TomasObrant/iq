<?php

namespace App\Service\API;

use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ResponseService
{
    /** @var array|null */
    protected ?array $data = null;

    /** @var bool */
    protected bool $success = true;

    /** @var int */
    protected int $statusCode = 200;

    /** @var string */
    protected string $env = '';

    /**
     * ResponseService constructor.
     *
     * @param string $env
     */
    public function __construct(string $env)
    {
        $this->env = $env;
    }

    /**
     * @return JsonResponse
     */
    public function getResponse(): JsonResponse
    {
        return new JsonResponse(
            [
                'success' => $this->success,
                'data' => $this->data
            ],
            $this->statusCode
        );
    }

    /**
     * @param array<mixed>|null $data
     * @return ResponseService
     */
    public function setData(?array $data): ResponseService
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param bool $success
     * @return ResponseService
     */
    public function setSuccess(bool $success): ResponseService
    {
        $this->success = $success;

        return $this;
    }

    /**
     * @param int $statusCode
     * @return ResponseService
     */
    public function setStatusCode(int $statusCode): ResponseService
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param Exception $exception
     * @return ResponseService
     */
    public function exception(Exception $exception): ResponseService
    {
        $this->setSuccess(false);

        if ($exception instanceof HttpException) {
            $this->setStatusCode($exception->getStatusCode());
        } else {
            $code = $exception->getCode();

            if (is_integer($code) &&
                $code >= 400 &&
                $code < 500
            ) {
                $this->setStatusCode($code);
            } else {
                $this->setStatusCode(400);
            }
        }

        if ($exception instanceof JWTDecodeFailureException) {
            $message = match ($exception->getReason()) {
                $exception::EXPIRED_TOKEN => 'Истёк срок действия токена',
                $exception::INVALID_TOKEN => 'Неправильный токен',
                $exception::UNVERIFIED_TOKEN => 'Токен не подтвержден',
                default => 'Ошибка при проверке токена',
            };
            $answer = [
                'code' => 401,
                'message' => $message
            ];
        } else {
            $answer = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }
        if ($this->env !== 'prod') {
            $answer['error'] = $exception->getFile() . ':' . $exception->getLine();
            $answer['trace'] = $exception->getTrace();
        }

        return $this->setData($answer);
    }
}
