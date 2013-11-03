<?php

App::uses('Reminder', 'Model');

class ReminderTest extends CakeTestCase {

  public function setUp()
  {
    parent::setUp();
    $this->Reminder = ClassRegistry::init('Reminder');
  }

  public function tearDown()
  {
    unset($this->Reminder);
    parent::tearDown();
  }

  public function testタイトルは必須入力である()
  {
    $this->Reminder->create(array('Reminder' => array('title' => '')));
    $this->assertFalse($this->Reminder->validates());
    $this->assertArrayHasKey('title', $this->Reminder->validationErrors);
  }
}