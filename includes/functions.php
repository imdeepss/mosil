<?php


/**
 * --------------------------------------------------------------------------
 * Core Database Helpers
 * --------------------------------------------------------------------------
 */

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
    } catch (PDOException $e) {
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
    } catch (PDOException $e) {
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
    } catch (PDOException $e) {
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
    } catch (PDOException $e) {
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
    $limit = (int) $limit;
    $offset = (int) $offset;

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
    return (int) db_query_value($sql);
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
            ORDER BY mcat_name ASC";

    if (!empty($limit)) {
        $sql .= " LIMIT " . intval($limit);
    }

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
    $limit = (int) $limit;
    $sql = "SELECT id, question, answer, category, subcategory 
            FROM faq 
            WHERE status = 'Active' 
            ORDER BY id ASC 
            LIMIT $limit";

    return db_query_all($sql);
}


function getBlogs($limit = null)
{
    $limit = (int) $limit;
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


function getRelatedProducts($subCatString, $currentProductId)
{

    $ids = explode(',', $subCatString);
    if (empty($ids))
        return [];


    $conditions = [];
    foreach ($ids as $id) {
        $conditions[] = "FIND_IN_SET(?, p.sub_cat)";
    }
    $whereClause = implode(' OR ', $conditions);


    $sql = "SELECT p.id, p.name, p.slug, p.image, p.sub_title, p.short_description 
            FROM products_v2 p 
            WHERE ($whereClause) 
              AND p.id != ? 
              AND p.status = 'Active' 
            ORDER BY p.id DESC 
            LIMIT 10";


    $params = array_merge($ids, [$currentProductId]);

    return db_query_all($sql, $params);
}


function searchProducts($searchQuery)
{
    $searchQueryLiked = "%" . $searchQuery . "%";
    $sql = "SELECT name, slug 
            FROM products_v2 
            WHERE status = 'Active' AND (
                REPLACE(LOWER(name), ' - ', '') LIKE ? OR
                REPLACE(LOWER(slug), ' - ', '') LIKE ? OR
                REPLACE(LOWER(sub_title), ' ', '') LIKE ? OR
                REPLACE(LOWER(parent_cat), ' - ', '') LIKE ? OR
                REPLACE(LOWER(main_cat), ' - ', '') LIKE ? OR
                REPLACE(LOWER(sub_cat), ' - ', '') LIKE ? OR
                REPLACE(LOWER(attribute), ' - ', '') LIKE ? OR
                REPLACE(LOWER(main_attribute), ' - ', '') LIKE ? OR
                REPLACE(LOWER(sub_attribute), ' - ', '') LIKE ? OR
                REPLACE(LOWER(tds_file), ' - ', '') LIKE ? OR
                REPLACE(LOWER(image), ' - ', '') LIKE ? OR
                REPLACE(LOWER(short_description), ' - ', '') LIKE ? OR
                REPLACE(LOWER(area_of_application), ' - ', '') LIKE ? OR
                REPLACE(LOWER(benifits), ' - ', '') LIKE ? OR
                REPLACE(LOWER(characteristics), ' - ', '') LIKE ?
            )
            LIMIT 10";

    // Create an array with the search query repeated 15 times
    $params = array_fill(0, 15, $searchQueryLiked);

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
        $mail->Password = 'ptan mqmv utcu roya';
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Sender
        $mail->setFrom('nowtestmehere@gmail.com', 'Mosil');

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
                } else {
                    // Usage: sendMail(..., [$path => $name])
                    $mail->addAttachment($filePath, $fileName);
                }
            }
        }

        $mail->send();
        return ['status' => 'success', 'message' => 'Email sent successfully.'];

    } catch (\PHPMailer\PHPMailer\Exception $e) {
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
    $page = (int) $page;
    $limit = (int) $limit;
    $offset = ($page - 1) * $limit;
    $params = [];
    $whereClauses = ["bp.status = 'Published'"];

    if ($category !== 'All' && !empty($category)) {
        $whereClauses[] = "bc.name = ?";
        $params[] = $category;
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
    $total = (int) db_query_value($countSql, $params);
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

function getCaseStudiesWithPagination($page = 1, $limit = 6, $category = 'All')
{
    $page = (int) $page;
    $limit = (int) $limit;
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
    $total = (int) db_query_value($countSql, $params);
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
?>