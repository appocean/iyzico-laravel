<?php

namespace Appocean\Payment\Services\IyzicoPayment;

use Appocean\Payment\Services\Payment\PaymentServiceInterface;
use Iyzipay\IyzipayResource;
use Iyzipay\Options;

interface IyzicoPaymentServiceInterface extends PaymentServiceInterface
{
    function options(): Options;

    function getConversationId(): string;

    function isSuccess(IyzipayResource $result): bool;

    function planIntervalMapper(string $interval): string;
}
