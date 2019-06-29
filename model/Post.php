<?php
include_once BASEPATH . 'core/AModel.php';
include_once BASEPATH . 'core/Authentication.php';

class Post extends AModel
{

    // Change table to view
    function DetailsMode()
    {
        self::SetTable('post_details');
        self::SetReadOnly(true);
        self::SetPrimaryKey('MasterID');
        self::SetProperties(array(
            'MasterID' => NULL,
            'Title' => NULL,
            'ID' => NULL,
            'Submit' => NULL,
            'UserID' => NULL,
            'Username' => NULL,
            'Body' => NULL,
            'Type' => NULL,
            'Level' => NULL,
            'RefrenceID' => NULL,
            'Index' => NULL,
            'Status' => NULL,
            'Language' => NULL,
            'BinContent' => NULL,
        ));
    }

    // Model level auth
    private $username = '';
    private $token = '';
    function AuthConstruct($username, $token)
    {
        $this->username = $username;
        $this->token = $token;
    }
    function ValidateAutomatic($Role)
    {
        $result = Authentication::ValidateToken($this->username, $this->token)
        && Authentication::ValidateRole($this->username, $Role);

        if (!$result)
			$this->httpstatus = "HTTP/1.0 401 Unauthorized";
		else
		{
			// TODO: SQL INJECTION BUG ON $Username and $Token
			// Functionalities::SQLINJECTIOENCODE
			$user = (new User())->Select(0 , 1, 'Id' ,'ASC', "WHERE `Username`='" . $Username . "'")[0];
			$UserID = $user['Id'];
			$UserRole = $user['Role'];
		}

		return array(
			"Username" => $Username,
			"UserID" => $UserID,
			"UserRole" => $UserRole,
			"Result" => $result);
    }

	function __construct()
	{
		self::SetTable('posts');
		self::SetProperties(array(
			// 'KEY' => DEFAULT_VALUE,
            'MasterId' => Functionalities::GenerateGUID(),
            'Id' => NULL,
            'Title' => '',
            'Submit' => constant("DATETIMENOW"),
            'Type' => NULL,
            'Level' => 1,
            'BinContent' => NULL,
            'Body' => '',
            'UserId' => NULL,
            'Status' => 'SENT',
            'Language' => 'en-us',
            'RefrenceId' => NULL,
            'Index' => '0',
            'IsDeleted' => '0',
            'IsContentDeleted' => '0',
		));
    }


    // =========== Programmer interface ❤️

    // @override
    // Commonly used for /explore/
    function Select($Skip = -1 , $Take = -1, $OrderField = 'Id', $OrderArrange = 'ASC', $Clause = '')
    {
        self::DetailsMode();
        $rows = parent::Select($Skip, $Take, $OrderField, $OrderArrange, $Clause);
        self::__construct();
        return $rows;
    }

    function SendPost($masterid, $title, $level, $content, $body, $status, $language)
    {
        $validate = ValidateAutomatic(2);

        if (!$validate["Result"])
            return false;

        self::SetValue("Body", $_POST['body']);
        self::SetValue("Index", Functionalities::IfExistsIndexInArray($_POST, 'index'));
        self::SetValue("UserId", $validate['UserID']);
        self::SetValue("Submit", $_POST['submit']);
        self::SetValue("Language", $_POST['language']);

        self::Insert();

        // SendKeyword() automatically based on $body

        if ($content['size'] > 0)
        {
            $Post->SetOperand("BinContent");
            $Post->SetValue("BinContent", ',' . urlencode(base64_encode(file_get_contents($_FILES['content']['tmp_name']))));
            $Post->Update();
        }
    }
    function DeletePostAttachment($masterid)
    {
        // TODO:
        // Duplicate post before delete attachment to have complete change log
        // $row = $Post->Select(-1, 1, 'Id', 'DESC', "WHERE `MasterID`='" . $MasterID . "'");
        // Renew the masterid
        // $Post->Insert();

        $Post->SetOperand("IsContentDeleted");
        $Post->SetValue("IsContentDeleted", "1");
        $Post->Update();
        $Post->ClearOperands("IsContentDeleted");
    }
    function DeletePost($masterid)
    {
        // TODO:
        // Duplicate post before delete attachment to have complete change log
        // $row = $Post->Select(-1, 1, 'Id', 'DESC', "WHERE `MasterID`='" . $MasterID . "'");
        // Renew the masterid
        // $Post->Insert();

        $Post->SetOperand("IsDeleted");
        $Post->SetValue("IsDeleted", "1");
        $Post->Update();
        // Attention: Maybe there is a bug when deleting a post <> $CURRENTLANGUAGE or $PATHINFO or etc ...
        $Post->ClearOperands("IsDeleted");
    }

    function SendComment($postid, $body)
    {

    }
    function SendKeyword($postid, $body)
    {

    }

    function SendFile($tilte, $content)
    {

    }
    
}
?>