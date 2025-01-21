<?php
// Enqueue Parent and Child Theme Styles
function jobmonster_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}
add_action('wp_enqueue_scripts', 'jobmonster_child_enqueue_styles');

// Register Custom Post Type: Job
if ( ! function_exists( 'jm_register_job_post_type' ) ) :
    function jm_register_job_post_type() {
        // Register the custom post type 'noo_job'
        register_post_type(
            'noo_job',
            array(
                'labels' => array(
                    'name'               => __( 'Book My Jobs', 'noo' ),
                    'singular_name'      => __( 'Job', 'noo' ),
                    'add_new'            => __( 'Add New Job', 'noo' ),
                    'add_new_item'       => __( 'Add Job', 'noo' ),
                    'edit'               => __( 'Edit', 'noo' ),
                    'edit_item'          => __( 'Edit Job', 'noo' ),
                    'new_item'           => __( 'New Job', 'noo' ),
                    'view'               => __( 'View', 'noo' ),
                    'view_item'          => __( 'View Job', 'noo' ),
                    'search_items'       => __( 'Search Job', 'noo' ),
                    'not_found'          => __( 'No Jobs found', 'noo' ),
                    'not_found_in_trash' => __( 'No Jobs found in Trash', 'noo' ),
                    'parent'             => __( 'Parent Job', 'noo' ),
                    'all_items'          => __( 'All Jobs', 'noo' ),
                ),
                'description'         => __( 'This is a place where you can add new job.', 'noo' ),
                'public'              => true,
                'menu_icon'           => 'dashicons-portfolio',
                'show_ui'             => true,
                'capability_type'     => 'post',
                'map_meta_cap'        => true,
                'publicly_queryable'  => true,
                'exclude_from_search' => false,
                'hierarchical'        => false,
                'rewrite'             => array( 'slug' => 'jobs' ),
                'query_var'           => true,
                'supports'            => array( 'title', 'editor', 'thumbnail', 'comments' ),
                'has_archive'         => true,
                'show_in_nav_menus'   => true,
                'delete_with_user'    => true,
                'can_export'          => true
            )
        );

        // Register the taxonomy 'job_category'
        register_taxonomy(
            'job_category',
            array('noo_job','course'),
            array(
                'labels'       => array(
                    'name'          => __( 'Category', 'noo' ),
                    'add_new_item'  => __( 'Add New Job Category', 'noo' ),
                    'new_item_name' => __( 'New Job Category', 'noo' )
                ),
                'hierarchical' => true,
                'query_var'    => true,
                'rewrite'      => array( 'slug' => 'job-category' )
            )
        );

        // Register the taxonomy 'job_type'
        register_taxonomy(
            'job_type',
            'noo_job',
            array(
                'labels'       => array(
                    'name'          => __( 'Job Type', 'noo' ),
                    'add_new_item'  => __( 'Add New Job Type', 'noo' ),
                    'new_item_name' => __( 'New Job Type', 'noo' )
                ),
                'hierarchical' => true,
                'query_var'    => true,
                'rewrite'      => array( 'slug' => 'job-type' )
            )
        );

        // Register the taxonomy 'job_tag'
        register_taxonomy(
            'job_tag',
            'noo_job',
            array(
                'labels'       => array(
                    'name'          => __( 'Job Tag', 'noo' ),
                    'add_new_item'  => __( 'Add New Job Tag', 'noo' ),
                    'new_item_name' => __( 'New Job Tag', 'noo' )
                ),
                'hierarchical' => false,
                'query_var'    => true,
                'rewrite'      => array( 'slug' => 'job-tag' )
            )
        );

        // Register the taxonomy 'job_location'
        register_taxonomy(
            'job_location',
            'noo_job',
            array(
                'labels'       => array(
                    'name'          => __( 'Job Location', 'noo' ),
                    'add_new_item'  => __( 'Add New Job Location', 'noo' ),
                    'new_item_name' => __( 'New Job Location', 'noo' )
                ),
                'hierarchical' => true,
                'query_var'    => true,
                'rewrite'      => array( 'slug' => 'job-location' )
            )
        );
    }
    add_action( 'init', 'jm_register_job_post_type' );
endif;



