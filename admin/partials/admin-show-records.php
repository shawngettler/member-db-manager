<?php

/**
 * Main record interface page.
 */

?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html(get_admin_page_title()); ?></h1>
    <a href="<?php echo admin_url().'admin.php?page=member-db-manager&view=edit'; ?>" class="page-title-action">Add New</a>

    <form id="members-filter" method="get">
        <input type="hidden" name="page" value="<?php echo $_GET['page'] ?>" />
<?php

$this->member_list_table->search_box('Search Members', 'member');
$this->member_list_table->display();

?>
    </form>
</div>
