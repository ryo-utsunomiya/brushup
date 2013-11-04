<?php
$this->set(
  'channelData',
  array(
       'title'       => "今日の復習",
       'link'        => $this->Html->url('/', true),
       'description' => "今日の復習",
       'language'    => 'ja'
  )
);
foreach ($reminders as $reminder) {
  $postTime = strtotime($reminder['Reminder']['created']);

  $postLink = array(
    'controller' => 'reminders',
    'action'     => 'view',
    $reminder['Reminder']['id'],
  );

  $bodyText = h(strip_tags($reminder['Reminder']['body']));
  $bodyText = $this->Text->truncate(
    $bodyText,
    400,
    array(
         'encoding' => '...',
         'exact'    => true,
         'html'     => true,
    )
  );

  $remain = $count_of_complete - $reminder['Reminder']['repeat_count'];

  echo $this->Rss->item(
    array(),
    array(
         'title'       => $reminder['Reminder']['title'] . '（残り' . $remain . '回）',
         'link'        => $postLink,
         'guid'        => array('url' => $postLink, 'isPermaLink' => 'true'),
         'description' => $bodyText,
         'pubDate'     => $reminder['Reminder']['created']
    )
  );
}
?>