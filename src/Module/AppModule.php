<?php
namespace MyVendor\Ticket\Module;

use BEAR\Package\AbstractAppModule;
use BEAR\Package\PackageModule;
use BEAR\Package\Provide\Router\AuraRouterModule;
use BEAR\Resource\Module\JsonSchemaLinkHeaderModule;
use BEAR\Resource\Module\JsonSchemaModule;
use Koriym\QueryLocator\QueryLocatorModule;
use MyVendor\Ticket\Annotation\BenchMark;
use MyVendor\Ticket\Interceptor\BenchMarker;
use MyVendor\Ticket\Logger\LoggerInterface;
use MyVendor\Ticket\Logger\TicketLogger;
use Ray\AuraSqlModule\AuraSqlModule;
use Ray\CakeDbModule\CakeDbModule;
use Ray\IdentityValueModule\IdentityValueModule;
use Ray\Query\SqlQueryModule;

class AppModule extends AbstractAppModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $appDir = $this->appMeta->appDir;
        require_once $appDir . '/env.php';
        $this->install(
            new AuraSqlModule(
                getenv('TKT_DB_DSN'),
                getenv('TKT_DB_USER'),
                getenv('TKT_DB_PASS'),
                getenv('TKT_DB_SLAVE')
            )
        );
        $this->install(new SqlQueryModule($appDir . '/var/sql'));
        $dbConfig = [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'username' => getenv('TKT_DB_USER'),
            'password' => getenv('TKT_DB_PASS'),
            'database' => getenv('TKT_DB_NAME'),
            'host' => getenv('TKT_DB_HOST'),
        ];
        $this->install(new CakeDbModule($dbConfig));
        $this->install(new IdentityValueModule);
        $this->install(
            new JsonSchemaModule(
                $appDir . '/var/json_schema',
                $appDir . '/var/json_validate'
            )
        );
        $this->install(new JsonSchemaLinkHeaderModule('http://www.example.com/'));
        $this->install(new AuraRouterModule($appDir . '/var/conf/aura.route.php'));
        $this->install(new QueryLocatorModule($appDir . '/var/sql'));
        $this->bind(LoggerInterface::class)->to(TicketLogger::class);
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith(BenchMark::class),
            [BenchMarker::class]
        );
        $this->install(new PackageModule);
    }
}
