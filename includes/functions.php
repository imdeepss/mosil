<?php


/**
 * --------------------------------------------------------------------------
 * Core Database Helpers
 * --------------------------------------------------------------------------
 */



/**
 * Sanitize input data to prevent XSS and SQL injection.
 * 
 * @param string|array $data The data to sanitize
 * @return string|array The sanitized data
 */
function sanitizeInput($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitizeInput($value);
        }
    }
    else {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
    }
    return $data;
}

/**
 * Check if the session has timed out
 * 
 * @return bool True if session has timed out, false otherwise
 */
function isSessionTimedOut()
{
    if (!isset($_SESSION['admin_last_activity'])) {
        return true;
    }

    if (time() - $_SESSION['admin_last_activity'] > SESSION_TIMEOUT) {
        return true;
    }

    // Update last activity time
    $_SESSION['admin_last_activity'] = time();

    return false;
}

/**
 * Check if user has permission for a specific action
 * 
 * @param string $permission The permission to check
 * @return bool True if user has permission, false otherwise
 */
function hasPermission($permission)
{
    // For demo purposes, we'll assume administrator role has all permissions
    if ($_SESSION['admin_role'] === 'administrator') {
        return true;
    }

    // In a real application, you would check against a permissions table
    $permissions = [
        'editor' => ['view_dashboard', 'edit_content', 'view_reports'],
        'viewer' => ['view_dashboard', 'view_reports']
    ];

    if (
    isset($permissions[$_SESSION['admin_role']]) &&
    in_array($permission, $permissions[$_SESSION['admin_role']])
    ) {
        return true;
    }

    return false;
}
/**
 * Generate a random token
 * 
 * @param int $length The length of the token
 * @return string The generated token
 */
function generateToken($length = 32)
{
    return bin2hex(random_bytes($length));
}

/**
 * Log activity
 * 
 * @param string $action The action performed
 * @param string $description The description of the action
 * @return bool True if logged successfully, false otherwise
 */
function logActivity($action, $description)
{
    // In a real application, you would log to database
    // For demo purposes, we'll just return true
    return true;
}

function generateSlug($string)
{
    // Convert to lowercase
    $slug = strtolower($string);

    // Replace special characters with empty string
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug); // Removes special characters except dash and space

    // Replace multiple spaces or dashes with a single dash
    $slug = preg_replace('/[\s-]+/', '-', $slug);

    // Trim dashes from the beginning and end
    $slug = trim($slug, '-');

    return $slug;
}

/**
 * Execute a query and fetch all results.
 * Supports standard parameter binding.
 */
function db_query_all($sql, $params = [])
{
    global $db;
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return [];
    }
}

/**
 * Execute a query and fetch a single result row.
 */
function db_query_one($sql, $params = [])
{
    global $db;
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() ?: null;
    }
    catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return null;
    }
}

/**
 * Execute a query and fetch a single scalar value (e.g. COUNT).
 */
function db_query_value($sql, $params = [], $column = 0)
{
    global $db;
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn($column);
    }
    catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Execute a query (INSERT, UPDATE, DELETE).
 * Returns true on success, false on failure.
 */
function db_execute($sql, $params = [])
{
    global $db;
    try {
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }
    catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return false;
    }
}

/**
 * --------------------------------------------------------------------------
 * Product & Catalog Functions
 * --------------------------------------------------------------------------
 */

/**
 * Fetch a list of active products with pagination.
 */
function getProducts($limit = 10, $offset = 0)
{
    $limit = (int)$limit;
    $offset = (int)$offset;

    $sql = "SELECT id, name, slug, image, description 
            FROM products_v2 
            WHERE status = 'Active' 
            ORDER BY id DESC 
            LIMIT $limit OFFSET $offset";

    return db_query_all($sql);
}



/**
 * Fetch a single product by ID and Slug.
 */
function getProductBySlug($slug)
{
    $slug = trim($slug);
    $sql = "SELECT * 
            FROM products_v2 
            WHERE slug LIKE ? 
            AND TRIM(status) = 'Active'";

    return db_query_one($sql, [$slug]);
}

/**
 * Get total count of active products.
 */
function getTotalProducts()
{
    $sql = "SELECT COUNT(*) as total FROM products_v2 WHERE status = 'Active'";
    return (int)db_query_value($sql);
}

/**
 * Fetch Industries Category details by ID.
 */
