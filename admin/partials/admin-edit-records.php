<?php

/**
 * Record editing page.
 */

?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html(get_admin_page_title()); ?></h1>

    <form id="members-edit" method="post">
        <input type="hidden" name="updatemember" value="true" />
<?php

$this->member_form->display();

?>
    </form>
</div>
