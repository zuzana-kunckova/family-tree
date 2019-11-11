<?php

namespace App\Providers;

use GraphAware\Bolt\Configuration;
use GraphAware\Bolt\GraphDatabase;
use GraphAware\Bolt\Protocol\V1\Session;
use Illuminate\Support\ServiceProvider;

class Neo4jServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (
            config('database.connections.neo4j.password_testing')
            === config('database.connections.neo4j.password')
        ) {
            abort(500, 'The passwords for the Neo4j testing database and the live database must be different.');
        }
    }

    public function register()
    {
        $this->app->singleton(Session::class, function ($app) {
            return $this->getClient();
        });
    }

    protected function getClient()
    {
        $testing = (getenv('APP_ENV') === 'testing' || app()->environment() === 'testing');

        $password = $testing
            ? config('database.connections.neo4j.password_testing')
            : config('database.connections.neo4j.password');

        $config = Configuration::newInstance()
            ->withCredentials(config('database.connections.neo4j.username'), $password)
            ->withTimeout(10);

        if (! $testing && config('database.connections.neo4j.use_ssl')) {
            $config = $config->withTLSMode(Configuration::TLSMODE_REQUIRED);
        }
        $driver = GraphDatabase::driver($this->getConnectionString(), $config);

        return $driver->session();
    }

    protected function getConnectionString()
    {
        return sprintf(
            '%s://%s:%s',
            config('database.connections.neo4j.protocol'),
            config('database.connections.neo4j.host'),
            config('database.connections.neo4j.port')
        );
    }

    protected function getConnectionName()
    {
        return config('database.connections.neo4j.protocol') === 'bolt'
            ? 'bolt'
            : 'default';
    }
}
