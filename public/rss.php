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
$Sender = Functionalities::IfExistsIndexInArray($PATHINFO, 3);
$output = '<?xml version="1.0" encoding="UTF-8" ?>
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
';

$rows = $PostDetail->Select(-1, 10, "Submit", "DESC",
"WHERE `Language` = '" . $Language . "'" . 
(($Sender != null) ? " AND CONCAT('@',`Username`) LIKE '@%'" : ""));
foreach ($rows as $row) {
    $output .= '
    <item>
    <title>' . $row['Title'] . '</title>
    <link>' . $BASEURL . 'view/' . $row['Language'] . '/' . $row['MasterID'] . '</link>
    <description>
    ' . $row['Body'] . '
    </description>
    <author>' . $row['Username'] . '</author>
    <pubDate>' . $row['Submit'] . '</pubDate>
    <enclosure url="' . $BASEURL . 'download.php?id=' . $row['MasterID'] . '" />
    </item>
';
}
?>
<?php
if (!$AJAX)
{
    echo str_replace("\n", "<br/>", htmlentities($output));
    echo '</channel>
</rss>
    </code>
</pre>
';
}
else
{
    echo $output;
    echo '</channel>
</rss>';
}

?>
