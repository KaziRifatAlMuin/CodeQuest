SELECT *
FROM (
        SELECT u.*, RANK() OVER (
                ORDER BY u.cf_max_rating DESC, u.solved_problems_count DESC
            ) AS actual_rank
        FROM users u
    ) ranked
WHERE (
        name LIKE ?
        OR cf_handle LIKE ?
        OR university LIKE ?
    )
ORDER BY cf_max_rating DESC, name ASC
LIMIT ?
OFFSET
    ?;

SELECT COUNT(*) AS total
FROM (
        SELECT u.*, RANK() OVER (
                ORDER BY u.cf_max_rating DESC, u.solved_problems_count DESC
            ) AS actual_rank
        FROM users u
    ) ranked
WHERE (
        name LIKE ?
        OR cf_handle LIKE ?
        OR university LIKE ?
    );