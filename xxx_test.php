<!DOCTYPE html>
<html>
<head>
	<title>BHRA Leaf Raking</title>
</head>
<body>

<h1> ---- Example Forms from W3C HTML 5 Specification ---</h1>
<b>http://www.w3.org/TR/html5/forms.html#forms</b>

<h3>4.10.1.1 Writing a form's user interface</h3>



	<form method="post"
	enctype="application/x-www-form-urlencoded"
	action="http://localhost/BHRA-raking-merge-tool/xxx_test_yang.php">

	<br><label>Customer name:<input name="custname" required></label>
	<br><label>Telephone: <input type=tel></label>
	<br><label>E-mail address: <input type=email></label>

	<fieldset>
		<legend> Pizza Size </legend>
		<br><label> <input type=radio name=size required value="small"> Small </label>
		<br><label> <input type=radio name=size required value="medium"> Medium </label>
		<br><label> <input type=radio name=size required value="large"> Large </label>
	</fieldset>

	<fieldset>
		<legend> Pizza Toppings </legend>
		<br><label> <input type=checkbox name="topping" value="bacon"> Bacon </label>
		<br><label> <input type=checkbox name="topping" value="cheese"> Extra Cheese </label>
		<br><label> <input type=checkbox name="topping" value="onion"> Onion </label>
		<br><label> <input type=checkbox name="topping" value="mushroom"> Mushroom </label>
	</fieldset>

	<br><label>Preferred delivery time: <input type=time min="11:00" max="21:00" step="900" name="delivery" required></label>
	<br><label>Delivery instructions:   <textarea name="comments" maxlength=30></textarea></label></p>
	<br><label>This is a Label</label>
	<br><textarea name="comments"></textarea>
	<br><input type=checkbox name="topping" value="mushroom">

	<br><label>Temperature1:
<input type="range" min="-100" max="100" value="0" step="10" name="power" list="powers">
<datalist id="powers">
 <option value="0">
 <option value="-30">
 <option value="30">
 <option value="++50">
</datalist>
	</label>


<h3>4.10.5 The input element</h3>
<h4>4.10.5.1 States of the type attribute</h4>
<h5>4.10.5.1.1 Hidden state (type=hidden)</h5>
<h5>4.10.5.1.2 Text (type=text) state and Search state (type=search)</h5>
<h5>4.10.5.1.3 Telephone state (type=tel)</h5>
<h5>4.10.5.1.4 URL state (type=url)</h5>

<br><label>Homepage: <input name=hp type=url list=hpurls></label>
<datalist id=hpurls>
  <option value="http://www.reddit.com/" label="Reddit"></option>
  <option value="http://www.google.com/" label="Google"></option>
</datalist>

<h5>4.10.5.1.5 E-mail state (type=email)</h5>
<h5>4.10.5.1.6 Password state (type=password)</h5>
<h5>4.10.5.1.7 Date state (type=date)</h5>
<h5>4.10.5.1.8 Time state (type=time)</h5>
<h5>4.10.5.1.9 Number state (type=number)</h5>
<h5>4.10.5.1.10 Range state (type=range)</h5>
<h5>4.10.5.1.11 Color state (type=color)</h5>
<br><label>Color: <input name=col type=color></label>

<h5>4.10.5.1.12 Checkbox state (type=checkbox)</h5>
<h5>4.10.5.1.13 Radio Button state (type=radio)</h5>
<h5>4.10.5.1.14 File Upload state (type=file)</h5>


<br><label>The File ( C:\Users\cwinsor\Documents\me\BHRA_2015\Leaf Raking ): 
<input name=thefile type=file multiple></label>





<p>
 <label>
  Enter a breed:
  <input type="text" name="breed" list="breeds">
  <datalist id="breeds">
   <option value="Abyssinian">
   <option value="Alpaca">
   <!-- ... -->
  </datalist>
 </label>
</p>

