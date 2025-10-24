-- ===============================================
-- ADVANCED SQL FEATURES FOR CODEQUEST
-- ===============================================
-- This file contains: Views, Stored Procedures, Functions, Triggers, and Cursors
-- Run this after basic table setup and data insertion

USE codequest;

-- ===============================================
-- SECTION 1: VIEWS
-- ===============================================

-- View 1: User Statistics with Rankings
DROP VIEW IF EXISTS user_statistics_view;
CREATE VIEW user_statistics_view AS
SELECT 
    u.user_id,
    u.name,
    u.email,
    u.cf_handle,
    u.cf_max_rating,
    u.solved_problems_count,
    u.average_problem_rating,
    u.followers_count,
    COUNT(DISTINCT up.problem_id) as total_attempts,
    COUNT(DISTINCT CASE WHEN up.status = 'solved' THEN up.problem_id END) as solved_count,
    COUNT(DISTINCT CASE WHEN up.is_starred = 1 THEN up.problem_id END) as starred_count,
    RANK() OVER (ORDER BY u.cf_max_rating DESC) as rating_rank,
    RANK() OVER (ORDER BY u.solved_problems_count DESC) as solver_rank,
    u.created_at,
    u.updated_at
FROM users u
LEFT JOIN userproblems up ON u.user_id = up.user_id
GROUP BY u.user_id, u.name, u.email, u.cf_handle, u.cf_max_rating, 
         u.solved_problems_count, u.average_problem_rating, u.followers_count,
         u.created_at, u.updated_at;

-- View 2: Problem Statistics with Tag Information
DROP VIEW IF EXISTS problem_statistics_view;
CREATE VIEW problem_statistics_view AS
SELECT 
    p.problem_id,
    p.title,
    p.problem_link,
    p.rating,
    p.solved_count,
    p.stars,
    p.popularity,
    GROUP_CONCAT(DISTINCT t.tag_name ORDER BY t.tag_name SEPARATOR ', ') as tags,
    COUNT(DISTINCT pt.tag_id) as tag_count,
    COUNT(DISTINCT e.editorial_id) as editorial_count,
    p.created_at,
    p.updated_at
FROM problems p
LEFT JOIN problemtags pt ON p.problem_id = pt.problem_id
LEFT JOIN tags t ON pt.tag_id = t.tag_id
LEFT JOIN editorials e ON p.problem_id = e.problem_id
GROUP BY p.problem_id, p.title, p.problem_link, p.rating, 
         p.solved_count, p.stars, p.popularity, p.created_at, p.updated_at;

-- View 3: Editorial Statistics with Author Info
DROP VIEW IF EXISTS editorial_statistics_view;
CREATE VIEW editorial_statistics_view AS
SELECT 
    e.editorial_id,
    e.problem_id,
    p.title as problem_title,
    e.author_id,
    u.name as author_name,
    u.cf_handle as author_handle,
    e.upvotes,
    e.downvotes,
    (e.upvotes - e.downvotes) as net_votes,
    CASE 
        WHEN (e.upvotes + e.downvotes) > 0 
        THEN ROUND((e.upvotes * 100.0 / (e.upvotes + e.downvotes)), 2)
        ELSE 0 
    END as approval_rating,
    e.created_at,
    e.updated_at
FROM editorials e
INNER JOIN problems p ON e.problem_id = p.problem_id
INNER JOIN users u ON e.author_id = u.user_id;

-- View 4: Social Network View
DROP VIEW IF EXISTS social_network_view;
CREATE VIEW social_network_view AS
SELECT 
    f.user_id,
    u1.name as user_name,
    f.friend_id,
    u2.name as friend_name,
    u1.followers_count as user_followers,
    u2.followers_count as friend_followers,
    u1.solved_problems_count as user_solved,
    u2.solved_problems_count as friend_solved
FROM friends f
INNER JOIN users u1 ON f.user_id = u1.user_id
INNER JOIN users u2 ON f.friend_id = u2.user_id
WHERE f.is_friend = 1;

