<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	?>

    <section class="container">
        <div class="row">

        </div>
    </section>

	<?php
	include('footer.php');
}
?>