		<?php
		 
		if($this->session->userdata('logged_in') == TRUE)
		{
			echo anchor('/logout', 'logout');
		}
		else
		{
			echo $login_form;
		}