-- ===============================================
-- SECTION 2: STORED PROCEDURES
-- ===============================================

-- Procedure 1: Update Problem Statistics (with cursor)
DROP PROCEDURE IF EXISTS update_problem_statistics;
DELIMITER //
CREATE PROCEDURE update_problem_statistics(IN p_problem_id INT)
BEGIN
    DECLARE v_solved_count INT DEFAULT 0;
    DECLARE v_stars_count INT DEFAULT 0;
    DECLARE v_popularity DECIMAL(10,4) DEFAULT 0;
    DECLARE v_max_stars INT DEFAULT 1;
    
    -- Count solved users
    SELECT COUNT(*) INTO v_solved_count
    FROM userproblems
    WHERE problem_id = p_problem_id AND status = 'solved';
    
    -- Count stars
    SELECT COUNT(*) INTO v_stars_count
    FROM userproblems
    WHERE problem_id = p_problem_id AND is_starred = 1;
    
    -- Get max stars for popularity calculation
    SELECT MAX(stars) INTO v_max_stars FROM problems;
    IF v_max_stars IS NULL OR v_max_stars = 0 THEN
        SET v_max_stars = 1;
    END IF;
    
    -- Calculate popularity
    SET v_popularity = ROUND(v_stars_count / v_max_stars, 4);
    
    -- Update problem
    UPDATE problems
    SET solved_count = v_solved_count,
        stars = v_stars_count,
        popularity = v_popularity,
        updated_at = NOW()
    WHERE problem_id = p_problem_id;
END //
DELIMITER ;

-- Procedure 2: Update User Statistics (with loops)
DROP PROCEDURE IF EXISTS update_user_statistics;
DELIMITER //
CREATE PROCEDURE update_user_statistics(IN p_user_id INT)
BEGIN
    DECLARE v_solved_count INT DEFAULT 0;
    DECLARE v_total_rating INT DEFAULT 0;
    DECLARE v_avg_rating INT DEFAULT 0;
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_problem_rating INT;
    
    -- Cursor for solved problems
    DECLARE problem_cursor CURSOR FOR
        SELECT p.rating
        FROM userproblems up
        INNER JOIN problems p ON up.problem_id = p.problem_id
        WHERE up.user_id = p_user_id AND up.status = 'solved';
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    -- Count solved problems
    SELECT COUNT(*) INTO v_solved_count
    FROM userproblems
    WHERE user_id = p_user_id AND status = 'solved';
    
    -- Calculate average rating using cursor
    OPEN problem_cursor;
    
    read_loop: LOOP
        FETCH problem_cursor INTO v_problem_rating;
        IF done THEN
            LEAVE read_loop;
        END IF;
        SET v_total_rating = v_total_rating + v_problem_rating;
    END LOOP;
    
    CLOSE problem_cursor;
    
    -- Calculate average
    IF v_solved_count > 0 THEN
        SET v_avg_rating = v_total_rating DIV v_solved_count;
    END IF;
    
    -- Update user
    UPDATE users
    SET solved_problems_count = v_solved_count,
        average_problem_rating = v_avg_rating,
        updated_at = NOW()
    WHERE user_id = p_user_id;
END //
DELIMITER ;

-- Procedure 3: Bulk Update All Problem Statistics
DROP PROCEDURE IF EXISTS bulk_update_problem_statistics;
DELIMITER //
CREATE PROCEDURE bulk_update_problem_statistics()
BEGIN
    DECLARE v_problem_id INT;
    DECLARE done INT DEFAULT FALSE;
    DECLARE problem_cursor CURSOR FOR SELECT problem_id FROM problems;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    OPEN problem_cursor;
    
    update_loop: LOOP
        FETCH problem_cursor INTO v_problem_id;
        IF done THEN
            LEAVE update_loop;
        END IF;
        
        CALL update_problem_statistics(v_problem_id);
    END LOOP;
    
    CLOSE problem_cursor;
    
    SELECT 'All problem statistics updated successfully' as message;
END //
DELIMITER ;