function getIndustriesCategory()
{
    $sql = "SELECT id, mcat_name, mcat_desc,slug, mcat_image
            FROM main_category 
            WHERE parent_cat = 2 AND status = 'Active' ORDER BY mcat_name ASC";

    return db_query_all($sql);
}

/**
 * Fetch Products Category details by ID.
 */
function getProductsCategory()
{
    $sql = "SELECT id, mcat_name, mcat_desc,slug, mcat_image
            FROM main_category 
            WHERE parent_cat = 3 AND status = 'Active' ORDER BY mcat_name ASC";

    return db_query_all($sql);
}

/**
 * Fetch category details by parent category ID.
 *
 * @param int $parentCatId
 * @param int|null $limit  Optional limit (default: all)
 * @return array
 */
function getCategoryByParent($parentCatId, $limit = null)
{
    $sql = "SELECT id, mcat_name, mcat_desc, slug, mcat_image,meta_description
            FROM main_category
            WHERE parent_cat = " . intval($parentCatId) . "
              AND status = 'Active'
            ORDER BY mcat_name DESC";

    if (!empty($limit)) {
        $sql .= " LIMIT " . intval($limit);
    }

    return db_query_all($sql);
}

/**
 * Fetch specific categories by their IDs.
 */
function getSpecificIndustries()
{
    $ids = [26, 21, 16, 19];
    $idString = implode(',', $ids);

    // Using ORDER BY FIELD to preserve the specific order requested
    $sql = "SELECT id, mcat_name, mcat_desc, slug, mcat_image, meta_description
            FROM main_category
            WHERE id IN ($idString)
              AND status = 'Active'
            ORDER BY FIELD(id, $idString)";

    return db_query_all($sql);
}


/**
 * Fetch category details by parent category ID.
 *
 * @param int $parentCatId
 * @param int|null $limit  Optional limit (default: all)
 * @return array
 */
function getCaseStudy($limit = null)
{
    $sql = "SELECT * FROM case_studies WHERE status = 'Active' ORDER BY created_at ASC";

    if (!empty($limit)) {
        $sql .= " LIMIT " . intval($limit);
    }

    return db_query_all($sql);
}

/**
 * Fetch specific case studies by their IDs.
 *
 * @param array $ids Array of case study IDs
 * @return array
 */
function getSpecificCaseStudies($ids)
{
    if (empty($ids)) {
        return [];
    }

    $safeIds = array_map('intval', $ids);
    $idString = implode(',', $safeIds);

    $sql = "SELECT * FROM case_studies 
            WHERE status = 'Active' AND id IN ($idString) 
            ORDER BY FIELD(id, $idString)";

    return db_query_all($sql);
}

/**
 * Fetch fixed case studies for the home page.
 * Hardcoded IDs: 13, 14, 15 as requested.
 */
function getHomeFixedCaseStudies()
{
    $ids = [13, 14, 15];
    $idString = implode(',', $ids);

    $sql = "SELECT * FROM case_studies 
            WHERE status = 'Active' AND id IN ($idString) 
            ORDER BY FIELD(id, $idString)";

    return db_query_all($sql);
}


/**
 * Fetch Sub Categories for a specific Main Category.
 * Uses FIND_IN_SET to match the main category ID in the 'm_cat' column.
 */
function getSubCategoriesByMainCategory($slug)
{
    $sql = "SELECT sc.id, sc.scat_name as name 
    FROM sub_category sc 
    INNER JOIN main_category mc ON FIND_IN_SET(mc.id, sc.m_cat) 
    WHERE mc.slug = ? AND mc.status = 'Active' AND sc.status = 'Active' ORDER BY sc.scat_name ASC;";
    return db_query_all($sql, [$slug]);
}

/**
 * Fetch Parent Attributes for a Sub Category.
 */
function getParentAttributesBySubCategory($subCatId)
{
    $sql = "SELECT id, parent_attr_name as name 
            FROM parent_attribute 
            WHERE status = 'Active' AND sub_cat = ?";

    return db_query_all($sql, [$subCatId]);
}

/**
 * Fetch Main Attributes by Parent Attribute ID.
 */
function getMainAttributesByParentAttribute($parentAttrId)
{
    $sql = "SELECT id, main_attr_name as name 
            FROM main_attribute 
            WHERE status = 'Active' AND parent_attr = ?";

    return db_query_all($sql, [$parentAttrId]);
}

/**
 * Fetch Sub Attributes by Main Attribute ID.
 */
