<?php
date_default_timezone_set("Europe/Paris");
include 'rsc/database.php';
global $db; ?>
<header>
		<div>
			<form action="search.php" method="GET">
		           <input type="text" name="query" id="search-bar" placeholder="Rechercher...">
		           <button type="submit"><span class="material-symbols-outlined fs-30">search</span></button>
		    </form>
		    <a class="header-button" href="new_recipe.php"><span class="material-symbols-outlined fs-30">add</span></a>
		</div>
		<div class="title-container">
			<p class="title-p">
				TomaneetRomas
			</p>
		</div>
		<div>
			<a class="header-button" href="notifications.php"><span class="material-symbols-outlined fs-30">mail</span></a>
			<a class="header-button" href="settings_menu.php"><span class="material-symbols-outlined fs-30">settings</span></a>
			<?php
			if(!isset($_SESSION['userid'])){
				echo '<a class="header-button" href="login.php"><span class="material-symbols-outlined fs-30">login</span> Connexion</a>';
			} else {
				echo '<a class="header-button" href="logout.php"><span class="material-symbols-outlined fs-30">logout</span>' . $_SESSION['username'] . ' - Déconnexion</a>';
			}
			?>
		</div>
	</header>