<div class="well" onLoad="setTimeout('delayer()', 2000)">
<h1>Success !</h1>
<p>The page will redirect in 3 seconds </p>
<p> or <a href="index.php">click here</a></p>
</div>
<script>
function redirect(){
   window.location = document.URL;
}
setTimeout(redirect, 3000);
</script>