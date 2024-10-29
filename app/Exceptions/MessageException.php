<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class MessageException
{
    public static function getMessage($message, $code = Response::HTTP_UNAUTHORIZED, array $errors = [])
    {
        if ($message == null) {
            $message = 'Dados fornecidos inválidos';
        }
        return [
            'validations' => [
                'code' => $code,
                'message' => $message,
                'errors' => $errors
            ]
        ];
    }

    public static function getMessageInvalidDataValidation($validations): JsonResponse
    {
        return response()->json(
            MessageException::getMessage(
                null,
                Response::HTTP_UNPROCESSABLE_ENTITY,
                is_array($validations) ? $validations : $validations->toArray()
            ),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public static function getMessageOperationNotPermitted(): JsonResponse
    {
        return response()->json(
            MessageException::getMessage(
                __('messages.OPERATION_NOT_PERMITTED'),
                Response::HTTP_UNAUTHORIZED,
                [__('messages.OPERATION_NOT_PERMITTED')]
            ),
            Response::HTTP_UNAUTHORIZED
        );
    }

    public static function getMessageRegistryNotFound(): JsonResponse
    {
        return response()->json(
            MessageException::getMessage(
                __('error_messages.registry_not_found'), Response::HTTP_OK
            ),
            Response::HTTP_OK
        );
    }

    public static function getMessageOfServiceUnvailable(): JsonResponse
    {
        return response()->json(
            MessageException::getMessage(
                __('messages.OPERATION_NOT_PERMITTED'),
                Response::HTTP_NOT_IMPLEMENTED,
                ['motive' => [__('messages.NOT_IMPLEMENTED')]]
            ),
            Response::HTTP_NOT_IMPLEMENTED
        );
    }

    public static function getMessageRegistryDeleted(): JsonResponse
    {
        return response()->json(
            MessageException::getMessage(
                __('messages.REGISTRY_DELETED'),
                Response::HTTP_OK
            ),
            Response::HTTP_OK
        );
    }

    public static function getMessageRegistryCanceled(): JsonResponse
    {
        return response()->json(
            MessageException::getMessage(
                __('messages.REGISTRY_CANCELED'),
                Response::HTTP_OK
            ),
            Response::HTTP_OK
        );
    }

    public static function getMessageInformed(string $message, $status = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        return response()->json(
            MessageException::getMessage(
                __("messages.{$message}"),
                $status
            ),
            $status
        );
    }
}
