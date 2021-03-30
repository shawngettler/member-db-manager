<?php

/**
 * Custom form class for editing member records.
 */
class Member_DB_Manager_Admin_Member_Form {

    // member data
    private $item;


    /**
     * Initialize form.
     */
    public function __construct() {
    }


    /**
     * Return blank record item. Used for adding a new member.
     */
    public function get_empty_item() {
        return (object)array(
            'membertype' => 0,
            'memberterm' => 0,
            'createdate' => 0,
            'updatedate' => 0,
            'expiredate' => 0,
            'firstname' => '',
            'lastname' => '',
            'email' => '',
            'street' => '',
            'city' => '',
            'province' => '',
            'country' => '',
            'postalcode' => '',
            'phone' => '',
            'message' => '',
            'hearabout' => 0
        );
    }

    /**
     * Prepare form contents. Query the database to fill in values.
     */
    public function prepare() {
        global $wpdb;
        $plugin_options = get_option(MEMBER_DB_MANAGER_OPTION);

        $table_name = $wpdb->prefix.$plugin_options['db_name'];

        $this->item = $this->get_empty_item();
        if(isset($_GET['member']) && !empty($_GET['member']) && $_GET['member'] != -1) {
            $qselect = 'SELECT * FROM '.$table_name;
            $qid = $wpdb->prepare(' WHERE id = %d', $_GET['member']);
            $this->item = $wpdb->get_results($qselect.$qid)[0];

            if($wpdb->num_rows == 0) {
                wp_redirect(add_query_arg('member', '-1'));
            }
        }
    }

    /**
     * Process form data and insert or update record.
     */
    public function process() {
        global $wpdb;
        $plugin_options = get_option(MEMBER_DB_MANAGER_OPTION);

        $table_name = $wpdb->prefix.$plugin_options['db_name'];

        $memberdata = array(
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'email' => $_POST['email'],
            'street' => $_POST['street'],
            'city' => $_POST['city'],
            'province' => $_POST['province'],
            'country' => $_POST['country'],
            'postalcode' => $_POST['postalcode'],
            'membertype' => $_POST['membertype'],
            'memberterm' => $_POST['memberterm'],
            'createdate' => $_POST['createdate'],
            'updatedate' => $_POST['updatedate'],
            'expiredate' => $_POST['expiredate']
        );

        if($_POST['action'] == 'updatemember') {
            $wpdb->update($table_name, $memberdata, array('id' => $_POST['id']));
        } else {
            $wpdb->insert($table_name, $memberdata);
        }
        wp_redirect(add_query_arg('view', 'show'));
    }

    /**
     * Displays the form.
     */
    public function display() {
        if(isset($this->item->id)) {
            echo '<input type="hidden" name="action" value="updatemember" />';
            echo '<input type="hidden" name="id" value="'.$this->item->id.'" />';
        } else {
            echo '<input type="hidden" name="action" value="createmember" />';
        }

?>
<table class="form-table">
    <tbody>
        <tr class="form-field"><th scope="row">First Name</th><td><input type="text" name="firstname" value="<?php echo $this->item->firstname; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">Last Name</th><td><input type="text" name="lastname" value="<?php echo $this->item->lastname; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">Email</th><td><input type="text" name="email" value="<?php echo $this->item->email; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">Street</th><td><input type="text" name="street" value="<?php echo $this->item->street; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">City</th><td><input type="text" name="city" value="<?php echo $this->item->city; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">Province</th><td><input type="text" name="province" value="<?php echo $this->item->province; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">Country</th><td><input type="text" name="country" value="<?php echo $this->item->country; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">Postal Code</th><td><input type="text" name="postalcode" value="<?php echo $this->item->postalcode; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">Membership Type</th><td><input type="text" name="membertype" value="<?php echo $this->item->membertype; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">Membership Term</th><td><input type="text" name="memberterm" value="<?php echo $this->item->memberterm; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">Joined</th><td><input type="date" name="createdate" value="<?php echo $this->item->createdate; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">Renewed</th><td><input type="date" name="updatedate" value="<?php echo $this->item->updatedate; ?>" /></td></tr>
        <tr class="form-field"><th scope="row">Expires</th><td><input type="date" name="expiredate" value="<?php echo $this->item->expiredate; ?>" /></td></tr>
    </tbody>
</table>
<?php

        if(isset($this->item->id)) {
            echo '<p class="submit"><input type="submit" class="button button-primary" value="Update Member" /></p>';
        } else {
            echo '<p class="submit"><input type="submit" class="button button-primary" value="Add New Member" /></p>';
        }
    }

}

?>
