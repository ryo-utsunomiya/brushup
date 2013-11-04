<?php
/**
 *
 * PHP 5
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
  <?php echo $this->Html->charset(); ?>
  <title>
    <?php echo $title_for_layout; ?>
  </title>
  <link rel="alternate" type="application/rss+xml" title="今日の復習 RSS"
        href="http://133.242.131.107/brushup/reminders/index.rss"/>
  <?php
  echo $this->Html->meta('icon');

  echo $this->Html->css('cake.generic');

  echo $this->fetch('meta');
  echo $this->fetch('css');
  echo $this->fetch('script');
  ?>
  <style type="text/css">
    h1 {
      display: inline;
    }

    #header a {
      font-weight: normal;
    }

    .reminder_item {
      font-size: 1.2em;
    }

  </style>
  <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script type="text/javascript">
    $(function () {
      setTimeout(function () {
        $("#flashMessage").fadeOut("slow");
      }, 800)
    });
  </script>
</head>
<body>
<div id="container">
  <div id="header">
    <h1><?php echo $this->Html->link('絶対復習クローン', '/'); ?></h1>
    <?php echo $this->Html->link('今日の復習', '/'); ?>
    |
    <?php echo $this->Html->link('全ての復習', '/reminders/all'); ?>
    |
    <?php echo $this->Html->link('RSS', '/reminders/index.rss'); ?>
  </div>
  <div id="content">

    <?php echo $this->Session->flash(); ?>

    <?php echo $this->fetch('content'); ?>
  </div>
</div>
<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