<fieldset>
 <legend>Mail Account</legend>
 <p><label>Name: <input type="text" name="fullname" placeholder="John Ratzenberger"></label></p>
 <p><label>Address: <input type="email" name="address" placeholder="john@example.net"></label></p>
 <p><label>Password: <input type="password" name="password"></label></p>
 <p><label>Description: <input type="text" name="desc" placeholder="My Email Account"></label></p>
</fieldset>


<p>
 <label for="unittype">Select unit type:</label>
 <select id="unittype" name="unittype">
  <option value="1"> Miner </option>
  <option value="2"> Puffer </option>
  <option value="3" selected> Snipey </option>
  <option value="4"> Max </option>
  <option value="5"> Firebot </option>
 </select>
</p>

<h1>datalist</h1>
<label>
 Sex:
 <input name=sex list=sexes>
 <datalist id=sexes>
  <option value="Female">
  <option value="Male">
 </datalist>
</label>

<h1>optgroup</h1>
 <p>Which course would you like to watch today?
 <p><label>Course:
  <select name="c">
   <optgroup label="8.01 Physics I: Classical Mechanics">
    <option value="8.01.1">Lecture 01: Powers of Ten
    <option value="8.01.2">Lecture 02: 1D Kinematics
    <option value="8.01.3">Lecture 03: Vectors
   <optgroup label="8.02 Electricity and Magnestism">
    <option value="8.02.1">Lecture 01: What holds our world together?
    <option value="8.02.2">Lecture 02: Electric Field
    <option value="8.02.3">Lecture 03: Electric Flux
   <optgroup label="8.03 Physics III: Vibrations and Waves">
    <option value="8.03.1">Lecture 01: Periodic Phenomenon
    <option value="8.03.2">Lecture 02: Beats
    <option value="8.03.3">Lecture 03: Forced Oscillations with Damping
  </select>
 </label>
 <p><input type=submit value="▶ Play">

<h1>textarea(read-only)</h1>
 <p><label>Filename: <code>/etc/bash.bashrc</code>
<textarea name="buffer" readonly>
# System-wide .bashrc file for interactive bash(1) shells.

# To enable the settings / commands in this file for login shells as well,
# this file has to be sourced in /etc/profile.

# If not running interactively, don't do anything
[ -z "$PS1" ] &amp;&amp; return

</textarea>
</label>


<h1>submit</h1>
	<br><button>Submit order</button>
</form>



<form action="processkey.cgi" method="post" enctype="multipart/form-data">
<h1>keygen</h1>
 <p><keygen name="key"></p>
 <p><input type=submit value="Submit key..."></p>
</form>

<form onsubmit="return false" oninput="o.value = a.valueAsNumber + b.valueAsNumber">
<h1>output (as a local processor)</h1>
 <input name=a type=number step=any> +
 <input name=b type=number step=any> =
 <output name=o for="a b"></output>
</form>

 <!-- var primeSource = new WebSocket('ws://primes.example.net/'); 
<form>
<h1>output (websocket message recipient)</h1>
<output id="result"></output>
<script>
 primeSource.onmessage = function (event) {
   document.getElementById('result').value = event.data;
 }
</script>
</form>
-->

<section>
<h1>WebSocket Test</h1>
<script language="javascript" type="text/javascript">
var wsUri = "ws://echo.websocket.org/";
var output;
function init() {
	output = document.getElementById("output");
	testWebSocket();
}
function testWebSocket() {
	websocket = new WebSocket(wsUri);
	websocket.onopen = function(evt) {
		onOpen(evt)
	};
	websocket.onclose = function(evt) {
		onClose(evt) 
	};
	websocket.onmessage = function(evt) {
		onMessage(evt) 
	};
	websocket.onerror = function(evt) {
		onError(evt) 
	};
}
function onOpen(evt) {
	writeToScreen("CONNECTED");
	doSend("WebSocket rocks"); 
}
function onClose(evt) {
	writeToScreen("DISCONNECTED"); 
}
function onMessage(evt) {
	writeToScreen('<span style="color: blue;">RESPONSE: ' + evt.data+'</span>');
	websocket.close(); 
}
function onError(evt) {
	writeToScreen('<span style="color: red;">ERROR:</span> ' + evt.data); 
}
function doSend(message) {
	writeToScreen("SENT: " + message);  websocket.send(message); 
}
function writeToScreen(message) {
	var pre = document.createElement("p");
	pre.style.wordWrap = "break-word";
	pre.innerHTML = message; output.appendChild(pre);
}
window.addEventListener("load", init, false);
</script>
<h2>WebSocket Test</h2>
<div id="output"></div>
</section>


