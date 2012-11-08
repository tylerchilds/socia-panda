<?php echo validation_errors(); ?>

<?php echo form_open('admin/types') ?>

	<label for="typeTitle">Title</label> 
	<input type="input" name="typeTitle" value="<?php echo set_value('typeTitle'); ?>" /><br />

	<input type="submit" name="submit" value="Submit" /> 

</form>
<ul>
<?php foreach ($types as $item): ?>

    <li><?php echo $item['typeTitle'] ?></li>
    
<?php endforeach ?>
</ul>