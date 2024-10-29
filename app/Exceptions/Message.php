<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class Message
{
    public static function getMessage($message, $code = Response::HTTP_UNAUTHORIZED, $errors = [], $specificCode = null)
    {
        if ($message == null) {
            $message = 'Dados fornecidos inválidos';
        }
        $data = [
            'validations' => [
                'code' => $code,
                'message' => $message,
                'errors' => $errors
            ]
        ];
        return response()->json($data, $specificCode ?? $code);
    }

    public static function getMessageInvalidDataValidation($validations): JsonResponse
    {
        return Message::getMessage(
            null,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            is_array($validations) ? $validations : $validations->toArray()
        );
    }

    public static function getMessageOperationNotPerfomed($eMessage, $eCode): JsonResponse
    {
        $eCode = ($eCode != 0) ? $eCode : Response::HTTP_UNPROCESSABLE_ENTITY;
        return Message::getMessage(
            __('messages.OPERATION_NOT_PERFORMED'),
            Response::HTTP_OK,
            $eMessage,
            $eCode
        );
    }

    public static function getMessageOperationNotPerfomedWithCode($eMessage, $eCode): JsonResponse
    {
        return Message::getMessage(
            __('messages.OPERATION_NOT_PERFORMED'),
            $eCode,
            $eMessage
        );
    }

    public static function getMessageOperationNotPermitted(): JsonResponse
    {
        return Message::getMessage(
            __('messages.OPERATION_NOT_PERMITTED'),
            Response::HTTP_UNAUTHORIZED,
            [__('messages.OPERATION_NOT_PERMITTED')]
        );
    }

    public static function getMessageRegistryNotFound(): JsonResponse
    {
        return Message::getMessage(
            __('error_messages.registry_not_found'),
            Response::HTTP_NOT_FOUND
        );
    }

    public static function getMessageCityNotHasForm(): JsonResponse
    {
        return Message::getMessage(
            'Cidade não possui formularios vinculados',
            Response::HTTP_NOT_FOUND
        );
    }

    public static function getMessagePersonHasProperty(): JsonResponse
    {
        return Message::getMessage(
            'Não é possivel deletar uma pessoa que possua propriedades vinculadas',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public static function getMessageOfServiceUnvailable(): JsonResponse
    {
        return Message::getMessage(
            __('messages.OPERATION_NOT_PERMITTED'),
            Response::HTTP_NOT_IMPLEMENTED,
            ['motive' => [__('messages.NOT_IMPLEMENTED')]]
        );
    }

    public static function getMessageRegistryDeleted(): JsonResponse
    {
        return Message::getMessage(
            __('messages.REGISTRY_DELETED'),
            Response::HTTP_OK
        );
    }

    public static function getMessageRegistryNotDeleted(): JsonResponse
    {
        return Message::getMessage(
            __('messages.REGISTRY_NOT_DELETED'),
            Response::HTTP_UNAUTHORIZED,
            __('messages.REGISTRY_NOT_DELETED'),
        );
    }

    public static function getMessageRegistryCanceled(): JsonResponse
    {
        return Message::getMessage(
            __('messages.REGISTRY_CANCELED'),
            Response::HTTP_OK
        );
    }

    public static function getMessageBuyerCodeState(): JsonResponse
    {
        return Message::getMessage(
            __('messages.THE_FIELD_BUYER_ADDRESS_CODE/STATE_MUST_CONTAIN_VALID_VALUE'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public static function getMessageInformed(string $message, $status = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        return Message::getMessage(
            __("messages.{$message}"),
            $status
        );
    }

    public static function getMessageClientNotFound(): JsonResponse
    {
        return Message::getMessage(
            __('messages.CLIENT_NOT_FOUND'),
            Response::HTTP_UNPROCESSABLE_ENTITY,
            ['client_id' => [__('messages.CLIENT_NOT_FOUND')]]
        );
    }

    public static function getMessageUserUnauthorized(): JsonResponse
    {
        return Message::getMessage(
            __('messages.USER_UNAUTHORIZED'),
            Response::HTTP_UNAUTHORIZED,
            ['user_id' => [__('messages.USER_UNAUTHORIZED')]]
        );
    }

    public static function getMessageCredentialAlreadyExists(): JsonResponse
    {
        return Message::getMessage(
            __('messages.CREDENTIAL_ALREADY_EXISTS'),
            Response::HTTP_UNAUTHORIZED,
            ['user_id' => [__('messages.CREDENTIAL_ALREADY_EXISTS')]]
        );
    }
}
