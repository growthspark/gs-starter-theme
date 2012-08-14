<?php

$default = 'Enter keywords...';

?>
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
    <p><input type="text" class="field" name="s" id="s"  value="<?php echo $default; ?>" onfocus="if (this.value == '<?php echo $default; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $default; ?>';}" />
    <input type="submit" class="submit" name="submit" value="search" /></p>
</form>

<?php ?>