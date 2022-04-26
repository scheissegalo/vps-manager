<?php

add_action('wp_ajax_myfilter', 'misha_filter_function'); // wp_ajax_{ACTION HERE} 

function misha_filter_function(){
	//var_dump($_POST);
	//print "Gehts?";
	if (isset($_POST['filterLetter'])){
		//print 'FilterLetter: '.$_POST['filterLetter'];
		//print 'act: '.$_POST['act'];
		//print 'type: '.$_POST['serviceType'];
		
		if ($_POST['serviceType'] == "service"){
			if ($_POST['act'] == "start"){
				$output1 = shell_exec('sudo service '.$_POST['filterLetter'].' start');
				//print "Service: ".$_POST['filterLetter']." started";
				print $output1;
			}elseif($_POST['act'] == "stop"){
				$output1 = shell_exec('sudo service '.$_POST['filterLetter'].' stop');
				//print "Service: ".$_POST['filterLetter']." stopped";
				print $output1;
			}elseif($_POST['act'] == "restart"){
				$output1 = shell_exec('sudo service '.$_POST['filterLetter'].' restart');
				//print "Service: ".$_POST['filterLetter']." restarted";
				print $output1;
			}

		}elseif($_POST['serviceType'] == "docker"){
			if ($_POST['act'] == "start"){
				$output1 = shell_exec('sudo docker stop '.$_POST['filterLetter']);
				//print "Service: ".$_POST['filterLetter']." started";
				print $output1;
			}elseif($_POST['act'] == "stop"){
				$output1 = shell_exec('sudo docker start '.$_POST['filterLetter']);
				//print "Service: ".$_POST['filterLetter']." stopped";
				print $output1;
			}elseif($_POST['act'] == "restart"){
				$output1 = shell_exec('sudo docker restart '.$_POST['filterLetter']);
				//print "Service: ".$_POST['filterLetter']." restarted";
				print $output1;
			}
		}
		
		print enable_controls_function();
		
		die();
	}
}

function theme_scripts() {
  wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'theme_scripts');

if ( is_user_logged_in() ) {
	
	if (isset($_GET['service'])){
		//ButtonPressed
		//print 'button pressed';
		
		if ($_GET['action'] == "stop"){
			//print 'action stop';
			//print 'service '.$_GET['service'].' stop';
			//$output1 = shell_exec('sudo whoami');
			$output1 = shell_exec('sudo service '.$_GET['service'].' stop');
		}elseif ($_GET['action'] == "start"){
			$output1 = shell_exec('sudo service '.$_GET['service'].' start');
		}elseif ($_GET['action'] == "restart"){
			$output1 = shell_exec('sudo service '.$_GET['service'].' restart');
		}
		
		print $output1;
	}elseif(isset($_GET['docker'])){
		if ($_GET['action'] == "stop"){
			$output1 = shell_exec('sudo docker stop '.$_GET['docker']);
		}elseif ($_GET['action'] == "start"){
			$output1 = shell_exec('sudo docker start '.$_GET['docker']);
		}elseif ($_GET['action'] == "restart"){
			$output1 = shell_exec('sudo docker restart '.$_GET['docker']);
		}
	}
}

 function dotiavatar_function() {
     return '<img src="http://dayoftheindie.com/wp-content/uploads/avatar-simple.png" 
    alt="doti-avatar" width="96" height="96" class="left-align" />';
}
add_shortcode('dotiavatar', 'dotiavatar_function');

function ts3_function() {
	require_once("/var/www/html/klabausterbeere/ts3ssv.php");
	$ts3ssv = new ts3ssv("localhost", 10011);
	$ts3ssv->useServerPort(9987);
	$ts3ssv->imagePath = "/img/default/";
	$ts3ssv->timeout = 2;
	$ts3ssv->setLoginPassword("serveradmin", "lfRYaFRf");
	$ts3ssv->hideEmptyChannels = false;
	$ts3ssv->hideParentChannels = false;
	$ts3ssv->showNicknameBox = false;
	$ts3ssv->showPasswordBox = false;
	return $ts3ssv->render();
}
add_shortcode('ts3', 'ts3_function');