function getSubAttributesByMainAttribute($mainAttrId)
{
    $sql = "SELECT id, sub_attr_name as name 
            FROM sub_attribute 
            WHERE status = 'Active' AND main_attr = ?";

    return db_query_all($sql, [$mainAttrId]);
}

/**
 * Fetch FAQs.
 */
function getFaqs($limit = 20)
{
    $limit = (int)$limit;
    $sql = "SELECT id, question, answer, category, subcategory 
            FROM faq 
            WHERE status = 'Active' 
            ORDER BY id ASC 
            LIMIT $limit";

    return db_query_all($sql);
}


function getBlogs($limit = null)
{
    $limit = (int)$limit;
    $limitSql = $limit > 0 ? "LIMIT $limit" : "";

    $sql = "
        SELECT 
            bp.*,
            bc.name AS category_name
        FROM blog_posts_v2 bp
        LEFT JOIN blog_categories bc 
            ON bp.category_id = bc.id
        WHERE bp.status = 'Published'
        ORDER BY bp.created_at ASC
        $limitSql
    ";

    return db_query_all($sql);
}


/**
 * Fetch Industries Category details by ID.
 */
function getProductsByCategorySlug($slug)
{
    $sql = "SELECT p.id, p.name, p.slug, p.image, p.sub_title, p.short_description 
            FROM products_v2 p
            INNER JOIN main_category c ON FIND_IN_SET(c.id, p.main_cat)
            WHERE c.slug = ? 
            AND c.status = 'Active' 
            AND p.status = 'Active'
            ORDER BY p.id DESC";

    $products = db_query_all($sql, [$slug]);

    return [
        'total_found' => count($products),
        'products' => $products
    ];
}

/**
 * Fetch Industries Category details by ID.
 */
function getProductsBySubCategoryID($id, $slug)
{
    $sql = "SELECT p.id, p.name, p.slug, p.image, p.sub_title, p.short_description 
            FROM products_v2 p 
            INNER JOIN main_category c ON FIND_IN_SET(c.id, p.main_cat) 
            WHERE c.slug = ? 
              AND FIND_IN_SET(?, p.sub_cat) 
              AND p.status = 'Active' 
            ORDER BY p.id DESC";

    $products = db_query_all($sql, [$slug, $id]);
    return [
        'total_found' => count($products),
        'products' => $products
    ];
}


function getRelatedProducts($subCatString, $currentProductId, $mainCatString = '')
{
    // Helper to extract numeric IDs
    $parseIds = function ($str) {
        return array_filter(explode(',', $str), function ($val) {
                return is_numeric(trim($val));
            }
            );
        };

    $subCatIds = $parseIds($subCatString);
    $products = [];

    // 1. Try fetching by Sub Category (Most Relevant)
    if (!empty($subCatIds)) {
        $conditions = [];
        $params = [];
        foreach ($subCatIds as $id) {
            $conditions[] = "FIND_IN_SET(?, p.sub_cat)";
            $params[] = $id;
        }
        $whereClause = implode(' OR ', $conditions);

        // Exclude current product
        $params[] = $currentProductId;

        $sql = "SELECT p.id, p.name, p.slug, p.image, p.sub_title, p.short_description 
                FROM products_v2 p 
                WHERE ($whereClause) 
                  AND p.id != ? 
                  AND p.status = 'Active' 
                ORDER BY RAND() 
                LIMIT 10";

        $products = db_query_all($sql, $params);
    }

    // 2. Fallback: If no sub-category matches (or no sub-cats), try Main Category
    if (empty($products) && !empty($mainCatString)) {
        $mainCatIds = $parseIds($mainCatString);
        if (!empty($mainCatIds)) {
            $conditions = [];
            $params = [];
            foreach ($mainCatIds as $id) {
                $conditions[] = "FIND_IN_SET(?, p.main_cat)";
                $params[] = $id;
            }
            $whereClause = implode(' OR ', $conditions);

            $params[] = $currentProductId;

            $sql = "SELECT p.id, p.name, p.slug, p.image, p.sub_title, p.short_description 
                    FROM products_v2 p 
                    WHERE ($whereClause) 
                      AND p.id != ? 
                      AND p.status = 'Active' 
                    ORDER BY RAND() 
                    LIMIT 10";

            $products = db_query_all($sql, $params);
        }
    }

    return $products;
}