<section>
 <h1>Task Progress</h1>
 <p>Progress: <progress id="p" max=100><span>0</span>%</progress></p>
 <script>
  var progressBar = document.getElementById('p');
  function updateProgress(newValue) {
    progressBar.value = newValue;
    progressBar.getElementsByTagName('span')[0].textContent = newValue;
  }
 </script>
</section>

<section>
 <h1>Meter</h1>
Storage space usage: <meter value=6 max=8>6 blocks used (out of 8 total)</meter>
Voter turnout: <meter value=0.75><img alt="75%" src="graph75.png"></meter>
Tickets sold: <meter min="0" max="100" value="75"></meter>
</section>

<section>
Something: <meter min=0 max=60 value=23.2 title=seconds></meter>
</section>

<h1>Meter groups</h1>
<ul>
 <li>
  <p><a href="/group/comp.infosystems.www.authoring.stylesheets/view">comp.infosystems.www.authoring.stylesheets</a> -
     <a href="/group/comp.infosystems.www.authoring.stylesheets/subscribe">join</a></p>
  <p>Group description: <strong>Layout/presentation on the WWW.</strong></p>
  <p><meter value="0.5">Moderate activity,</meter> Usenet, 618 subscribers</p>
 </li>
 <li>
  <p><a href="/group/netscape.public.mozilla.xpinstall/view">netscape.public.mozilla.xpinstall</a> -
     <a href="/group/netscape.public.mozilla.xpinstall/subscribe">join</a></p>
  <p>Group description: <strong>Mozilla XPInstall discussion.</strong></p>
  <p><meter value="0.25">Low activity,</meter> Usenet, 22 subscribers</p>
 </li>
 <li>
  <p><a href="/group/mozilla.dev.general/view">mozilla.dev.general</a> -
     <a href="/group/mozilla.dev.general/subscribe">join</a></p>
  <p><meter value="0.25">Low activity,</meter> Usenet, 66 subscribers</p>
 </li>
</ul>

<section>
<form>
	<h1>autofocus</h1>
<input maxlength="256" name="q" value="" >
<input type="submit" value="Search">
</form>
</section>


<label>Feeling: <input name=f type="text" oninput="check(this)"></label>
<script>
 function check(input) {
   if (input.value == "good" ||
       input.value == "fine" ||
       input.value == "tired") {
     input.setCustomValidity('"' + input.value + '" is not a feeling.');
   } else {
     // input is fine -- reset the error message
     input.setCustomValidity('hmm');
   }
 }
</script>


<h1> ------- 4.10.22 Form submission ------</h1>



<h2> ------- get handling ------</h2>
<?php
if (isset($_GET['submitA'])) {
		echo 'got a get';
}
?>

<h2> ------- get form ------</h2>
<form action="xxx_test.php" method=get>
 <input type=text name=t>
 <input type=search name=q>
 <input type=submit name=submitA>
</form>


<h2> ------- post handling ------</h2>
<?php
if (isset($_POST['submitB'])) {
	echo 'got a post';
}
?>

<h2> ------- post form ------</h2>
<form action="xxx_test.php" method=post enctype="multipart/form-data">
 <input type=text name=t>
 <input type=search name=q>
 <input type=submit name=submitB value="Submit">
</form>

<?php
echo '<br> $_GET: ';
var_dump($_GET);
echo '<br> $_POST: ';
var_dump($_POST);
?>

</body>
</html>

