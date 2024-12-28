
<header class="header">
    <h2 class="u-name">
        <?php
        // Check if a company is logged in
        if (isset($_SESSION['company_name']) && !empty($_SESSION['company_name'])) {
            // Display the company name
            echo htmlspecialchars($_SESSION['company_name']);
            
            // If subscription name is available, append it
            if (isset($_SESSION['subscription_name']) && !empty($_SESSION['subscription_name'])) {
                echo " - " . htmlspecialchars($_SESSION['subscription_name']);
            }
        } else {
            // If no company is logged in, show the default name
            echo "Pat Mac <b>Tech</b>";
        }
        ?>
        <label for="checkbox">
            <i id="navbtn" class="fa fa-bars" aria-hidden="true"></i>
        </label>
    </h2>
    <span class="notification" id="notificationBtn">
        <i class="fa fa-bell" aria-hidden="true"></i>
        <span id="notificationNum"></span>
    </span>
</header>

<div class="notification-bar" id="notificationBar">
	<ul id="notifications">
	
	</ul>
</div>
<script type="text/javascript">
	var openNotification = false;

	const notification = ()=> {
		let notificationBar = document.querySelector("#notificationBar");
		if (openNotification) {
			notificationBar.classList.remove('open-notification');
			openNotification = false;
		}else {
			notificationBar.classList.add('open-notification');
			openNotification = true;
		}
	}
	let notificationBtn = document.querySelector("#notificationBtn");
	notificationBtn.addEventListener("click", notification);
</script>

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script type="text/javascript">
	$(document).ready(function(){

       $("#notificationNum").load("app/notification-count.php");
       $("#notifications").load("app/notification.php");

   });
</script>