function menuButtons() {
	$contents = '';
	if ( is_user_logged_in() ) {
		$contents .= '<div class="wp-block-button is-style-fill">
						<a class="wp-block-button__link has-vivid-red-background-color has-background" href="#" style="border-radius:15px" target="_blank" rel="# noopener">
							PHP My Admin
						</a>
					</div>';
	}
	
	$contents .= '<div class="wp-block-button is-style-fill">
					<a class="wp-block-button__link has-vivid-red-background-color has-background" href="#" style="border-radius:15px" target="_blank" rel="# noopener">
						Sinusbot
					</a>
				</div>';
				
	$contents .= '<div class="wp-block-button is-style-fill">
					<a class="wp-block-button__link has-vivid-red-background-color has-background" href="#" style="border-radius:15px" target="_blank" rel="# noopener">
						KB-Chat
					</a>
				</div>';
	$contents .= '<div class="wp-block-button is-style-fill">
					<a class="wp-block-button__link has-vivid-red-background-color has-background" href="#" style="border-radius:15px" target="_blank" rel="# noopener">
						Forum
					</a>
				</div>';
	$contents .= '<div class="wp-block-button is-style-fill">
					<a class="wp-block-button__link has-vivid-red-background-color has-background" href="#" style="border-radius:15px" target="_blank" rel="# noopener">
						Rona Roller
					</a>
				</div>';
	
	return $contents;
}
add_shortcode('mb', 'menuButtons');

function displaySinceYear() { // We Have our business Since xx years auto update
	$sdate = "2001-02-04";
	$edate = date("Y-m-d");
	//print "$edate | $sdate";

	$date_diff = abs(strtotime($edate) - strtotime($sdate));

	$years = floor($date_diff / (365*60*60*24));
	$months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

	return $years;
}
add_shortcode('since', 'displaySinceYear');

function HumanSize($Bytes)
{
  $Type=array("", "kilo", "mega", "giga", "tera", "peta", "exa", "zetta", "yotta");
  $Index=0;
  while($Bytes>=1024)
  {
    $Bytes/=1024;
    $Index++;
  }
  return("".floor($Bytes)." ".$Type[$Index]."bytes");
}

function get_server_memory_usage(){

	// Linux MEM
	$free = shell_exec('free');
	$free = (string)trim($free);
	$free_arr = explode("\n", $free);
	$mem = explode(" ", $free_arr[1]);
	$mem = array_filter($mem, function($value) { return ($value !== null && $value !== false && $value !== ''); }); // removes nulls from array
	$mem = array_merge($mem); // puts arrays back to [0],[1],[2] after 
	$memtotal = round($mem[1] / 1000000,2);
	$memused = round($mem[2] / 1000000,2);
	$memfree = round($mem[3] / 1000000,2);
	$memshared = round($mem[4] / 1000000,2);
	$memcached = round($mem[5] / 1000000,2);
	$memavailable = round($mem[6] / 1000000,2);

	$percent = round((float)$memfree * 100 ) . '%';
    //return $memused."GB/".$memtotal."GB - ".$percent;
    return $memfree."GB available - ".$memused."GB used/".$memtotal."GB total";
	
}

function get_server_cpu_usage(){

    $load = sys_getloadavg();
	$percent = round((float)$load[0] * 100 ) . '%';
    return $percent;

}