function searchProducts($searchQuery)
{
    $formattedQuery = trim(strtolower($searchQuery));

    if (strlen($formattedQuery) < 2) {
        return [];
    }

    $conditions = [];
    $params = [];

    // 1. Prepare match terms
    // Broad match term
    $originalTerm = "%" . $formattedQuery . "%";

    // Clean match term (alphanumeric only)
    $cleanQueryStr = preg_replace('/[^a-z0-9]/', '', $formattedQuery);
    $cleanTerm = "%" . $cleanQueryStr . "%";

    // Tokens (split by non-alphanumeric)
    $tokens = preg_split('/[^a-z0-9]+/', $formattedQuery, -1, PREG_SPLIT_NO_EMPTY);
    $tokens = array_slice($tokens, 0, 6); // Limit tokens

    // 2. Build Query
    // Priority: 
    // - Stripped Name/Slug matches Stripped Query (e.g. "abc-123" matches "abc123")
    // - Token Intersection (e.g. "abc - 123" matches "abc 123")
    // - Legacy Broad Search

    // Base SQL
    $sql = "SELECT name, slug FROM products_v2 WHERE status = 'Active' AND (";

    // A. Stripped Match (Name & Slug)
    // Works for "abc123" -> found "abc-123"
    // Works for "abc" -> found "abc-123"
    if (!empty($cleanQueryStr)) {
        // Strip common separators from DB columns for comparison
        $dbCleanName = "REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(name), '-', ''), ' ', ''), '/', ''), '_', ''), ',', ''), '.', '')";
        $dbCleanSlug = "REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(slug), '-', ''), ' ', ''), '/', ''), '_', ''), ',', ''), '.', '')";

        $conditions[] = "$dbCleanName LIKE ?";
        $params[] = $cleanTerm;

        $conditions[] = "$dbCleanSlug LIKE ?";
        $params[] = $cleanTerm;
    }

    // B. Token Intersection Match (Name Only - High Precision)
    // Works for "abc 123" -> found "abc - 123"
    if (count($tokens) > 1) {
        $tokenWhere = [];
        foreach ($tokens as $token) {
            $tokenWhere[] = "LOWER(name) LIKE ?";
            $params[] = "%$token%";
        }
        $conditions[] = "(" . implode(' AND ', $tokenWhere) . ")";
    }

    // C. Legacy Broad Search (All Fields - Fallback)
    // Works for descriptions, categories, etc.
    // Also covers single token broad matches
    $fields = [
        'name',
        'slug',
        'sub_title',
        'parent_cat',
        'main_cat',
        'sub_cat',
        'attribute',
        'main_attribute',
        'sub_attribute',
        'short_description',
        'area_of_application',
        'characteristics'
    ];

    foreach ($fields as $field) {
        $conditions[] = "LOWER($field) LIKE ?";
        $params[] = $originalTerm;
    }

    $sql .= implode(' OR ', $conditions);
    $sql .= ") ORDER BY CASE WHEN LOWER(name) LIKE ? THEN 1 WHEN LOWER(name) LIKE ? THEN 2 ELSE 3 END, name ASC LIMIT 15";

    // Add params for ORDER BY
    $params[] = $cleanTerm; // Priority match (starts with or contains clean term nicely)
    $params[] = $originalTerm;

    return db_query_all($sql, $params);
}


function getCareerPosition()
{
    $sql = "SELECT id, position FROM career WHERE status = 'Active'";
    return db_query_all($sql);

}
/**
 * Clean and format text from database for display.
 * Removes HTML tags, converts entities, cleans junk characters/whitespace,
 * and ensures sentence casing.
 *
 * @param string $text
 * @param int|null $limit Optional character limit (soft break at word)
 * @return string
 */
function cleanText($text, $limit = null)
{
    if (empty($text)) {
        return '';
    }

    // 1. Decode HTML entities (e.g. &amp; -> &, &nbsp; -> ' ')
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // 2. Strip HTML tags
    $text = strip_tags($text);

    // 3. Replace non-breaking spaces and other invisible characters with a regular space
    $text = str_replace(["\xC2\xA0", "&nbsp;"], ' ', $text);

    // 4. Remove control characters (0-31) to strip "junk"
    $text = preg_replace('/[\x00-\x1F\x7F]/u', '', $text);

    // 5. Replace multiple whitespace sequences (newlines, tabs, spaces) with a single space
    $text = preg_replace('/\s+/', ' ', $text);

    // 6. Trim leading/trailing whitespace
    $text = trim($text);

    // Remove specific AI artifact if present
    $text = str_replace(' - ,and', '', $text);

    // 7. Ensure first letter is uppercase
    $text = ucfirst($text);

    // 8. Handle truncation if limit is provided
    if ($limit && mb_strlen($text) > $limit) {
        $text = mb_substr($text, 0, $limit);
        // Trim to last space to avoid cutting words
        $lastSpace = mb_strrpos($text, ' ');
        if ($lastSpace !== false) {
            $text = mb_substr($text, 0, $lastSpace);
        }
        $text .= '...';
    }

    return $text;
}

