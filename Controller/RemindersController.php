<?php

/**
 * Class RemindersController
 */
class RemindersController extends AppController
{
  public $helpers = array('Html', 'Form', 'Text');
  public $components = array('RequestHandler');
  private $spans = array('+ 1 day', '+ 1 week', '+ 2 week', '+ 1 month', '+ 6 month');
  private $count_of_complete;

  /**
   *
   */
  public function beforeFilter()
  {
    $this->count_of_complete = count($this->spans);
  }

  /**
   *
   */
  public function index()
  {
    $this->today();
  }

  /**
   * 今日の復習を表示
   */
  public function today()
  {
    $this->set('count_of_complete', $this->count_of_complete);

    if ($this->RequestHandler->isRss()) {
      $this->set('reminders', $this->findTodayReminders());
    }

    $this->set('reminders', $this->findTodayReminders());
  }

  /**
   * すべての復習を表示
   */
  public function all()
  {
    $this->set('reminders', $this->Reminder->find('all'));
  }

  /**
   * 復習の詳細を表示
   *
   * @param null $id
   */
  public function view($id = null)
  {
    $this->Reminder->id = $id;
    $this->set('reminder', $this->Reminder->read());
    $this->set('completed_count', $this->count_of_complete);
  }

  /**
   * 新しい復習を追加
   */
  public function add()
  {
    if ($this->request->is('post')) {
      $this->request->data['Reminder']['next_learn_date'] = $this->getFirstLearnDate(); // 最初の復習日を設定
      if ($this->Reminder->save($this->request->data)) {
        $this->Session->setFlash('保存しました！');
        $this->redirect(array('action' => 'all'));
      } else {
        $this->Session->setFlash('保存失敗。。。');
      }
    }
  }

  /**
   * 復習を編集
   *
   * @param null $id
   */
  public function edit($id = null)
  {
    $this->Reminder->id = $id;
    if ($this->request->is('get')) {
      $this->request->data = $this->Reminder->read();
    }
    if ($this->request->is('post')) {
      if ($this->Reminder->save($this->request->data)) {
        $this->Session->setFlash('保存しました！');
        $this->redirect(array('action' => 'view/' . $id));
      } else {
        $this->Session->setFlash('保存失敗。。。');
      }
    }
  }

  /**
   * 復習を削除
   *
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
    if ($this->request->is('post')) {
      if ($this->Reminder->delete($id)) {
        $this->Session->setFlash('削除しました！');
      } else {
        $this->Session->setFlash('削除失敗。。。');
      }
    }
    $this->redirect(array('action' => 'all'));
  }

  /**
   * 復習した
   *
   * @param $id
   */
  public function repeat($id)
  {
    if ($this->request->is('post')) {
      $this->update($id);
      if ($this->Reminder->save($this->request->data)) {
        $this->Session->setFlash('保存しました！');
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('保存失敗。。。');
      }

    }
  }

  /**
   * @return bool|string
   */
  private function getFirstLearnDate()
  {
    return date('Y-m-d', strtotime($this->spans[0]));
  }

  /**
   * @param $id
   * @return bool|string
   */
  private function getNextLearnDate($id)
  {
    return date('Y-m-d', strtotime($this->getNextSpan($id)));
  }

  /**
   * 次の復習期間を取得
   *
   * @param $id
   * @return string
   */
  private function getNextSpan($id)
  {
    $this->Reminder->id = $id;
    $reminder           = $this->Reminder->read();

    return $this->spans[$reminder['Reminder']['repeat_count']];
  }

  /**
   * @return mixed
   */
  private function findTodayReminders()
  {
    $options = array('conditions' => array('next_learn_date <= "' . date('Y-m-d', time()) . '"'));

    return $this->Reminder->find('all', $options);
  }

  /**
   * @param $id
   */
  private function update($id)
  {
    $this->Reminder->id = $id;
    $this->request->data = $this->Reminder->read();
    $this->request->data['Reminder']['repeat_count'] += 1;
    if ($this->request->data['Reminder']['repeat_count'] === $this->count_of_complete) { // 復習完了した場合
      $this->request->data['Reminder']['completed']       = 1;
      $this->request->data['Reminder']['next_learn_date'] = null;
    } else {
      $this->request->data['Reminder']['next_learn_date'] = $this->getNextLearnDate($id);
    }
  }
}