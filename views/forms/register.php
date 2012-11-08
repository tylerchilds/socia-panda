<?php echo validation_errors(); ?>

<h3>Register</h3>
<?php echo form_open('auth/register') ?>
    
	<label for="alias">Alias</label> 
	<input type="input" name="alias" value="<?php echo set_value('alias'); ?>" /><br />

	<label for="email">Email</label>
	<input type="input" name="email" value="<?php echo set_value('email'); ?>" /><br />
	
	<label for="password">Password</label>
	<input type="password" name="password" /><br />
	
	<label for="passconf">Password Confirmation</label>
	<input type="password" name="passconf" /><br />
	
	<input type="submit" class="btn btn-primary" name="submit"  value="Register" /> 

</form>