// Register Custom Post Type: Courses
function create_course_post_type() {
    $labels = array(
        'name'               => _x('SMECLabs Courses', 'post type general name'),
        'singular_name'      => _x('Course', 'post type singular name'),
        'menu_name'          => _x('Courses', 'admin menu'),
        'name_admin_bar'     => _x('Course', 'add new on admin bar'),
        'add_new'            => _x('Add New', 'course'),
        'add_new_item'       => __('Add New Course'),
        'new_item'           => __('New Course'),
        'edit_item'          => __('Edit Course'),
        'view_item'          => __('View Course'),
        'all_items'          => __('All Courses'),
        'search_items'       => __('Search Courses'),
        'parent_item_colon'  => __('Parent Courses:'),
        'not_found'          => __('No courses found.'),
        'not_found_in_trash' => __('No courses found in Trash.')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
		'menu_icon'			=> 'dashicons-id',
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'courses'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5, // Adjust menu position if needed
        'supports'           => array('title', 'editor', 'thumbnail')
    );

    register_post_type('course', $args);
}
add_action('init', 'create_course_post_type');

// Flush rewrite rules manually after theme activation
function my_rewrite_flush() {
    create_course_post_type(); // Ensure this is called after the custom post type is registered.
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'my_rewrite_flush');

// Fetch courses with job category taxonomy
function get_related_courses($job_id) {
    $categories = wp_get_post_terms($job_id, 'job_category', array('fields' => 'ids'));

    $args = array(
        'post_type' => 'course',
        'tax_query' => array(
            array(
                'taxonomy' => 'job_category',
                'field'    => 'term_id',
                'terms'    => $categories,
            ),
        ),
        'posts_per_page' => -1,
    );

    return new WP_Query($args);
}

function jm_add_custom_columns( $columns ) {
    // Insert the Job ID column at the beginning
    $new_columns = array(
        'job_id' => __( 'Job ID', 'noo' )
    );

    return array_merge($new_columns, $columns);
}
add_filter( 'manage_noo_job_posts_columns', 'jm_add_custom_columns' );

// Display the Job ID in the custom column
function jm_custom_column_content( $column, $post_id ) {
    if ( 'job_id' === $column ) {
        echo $post_id; // Display the Job ID
    }
}
add_action( 'manage_noo_job_posts_custom_column', 'jm_custom_column_content', 10, 2 );

// Make the Job ID column sortable (Optional)
function jm_sortable_custom_columns( $columns ) {
    $columns['job_id'] = 'ID';
    return $columns;
}
add_filter( 'manage_edit-noo_job_sortable_columns', 'jm_sortable_custom_columns' );



// 15-01-2025 updates 
// Display custom fields (DOB, Qualification, and Phone) in the user profile page
function display_custom_user_profile_fields($user) {
    ?>
    <h3><?php esc_html_e('Additional Information', 'textdomain'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="dob"><?php esc_html_e('Date of Birth', 'textdomain'); ?></label></th>
            <td>
                <!-- Ensure the date is displayed in YYYY-MM-DD format -->
                <input type="date" 
                       name="dob" 
                       id="dob" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'dob', true)); ?>" 
                       class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="degree"><?php esc_html_e('Qualification', 'textdomain'); ?></label></th>
            <td>
                <input type="text" 
                       name="degree" 
                       id="degree" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'degree', true)); ?>" 
                       class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="phone"><?php esc_html_e('Phone Number', 'textdomain'); ?></label></th>
            <td>
                <input type="text" 
                       name="phone" 
                       id="phone" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" 
                       class="regular-text" />
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'display_custom_user_profile_fields');
add_action('edit_user_profile', 'display_custom_user_profile_fields');

// Save custom fields when the user updates their profile
function custom_candidate_save_profile_fields($user_id) {
    // Check user permissions
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    // Save Date of Birth (in YYYY-MM-DD format)
    if (isset($_POST['dob']) && !empty($_POST['dob'])) {
        update_user_meta($user_id, 'dob', sanitize_text_field($_POST['dob']));
    } else {
        delete_user_meta($user_id, 'dob'); // Remove if not set
    }

    // Save Qualification
    if (isset($_POST['degree']) && !empty($_POST['degree'])) {
        update_user_meta($user_id, 'degree', sanitize_text_field($_POST['degree']));
    } else {
        delete_user_meta($user_id, 'degree'); // Remove if not set
    }

    // Save Phone Number
    if (isset($_POST['phone']) && !empty($_POST['phone'])) {
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    } else {
        delete_user_meta($user_id, 'phone'); // Remove if not set
    }
}
add_action('personal_options_update', 'custom_candidate_save_profile_fields');
add_action('edit_user_profile_update', 'custom_candidate_save_profile_fields');



