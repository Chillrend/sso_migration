<?php

namespace App\Console\Commands;

use App\Http\Object\KCHelper;
use App\Support\KeycloakInstance;
use Fschmtt\Keycloak\Collection\GroupCollection;
use Fschmtt\Keycloak\Keycloak;
use Fschmtt\Keycloak\Representation\Group;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Keycloak\Admin\KeycloakClient;

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
        $this->importGroupToKc($keycloak);
    }
     */

    public function handle()
    {
        $client = KeycloakInstance::getKeycloakInstanceWaleed();
        $this->info("Connected to KC Instance: Keycloak " . $client->getVersion());

        $this->importGroupToKcWaleed($client);
    }

    public function importGroupToKc(Keycloak $keycloak){
        $groups = File::get(base_path() . '/node_scripts/groups.json');
        $raw = json_decode($groups);

        $groups = $raw->groups;

        foreach ($groups as $group) {
            $group_to_kc = KCHelper::buildKcGroupRecursively($group);
            $this->info("Running Import on: " . $group_to_kc->getName());
            try {
                $keycloak->groups()->create(config('app.keycloak_realms'), $group_to_kc);
            }catch (ClientException $e){
                $this->error("Error: " . $e->getMessage() . " On : " . $group_to_kc->getName());
            }

        }

        $this->info('Done!');

        $groups = $keycloak->groups()->all(config('app.keycloak_realms'));
        $this->info(sprintf('Realm "%s" has the following groups:%s', config('app.keycloak_realms'), PHP_EOL));

    }

    public function importGroupToKcWaleed(KeycloakClient $client){
        $groups = File::get(base_path() . '/node_scripts/groups.json');
        $raw = json_decode($groups);

        $groups = $raw->groups;
        $this->info(json_encode($groups));

        $response = $client->createGroup($groups);
    }
}
