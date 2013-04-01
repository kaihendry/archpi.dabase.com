<!DOCTYPE html>
<html>
<head>
<style>
body {
	font-family: "Helvetica Neue", sans-serif;
}
textarea { width: 100%; height: 20em; }
</style>
<title>Page editor</title>
</head>
<body>

<pre>
<?php
$content = "../index.mdwn";
$style = "../style.css";
if (isset($_POST['content'])) {
	file_put_contents($content, stripslashes($_POST['content']));
	echo "<p>Saved content.</p>";
}
if (isset($_POST['style'])) {
	file_put_contents($style, stripslashes($_POST['style']));
	echo "<p>Saved style.</p>";
}
`cd .. && make`;
?>
</pre>

<form method=post>
<h1>Content</h1>
<textarea name=content>
<?php readfile($content); ?>
</textarea>


<h1>Style</h1>
<textarea name=style>
<?php readfile($style); ?>
</textarea>

<input type=submit>
</form>
</body>
</html>
