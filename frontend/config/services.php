<?php

declare(strict_types=1);

use Monolog\Processor\PsrLogMessageProcessor;
use CeladnaZS\Web\Services\Doctrine\FixDoctrineMigrationTableSchema;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function(ContainerConfigurator $configurator): void
{
    $parameters = $configurator->parameters();

    # https://symfony.com/doc/current/performance.html#dump-the-service-container-into-a-single-file
    $parameters->set('.container.dumper.inline_factories', true);

    $parameters->set('doctrine.orm.enable_lazy_ghost_objects', true);

    $parameters->set('strapi.api_uri', env('STRAPI_API_URL'));
    $parameters->set('strapi.api_key', env('STRAPI_API_KEY'));

    $services = $configurator->services();

    $services->defaults()
        ->autoconfigure()
        ->autowire()
        ->public();

    $services->set(PdoSessionHandler::class)
        ->args([
            env('DATABASE_URL'),
        ]);

    $services->set(PsrLogMessageProcessor::class)
        ->tag('monolog.processor');

    // Controllers
    $services->load('CeladnaZS\\Web\\Controller\\', __DIR__ . '/../src/Controller/**/{*.php}');

    // Components
    $services->load('CeladnaZS\\Web\\Components\\', __DIR__ . '/../src/Components/**/{*.php}');

    // Repositories
    $services->load('CeladnaZS\\Web\\Repository\\', __DIR__ . '/../src/Repository/{*Repository.php}');

    // Form types
    $services->load('CeladnaZS\\Web\\FormType\\', __DIR__ . '/../src/FormType/**/{*.php}');

    // Message handlers
    $services->load('CeladnaZS\\Web\\MessageHandler\\', __DIR__ . '/../src/MessageHandler/**/{*.php}');

    // Console commands
    $services->load('CeladnaZS\\Web\\ConsoleCommands\\', __DIR__ . '/../src/ConsoleCommands/**/{*.php}');

    // Validators
    $services->load('CeladnaZS\\Web\\Validation\\', __DIR__ . '/../src/Validation/**/{*Validator.php}');

    // Services
    $services->load('CeladnaZS\\Web\\Services\\', __DIR__ . '/../src/Services/**/{*.php}');
    $services->load('CeladnaZS\\Web\\Query\\', __DIR__ . '/../src/Query/**/{*.php}');

    /** @see https://github.com/doctrine/migrations/issues/1406 */
    $services->set(FixDoctrineMigrationTableSchema::class)
        ->autoconfigure(false)
        ->arg('$dependencyFactory', service('doctrine.migrations.dependency_factory'))
        ->tag('doctrine.event_listener', ['event' => 'postGenerateSchema']);
};
