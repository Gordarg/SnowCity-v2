SELECT DISTINCT
    `A`.`Title`
    , `A`.`Type`
    , `A`.`ID`
    , `A`.`MasterID`
    , `A`.`RefrenceID`
    , `A`.`UserID`
    , `A`.`Username`
    , `A`.`Submit`
    , `A`.`Language`
    , `A`.`Status`
    , `A`.`Level`
    , `A`.`Body`
    
    FROM `post_details` `A`

    LEFT OUTER JOIN `post_details` as pd2
    ON A.MasterID = pd2.RefrenceID

    WHERE
    (
        `A`.`Title` LIKE '%@Q%'
    OR `pd2`.`Title` LIKE '%@Q%'
    OR CONCAT ('@', `A`.`Username`) LIKE '@Q'
    OR `A`.`Body` LIKE '%@Q%'
    )
    AND
    (
        `A`.`Type` = 'POST'
    OR  `A`.`Type` = 'COMT' 
    OR  `A`.`Type` = 'FILE' 
    OR  `A`.`Type` = 'QUST'
    )

    ORDER BY `A`.`Submit`
    Limit 10
    ;