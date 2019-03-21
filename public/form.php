<?php

$lines = explode('\n', str_replace('\\' . '\n', '\n', $row['Body']));
$ItemTitles = explode(",", $lines[0]);
$ItemTypes = explode(",", $lines[1]);
$form_last_item = sizeof($ItemTitles) - 1;

?>

<div class="imagebg"></div>
<div class="container">
    <div class="form-container z-depth-5">
        <a href="<?php echo $BASEURL . 'say/QUST/' . $Language . '/' . $row['MasterID'] ?>">(<?php echo Translate::Label('Edit') ?>)</a>
        <h3>
            <?php echo $row['Title'] ?>
        </h3> 
        <div class="row">
            <form class="col s12">
                <?php
                for ($i = 0; $i < $form_last_item; $i++)
                {
                    echo '
                <div class="row">
                    <div class="input-field col s12">
                        <label for="name">' . $ItemTitles[$i] . '</label>
                ';
                    switch ($ItemTypes[$i])
                    {
                        case "":
                            break;
                        default:
                            echo '<input type="text" name="field-' . ($i + 1) . '" required class="validate form-control">';
                            break;
                    }
                    echo '
                    </div>
                </div>
                    ';
                }
                ?>
                <div>
                    <button class="btn form-control" type="submit">Submit</button>
                </div>
            </form>
            <!-- <div id="error_message" style="width:100%; height:100%; display:none; ">
                <h4>
                    Error
                </h4>
                Sorry there was an error sending your form. 
            </div>
            <div id="success_message" style="width:100%; height:100%; display:none; ">
                <h4>
                    Success! Your Message was Sent Successfully.
                </h4>
            </div> -->
        </div>
    </div>
</div>
