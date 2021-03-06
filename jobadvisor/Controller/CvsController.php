<?php
App::uses('AppController', 'Controller');
/**
 * Cvs Controller
 *
 * @property Cv $Cv
 * @property PaginatorComponent $Paginator
 */
class CvsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Cv->recursive = 0;
		$this->set('cvs', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Cv->exists($id)) {
			throw new NotFoundException(__('Invalid cv'));
		}

		$this->Cv->bindModel(array('hasMany' => array(
				'CompletedExperience' => array(
					'className' => 'Experience',
					'conditions' => array('end_date < NOW()'),
					)
				))
			);

		$options = array('conditions' => array('Cv.' . $this->Cv->primaryKey => $id));
		$this->set('cv', $this->Cv->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Cv->create();
			if ($this->Cv->save($this->request->data)) {
				$this->Session->setFlash(__('The cv has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cv could not be saved. Please, try again.'));
			}
		}
		$jobs = $this->Cv->Job->find('list');
		$this->set(compact('jobs'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Cv->exists($id)) {
			throw new NotFoundException(__('Invalid cv'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Cv->save($this->request->data)) {
				$this->Session->setFlash(__('The cv has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cv could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cv.' . $this->Cv->primaryKey => $id));
			$this->request->data = $this->Cv->find('first', $options);
		}
		$jobs = $this->Cv->Job->find('list');
		$this->set(compact('jobs'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cv->id = $id;
		if (!$this->Cv->exists()) {
			throw new NotFoundException(__('Invalid cv'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Cv->delete()) {
			$this->Session->setFlash(__('Cv deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Cv was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}

	public function saving_examples() {
		$data = array(
			'first_name' => 'Peter',
			'last_name' => 'Parker',
			'telephone' => '123443',
			'email' => 'pparker@example.com',
			'bio' => 'Bio goes here...',
			);
		// $this->Cv->create();
		// $saveResult = $this->Cv->save($data);	// returns the record in an array

		$complexData = array(
			'Cv' => array(
				'first_name' => 'Miss',
				'last_name' => 'Shepard',
				'telephone' => '123443',
				'email' => 'shep@n7.com',
				'bio' => 'Bio goes here...',
				),
			'Education' => array(
				array('name' => 'first', 'description' => 'first description'),
				array('name' => 'second', 'description' => 'second description')
				)
			);
		// $this->Cv->create();
		// $saveResult = $this->Cv->saveAssociated($complexData);	// now contains a bool result

		$inverseData = array(
			'Cv' => array(
				'first_name' => 'Mr',
				'last_name' => 'Shepard',
				'telephone' => '123443',
				'email' => 'manshep@n7.com',
				'bio' => 'Bio goes here...',
				),
			'Education' => array(
				'name' => 'third',
				'description' => 'third description'
				)
			);
		$this->Cv->Education->create();
		$saveResult = $this->Cv->Education->saveAssociated($inverseData);	// now contains a bool result

		debug($saveResult);
		$this->autoRender = false;
	}
}
