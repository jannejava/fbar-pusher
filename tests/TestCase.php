<?php
namespace Eastwest\FBar\Test;
use Eastwest\FBar\FbarServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return lasselehtinen\MyPackage\MyPackageServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [FBarServiceProvider::class];
    }
    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'FBar' => FBar::class,
        ];
    }
}