function enable_controls_function(){

	$returnst = '<script> 
					   function clickAndDisable(link) {
							event.preventDefault();
							link.innerHTML = \'Please Wait...\';
							window.open(link.href, "_self");
							//var elem = document.getElementById(\'ctlbutton\');
							//elem.innerHTML = \'Disabled\';
							var elements = document.getElementsByClassName("ctlbutton");
							for(var i=0; i<elements.length; i++) {
								elements[i].innerHTML = \'Please Wait...\';
								event.preventDefault();
							}
					   } 
					   
					</script>';

	if ( is_user_logged_in() ) {
   		//code for logged in user 
   		//
		$serverVersion = shell_exec('lsb_release -a');
		$serverHost = shell_exec('uname -r');
		global $current_user;
   		$returnst .= '<div align="center" class="controlholder">';
		$returnst .= '<h2>Servermanager</h2>';
		$returnst .= '<h4>Hi, '.$current_user->user_login.'</h4>';
		$df = disk_free_space("/");
		$spacepc = floor(100 * disk_free_space("/") / disk_total_space("/"));
		
		$returnst .= '<div><span class="bold">Free Space: </span>'.HumanSize($df).' ('.$spacepc.'%) |
				<span class="bold">RAM: </span>'.get_server_memory_usage().' | 
				<span class="bold">CPU usage: </span>'.get_server_cpu_usage().'</div>';
		$returnst .= '<div><span class="bold">Server infos: </span>'.$serverVersion.'</div>';
		$returnst .= '<div><span class="bold">Uname: </span>'.$serverHost.'</div>';
		$returnst .= '<h4 style="font-size:20px;">WARNING! Only click on the buttons if you know what you are doing!</h4>';
		$returnst .= '<div align="center" class="filter">
				<form action="https://klabausterbeere.xyz/wp-admin/admin-ajax.php" method="POST" id="filter">
					<button id="button_A" class="button-4 buttongreen button_B" value="re" name="filterLetter">Refresh</button>
					<input type="hidden" name="action" value="myfilter">
					<input type="hidden" name="serviceType" value="nix">
					<input type="hidden" name="act" value="stop">
				</form></div>';
		$returnst .= checkService('teamspeak','Teamspeak', true, "VOIP Service", false);
		$returnst .= checkService('tsbanner','TS Banner', true, "Banner Clock in TS", false);
		$returnst .= checkService('sinusbot','Sinusbot', true, "Teamspeak Bot", false);
		$returnst .= checkService('satisfactory','Satisfactory', true, "Game Server", false);
		$returnst .= checkDockerService('fervent_visvesvaraya','Empyrion', "Game Server", false);
		//print checkService('valheim','Valheim', false, "Game Server");
		$returnst .= checkService('matrix-synapse','Matrix', true, "Message Server", false);
		
		//wp_logout_url();
		$returnst .= '<p></p> ';
		
		$returnst .= '<div align="center" class="filter">
						<form action="https://klabausterbeere.xyz/wp-admin/admin-ajax.php" method="POST" id="filter">
							<button id="button_A" class="button-4 buttonred button_B" value="reboot" name="filterLetter">Server Reboot</button>
							<input type="hidden" name="action" value="myfilter">
							<input type="hidden" name="serviceType" value="cmd">
							<input type="hidden" name="act" value="stop">
						</form>	
						<form action="https://klabausterbeere.xyz/wp-admin/admin-ajax.php" method="POST" id="filter">						
							<button class="button-4 button_B buttonorange" value="clean" name="filterLetter">Clean Cache</button>
							<input type="hidden" name="action" value="myfilter">
							<input type="hidden" name="serviceType" value="cmd">
							<input type="hidden" name="act" value="stop">
						</form>	
						<form action="https://klabausterbeere.xyz/wp-admin/admin-ajax.php" method="POST" id="filter">							
							<button class="button-4 button_B buttonorange" value="sinus" name="filterLetter">Sinusbot Debug</button>
							<input type="hidden" name="action" value="myfilter">
							<input type="hidden" name="serviceType" value="cmd">
							<input type="hidden" name="act" value="restart">
						</form></div>';
					
/* 		$returnst .= '<div id="response" class="newTitle">
							<h3 align="center">Please press the button to test</h3>
					</div>'; */
		$returnst .= '<div id="loading" style="display:none"><img src="https://klabausterbeere.xyz/load.gif" /></div><h4><div id="results">Please wait, still loading!</div></h4>';
		$returnst .= '<br><br><a href="'.wp_logout_url($redirect = home_url()).'">Logout</a></p><br><br><span class="madeby">VPS Manager v1.0 made by <a href="https://karich.design/">Karich.Design</a></span></div>';

		$returnst .= '<script>
						jQuery(function($){

							$("button").click(function(e) 
							{
								if (this.value === "reboot") {
									//alert(this.value);
									if (window.confirm("Do you really want to reboot the server?")) {
										//window.open("exit.html", "Thanks for Visiting!");
										alert("Full Reboot in around 15 sec.");
										alert("This feature is currently disabled!");
									}
								}

								if (this.value === "clean") {
									//alert(this.value);
									if (window.confirm("Do you really want to clean the server cache?")) {
										//window.open("exit.html", "Thanks for Visiting!");
										alert("What you want to clean?");
										alert("This feature is currently disabled!");
									}
								}
								
								if (this.value === "sinus") {
									//alert(this.value);
									if (window.confirm("Do you really want to debug Sinusbot?")) {
										//window.open("exit.html", "Thanks for Visiting!");
										alert("Cleaning and debugging process is around 5-10 sec");
										alert("This feature is currently disabled!");
									}
								}
								
								e.preventDefault();
								var formData = $(this).closest(\'form\').serializeArray();
								formData.push({ name: this.name, value: this.value });
								//now use formData, it includes the submit button
								var filter = $(\'#filter\');
								$(\'#loading\').show();
								$.ajax({
									url:\'https://klabausterbeere.xyz/wp-admin/admin-ajax.php\',
									data:formData,
									type: "post", // POST
									beforeSend:function(xhr){
										//filter.find(\'#response\').text(\'Loading...\'); 
										$(".button_B").attr("disabled", true);
										//$(\'#response\').html(\'<div align="center" class="testloader"><h2>Please Wait....</h2></div>\');
										$(\'#results\').html(\'Please Wait....\');
									},
									success:function(data){
										$(\'#response\').html(data); // insert data
										$(".button_B").attr("disabled", false);
										$(\'#results\').html(\'Ready\');
										$(\'#loading\').hide();
									},
									error: function(xhr) { // if error occured
										//alert("Error occured.please try again");
										//$(\'#response\').html(xhr.statusText + xhr.responseText); // insert data
										$(".button_B").attr("disabled", false);
										$(\'#results\').html(\'Error!\');
										$(\'#loading\').hide();
									}
								});
							});

						});


</script>';
		
	} else {
		$returnst .= '<div align="center" class="controlholder bggreen">';
		$returnst .= '<h2>Server Infos</h4>';
		$returnst .= checkService('teamspeak','Teamspeak', true, "VOIP Service", true);
		$returnst .= checkService('tsbanner','TS Banner', true, "Banner Clock in TS", true);
		$returnst .= checkService('sinusbot','Sinusbot', true, "Teamspeak Bot", true);
		$returnst .= checkService('satisfactory','Satisfactory', true, "Game Server", true);
		$returnst .= checkDockerService('fervent_visvesvaraya','Empyrion', "Game Server", true);
		//$returnst .= checkService('valheim','Valheim', false, "Game Server");
		$returnst .= checkService('matrix-synapse','Matrix', true, "Message Server", true);
		$returnst .= '<br><br><a href="'.wp_login_url($redirect = home_url()).'">Login</a> to control Server';
		//$returnst .= '<a href="http://klabausterbeere.xyz/wp-login.php">Login</a> to Serveradmin-Panel';
		$returnst .= '</div>';
	}
	
    return $returnst;
}

//document.getElementById("ctlbutton").addEventListener("click", submitPoll);</script>';
	
	
	

add_shortcode('admin_controls', 'enable_controls_function');


function checkDockerService($service, $servicename, $descript, $isPublic){
	//docker ps -a | grep fervent_
	$output = shell_exec("sudo docker ps -a | grep $service");
	//print "docker ps -a | grep $service";
	$returnstring = 'Nothing to return';
	if ($isPublic){
		if (preg_match('/\Up\b/', $output)){
			//is active
			$returnstring = '	<div class="boxcontrol" align="center">
							<div class="boxcontrolchild"><h2 class="boxcontroltitle">'.$servicename.'</h2><p>'.$descript.'</p></div>
							<div><h4 class="boxcontrolactive">&#9989; ONLINE</h4></div>
						</div>';
		}else{
			//is inactive
			$returnstring = '	<div class="boxcontrol" align="center">
							<div class="boxcontrolchild"><h2 class="boxcontroltitle">'.$servicename.'</h2><p>'.$descript.'</p></div>
							<div><h4 class="boxcontrolnotactive">&#10060; OFFLINE</h4></div>
						</div>';
		}	
	}else{
		if (preg_match('/\Up\b/', $output)){
			//is active
			$returnstring = '	<div class="boxcontrol" align="center">
							<div class="boxcontrolchild"><h2 class="boxcontroltitle">'.$servicename.'</h2><p>'.$descript.'</p></div>
							<div><h4 class="boxcontrolactive">&#9989; ONLINE</h4></div>
							<button class="button_B button-4 buttonred" value="'.$service.'" name="filterLetter">stop</button>
							<input type="hidden" name="action" value="myfilter">
							<input type="hidden" name="serviceType" value="docker">
							<input type="hidden" name="act" value="stop">
							</form>
							<form action="https://klabausterbeere.xyz/wp-admin/admin-ajax.php" method="POST" id="filter">
							<button class="button_B button-4 buttonorange" value="'.$service.'" name="filterLetter">restart</button>
							<input type="hidden" name="action" value="myfilter">
							<input type="hidden" name="serviceType" value="docker">
							<input type="hidden" name="act" value="restart">
							</form>
						</div>';
		}else{
			//is inactive
			$returnstring = '	<div class="boxcontrol" align="center">
							<div class="boxcontrolchild"><h2 class="boxcontroltitle">'.$servicename.'</h2><p>'.$descript.'</p></div>
							<div><h4 class="boxcontrolnotactive">&#10060; OFFLINE</h4></div>
							<form action="https://klabausterbeere.xyz/wp-admin/admin-ajax.php" method="POST" id="filter">
							<button class="button_B button-4 buttongreen" value="'.$service.'" name="filterLetter">start</button>
							<input type="hidden" name="action" value="myfilter">
							<input type="hidden" name="serviceType" value="docker">
							<input type="hidden" name="act" value="start">
							</form>
						</div>';
		}		
	}
	
	return $returnstring;
}

function checkService($service, $servicename, $status, $descript, $isPublic){
	//$output = shell_exec("pgrep $service");
	$output = shell_exec("sudo systemctl is-active $service");
	$returnstring = 'Nothing to return';
	//print '|'.$output.'|';
	//print "sudo systemctl is-active $service";
	
	//if (str_contains($output, 'active')){
	if ($status == true){
		if ($isPublic){
			if (preg_match('/\bactive\b/', $output)){
				//is active
				$returnstring = '	<div class="boxcontrol" align="center">
								<div class="boxcontrolchild"><h2 class="boxcontroltitle">'.$servicename.'</h2><p>'.$descript.'</p></div>
								<div><h4 class="boxcontrolactive">&#9989; ONLINE</h4></div>
							</div>';
			}else{
				//is inactive
				$returnstring = '	<div class="boxcontrol" align="center">
								<div class="boxcontrolchild"><h2 class="boxcontroltitle">'.$servicename.'</h2><p>'.$descript.'</p></div>
								<div><h4 class="boxcontrolnotactive">&#10060; OFFLINE</h4></div>
							</div>';
			}		
		}else{
			if (preg_match('/\bactive\b/', $output)){
				//is active
				$returnstring = '	<div class="boxcontrol" align="center">
								<div class="boxcontrolchild"><h2 class="boxcontroltitle">'.$servicename.'</h2><p>'.$descript.'</p></div>
								<div><h4 class="boxcontrolactive">&#9989; ONLINE</h4></div>
								<form action="https://klabausterbeere.xyz/wp-admin/admin-ajax.php" method="POST" id="filter">
								<button class="button_B button-4 buttonred" value="'.$service.'" name="filterLetter">stop</button>
								<input type="hidden" name="action" value="myfilter">
								<input type="hidden" name="serviceType" value="service">
								<input type="hidden" name="act" value="stop">
								</form>
								<form action="https://klabausterbeere.xyz/wp-admin/admin-ajax.php" method="POST" id="filter">
								<button class="button_B button-4 buttonorange" value="'.$service.'" name="filterLetter">restart</button>
								<input type="hidden" name="action" value="myfilter">
								<input type="hidden" name="serviceType" value="service">
								<input type="hidden" name="act" value="restart">
								</form>
							</div>';

			}else{
				//is inactive
				$returnstring = '	<div class="boxcontrol" align="center">
								<div class="boxcontrolchild"><h2 class="boxcontroltitle">'.$servicename.'</h2><p>'.$descript.'</p></div>
								<div><h4 class="boxcontrolnotactive">&#10060; OFFLINE</h4></div>
								<form action="https://klabausterbeere.xyz/wp-admin/admin-ajax.php" method="POST" id="filter">
								<button class="button_B button-4 buttongreen" value="'.$service.'" name="filterLetter">start</button>
								<input type="hidden" name="action" value="myfilter">
								<input type="hidden" name="serviceType" value="service">
								<input type="hidden" name="act" value="start">
								</form>
							</div>';
			}		
		}
	}else{
		if ($isPublic){}else{
			
			$returnstring = '	<div class="boxcontrol" align="center">
					<div class="boxcontrolchild"><h2 class="boxcontroltitle">'.$servicename.'</h2><p>'.$descript.'</p></div>
					<div><h4 class="boxcontrolnotactive">&#10060; Disabled</h4></div>
					<a href="#"><button class="button-4 buttonred" role="button" >Disabled</button></a>
				</div>';
		}
	}
	
	return $returnstring;
}
?>
