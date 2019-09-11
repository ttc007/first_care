<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.2.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase\Controller;

use App\Controller\PagesController;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\IntegrationTestCase;
use Cake\View\Exception\MissingTemplateException;

/**
 * PagesControllerTest class
 */
class PagesControllerTest extends IntegrationTestCase
{
    public function testAddUnauthenticatedFails()
    {
        // No session data set.
        $this->get('/');

        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
    }
    /**
     * testMultipleGet method
     *
     * @return void
     */
    public function testMultipleGet()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'testing',
                    // other keys.
                ]
            ]
        ]);
        $this->get('/');
        $this->assertResponseCode(200);
        $this->get('/');
        $this->assertResponseCode(200);
    }

    /**
     * testDisplay method
     *
     * @return void
     */
    public function testDisplay()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'testing',
                    // other keys.
                ]
            ]
        ]);
        $this->get('/pages/home');
        $this->assertResponseCode(200);
    }

    /**
     * Test that missing template renders 404 page in production
     *
     * @return void
     */
    // public function testMissingTemplate()
    // {
    //     Configure::write('debug', false);
    //     $this->get('/pages/not_existing');

    //     $this->assertResponseError();
    //     $this->assertResponseContains('Error');
    // }

    /**
     * Test that missing template in debug mode renders missing_template error page
     *
     * @return void
     */
    // public function testMissingTemplateInDebug()
    // {
    //     Configure::write('debug', true);
    //     $this->get('/pages/not_existing');

    //     $this->assertResponseFailure();
    //     $this->assertResponseContains('Missing Template');
    //     $this->assertResponseContains('Stacktrace');
    //     $this->assertResponseContains('not_existing.ctp');
    // }

    /**
     * Test directory traversal protection
     *
     * @return void
     */
    // public function testDirectoryTraversalProtection()
    // {
    //     $this->get('/pages/../Layout/ajax');
    //     $this->assertResponseCode(403);
    //     $this->assertResponseContains('Forbidden');
    // }
}