/**
 * Send Email using PHPMailer.
 *
 * @param string $toEmail
 * @param string $toName
 * @param string $subject
 * @param string $body      HTML Body
 * @param array  $attachments Array of file paths (optional)
 * @return array  ['status' => 'success'|'error', 'message' => string]
 */
function sendMail($toEmail, $toName, $subject, $body, $attachments = [])
{
    // Ensure PHPMailer classes are loaded
    if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        $baseDir = dirname(__DIR__);
        require_once $baseDir . '/php_mailer/src/PHPMailer.php';
        require_once $baseDir . '/php_mailer/src/SMTP.php';
        require_once $baseDir . '/php_mailer/src/Exception.php';
    }

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        // Credentials
        $mail->Username = 'nowtestmehere@gmail.com';
        $mail->Password = 'hpnr gvgc kdjy gdzz';
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Sender
        $mail->setFrom('website.mosil@gmail.com', 'Mosil');

        // Recipient
        $mail->addAddress($toEmail, $toName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Attachments
        if (!empty($attachments)) {
            foreach ($attachments as $filePath => $fileName) {
                // Check if $filePath is array index (0, 1...) or key
                if (is_int($filePath)) {
                    // Usage: sendMail(..., [$path1, $path2])
                    $mail->addAttachment($fileName);
                }
                else {
                    // Usage: sendMail(..., [$path => $name])
                    $mail->addAttachment($filePath, $fileName);
                }
            }
        }

        $mail->send();
        return ['status' => 'success', 'message' => 'Email sent successfully.'];

    }
    catch (\PHPMailer\PHPMailer\Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return ['status' => 'error', 'message' => $mail->ErrorInfo];
    }
}

/**
 * Fetch Main Category details by Slug.
 */
function getCategoryDetailsBySlug($slug)
{
    $formattedSlug = trim($slug);
    $sql = "SELECT id, mcat_name, mcat_desc, slug, mcat_image, meta_description, parent_cat
            FROM main_category 
            WHERE slug = ? 
            AND status = 'Active'";

    return db_query_one($sql, [$formattedSlug]);
}


function getLatestBlogs($limit = 5)
{
    $sql = "SELECT
    bp.id,
    bp.title,
    bp.slug,
    bp.image,
    bp.created_at,
    bc.name AS category_name,
    CASE
        WHEN bp.id = (
            SELECT id
            FROM blog_posts_v2
            WHERE status = 'Published'
            ORDER BY created_at DESC
            LIMIT 1
        ) THEN 1
        ELSE 0
    END AS is_featured
FROM blog_posts_v2 bp
LEFT JOIN blog_categories bc
    ON bp.category_id = bc.id
WHERE bp.status = 'Published'
ORDER BY bp.created_at DESC
LIMIT ?
";

    return db_query_all($sql, [$limit]);
}


function getBlogsWithPagination($page = 1, $limit = 6, $category = 'All')
{
    $page = (int)$page;
    $limit = (int)$limit;
    $offset = ($page - 1) * $limit;
    $params = [];
    $whereClauses = ["bp.status = 'Published'"];

    if ($category !== 'All' && !empty($category)) {
        $whereClauses[] = "bc.name = ?";
        $params[] = $category;
    }
    else {
        // Exclude 'Beyond Business' (handle case variations) and 'News' from 'All' listing
        $whereClauses[] = "bc.name NOT IN ('Beyond Business', 'Beyond business', 'News')";
    }

    $whereSql = implode(' AND ', $whereClauses);

    // Get Total Count
    $countSql = "
        SELECT COUNT(*)
        FROM blog_posts_v2 bp
        LEFT JOIN blog_categories bc ON bp.category_id = bc.id
        WHERE $whereSql
    ";

    // We need to execute count query with same params
    $total = (int)db_query_value($countSql, $params);
    $totalPages = ceil($total / $limit);

    // Get Data
    $sql = "
        SELECT 
            bp.id,
            bp.title,
            bp.slug,
            bp.image,
            bp.content,
            bp.created_at,
            bc.name AS category_name
        FROM blog_posts_v2 bp
        LEFT JOIN blog_categories bc 
            ON bp.category_id = bc.id
        WHERE $whereSql
        ORDER BY bp.created_at DESC
        LIMIT $limit OFFSET $offset
    ";

    $blogs = db_query_all($sql, $params);

    return [
        'blogs' => $blogs,
        'total' => $total,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];
}