// Add 'dob' and 'qualification' columns to the Users table in the admin
function admin_custom_columns($columns) {
    $columns['dob'] = esc_html__('Date of Birth', 'textdomain');
    $columns['degree'] = esc_html__('Qualification', 'textdomain');
    $columns['phone'] = esc_html__('Phone', 'textdomain');

    return $columns;
}
add_filter('manage_users_columns', 'admin_custom_columns');

// Show the data for 'dob' and 'qualification' in the admin users table
function show_custom_columns_data($val, $column_name, $user_id) {
    if ('dob' == $column_name) {
        $dob = get_user_meta($user_id, 'dob', true);
        return $dob ? esc_html($dob) : 'N/A';
    }

    if ('degree' == $column_name) {
        $degree = get_user_meta($user_id, 'degree', true);
        return $degree ? esc_html($degree) : 'N/A';
    }
    if ('phone' == $column_name) {
        $phone = get_user_meta($user_id, 'phone', true);
        return $phone ? esc_html($phone) : 'N/A';
    }

    return $val;
}
add_action('manage_users_custom_column', 'show_custom_columns_data', 10, 3);


add_action('user_register', 'save_noo_register_fields');

function save_noo_register_fields($user_id) {
    
        update_user_meta($user_id, 'dob', sanitize_text_field($_POST['dob']));

    
        update_user_meta($user_id, 'degree', sanitize_text_field($_POST['degree']));
    
    
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    
}
//add_action('user_register', 'save_noo_register_fields');

//candidate post 




function display_candidates_admin_page() {
    add_menu_page(
        __('Candidates'), // Page title
        __('Candidates'), // Menu title
        'manage_options', // Capability
        'candidate-users', // Menu slug
        'render_candidates_page', // Callback function to render the page
        'dashicons-groups', // Icon for the menu
        6 // Position in the menu
    );
}
add_action('admin_menu', 'display_candidates_admin_page');


//display candidates 

