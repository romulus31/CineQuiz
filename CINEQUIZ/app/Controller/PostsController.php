<?php
class PostsController extends AppController {

	public $helpers = array('Html', 'Form');

	public function index() {
		$this->set('posts', $this->Post->find('all')); //Notre model Post est automatiquement
		//disponible via $this->Post, parce que nous avons suivi les conventions de nommage de CakePHP
	}

	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}
		$post = $this->Post->findById($id); 
		if (!$post) {
			throw new NotFoundException(__('Invalid post'));
		}
		$this->set('post', $post);
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Post->create();
			if ($this->Post->save($this->request->data)) { //vérifiera les erreurs de validation et interrompra l’enregistrement si une erreur survient
				$this->Session->setFlash(__('Your post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to add your post.'));
		}
	}

	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}
		$post = $this->Post->findById($id);
		if (!$post) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->Post->id = $id;
			if ($this->Post->save($this->request->data)) {
			}
			$this->Session->setFlash(__('Your post has been updated.'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Unable to update your post.'));

		if (!$this->request->data) {
			$this->request->data = $post;
		}
	}


	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Post->delete($id)) {
			$this->Session->setFlash(
			__('Le post avec id : %s a été supprimé.', h($id))
			);
			return $this->redirect(array('action' => 'index'));
		}
	}
}

/**
 * @todo : comprendre fonction set et find du PostsController
 */
?>

