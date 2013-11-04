<ul>
  <?php foreach ($reminders as $reminder): ?>
    <li id="reminder_<?php echo h($reminder['Reminder']['id']); ?>" class="reminder_item">
      <?php echo $this->Html->link($reminder['Reminder']['title'], '/reminders/view/' . $reminder['Reminder']['id']); ?>
    </li>
  <?php endforeach; ?>
</ul>

<h3 style="margin-top:1em;"><?php echo $this->Html->link('復習を追加', array('controller' => 'reminders', 'action' => 'add')); ?></h3>