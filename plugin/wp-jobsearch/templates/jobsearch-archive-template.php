<?php
global $jobsearch_plugin_options;
if (wp_is_mobile()) {
    get_header('mobile');
} else {
    get_header();
}


$plugin_default_view = isset($jobsearch_plugin_options['jobsearch-default-page-view']) ? $jobsearch_plugin_options['jobsearch-default-page-view'] : 'full';
$plugin_default_view_with_str = '';
if ($plugin_default_view == 'boxed') {

    $plugin_default_view_with_str = isset($jobsearch_plugin_options['jobsearch-boxed-view-width']) && $jobsearch_plugin_options['jobsearch-boxed-view-width'] != '' ? $jobsearch_plugin_options['jobsearch-boxed-view-width'] : '1140px';
    if ($plugin_default_view_with_str != '') {
        $plugin_default_view_with_str = ' style="width:' . $plugin_default_view_with_str . '"';
    }
}
$jobsearch_post_type = get_query_var( 'post_type', 'job' );

if(!empty($jobsearch_post_type == 'employer')){
    $jobsearch_search_list_page = isset($jobsearch_plugin_options['jobsearch_emp_result_page']) ? $jobsearch_plugin_options['jobsearch_emp_result_page'] : '';    
} elseif(!empty($jobsearch_post_type == 'candidate')){
    $jobsearch_search_list_page = isset($jobsearch_plugin_options['jobsearch_cand_result_page']) ? $jobsearch_plugin_options['jobsearch_cand_result_page'] : '';    
} else {
    $jobsearch_search_list_page = isset($jobsearch_plugin_options['jobsearch_search_list_page']) ? $jobsearch_plugin_options['jobsearch_search_list_page'] : '';
}
?>
<div class="jobsearch-main-content">
    <div class="jobsearch-plugin-default-container" <?php echo force_balance_tags($plugin_default_view_with_str); ?>>
        <?php
        if(!empty($jobsearch_search_list_page)) {    
            $jobsearch_search_page_id = jobsearch__get_post_id($jobsearch_search_list_page, 'page');
            $jobsearch_args = array(
                'p'         => $jobsearch_search_page_id,
                'post_type' => 'any'
            );
            $jobsearch_posts = new WP_Query($jobsearch_args);
            if($jobsearch_posts->have_posts()):
                while ($jobsearch_posts->have_posts()) : $jobsearch_posts->the_post();
                    //echo htmlentities(get_the_content());
                    the_content();
                endwhile;
                wp_reset_postdata();
            endif;
        }
        ?>
    </div>
</div>
<?php
get_footer();
