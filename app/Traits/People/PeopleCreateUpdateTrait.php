<?php

namespace App\Traits\People;

use App\Models\Address;
use App\Models\Image;
use App\Models\Person;
use App\Models\Phone;

trait PeopleCreateUpdateTrait
{
    public function createUpdateAddress($request): int|null
    {
        if (empty($request['address'])) {
            return null;
        }
        $address = $request['address'];
        if (isset($address['id']) && $address['id']) {
            $register = Address::find($address['id']);
            if ($register) {
                debug('oi');
                $register->update($address);
                return $register->id;
            }
        }
        return Address::create($address)->id;
    }

    public function createUpdateAddressForceDelete($request, $person): int|null
    {
        if (empty($request['address'])) {
            $address = $person->address_id;

            if ($address) {
                $person->update(['address_id' => null]);
                $find = Address::find($address);
                if ($find) {
                    $find->delete();
                    return null;
                }
            }
        }

        return $this->createUpdateAddress($request);
    }

    public function createUpdatePerson($request)
    {
        $person = $request;

        if (isset($person['id']) && $person['id']) {
            $register = Person::find($person['id']);
            if ($register) {
                $register->update($person);
                return $register->id;
            }
        }
        return Person::create($person);
    }

    public function createUpdatePhones($request, $person): void
    {
        if (!isset($request['phones']) || empty($request['phones'])) {
            return;
        }
        $phones = $request['phones'];
        foreach ($phones as $phone) {
            if (isset($phone['id']) && $phone['id']) {
                $item = Phone::find($phone['id']);
                if ($item) {
                    $item->update($phone);
                    continue;
                }
            }
            $person->phones()->create($phone);
        }
    }

    public function createUpdateImages($request): int|null
    {
        if (!isset($request['images']) || empty($request['images'])) {
            return null;
        }
        $images = $request['images'];
        if (isset($images['id']) && $images['id']) {
            $register = Image::find($images['id']);
            if ($register) {
                $register->update($images);
                return $register->id;
            }
        }
        return Image::create($images)->id;
    }

}
