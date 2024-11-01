<?php
/**
 * $LastChangedDate: 2010-05-31 07:42:36 -0500 (Mon, 31 May 2010) $
 */
if (count(debug_backtrace()) === 0) exit();
?>
<script type="text/javascript">
	var wpPageRizeClassName = "<?php echo $className; ?>";
	var wpPageRizeDefaultCondition = "<?php echo $defaultCondition; ?>";
<?php if ($pageNumber > 0): ?>
	var wpPageRizePageNumberFalse = false;
<?php endif; ?>
<?php if (!empty($customInsertPos)): ?>
	var wpPageRizeCustomInsertPos = "<?php echo $customInsertPos; ?>";
<?php endif; ?>
	var wpPageRizeLoadingMethod = "<?php echo $loadingMethod; ?>";
	var wpPageRizeButtonValue = "<?php echo $buttonValue; ?>";
	var wpPageRizeFullPath = "<?php echo $pluginFullPath; ?>";
<?php if (!empty($beforeCall)): ?>
	var wpPageRizeBeforeCall = function() {
<?php
	$lines = explode("\n", str_replace(array("\r\n", "\r", "\n"), "\n", $beforeCall));
	foreach ($lines as $line) {
		echo "\t\t$line" . PHP_EOL;
	}
?>
	}
<?php endif; ?>
<?php if (!empty($callback)): ?>
	var wpPageRizeCallback = function() {
<?php
	$lines = explode("\n", str_replace(array("\r\n", "\r", "\n"), "\n", $callback));
	foreach ($lines as $line) {
		echo "\t\t$line" . PHP_EOL;
	}
?>
	}
<?php endif; ?>
</script>
<script type="text/javascript" src="<?php echo $pluginFullPath; ?>wp-autopagerize.js"></script>
