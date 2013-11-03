<h2>Edit Post</h2>

<?php
echo $this->Form->create('Reminder', array('action' => 'edit'));
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => 3));
echo $this->Form->end('save!');
?>