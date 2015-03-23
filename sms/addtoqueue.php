<?php
        $number = $_POST['number'];
        $template = $_POST['template'];
        $custom = $_POST['custom'];

        $xml = simplexml_load_file("defaultTemplate.xml") or die("Error: Cannot create object");
        $variables = array();
        $data = html_entity_decode($xml->data);
        $pos = strpos($data, "<variable>") + 10;
        $pos2 = strpos($data, "</variable>");
        $len = strlen($data);
        while ($len > 0)
        {
            $variable = substr($data,$pos, $pos2 - $pos);
            $data = substr($data,$pos2 + 11);
            $pos = strpos($data, "<variable>") + 10;
            $pos2 = strpos($data, "</variable>");
            $len = strlen($data);
            if (strlen($variable) > 0)
                $variable[] = $variable;
        }
?>
<html>
<head>
    <title>
        Insert messages to queue
    </title>
</head>
<body>
<form method="post">
    <label for="number">Phone Number: </label><input type="text" name="number"><br>
    <label for="template">Template Name: </label><input type="text" name="template" value="defaultTemplate.xml"><br>
    <label for="custom">Custom Template: </label><br><textarea name="custom"></textarea><br>
    <?php
    foreach ($variables as $variable)
    echo "<label for=\"{$variable}\">{$variable}: </label><input type=\"text\" name=\"{$variable}\" value=\"{$variable}\"><br>";
    ?>
    <input type="submit">
</form>
</body>
</html>