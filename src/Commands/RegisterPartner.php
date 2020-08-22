<?php

namespace Modelizer\MultiTenent\Commands;

use Illuminate\Console\Application;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Migrations\Migrator;
use Modelizer\MultiTenant\Partner;

class RegisterPartner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'partner:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register a given company into the system';

    /**
     * @param \Illuminate\Database\DatabaseManager $databaseManager
     * @param \Illuminate\Database\Migrations\Migrator $migrator
     * @param \Modelizer\MultiTenant\Partner $partner
     * @throws \Throwable
     */
    public function handle(DatabaseManager $databaseManager, Migrator $migrator, Partner $partner)
    {
        /**
         * | ------------------------------------------------------------------------------------------
         * | Get company details
         * | ------------------------------------------------------------------------------------------
         */
        $this->info('You are about to register a new partner');
        $partnerName = $this->ask('partner name:', 'Qafeen');
        $subDomain = str_slug($this->ask('Partner sub domain?', 'qafeen'));
        $databaseManager->beginTransaction();

        /**
         * | ------------------------------------------------------------------------------------------
         * | Register Host
         * | ------------------------------------------------------------------------------------------
         */
        $partner = $partner->firstOrCreate([
            'uuid' => $subDomain,
            'name' => $partnerName,
        ]);
        $this->registerPartnerHostname($partner);

        /**
         * | ------------------------------------------------------------------------------------------
         * | Create partner database and initialize migration table
         * | ------------------------------------------------------------------------------------------
         */
        $this->info("Creating database and running initial migrations.");
        $databaseManager->statement("CREATE DATABASE {$subDomain};");
        $migrator->setConnection('partner');
        $migrator->run('database/migrations');
        $databaseManager->commit();
    }

    /**
     * @param \Modelizer\MultiTenant\Partner $partner
     * @return mixed
     */
    protected function registerPartnerHostname(Partner $partner)
    {
        return $partner->hostnames()->firstOrCreate([
            'fqdn' => config('multi-tenant.partner').'.'.config('multi-tenant.domain'),
        ]);
    }
}
