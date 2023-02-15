<?php

namespace App\Console\Commands;

use App\Support\KeycloakInstance;
use Illuminate\Console\Command;

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

        $users = $keycloak->users()->all(config('app.keycloak_realms'));

        $this->info(sprintf('Realm "%s" has the following users:%s', config('app.keycloak_realms'), PHP_EOL));
        foreach ($users as $user) {
            $this->info(sprintf('-> User "%s"%s', $user->getUsername(), PHP_EOL));
        }

    }
}
