<?php

/**
 * Main record interface page.
 */

$member_list_table = new Member_DB_Manager_Admin_Member_List_Table();
$member_list_table->prepare_items();

?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html(get_admin_page_title()); ?></h1>

    <form id="members" method="get">
<?php

//$member_list_table->search_box('Search Members', 'member');
$member_list_table->display();

?>
    </form>
</div>
