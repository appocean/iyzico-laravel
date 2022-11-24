<?php

namespace Appocean\Payment\Models;

class Subscription {

    public string $plan_reference_code;

    public string $first_name;

    public string $last_name;

    public string $gsm_number;

    public string $email;

    public string $identity_number;

    public string $city_name;

    public string $country_name;

    public string $address;

    public string $zip_code;

    public string $card_holder_name;

    public string $card_number;

    public int $expire_month;

    public int $expire_year;

    public int $cvc;
}