-- Procedure 4: Get User Leaderboard with Pagination
DROP PROCEDURE IF EXISTS get_user_leaderboard;
DELIMITER //
CREATE PROCEDURE get_user_leaderboard(
    IN p_limit INT,
    IN p_offset INT,
    IN p_order_by VARCHAR(50)
)
BEGIN
    SET @sql = CONCAT('
        SELECT 
            user_id, name, cf_handle, cf_max_rating,
            solved_problems_count, average_problem_rating,
            followers_count
        FROM users
        ORDER BY ', p_order_by, ' DESC
        LIMIT ', p_limit, ' OFFSET ', p_offset
    );
    
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //
DELIMITER ;

-- Procedure 5: Search Problems with Tags
DROP PROCEDURE IF EXISTS search_problems;
DELIMITER //
CREATE PROCEDURE search_problems(
    IN p_search_term VARCHAR(255),
    IN p_min_rating INT,
    IN p_max_rating INT
)
BEGIN
    SELECT DISTINCT
        p.problem_id,
        p.title,
        p.problem_link,
        p.rating,
        p.solved_count,
        p.stars,
        p.popularity,
        GROUP_CONCAT(DISTINCT t.tag_name ORDER BY t.tag_name SEPARATOR ', ') as tags
    FROM problems p
    LEFT JOIN problemtags pt ON p.problem_id = pt.problem_id
    LEFT JOIN tags t ON pt.tag_id = t.tag_id
    WHERE (p.title LIKE CONCAT('%', p_search_term, '%')
           OR t.tag_name LIKE CONCAT('%', p_search_term, '%'))
        AND p.rating >= COALESCE(p_min_rating, 0)
        AND p.rating <= COALESCE(p_max_rating, 3500)
    GROUP BY p.problem_id, p.title, p.problem_link, p.rating, 
             p.solved_count, p.stars, p.popularity
    ORDER BY p.popularity DESC, p.solved_count DESC;
END //
DELIMITER ;

-- ===============================================
-- SECTION 3: FUNCTIONS
-- ===============================================

-- Function 1: Calculate User Rank
DROP FUNCTION IF EXISTS get_user_rank;
DELIMITER //
CREATE FUNCTION get_user_rank(p_user_id INT) 
RETURNS INT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE user_rank INT;
    
    SELECT COUNT(*) + 1 INTO user_rank
    FROM users u1
    WHERE u1.cf_max_rating > (
        SELECT u2.cf_max_rating 
        FROM users u2 
        WHERE u2.user_id = p_user_id
    );
    
    RETURN user_rank;
END //
DELIMITER ;

-- Function 2: Get Problem Difficulty Category
DROP FUNCTION IF EXISTS get_difficulty_category;
DELIMITER //
CREATE FUNCTION get_difficulty_category(p_rating INT) 
RETURNS VARCHAR(20)
DETERMINISTIC
BEGIN
    DECLARE category VARCHAR(20);
    
    IF p_rating < 1000 THEN
        SET category = 'Beginner';
    ELSEIF p_rating < 1400 THEN
        SET category = 'Easy';
    ELSEIF p_rating < 1800 THEN
        SET category = 'Medium';
    ELSEIF p_rating < 2200 THEN
        SET category = 'Hard';
    ELSE
        SET category = 'Expert';
    END IF;
    
    RETURN category;
END //
DELIMITER ;

-- Function 3: Calculate User Progress Percentage
DROP FUNCTION IF EXISTS get_user_progress;
DELIMITER //
CREATE FUNCTION get_user_progress(p_user_id INT) 
RETURNS DECIMAL(5,2)
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE progress DECIMAL(5,2);
    DECLARE total_problems INT;
    DECLARE solved_problems INT;
    
    SELECT COUNT(*) INTO total_problems FROM problems;
    
    SELECT COUNT(*) INTO solved_problems
    FROM userproblems
    WHERE user_id = p_user_id AND status = 'solved';
    
    IF total_problems > 0 THEN
        SET progress = (solved_problems * 100.0) / total_problems;
    ELSE
        SET progress = 0;
    END IF;
    
    RETURN progress;
