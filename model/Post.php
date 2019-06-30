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
        self::SetPrimaryKeyType('String');
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
			return false;
		else
		{
			// TODO: SQL INJECTION BUG ON $Username and $Token
			// Functionalities::SQLINJECTIOENCODE
			$user = (new User())->Select(0 , 1, 'Id' ,'ASC', "WHERE `Username`='" . $this->username . "'")[0];
			$UserID = $user['Id'];
			$UserRole = $user['Role'];
        }
        
		return array(
			"Username" => $this->username,
			"UserID" => $UserID,
			"UserRole" => $UserRole,
			"Result" => $result);
    }

	function __construct()
	{
        self::SetTable('posts');
        self::SetPrimaryKey('Id');
        self::SetPrimaryKeyType('Int');
        self::SetReadOnly(false);
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
        $validate = self::ValidateAutomatic(2);

        if (!$validate["Result"])
            return false;

        self::SetValue("MasterId", $masterid);
        self::SetValue("Title", $title);
        self::SetValue("Body", $body);
        self::SetValue("Level", $level);
        self::SetValue("UserId", $validate['UserID']);
        self::SetValue("Status", $status);
        self::SetValue("Language", $language);
        self::SetValue("Type", "POST");

        $result = !self::Insert();

        if (!$result instanceof Exception)
        {
            
            // SendKeyword() automatically based on $body

            if ($content['size'] > 0)
            {
                self::SetOperand("BinContent");
                // self::SetValue("BinContent", ',' . urlencode(base64_encode(file_get_contents($content['tmp_name']))));
                // echo 'data:image/png;base64,' . base64_encode(file_get_contents($content['tmp_name']));exit;
                self::SetValue("BinContent", base64_encode(file_get_contents($content['tmp_name'])));
                self::Update();
                self::ClearOperands("BinContent");
            }

            return self::GetProperties();
        }

        return $result;
    }
    function DeletePostAttachment($masterid)
    {
        $result = self::Select(-1, 1, 'Id', 'DESC', "WHERE `MasterID`='" . $masterid . "'")[0];
        self::SendPost($result["MasterID"], $result['Title'], $result['Level'],
        $result['Content'], $result['Body'], $result['Status'], $result["Language"]);
        self::SetOperand("IsContentDeleted");
        self::SetValue("IsContentDeleted", "1");
        $response = self::Update();
        self::ClearOperands("IsContentDeleted");
    }
    function DeletePost($masterid)
    {
        $result = self::Select(-1, 1, 'Id', 'DESC', "WHERE `MasterID`='" . $masterid . "'")[0];
        self::SendPost($result["MasterID"], null, null, null, null, null, $result["Language"]);
        self::SetOperand("IsDeleted");
        self::SetValue("IsDeleted", "1");
        $response = self::Update();
        // Attention: Maybe there is a bug when deleting a post <> $CURRENTLANGUAGE or $PATHINFO or etc ...
        self::ClearOperands("IsDeleted");
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