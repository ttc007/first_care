<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

use Cake\Log\Log;

use App\ModelView\BlogModelView;
use App\Service\BlogsService;
use App\DTO\BlogDTO;


/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class BlogsController extends AppController
{
    var $blogService;

    public function initialize()
    {
        $this->loadComponent('GiantPaginate');
        $this->loadComponent('Flash');
        parent::initialize();

        $this->blogsService = new BlogsService();
    }
    
    public function index()
    {
        $blogs = $this->GiantPaginate->paginate($this->blogsService->find(null));
        $this->set(compact('blogs'));
    }

    public function add()
    {
        $blogModelView = new BlogModelView($this->request->getData());
        $errors = [];
        if ($this->request->is('post')) {

            $errors = $blogModelView->validate();
            if($errors){
                $this->set(compact('blogModelView', 'errors'));
                return;
            }
            $blogDTO = new BlogDTO($blogModelView);
            $this->blogsService->save($blogDTO);
            $this->Flash->success(__('The blog has been saved.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('blogModelView', 'errors'));
    }

    public function edit($id)
    {
        $blogModelView = $this->blogsService->get($id);
        $errors = [];
        if ($this->request->is(['post', 'put'])) {
            $blogModelView = new BlogModelView($this->request->getData());
            
            $errors = $blogModelView->validate();
            if($errors){
                $this->set(compact('blogModelView', 'errors'));
                return;
            }

            $blogDTO = new BlogDTO($blogModelView);
            $this->blogsService->save($blogDTO);
            $this->Flash->success(__('The blog has been saved.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('blogModelView', 'errors'));
    }

    public function delete($id)
    {
        $this->blogsService->delete($id);
        $this->Flash->success(__('The blog has been deleted.'));
        return $this->redirect(['action' => 'index']);
    }
}
