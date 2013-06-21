<?php
$content = "../index.mdwn";
$style = "../style.css";
include("auth.php");

umask(002);

if (isset($_REQUEST['q'])) {
	$q = preg_replace('@[^-a-z0-9]+@', '', trim(strtolower($_REQUEST['q'])));
	$content = "../" . $q;
	@mkdir($content, 0777, true);
	$content = "../" . $q . "/index.mdwn";
}
if (getAdmin() && isset($_POST['style'])) {
	file_put_contents($style, stripslashes($_POST['style']));
}
if (getAdmin() && isset($_POST['content'])) {
	file_put_contents($content, stripslashes($_POST['content']));
	`cd .. && make`;
	header("Location: http://" . $_SERVER["HTTP_HOST"] . '/' . dirname($content));
}

?>
<!DOCTYPE html>
<html>
<head>
<style>
body { font-family: "Helvetica Neue", sans-serif; }
textarea { width: 100%; height: 20em; }
</style>
<link rel="stylesheet" href="/edit/main.css">
<script src="/edit/jquery.js"></script>
<script src="/edit/main.js"></script>
<script src="/edit/showdown.js"></script>
<title>Editing <?php echo $content; ?></title>
</head>
<body>

<form method=post>

<?php
// Auth bit
if (is_dir_empty($cc)) {
	setAdmin(trim(`head -c 4 /dev/urandom | xxd -p`));
	echo '<p><input type=submit value=Save>Set cookie!</p>';
} elseif (getAdmin()) {
	echo '<p><input type=submit value=Save>Found cookie!</p>';
} else { die('<h1>You do not have write permissions. Someone got the cookie before you?</h1>'); }
?>
<div id="left_column">
<div id="top_panels_container">
<div class="top_panel" id="quick_reference">
<div class="close">×</div>
<table>
<tr>
<td>
<pre><code><span class="highlight">*</span>This is italicized<span class="highlight">*</span>, and <span class="highlight">**</span>this is bold<span class="highlight">**</span>.</code></pre>
</td>
<td><p>Use <code>*</code> or <code>_</code> for emphasis.</p></td>
</tr>
<tr>
<td>
<pre><code>This is a first level header
<span class="highlight">============================</span></code></pre>
</td>
<td><p>You can alternatively put hash marks at the beginning of the line: <code>#&nbsp;H1&nbsp;#</code>, <code>##&nbsp;H2&nbsp;##</code>, <code>###&nbsp;H3&nbsp;###</code>...</p></td>
</tr>
<tr>
<td>
<pre><code>This is a link to <span class="highlight">[Google](http://www.google.com)</span></code></pre>
</td>
<td><p></p></td>
</tr>
<tr>
<td>
<pre><code>First line.<span class="highlight">  </span>
Second line.</code></pre>
</td>
<td><p>End a line with two spaces for a linebreak.</p></td>
</tr>
<tr>
<td>
<pre><code><span class="highlight">- </span>Unordered list item
<span class="highlight">- </span>Unordered list item</code></pre>
</td>
<td><p>Unordered (bulleted) lists use asterisks, pluses, and hyphens (<code>*</code>, <code>+</code>, and <code>-</code>) as list markers.</p></td>
</tr>
<tr>
<td>
<pre><code><span class="highlight">1. </span>Ordered list item
<span class="highlight">2. </span>Ordered list item</code></pre>
</td>
<td><p>Ordered (numbered) lists use regular numbers, followed by periods, as list markers.</p></td>
</tr>
<tr>
<td><pre><code><span class="highlight">    </span>/* This is a code block */</code></pre></td>
<td><p>Indent four spaces for a preformatted block.</p></td>
</tr>
<tr>
<td><pre><code>Let's talk about <span class="highlight">`</span>&lt;html&gt;<span class="highlight">`</span>!</code></pre></td>
<td><p>Use backticks for inline code.</p></td>
</tr>
<tr>
<td>
<pre><code><span class="highlight">![Valid XHTML](http://w3.org/Icons/valid-xhtml10)</span></code></pre>
</td>
<td><p>Images are exactly like links, but they have an exclamation point in front of them.</p></td>
</tr>
</table>
</div>
</div>

<div class="wrapper">
<div class="overlay">
<a href="#" class="button toppanel" data-toppanel="quick_reference">Quick Reference</a>
<div class="clear"></div>
</div>

<textarea id="markdown" name="content" class="full-height">
<?php readfile($content); ?>
</textarea>
</div>
</div>
<div id="right_column">
<div class="wrapper">
<div class="overlay">
<a href="#" class="button switch" data-switchto="html">HTML</a>
<a href="#" class="button switch" data-switchto="preview">Preview</a>
<div class="clear"></div>
</div>
<textarea id="html" class="full-height"></textarea>
<div id="preview" class="full-height"></div>
</div>
</div>

<textarea id="styleeditor" name=style>
<?php readfile($style); ?>
</textarea>

</form>

<?php if(file_exists("../upload.php")) { ?>
<form id=upload action="/upload.php" method="post" enctype="multipart/form-data">
<p>Upload a file</p>
<input name="f" type="file" />
<input value="Upload" type="submit">
</form>
<?php } ?>

</body>
</html>
