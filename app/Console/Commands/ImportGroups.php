<?php

namespace App\Console\Commands;

use App\Http\Object\KCHelper;
use App\Support\KeycloakInstance;
use Fschmtt\Keycloak\Collection\GroupCollection;
use Fschmtt\Keycloak\Representation\Group;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'group:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the SSO Groups and the childs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $keycloak = KeycloakInstance::getKeycloakInstance();
        $serverInfo = $keycloak->serverInfo()->get();

        $this->info('Connected to ' . sprintf(
                'Keycloak %s is running on %s/%s (%s) with %s/%s since %s and is currently using %s of %s (%s %%) memory.',
                $serverInfo->getSystemInfo()->getVersion(),
                $serverInfo->getSystemInfo()->getOsName(),
                $serverInfo->getSystemInfo()->getOsVersion(),
                $serverInfo->getSystemInfo()->getOsArchitecture(),
                $serverInfo->getSystemInfo()->getJavaVm(),
                $serverInfo->getSystemInfo()->getJavaVersion(),
                $serverInfo->getSystemInfo()->getUptime(),
                $serverInfo->getMemoryInfo()->getUsedFormated(),
                $serverInfo->getMemoryInfo()->getTotalFormated(),
                100 - $serverInfo->getMemoryInfo()->getFreePercentage(),
            ));

        $this->info('Connected to realm ' . config('app.keycloak_realms'));
        $this->importGroupToKc();
    }

    public function importGroupToKc(){
        $groups = File::get(base_path() . '/node_scripts/groups.json');
        $raw = json_decode($groups);

        $groups = $raw->groups;

        $iterableGroups = [];

        foreach ($groups as $group) {
            $iterableGroups[] = KCHelper::buildKcGroupRecursively($group);
        }

        $GroupCollection = new GroupCollection($iterableGroups);
        $this->info($GroupCollection->first()->jsonSerialize());
    }
}