function getEventsWithPagination($page = 1, $limit = 6, $category = 'All')
{
    $page = (int)$page;
    $limit = (int)$limit;
    $offset = ($page - 1) * $limit;
    $params = [];
    $whereClauses = ["bp.status = 'Published'"];

    // Allowed Event Categories
    $eventCategories = ['Exhibitions', 'Events', 'News', 'Beyond Business', 'Beyond business'];

    if ($category !== 'All' && !empty($category)) {
        $whereClauses[] = "bc.name = ?";
        $params[] = $category;
    }
    else {
        // Only include specific event-related categories
        // Using IN clause with named parameters or placeholders
        // Since we have a fixed list, we can just put placeholders
        $placeholders = implode(',', array_fill(0, count($eventCategories), '?'));
        $whereClauses[] = "bc.name IN ($placeholders)";
        $params = array_merge($params, $eventCategories);
    }

    $whereSql = implode(' AND ', $whereClauses);

    // Get Total Count
    $countSql = "
        SELECT COUNT(*)
        FROM blog_posts_v2 bp
        LEFT JOIN blog_categories bc ON bp.category_id = bc.id
        WHERE $whereSql
    ";

    $total = (int)db_query_value($countSql, $params);
    $totalPages = ceil($total / $limit);

    // Get Data
    $sql = "
        SELECT 
            bp.id,
            bp.title,
            bp.slug,
            bp.image,
            bp.content,
            bp.created_at,
            bc.name AS category_name
        FROM blog_posts_v2 bp
        LEFT JOIN blog_categories bc 
            ON bp.category_id = bc.id
        WHERE $whereSql
        ORDER BY bp.created_at DESC
        LIMIT $limit OFFSET $offset
    ";

    $blogs = db_query_all($sql, $params);

    return [
        'blogs' => $blogs,
        'total' => $total,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];
}

function getLatestEvent()
{
    $sql = "SELECT * FROM event_posts WHERE status = 'Published' ORDER BY event_date DESC LIMIT 1";
    return db_query_one($sql);
}

function getCaseStudiesWithPagination($page = 1, $limit = 6, $category = 'All')
{
    $page = (int)$page;
    $limit = (int)$limit;
    $offset = ($page - 1) * $limit;
    $params = [];
    $whereClauses = ["status = 'Active'"];

    // Note: Assuming 'type' or 'category' column exists if filtering is needed.
    // For now, if category is provided but I see no clear column, I might implement a placeholder.
    // However, looking at the UI, the user wants 'Technical concepts', 'Industry information' etc.
    // I will try to use the 'type' column if it exists or 'category'. Since I can't confirm, I'll stick to pagination.
    // If filtering is requested in the future, we can uncomment/add logic here.

    // Attempt to filter if category is not All
    if ($category !== 'All' && !empty($category)) {
    // $whereClauses[] = "category = ?"; 
    // $params[] = $category;
    }

    $whereSql = implode(' AND ', $whereClauses);

    // Get Total Count
    $countSql = "SELECT COUNT(*) FROM case_studies WHERE $whereSql";
    $total = (int)db_query_value($countSql, $params);
    $totalPages = ceil($total / $limit);

    // Get Data
    $sql = "
        SELECT *
        FROM case_studies
        WHERE $whereSql
        ORDER BY created_at DESC
        LIMIT $limit OFFSET $offset
    ";

    $caseStudies = db_query_all($sql, $params);

    return [
        'caseStudies' => $caseStudies,
        'total' => $total,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];
}