END //
DELIMITER ;

-- Function 4: Get Editorial Quality Score
DROP FUNCTION IF EXISTS get_editorial_quality;
DELIMITER //
CREATE FUNCTION get_editorial_quality(p_editorial_id INT) 
RETURNS DECIMAL(5,2)
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE quality DECIMAL(5,2);
    DECLARE v_upvotes INT;
    DECLARE v_downvotes INT;
    DECLARE total_votes INT;
    
    SELECT upvotes, downvotes INTO v_upvotes, v_downvotes
    FROM editorials
    WHERE editorial_id = p_editorial_id;
    
    SET total_votes = v_upvotes + v_downvotes;
    
    IF total_votes > 0 THEN
        SET quality = (v_upvotes * 100.0) / total_votes;
    ELSE
        SET quality = 50.0;
    END IF;
    
    RETURN quality;
END //
DELIMITER ;

-- ===============================================
-- SECTION 4: TRIGGERS
-- ===============================================

-- Trigger 1: Auto-update problem statistics on userproblems INSERT
DROP TRIGGER IF EXISTS after_userproblem_insert;
DELIMITER //
CREATE TRIGGER after_userproblem_insert
AFTER INSERT ON userproblems
FOR EACH ROW
BEGIN
    -- Update problem statistics
    UPDATE problems p
    SET 
        p.solved_count = (
            SELECT COUNT(*) 
            FROM userproblems 
            WHERE problem_id = NEW.problem_id AND status = 'solved'
        ),
        p.stars = (
            SELECT COUNT(*) 
            FROM userproblems 
            WHERE problem_id = NEW.problem_id AND is_starred = 1
        ),
        p.updated_at = NOW()
    WHERE p.problem_id = NEW.problem_id;
    
    -- Update user statistics if solved
    IF NEW.status = 'solved' THEN
        UPDATE users u
        SET 
            u.solved_problems_count = (
                SELECT COUNT(*) 
                FROM userproblems 
                WHERE user_id = NEW.user_id AND status = 'solved'
            ),
            u.updated_at = NOW()
        WHERE u.user_id = NEW.user_id;
    END IF;
END //
DELIMITER ;

-- Trigger 2: Auto-update statistics on userproblems UPDATE
DROP TRIGGER IF EXISTS after_userproblem_update;
DELIMITER //
CREATE TRIGGER after_userproblem_update
AFTER UPDATE ON userproblems
FOR EACH ROW
BEGIN
    -- Update problem statistics
    UPDATE problems p
    SET 
        p.solved_count = (
            SELECT COUNT(*) 
            FROM userproblems 
            WHERE problem_id = NEW.problem_id AND status = 'solved'
        ),
        p.stars = (
            SELECT COUNT(*) 
            FROM userproblems 
            WHERE problem_id = NEW.problem_id AND is_starred = 1
        ),
        p.updated_at = NOW()
    WHERE p.problem_id = NEW.problem_id;
    
    -- Update user statistics
    UPDATE users u
    SET 
        u.solved_problems_count = (
            SELECT COUNT(*) 
            FROM userproblems 
            WHERE user_id = NEW.user_id AND status = 'solved'
        ),
        u.updated_at = NOW()
    WHERE u.user_id = NEW.user_id;
END //
DELIMITER ;

-- Trigger 3: Auto-update statistics on userproblems DELETE
DROP TRIGGER IF EXISTS after_userproblem_delete;
DELIMITER //
CREATE TRIGGER after_userproblem_delete
AFTER DELETE ON userproblems
FOR EACH ROW
BEGIN
    -- Update problem statistics
    UPDATE problems p
    SET 
        p.solved_count = (
            SELECT COUNT(*) 
            FROM userproblems 
            WHERE problem_id = OLD.problem_id AND status = 'solved'
        ),
        p.stars = (
            SELECT COUNT(*) 
            FROM userproblems 
            WHERE problem_id = OLD.problem_id AND is_starred = 1
        ),
        p.updated_at = NOW()
    WHERE p.problem_id = OLD.problem_id;
    
    -- Update user statistics
    UPDATE users u
    SET 
        u.solved_problems_count = (
            SELECT COUNT(*) 
            FROM userproblems 
            WHERE user_id = OLD.user_id AND status = 'solved'
        ),
        u.updated_at = NOW()
    WHERE u.user_id = OLD.user_id;
