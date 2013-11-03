<h2><?php echo h($reminder['Reminder']['title']); ?></h2>

<p style="border:solid 1px #ddd; background-color: #eee; padding: 1em"><?php echo nl2br(h($reminder['Reminder']['body'])); ?></p>
<p><?php echo $this->Html->link('編集', '/reminders/edit/' . $reminder['Reminder']['id']); ?></p>
<p>登録日時：<?php echo h($reminder['Reminder']['created']); ?></p>
<p>残り復習回数：<?php echo h($completed_count - $reminder['Reminder']['repeat_count']); ?></p>

<?php
echo $this->Form->create('Reminder', array('action' => 'repeat/' . $reminder['Reminder']['id']));
echo $this->Form->end('復習しました！');
?>

<script type="text/javascript">
  $(function() {
    $("a.delete").click(function(e) {
      if (confirm("sure?")) {
        $.post("/cakephp/comments/delete/" + $(this).data("comment-id"), {}, function(res) {
          $("#comment_" + res.id).fadeOut();
        }, "json");
      }
      return false;
    });
  });
</script>