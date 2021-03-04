<?php

/**
 * Main record interface page.
 */

global $wpdb;


?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form id="members" method="get">

        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column"><input id="cb-select-all-1" type="checkbox"></td>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Joined</th>
                    <th scope="col">Renewed</th>
                    <th scope="col">Expires</th>
                </tr>
            </thead>
            <tbody>
<?php

$table_name = $wpdb->prefix.$plugin_options['db_name'];
$records = $wpdb->get_results('SELECT * FROM '.$table_name);

foreach($records as $r) {
    $rowhtml = '            <tr>';
    $rowhtml .= '<th scope="row" class="check-column"><input id="cb-select-'.$r->id.'" type="checkbox" name="member[]" value="'.$r->id.'"></th>';
    $rowhtml .= '<td>'.$r->firstname.'</td>';
    $rowhtml .= '<td>'.$r->lastname.'</td>';
    $rowhtml .= '<td>'.$r->email.'</td>';
    $rowhtml .= '<td>'.$r->createdate.'</td>';
    $rowhtml .= '<td>'.$r->updatedate.'</td>';
    $rowhtml .= '<td>'.$r->expiredate.'</td>';
    $rowhtml .= '</tr>';
    echo $rowhtml."\n";
}

?>
            </tbody>
        </table>

    </form>
</div>