END //
DELIMITER ;

-- Trigger 4: Auto-update follower count on friends INSERT
DROP TRIGGER IF EXISTS after_friend_insert;
DELIMITER //
CREATE TRIGGER after_friend_insert
AFTER INSERT ON friends
FOR EACH ROW
BEGIN
    UPDATE users
    SET followers_count = followers_count + 1
    WHERE user_id = NEW.friend_id;
END //
DELIMITER ;

-- Trigger 5: Auto-update follower count on friends DELETE
DROP TRIGGER IF EXISTS after_friend_delete;
DELIMITER //
CREATE TRIGGER after_friend_delete
AFTER DELETE ON friends
FOR EACH ROW
BEGIN
    UPDATE users
    SET followers_count = GREATEST(followers_count - 1, 0)
    WHERE user_id = OLD.friend_id;
END //
DELIMITER ;

-- ===============================================
-- SECTION 5: COMPLEX QUERIES EXAMPLES
-- ===============================================

-- Query 1: UNION - Get all users and their activity
DROP VIEW IF EXISTS user_activity_union;
CREATE VIEW user_activity_union AS
SELECT 
    u.user_id,
    u.name,
    'SOLVED' as activity_type,
    p.title as activity_detail,
    up.solved_at as activity_date
FROM users u
INNER JOIN userproblems up ON u.user_id = up.user_id
INNER JOIN problems p ON up.problem_id = p.problem_id
WHERE up.status = 'solved'
UNION ALL
SELECT 
    u.user_id,
    u.name,
    'EDITORIAL' as activity_type,
    p.title as activity_detail,
    e.created_at as activity_date
FROM users u
INNER JOIN editorials e ON u.user_id = e.author_id
INNER JOIN problems p ON e.problem_id = p.problem_id
UNION ALL
SELECT 
    u.user_id,
    u.name,
    'FOLLOWED' as activity_type,
    u2.name as activity_detail,
    NULL as activity_date
FROM users u
INNER JOIN friends f ON u.user_id = f.user_id
INNER JOIN users u2 ON f.friend_id = u2.user_id;

-- Query 2: Get users who solved ALL problems of a specific tag (Division/Intersection concept)
DROP PROCEDURE IF EXISTS get_tag_masters;
DELIMITER //
CREATE PROCEDURE get_tag_masters(IN p_tag_id INT)
BEGIN
    SELECT 
        u.user_id,
        u.name,
        u.cf_handle,
        COUNT(DISTINCT up.problem_id) as problems_solved
    FROM users u
    INNER JOIN userproblems up ON u.user_id = up.user_id
    INNER JOIN problemtags pt ON up.problem_id = pt.problem_id
    WHERE pt.tag_id = p_tag_id 
        AND up.status = 'solved'
        AND NOT EXISTS (
            SELECT 1 
            FROM problemtags pt2
            WHERE pt2.tag_id = p_tag_id
                AND NOT EXISTS (
                    SELECT 1
                    FROM userproblems up2
                    WHERE up2.user_id = u.user_id
                        AND up2.problem_id = pt2.problem_id
                        AND up2.status = 'solved'
                )
        )
    GROUP BY u.user_id, u.name, u.cf_handle
    ORDER BY problems_solved DESC;
END //
DELIMITER ;

-- ===============================================
-- END OF ADVANCED FEATURES
-- ===============================================

-- Show summary
SELECT 'Advanced SQL features created successfully!' as Status,
       'Views: 5, Procedures: 6, Functions: 4, Triggers: 5' as Summary;
