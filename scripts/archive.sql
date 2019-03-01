select
    DATE_FORMAT(`Submit`, '%M %Y')  as formatted,
    EXTRACT(YEAR_MONTH FROM `Submit`)  as link
from post_details
where `Type` = 'POST'
group by `Submit`
order by `Submit` asc
limit 10