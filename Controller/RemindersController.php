<?php

/**
 * Class RemindersController
 */
class RemindersController extends AppController
{
  public $helpers = array('Html', 'Form', 'Text');
  public $components = array('RequestHandler');
  private $span = array('+ 1 day', '+ 1 week', '+ 2 week', '+ 1 month', '+ 6 month');
  private $completed_count = 5;

  /**
   *
   */
  public function index()
  {
    if ($this->RequestHandler->isRss()) {
      $this->set('reminders', $this->findTodayReminders());
    }

    $this->set('reminders', $this->findTodayReminders());
  }

  public function all()
  {
    $this->set('reminders', $this->Reminder->find('all'));
  }

  /**
   * @param null $id
   */
  public function view($id = null)
  {
    $this->Reminder->id = $id;
    $this->set('reminder', $this->Reminder->read());
    $this->set('completed_count', $this->completed_count);
  }

  /**
   *
   */
  public function add()
  {
    if ($this->request->is('post')) {
      $this->request->data['Reminder']['next_learn_date'] = date('Y-m-d', strtotime($this->span[0])); // 最初の復習日を設定
      $this->save();
    }
  }

  /**
   * @param null $id
   * @throws BadMethodCallException
   */
  public function edit($id = null)
  {
    $this->Reminder->id = $id;
    if ($this->request->is('get')) {
      $this->request->data = $this->Reminder->read();
    }
    if ($this->request->is('post')) {
      $this->save();
    }
  }

  /**
   * @param null $id
   */
  public function delete($id = null)
  {
    if ($this->request->is('get')) {
      throw new MethodNotAllowedException();
    }
    if ($this->request->is('ajax')) {
      if ($this->Reminder->delete($id)) {
        $this->autoRender = false;
        $this->autoLayout = false;
        $response = ['id' => $id];
        echo json_encode($response);
        exit;
      }
    }
    $this->redirect(['action' => 'index']);
  }

  /**
   * @param null $id
   */
  public function repeat($id = null)
  {
    $this->Reminder->id = $id;
    if ($this->request->is('post')) {
      $this->request->data = $this->Reminder->read();
      $this->request->data['Reminder']['repeat_count'] += 1;
      if ($this->request->data['Reminder']['repeat_count'] === $this->completed_count) { // 復習完了した場合
        $this->request->data['Reminder']['completed']       = 1;
        $this->request->data['Reminder']['next_learn_date'] = null;
      } else {
        $this->request->data['Reminder']['next_learn_date'] = $this->getNextLearnDateById($id);
      }
      $this->save();
    }
  }

  /**
   *
   */
  private function save()
  {
    if ($this->Reminder->save($this->request->data)) {
      $this->Session->setFlash('保存しました！');
      $this->redirect(array('controller' => 'reminders', 'action' => 'index'));
    } else {
      $this->Session->setFlash('保存失敗。。。');
    }
  }

  /**
   * @param $id
   * @return string
   */
  private function getNextSpan($id)
  {
    $this->Reminder->id = $id;
    $reminder           = $this->Reminder->read();

    return $this->span[$reminder['Reminder']['repeat_count']];
  }

  /**
   * @param $id
   * @return bool|string
   */
  private function getNextLearnDateById($id)
  {
    return date('Y-m-d', strtotime($this->getNextSpan($id)));
  }

  /**
   * @return mixed
   */
  private function findTodayReminders()
  {
    $options = array('conditions' => array('next_learn_date <= "' . date('Y-m-d', time()) . '"'));

    return $this->Reminder->find('all', $options);
  }
}