<?php

namespace App\Http\Object;

use Fschmtt\Keycloak\Collection\GroupCollection;
use Fschmtt\Keycloak\Representation\Group;
use Fschmtt\Keycloak\Type\Map;

class KCHelper
{

    public static function buildKcGroupRecursively($groupObject): Group
    {

        $subGroupAppend = [];

        if(property_exists($groupObject, 'sub_groups')){
            foreach ($groupObject->sub_groups as $subGroup){
                $group = self::buildKcGroupRecursively($subGroup);
                $subGroupAppend[] = $group;
            }
        }

        $attributes = new Map([
            "description" => $groupObject->attributes->descriptiones,
            "version" => $groupObject->attributes->version,
            "short_unit_name" => $groupObject->attributes->short_unit_name,
            "unit_name" => $groupObject->attributes->unit_name
        ]);

        return new Group(
            attributes: null,
            name: $groupObject->name,
            path: $groupObject->path,
            subGroups: property_exists($groupObject, 'sub_groups') ? new GroupCollection($subGroupAppend) : null,
        );
    }

}
