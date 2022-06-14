<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class InstallationControllerTest extends TestCase
{
    /**
     * check if the install api routes exists
     *
     * @return void
     */
    public function test_is_the_install_api_routes_exists()
    {
        $response = $this->get(route('install.index'));

        $response->assertStatus(200);
    }

    /**
     * GET /install return true if not installed
     */
    public function test_get_install_return_false_if_app_not_installed()
    {
        $http_response_header = $this->get(route('install.index'));

        // TODO: use a better way to check the state
        $this->assertTrue($http_response_header->content() == 'false');
    }

    /**
     * install routes won't work if the app already installed
     * assert error 404 [NOT FOUND]
     */
    public function test_install_routes_not_working_if_app_installed()
    {

        Config::set('APP_INSTALLED', true);

        $http_response_header = $this->get(route('install.index'));

        $http_response_header->assertNotFound();
    }

    /**
     * System won't work if the app not installed
     */
    // TODO: work in this situation
    public function system_not_working_if_the_app_not_installed()
    {
        Config::set('APP_INSTALLED', false);

        $http_response_header = $this->get('/');

        $http_response_header->assertForbidden();
    }

    /**
     * Test to create a new app
     */
    public function test_create_new_app()
    {
        $database = [
            'db_name' => 'gymsystem',
            'db_host' => 'localhost',
            'db_port' => 3306,
            'username' => 'dev',
            'password' => 'password'
        ];

        $gym = ['name' => 'gymsystem'];

        $admin = [
            'full_name' => 'Oussama ELJABBARI',
            'email' => 'contact@ojpro.me',
            'password' => 'password'
        ];

        $mix = [
            'database' => $database,
            'gym' => $gym,
            'admin' => $admin
        ];

        $http_response_header = $this->post(route('install.store'), $mix);

        $http_response_header->assertJsonStructure(['success']);
    }
}