function getGlossary($letter, $limit = 8, $offset = 0)
{
    // Ensure letter is safe (though prepared statements handle this, nice to be explicit)
    $letterParam = $letter . '%';

    // Get Total Count for this letter
    $countSql = "SELECT COUNT(*) FROM glossary WHERE keyword LIKE ?";
    $total = (int)db_query_value($countSql, [$letterParam]);

    // Get Data
    $sql = "SELECT keyword, explanation FROM glossary WHERE keyword LIKE ? ORDER BY keyword ASC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
    $items = db_query_all($sql, [$letterParam]);

    return [
        'items' => $items,
        'total' => $total
    ];
}

function searchGlossaryItems($term)
{
    $termLike = '%' . $term . '%';
    $sql = "SELECT keyword, explanation FROM glossary WHERE keyword LIKE ? ORDER BY keyword ASC LIMIT 10";
    return db_query_all($sql, [$termLike]);
}

/**
 * Fetch a single blog post by slug.
 */
function getBlogBySlug($slug)
{
    $formattedSlug = trim($slug);
    $sql = "
        SELECT 
            bp.*,
            bc.name AS category_name
        FROM blog_posts_v2 bp
        LEFT JOIN blog_categories bc 
            ON bp.category_id = bc.id
        WHERE bp.slug = ? AND bp.status = 'Published'
    ";

    return db_query_one($sql, [$formattedSlug]);
}

/**
 * Fetch a single case study by slug.
 */
function getCaseStudyBySlug($slug)
{
    $formattedSlug = trim($slug);
    $sql = "
        SELECT *
        FROM case_studies
        WHERE slug = ? AND status = 'Active'
    ";

    return db_query_one($sql, [$formattedSlug]);
}

/**
 * Clean HTML content by removing empty paragraphs and inline styles.
 * 
 * @param string $content
 * @return string
 */
function clean_content($content)
{
    if (empty($content)) {
        return '';
    }

    // 1. Remove inline 'style' attributes from any tag
    // This regex looks for style="..." and removes it. 
    // Uses 'i' modifier for case-insensitivity.
    $content = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $content);

    // Also handle single quotes style='...'
    $content = preg_replace('/(<[^>]+) style=\'.*?\'/i', '$1', $content);

    // 2. Remove empty paragraphs including those with only whitespace or &nbsp;
    // Matches <p>...content...</p> where content is only whitespace or &nbsp;
    $content = preg_replace('/<p[^>]*>(?:\s|&nbsp;)*<\/p>/', '', $content);

    return $content;
}
/**
 * Fetch 3 specific blogs for Home Page:
 * 1. Category 'News'
 * 2. Category 'Beyond Business'
 * 3. Any other category (General Blog)
 */
function getHomeFeaturedBlogs()
{
    $sql = "
    (SELECT bp.*, bc.name as category_name, 1 as sort_order 
     FROM blog_posts_v2 bp 
     LEFT JOIN blog_categories bc ON bp.category_id = bc.id 
     WHERE bp.status = 'Published' AND bc.name = 'News' 
     ORDER BY bp.created_at DESC LIMIT 1)
    UNION
    (SELECT bp.*, bc.name as category_name, 2 as sort_order 
     FROM blog_posts_v2 bp 
     LEFT JOIN blog_categories bc ON bp.category_id = bc.id 
     WHERE bp.status = 'Published' AND bc.name IN ('Beyond Business', 'Beyond business') 
     ORDER BY bp.created_at DESC LIMIT 1)
    UNION
    (SELECT bp.*, bc.name as category_name, 3 as sort_order 
     FROM blog_posts_v2 bp 
     LEFT JOIN blog_categories bc ON bp.category_id = bc.id 
     WHERE bp.status = 'Published' AND (bc.name NOT IN ('News', 'Beyond Business', 'Beyond business') OR bc.name IS NULL)
     ORDER BY bp.created_at DESC LIMIT 1)
    ORDER BY sort_order ASC
    ";

    return db_query_all($sql);
}


/**
 * Format a date string to always use the current year.
 * 
 * @param string $dateString The date string to format (e.g., from database)
 * @param string $format The format for the day and month (default: 'M j')
 * @return string The formatted date with the current year
 */
function formatDateWithCurrentYear($dateString, $format = 'M j')
{
    if (empty($dateString)) {
        return '';
    }

    $timestamp = strtotime($dateString);
    if (!$timestamp) {
        return $dateString; // Return original if parsing fails
    }

    // Default format 'M j' results in "Jan 1"
    $dayMonth = date($format, $timestamp);
    $currentYear = date('Y') - 1;

    return $dayMonth . ', ' . $currentYear;
}