<h2>復習を追加</h2>

<?php
echo $this->Form->create('Reminder');
echo $this->Form->input('title');
echo $this->Form->input('body', ['rows' => 3]);
echo $this->Form->end('復習を保存');
?>