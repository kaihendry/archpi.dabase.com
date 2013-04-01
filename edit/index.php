<!DOCTYPE html>
<html>
<head>
<style>
body {
	font-family: "Helvetica Neue", sans-serif;
}
textarea { width: 100%; height: 20em; }
</style>
<link rel="stylesheet" href="/pagedown/demo.css">
<script src="/pagedown/Markdown.Converter.js"></script>
<script src="/pagedown/Markdown.Sanitizer.js"></script>
<script src="/pagedown/Markdown.Editor.js"></script>
<script src="/pagedown/jquery-1.9.1.min.js"></script>
<title>Page editor</title>
</head>
<body>

<pre>
<?php
$content = "../index.mdwn";
$style = "../style.css";
if (isset($_POST['content'])) {
	file_put_contents($content, stripslashes($_POST['content']));
}
if (isset($_POST['style'])) {
	file_put_contents($style, stripslashes($_POST['style']));
}
echo `cd .. && make`;
?>
</pre>

<form method=post>
<h1>Content</h1>
<div class="wmd-panel">
<div id="wmd-button-bar"></div>
<textarea class="wmd-input" id="wmd-input" name="content">
<?php readfile($content); ?>
</textarea>
</div>
<div id="wmd-preview" class="wmd-panel wmd-preview"></div>


<p>Write in HTML or <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">markdown</a>.</p>


<h1>Style</h1>
<textarea name=style>
<?php readfile($style); ?>
</textarea>

<input type=submit>

<script>
     var converter1 = Markdown.getSanitizingConverter();
            var editor1 = new Markdown.Editor(converter1);
            editor1.run();
</script>
</form>
</body>
</html>
