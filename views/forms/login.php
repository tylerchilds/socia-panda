<?php echo validation_errors(); ?>

<h3>Login</h3>
<?php echo form_open('auth/login') ?>

	<label for="alias">Alias</label> 
	<input type="input" name="alias"  /><br />
	
	<label for="password">Password</label>
	<input type="password" name="password" /><br />
	
	<input type="submit" class="btn btn-primary" name="submit" value="Login" /> 

</form>