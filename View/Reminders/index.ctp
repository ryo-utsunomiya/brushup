<h2>今日の復習一覧</h2>

<ul>
  <?php foreach($reminders as $reminder): ?>
    <li id="reminder_<?php  echo h($reminder['Reminder']['id']);?>">
      <?php echo $this->Html->link($reminder['Reminder']['title'], '/reminders/view/' . $reminder['Reminder']['id']); ?>
      <?php echo $this->Html->link('編集', '/reminders/edit/' . $reminder['Reminder']['id']); ?>
      <?php echo $this->Html->link('削除', '#', array('class' => 'delete', 'data-reminder-id' => $reminder['Reminder']['id'])); ?>
    </li>
  <?php endforeach; ?>
</ul>

<h2>復習を追加</h2>
<?php echo $this->Html->link('復習を追加', array('controller' => 'reminders', 'action' => 'add')); ?>

<script type="text/javascript">
  $(function() {
    $("a.delete").click(function(e) {
      if (confirm("sure?")) {
        $.post("/cake_brushup/reminders/delete/" + $(this).data("reminder-id"), {}, function(res) {
          $("#reminder_" + res.id).fadeOut();
        }, "json");
      }
      return false;
    });
  });
</script>