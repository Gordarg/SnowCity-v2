select
    count(*) as rate, `Title`
from post_details
where `Type`='KWRD'
group by `Title`
order by rate desc
limit 10