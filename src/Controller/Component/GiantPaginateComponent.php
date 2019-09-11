<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use App\ModelView\ModelView;
use Cake\Event\Event;
use Cake\Log\Log;

/**
 * 
 */
class GiantPaginateComponent extends Component
{
	var $controller = null;

	var $limit = 4;
	var $page = 1;
	var $count;

 	public function startup(Event $event)
    {
        $this->setController($event->getSubject());
    }

    public function setController($controller)
    {
        $this->controller = $controller;
        if (!isset($this->controller->paginate)) {
            $this->controller->paginate = [];
        }
    }

	public function paginate($query){
		$controllerName = (new \ReflectionClass($this->controller))->getShortName();
		$request = $this->controller->getRequest();
		$session = $request->getSession();

		if($request->query('page')) {
			$session->write('GiantPaginate.'.$controllerName.'.page', $request->query('page'));
			$this->page = $request->query('page');
		} elseif($session->read('GiantPaginate.'.$controllerName.'.page')) {
			$this->page = $session->read('GiantPaginate.'.$controllerName.'.page');
		}
		$this->setCount($query);
		$query->limit($this->limit)->page($this->page);
		$stmt = $query->execute();
		$rows = $stmt->fetchAll('assoc');

		$modelViews = [];
    	foreach ($rows as $key => $row) {
    		$modelViews[] = new ModelView($row);
    	}

    	$paginator = ['count'=> $this->count, 'limit' => $this->limit, 'page' => $this->page];

    	$this->controller->set('paginator', $paginator);
		return $modelViews;
	}

	public function adjust($options){
		if(isset($options['limit'])) {
			$this->limit = $options['limit'];
		}
	}

	public function setCount($query){
		$cleanQuery = clone $query;
		$this->count = $cleanQuery->select(['count' => $query->func()->count('*')])->execute()->fetch('assoc')['count'];;
	}
}