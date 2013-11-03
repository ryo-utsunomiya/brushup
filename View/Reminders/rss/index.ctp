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
    'year'       => date('Y', $postTime),
    'month'      => date('m', $postTime),
    'day'        => date('d', $postTime)
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

  echo $this->Rss->item(
    array(),
    array(
         'title'       => $reminder['Reminder']['title'],
         'link'        => $postLink,
         'guid'        => array('url' => $postLink, 'isPermaLink' => 'true'),
         'description' => $bodyText,
         'pubDate'     => $reminder['Reminder']['created']
    )
  );
}
?>