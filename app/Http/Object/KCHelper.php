<?php

namespace App\Http\Object;

use Fschmtt\Keycloak\Representation\Group;

class KCHelper
{

    public static function buildKcGroupRecursively($groupObject){

        $subGroup = [];

        if(property_exists($groupObject, 'sub_groups')){
            foreach ($groupObject->sub_groups as $subGroup){
                $group = self::buildKcGroupRecursively($subGroup);
                array_push($group);
            }
        }

        return new Group(
            attributes: $groupObject->attributes,
            name: $groupObject->name,
            path: $groupObject->path,
            subGroups: $subGroup,
        );
    }

}