function render_candidates_page() {
    global $wpdb;

    // Fetch date range from the request
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';

    // Build the query conditionally based on the date range
    $query = "SELECT u.ID, u.user_email, u.user_registered, 
              um1.meta_value as phone, um2.meta_value as dob, um3.meta_value as degree 
              FROM {$wpdb->users} u 
              INNER JOIN {$wpdb->usermeta} um ON u.ID = um.user_id 
              INNER JOIN {$wpdb->usermeta} um1 ON u.ID = um1.user_id 
              INNER JOIN {$wpdb->usermeta} um2 ON u.ID = um2.user_id 
              INNER JOIN {$wpdb->usermeta} um3 ON u.ID = um3.user_id 
              WHERE um.meta_key = 'wp_capabilities' 
                AND um.meta_value LIKE '%candidate%' 
                AND um1.meta_key = 'phone' 
                AND um2.meta_key = 'dob' 
                AND um3.meta_key = 'degree'";

    if (!empty($start_date) && !empty($end_date)) {
        $query .= $wpdb->prepare(
            " AND DATE(u.user_registered) BETWEEN %s AND %s",
            $start_date,
            $end_date
        );
    }

    // Execute the query
    $candidate_users = $wpdb->get_results($query);

    // Display the filter form
    echo '<div class="wrap">';
    echo '<h1>' . __('All Candidates') . '</h1>';
    echo '<form method="get" style="margin-bottom: 15px;">';
    echo '<input type="hidden" name="post_type" value="candidates">';
    echo '<input type="hidden" name="page" value="candidate-users">';
    echo '<label for="start_date">Start Date:</label> ';
    echo '<input type="date" name="start_date" value="' . esc_attr($start_date) . '"> ';
    echo '<label for="end_date">End Date:</label> ';
    echo '<input type="date" name="end_date" value="' . esc_attr($end_date) . '"> ';
    echo '<button type="submit" class="button-primary" style="background-color: #04AA6D;">Filter</button>';
    echo '</form>';

    // Export button
    echo '<a href="' . admin_url('admin-post.php?action=export_candidates&start_date=' . esc_attr($start_date) . '&end_date=' . esc_attr($end_date)) . '" class="button-primary" style="margin-bottom: 15px;background-color: #04AA6D;">Export to Excel</a>';

    // Display the table
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>DOB</th><th>Degree</th><th>Registration Date</th></tr></thead><tbody>';

    if ($candidate_users) {
        foreach ($candidate_users as $user) {
            echo '<tr>';
            echo '<td>' . esc_html(get_userdata($user->ID)->display_name) . '</td>';
            echo '<td>' . esc_html($user->user_email) . '</td>';
            echo '<td>' . esc_html($user->phone) . '</td>';
            echo '<td>' . esc_html($user->dob) . '</td>';
            echo '<td>' . esc_html($user->degree) . '</td>';
            echo '<td>' . esc_html($user->user_registered) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="6">' . __('No candidates found.') . '</td></tr>';
    }

    echo '</tbody></table></div>';
}

// Include PhpSpreadsheet's autoload file
require_once get_stylesheet_directory() . '/vendor/autoload.php';

// Use PhpSpreadsheet namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Export candidates to Excel
function export_candidates_to_excel() {
    global $wpdb;

    // Fetch date range from the request
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';

    // Build the query to fetch candidate data
    $query = "SELECT u.ID, u.user_email, u.user_registered, 
              um1.meta_value AS phone, um2.meta_value AS dob, um3.meta_value AS degree
              FROM {$wpdb->users} u
              INNER JOIN {$wpdb->usermeta} um1 ON u.ID = um1.user_id
              INNER JOIN {$wpdb->usermeta} um2 ON u.ID = um2.user_id
              INNER JOIN {$wpdb->usermeta} um3 ON u.ID = um3.user_id
              WHERE um1.meta_key = 'phone'
                AND um2.meta_key = 'dob'
                AND um3.meta_key = 'degree'
                AND u.ID IN (
                    SELECT user_id
                    FROM {$wpdb->usermeta}
                    WHERE meta_key = 'wp_capabilities'
                      AND meta_value LIKE '%candidate%'
                )";

    // Add date range filtering
    if (!empty($start_date) && !empty($end_date)) {
        $query .= $wpdb->prepare(
            " AND DATE(u.user_registered) BETWEEN %s AND %s",
            $start_date,
            $end_date
        );
    }

    // Execute the query
    $results = $wpdb->get_results($query, ARRAY_A);

    if (empty($results)) {
        wp_die('No candidates found for the specified date range.');
    }

    // Create a new PhpSpreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set sheet title
    $sheet->setTitle('Candidates');

    // Add headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Email');
    $sheet->setCellValue('C1', 'Registered Date');
    $sheet->setCellValue('D1', 'Phone');
    $sheet->setCellValue('E1', 'Date of Birth');
    $sheet->setCellValue('F1', 'Degree');

    // Populate data
    $row = 2;
    foreach ($results as $result) {
        $sheet->setCellValue('A' . $row, $result['ID']);
        $sheet->setCellValue('B' . $row, $result['user_email']);
        $sheet->setCellValue('C' . $row, $result['user_registered']);
        $sheet->setCellValue('D' . $row, $result['phone']);
        $sheet->setCellValue('E' . $row, $result['dob']);
        $sheet->setCellValue('F' . $row, $result['degree']);
        $row++;
    }

    // Clear output buffer before starting file download
    if (ob_get_contents()) {
        ob_end_clean();
    }

    // Set headers for file download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="candidates.xlsx"');
    header('Cache-Control: max-age=0');
    header('Expires: 0');
    header('Pragma: public');

    // Write the file to output
    $writer = new Xlsx($spreadsheet);  // Use Xlsx writer for .xlsx format
    $writer->save('php://output');
    exit;
}

// Hook the function to WordPress admin post action
add_action('admin_post_export_candidates', 'export_candidates_to_excel');
