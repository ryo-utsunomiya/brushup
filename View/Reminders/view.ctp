<?php $rem = (object)$reminder['Reminder']; ?>

<h2><?php echo h($rem->title); ?></h2>

<p style="border:solid 1px #ddd; background-color: #eee; padding: 1em"><?php echo nl2br(h($rem->body)); ?></p>
<p>
  <?php echo $this->Html->link('編集', '/reminders/edit/' . $rem->id); ?>
  <?php echo $this->Html->link('削除', '#', array('class' => 'delete', 'data-reminder-id' => $rem->id)); ?>
</p>
<table style="width:25%;">
  <tr>
    <th>登録日</th>
    <td><?php echo date('Y-m-d', strtotime(h($rem->created))); ?></td>
  </tr>
  <tr>
    <th>次回の復習日</th>
    <td><?php echo h($rem->next_learn_date); ?></td>
  </tr>
  <tr>
    <th>残り復習回数</th>
    <td><?php echo h($completed_count - $rem->repeat_count); ?></td>
  </tr>
</table>

<?php
if (strtotime($rem->next_learn_date) < time()) : // 「復習しました」ボタンは復習日が来るまで表示しない
  echo $this->Form->create('Reminder', array('action' => 'repeat/' . $rem->id));
  echo $this->Form->end('復習しました！');
endif;
?>

<?php
echo $this->Form->create('Reminder', array('id' => 'delete_form', 'action' => 'delete/' . $rem->id));
echo $this->Form->end();
?>

<script type="text/javascript">
  $(function() {
    $("a.delete").click(function() {
      if (confirm("この復習を削除します。よろしいですか？")) {
        $("#delete_form").submit();
      }
      return false;
    });
  });
</script>