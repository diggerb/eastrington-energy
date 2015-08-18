	<input type="checkbox" id="menutoggle" autocomplete="off">

	<div id="menu">
		<div id="menuleft">
			<div id="menuitembox">
				<a href="search.php">
					<div id="search">Search</div>
				</a>

				<a href="index.php">
					<div class="menuitem">Home</div>
				</a>
				
				<?php

				if($this->_user->isLoggedIn()){
					if($this->_user->hasPermission('admin')){
						?>

				<a href="upload.php">
					<div class="menuitem">Upload</div>
				</a>


						<?php
					}
				?>

				<a href="profile.php?user=<?php echo escape($this->_user->data()->username); ?>">
					<div class="menuitem">Profile</div>
				</a>
				<a href="logout.php">
					<div class="menuitem">Logout</div>
				</a>

				<?php
				} else {
				?>

				<a href="login.php">
					<div class="menuitem">Login</div>
				</a>
				<a href="register.php">
					<div class="menuitem">Register</div>
				</a>

				<?php
				}
				?>

				<a href="">
					<div class="menuitem">Newsletter - Coming Soon</div>
				</a>
			</div>
		</div>

		<label for="menutoggle">
			<div id="menuright">
				<div id="menutogglecontainer">
					<div id="menuicon"><p>&#8801;</p></div>
					<p id="menuiconmenu">menu</p>
				</div>
			</div>
		</label>
	</div>