<?php
// Check if session has timed out
if (isSessionTimedOut()) {
    // Redirect to login page
    header("Location: logout");
    exit;
}
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-5">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo $active_menu === 'dashboard' ? 'active' : ''; ?>" href="/">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>

            <!-- CMS Section -->
            <li class="nav-item">
                <a class="nav-link <?php echo $active_menu === 'cms' ? 'active' : ''; ?>" data-bs-toggle="collapse"
                    href="#cmsSubmenu" role="button" aria-expanded="false" aria-controls="cmsSubmenu">
                    <i class="fas fa-file-alt me-2"></i>
                    CMS
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse <?php echo strpos($active_menu, 'cms_') === 0 ? 'show' : ''; ?>" id="cmsSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'cms_company' ? 'active' : ''; ?>"
                                href="cms_company">
                                <i class="fas fa-building me-2"></i>
                                Company Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'cms_content' ? 'active' : ''; ?>"
                                href="cms_content">
                                <i class="fas fa-file-alt me-2"></i>
                                Content Page
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'cms_slider' ? 'active' : ''; ?>"
                                href="cms_slider">
                                <i class="fas fa-images me-2"></i>
                                Home Slider
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'case_studies' ? 'active' : ''; ?>"
                                href="case_studies">
                                <i class="fas fa-briefcase me-2"></i>
                                Case Studies
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'cms_history' ? 'active' : ''; ?>"
                                href="cms_history">
                                <i class="fas fa-history me-2"></i>
                                History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'cms_social' ? 'active' : ''; ?>"
                                href="cms_social">
                                <i class="fas fa-share-alt me-2"></i>
                                Social Media
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'cms_product_group' ? 'active' : ''; ?>"
                                href="cms_product_group">
                                <i class="fas fa-layer-group me-2"></i>
                                Product Group
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Blog Section -->
            <li class="nav-item">
                <a class="nav-link <?php echo $active_menu === 'blog' ? 'active' : ''; ?>" data-bs-toggle="collapse"
                    href="#blogSubmenu" role="button" aria-expanded="false" aria-controls="blogSubmenu">
                    <i class="fas fa-blog me-2"></i>
                    Blogs
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse <?php echo strpos($active_menu, 'blog_') === 0 ? 'show' : ''; ?>" id="blogSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'blog_posts' ? 'active' : ''; ?>"
                                href="blog_posts">
                                <i class="fas fa-pen me-2"></i>
                                Blog Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'blog_categories' ? 'active' : ''; ?>"
                                href="blog_categories">
                                <i class="fas fa-folder-open me-2"></i>
                                Blog Categories
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- News Section -->
            <li class="nav-item">
                <a class="nav-link <?php echo $active_menu === 'news' ? 'active' : ''; ?>" data-bs-toggle="collapse"
                    href="#newsSubmenu" role="button" aria-expanded="false" aria-controls="newsSubmenu">
                    <i class="fas fa-newspaper me-2"></i>
                    News
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse <?php echo strpos($active_menu, 'news_') === 0 ? 'show' : ''; ?>" id="newsSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'news_posts' ? 'active' : ''; ?>"
                                href="news_posts">
                                <i class="fas fa-pen me-2"></i>
                                News Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'news_categories' ? 'active' : ''; ?>"
                                href="news_categories">
                                <i class="fas fa-folder-open me-2"></i>
                                News Categories
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Catalogue Section -->
            <li class="nav-item">
                <a class="nav-link <?php echo $active_menu === 'catalogue' ? 'active' : ''; ?>"
                    data-bs-toggle="collapse" href="#catalogueSubmenu" role="button" aria-expanded="false"
                    aria-controls="catalogueSubmenu">
                    <i class="fas fa-book me-2"></i>
                    Catalogue
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse <?php echo strpos($active_menu, 'catalogue_') === 0 ? 'show' : ''; ?>"
                    id="catalogueSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'catalogue_main_category' ? 'active' : ''; ?>"
                                href="catalogue_main_category">
                                <i class="fas fa-folder me-2"></i>
                                Main Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'catalogue_sub_category' ? 'active' : ''; ?>"
                                href="catalogue_sub_category">
                                <i class="fas fa-folder-open me-2"></i>
                                Sub Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'catalogue_parent_attribute' ? 'active' : ''; ?>"
                                href="catalogue_parent_attribute">
                                <i class="fas fa-tags me-2"></i>
                                Parent Attribute
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'catalogue_main_attribute' ? 'active' : ''; ?>"
                                href="catalogue_main_attribute">
                                <i class="fas fa-tag me-2"></i>
                                Main Attribute
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'catalogue_sub_attribute' ? 'active' : ''; ?>"
                                href="catalogue_sub_attribute">
                                <i class="fas fa-tags me-2"></i>
                                Sub Attribute
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'catalogue_product' ? 'active' : ''; ?>"
                                href="catalogue_product">
                                <i class="fas fa-box me-2"></i>
                                Product
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Resources Section -->
            <li class="nav-item">
                <a class="nav-link <?php echo $active_menu === 'resources' ? 'active' : ''; ?>"
                    data-bs-toggle="collapse" href="#resourcesSubmenu" role="button" aria-expanded="false"
                    aria-controls="resourcesSubmenu">
                    <i class="fas fa-book-open me-2"></i>
                    Resources
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse <?php echo strpos($active_menu, 'resources_') === 0 ? 'show' : ''; ?>"
                    id="resourcesSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'resources_faq_category' ? 'active' : ''; ?>"
                                href="resources_faq_category">
                                <i class="fas fa-question-circle me-2"></i>
                                FAQ Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'resources_glossary' ? 'active' : ''; ?>"
                                href="resources_glossary">
                                <i class="fas fa-book me-2"></i>
                                Glossary
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Enquiries Section -->
            <li class="nav-item">
                <a class="nav-link <?php echo $active_menu === 'enquiries' ? 'active' : ''; ?>"
                    data-bs-toggle="collapse" href="#enquiriesSubmenu" role="button" aria-expanded="false"
                    aria-controls="enquiriesSubmenu">
                    <i class="fas fa-envelope me-2"></i>
                    All Enquiries
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse <?php echo strpos($active_menu, 'enquiries_') === 0 ? 'show' : ''; ?>"
                    id="enquiriesSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'enquiries_tds' ? 'active' : ''; ?>"
                                href="enquiries_tds">
                                <i class="fas fa-file-alt me-2"></i>
                                TDS File Enquiry
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'career' ? 'active' : ''; ?>" href="career">
                                <i class="fas fa-book me-2"></i>
                                Add Career
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'enquiries_contact' ? 'active' : ''; ?>"
                                href="enquiries_contact">
                                <i class="fas fa-address-book me-2"></i>
                                Contact Enquiry
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu === 'enquiries_career' ? 'active' : ''; ?>"
                                href="enquiries_career">
                                <i class="fas fa-briefcase me-2"></i>
                                Career Enquiry
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>System</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link <?php echo $active_menu === 'users' ? 'active' : ''; ?>" href="users">
                    <i class="fas fa-users me-2"></i>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $active_menu === 'settings' ? 'active' : ''; ?>" href="settings">
                    <i class="fas fa-cog me-2"></i>
                    Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</nav>