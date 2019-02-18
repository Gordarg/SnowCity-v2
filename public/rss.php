<?php

if (!$AJAX)
    echo '
        <nav class="navbar">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="' . $BASEURL . '">' . Translate::Label(Config::TITLE) . '</a>
            <a type="application/rss+xml" href="' . $BASEURL . 'ajax/rss">' . Translate::Label('خوراک') . '</a>
        </nav>
        <pre class="container"><code class="xml">
';
$Language = $PATHINFO[2] ?? Config::DefaultLanguage;
$output = '
<rss version="2.0">
<channel>
    <title>' . Config::TITLE . '</title>
    <link>' . $BASEURL . '</link>
    <description>' . Config::META_DESCRIPTION . '</description>
    <language>' . $Language . '</language>
    <image>
        <url>https://www.xul.fr/xul-icon.gif</url>
        <link>https://www.xul.fr/en/index.php</link>
    </image>
</channel>

';

// <![CDATA[
//     <img src="http://example.com/img/smiley.gif" alt="Smiley face" />         
// ]>

$rows = $PostDetail->Select(-1, 10, "Submit", "DESC", "");
foreach ($rows as $row) {
    $output .= '
    <item>
    <link>' . $row['Title'] . '</link>
    <description>

    ' . $row['Body'] . '</description>
    </item>
';
}
?>
<?php
if (!$AJAX)
{
    echo str_replace("\n", "<br/>", htmlentities($output));
    echo '</rss>
    </code>
</pre>
';
}
else
{
    echo $output;
    echo '</rss>';
}

?>
