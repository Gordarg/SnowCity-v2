CREATE 
     OR REPLACE 
VIEW `gordcms`.`post_details` AS
    SELECT 
        `gordcms`.`posts`.`Id` AS `ID`,
        `gordcms`.`posts`.`Title` AS `Title`,
        `gordcms`.`posts`.`Submit` AS `Submit`,
        `gordcms`.`categories`.`Id` AS `CategoryID`,
        `gordcms`.`categories`.`Name` AS `CategoryName`,
        `gordcms`.`users`.`id` AS `UserID`,
        `gordcms`.`users`.`username` AS `Username`,
        `gordcms`.`posts`.`Body` AS `Body`,
        `gordcms`.`posts`.`Content` AS `Content`,
        `gordcms`.`posts`.`Type` AS `Type`
    FROM
        ((`gordcms`.`posts`
        JOIN `gordcms`.`users` ON ((`gordcms`.`posts`.`UserId` = `gordcms`.`users`.`id`)))
        JOIN `gordcms`.`categories` ON ((`gordcms`.`posts`.`CategoryId` = `gordcms`.`categories`.`Id`)));
