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
    $sql = "SELECT id, mcat_name, mcat_desc, slug, mcat_image
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
    $sql = "SELECT * FROM case_studies WHERE status = 'Active' ORDER BY created_at ASC LIMIT $limit";

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
?>