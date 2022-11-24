<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Exception;
use Auth;
use App\Models\PurchaseNumber;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PricingController extends Controller
{
    protected $twilio;

    public function __construct()
    {
        // Your Account SID and Auth Token from twilio.com/console
        $this->sid = getenv("TWILIO_ACCOUNT_SID");
        $this->token = getenv("TWILIO_AUTH_TOKEN");
        /** Initialize the Twilio client so it can be used */
        $this->twilio = new Client($this->sid, $this->token);
    }

    public function index()
    {
        /** Retrieve a list of countries where Twilio phone number services are available */
        $phoneCountries = $this->twilio->pricing->phoneNumbers->countries->read();

        return view("pricing", ["phoneCountries" => $phoneCountries]);
    }

    /** PHONE NUMBERS */
    public function phoneNumbers(Request $request)
    {
        $this->validate($request, [
            "iso2" => "required",
        ]);

        try {
            $country = $request->iso2;
            /** Retrieve the cost of phone numbers in the given country. */
            $price = $this->twilio->pricing->v1->phoneNumbers
                ->countries($country)
                ->fetch();

            $phoneCountries = $this->twilio->pricing->phoneNumbers->countries->read();

            $available_number = $this->twilio
                ->availablePhoneNumbers($country)
                ->local->read([], 20);
            if ($price) {
                return view("pricing", [
                    "selectedCountry" => $country,
                    "available_number" => $available_number,
                    "price" => $price,
                    "phoneCountries" => $phoneCountries,
                ]);
            } else {
                return back()->with(
                    "sweet-error",
                    "Retrieving the pricing information failed. Please try again"
                );
            }
        } catch (Exception $e) {
            return back()->with("sweet-error", $e->getMessage());
        }
    }

    public function purchase_number($number, $country_code)
    {
        return view("address_form", [
            "number" => $number,
            "country_code" => $country_code,
        ]);
    }

    public function postAddress(Request $request)
    {
        $address_sid = "";
        try {
            $full_name = $request->full_name ? $request->full_name : "name";
            $street = $request->street ? $request->street : "street";
            $city = $request->city ? $request->city : "city";
            $region = $request->region ? $request->region : "region";
            $postal_code = $request->postal_code
                ? $request->postal_code
                : "postal_code";
            $country_code = $request->country_code
                ? $request->country_code
                : "country_code";
            $user_id = Auth::id();
            $user_name = Auth::user()->name;

            $address = $this->twilio->addresses->create(
                $full_name, // customerName
                $street, // street
                $city, // city
                $region, // region
                $postal_code, // postalCode
                $country_code, // isoCountry
                [
                    "friendlyName" =>  $full_name,
                    "emergencyEnabled" => True
                ]
            );
            $address_sid = $address->sid;
            $url = url("/");
            $p_params = [
                "friendlyName" => $address->friendlyName,
                "phoneNumber" => $request->number,
                "voiceMethod" => "GET",
                "voiceUrl" =>
                    $url . "/config/call-webhook-handler/" . Auth::id(),
                "smsMethod" => "GET",
                "smsUrl" => $url . "/call-system/SmsNotify/" . Auth::id(),
                "addressSid" => $address_sid,
                "emergencyAddressSid" => $address_sid,
            ];
            $incoming_phone_number = $this->twilio->incomingPhoneNumbers->create(
                $p_params
            );

            $attribute = [
                "user_id" => $user_id,
                "address_sid" => $address_sid,
                "customer_name" => $user_name,
                "phone_number" => $request->number,
                "voice_url" => $p_params["voiceUrl"],
                "sms_url" => $p_params["smsUrl"],
                "street" => $street,
                "city" => $city,
                "region" => $region,
                "postal_code" => $postal_code,
                "country_code" => $country_code,
            ];

            if ($incoming_phone_number->status == "in-use") {
                PurchaseNumber::create($attribute);
            }
            return redirect("/available-list")->with(
                "sweet-success",
                "Number successfully purchased number" .
                    $incoming_phone_number->phoneNumber .
                    " sid is " .
                    $incoming_phone_number->sid
            );
        } catch (Exception $e) {
            return redirect("/available-list")->with(
                "sweet-error",
                $e->getMessage()
            );
        }
    }
}