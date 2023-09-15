<?php
require_once("top.php");
require_once("connection.php");

?>
<div id="middle">
    <form action=addAgent.php method=post id="formGeneral">
        <h2><?php echo $translations["ADD_ADMIN_FORM"] ?></h2><br>
        <label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
        <table id="formFields">
            <tr>
                <td id=lblFixed><?php echo $translations["USERNAME"] ?><mark id=asterisk>*</mark></td>
                <td><input type=text name=txtUser required></td>
            </tr>
            <tr>
                <td id=lblFixed><?php echo $translations["PASSWORD"] ?><mark id=asterisk>*</mark></td>
                <td><input type=password name=txtPassword required></td>
            </tr>
            <tr>
                <td id=lblFixed><?php echo $translations["PRIVILEGE"]["NAME"] ?><mark id=asterisk>*</mark></td>
                <td>
                    <select name=txtPrivilegeLevel>
                        <option value=<?php echo $privilegeLevelsArray["ADMINISTRATOR_LEVEL"] ?>> <?php echo $translations["PRIVILEGE"][0] ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan=2><br>
                    <input id="registerButton" type=submit value="<?php echo $translations["LABEL_REGISTER_BUTTON"] ?>">
                </td>
            </tr>
        </table>
    </form>
</div>