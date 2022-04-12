<?php

if ( ! class_exists( "WP_List_Table" ) ) {
	require_once( ABSPATH . "wp-admin/includes/class-wp-list-table.php" );
}

class Persons_Table extends WP_List_Table{

    private $_items;

    function set_data($data){
        $this->_items = $data;
    }

    function get_columns(){
        return [
            'cb'    => '<input type="checkbox">',
            'name'  => __('Name', 'tabledata'),
            'sex'  => __('Gender', 'tabledata'),
            'email' => __('E-Mail', 'tabledata'),
            'age'   => __('Age', 'tabledata'),
        ];
    }

    function get_sortable_columns(){
        // sorting by name and age
        return [
            'age'  => [ 'age', true],
            'name' => [ 'name', true ],
        ];
    }

    function column_cb($item){
        return "<input type='checkbox' value='{$item['id']}'/>";
    }

    function column_email($item){
        return "<strong>{$item['email']}</strong>";
    }

    function column_age($item){
        return "<em>{$item['age']}</em>";
    }

    function extra_tablenav( $which ) {
		if('top'==$which):
		?>
		<div class="actions alignleft">
			<select name="filter_s" id="filter_s">
				<option value="all">All</option>
				<option value="M">Males</option>
				<option value="F">Females</option>
			</select>
			<?php
			submit_button(__('Filter','tabledata'),'button','submit',false);
			?>
		</div>
        <?php
	    endif;
	}

    function prepare_items(){
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());
        // table data pagination
        $per_page = 4;
        $data_chunks = array_chunk($this->_items, $per_page);
        $paged = $_REQUEST['paged'] ?? 1;
        $total_items = count($this->_items);
        $this->items = $data_chunks[$paged-1];
        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => $total_items / $per_page,
        ]);
    }

    function column_default($item, $column_name){
        return $item[$column_name];
    }

}