<?php

/**
 * room模块
 * @version {version}
 * @package application
 * @subpackage application/modules/room/controllers
 * @author {author}
 */
class Room_Main_Module extends MY_Module
{

	/**
	 * 初始化分页
	 * @param array $data
	 */
	private function _pagination( &$data ) {
		// 总数与分页
		$total = $this->model_room_total();
		$data['total'] = $total;
		$per_page = config_item( 'per_page' );
		$this->load->library( 'pagination' );
		$pagination_config = array(
			'base_url' => module_url( 'room/main/index' ),
			'total_rows' => $total,
			'per_page' => $per_page,
			'uri_segment' => 5,
		);
		$this->pagination->initialize( $pagination_config );
		$data['pagination'] = $this->pagination->create_links();
	}

	/**
	 * 列表
	 */
	public function index() {
		$data = array( );

		$this->_pagination( $data );
		$list_data = $this->model_room_all( config_item( 'per_page' ), $this->pagination->get_cur_offset() );
		$data['list_data'] = $list_data;

		$this->_set_pagetitle( 'room-index' );
		$this->load->layout( 'list', $data );
	}

	/**
	 * 详细
	 * @param int $id
	 */
	public function view( $id ) {
		$data = array( );
		try {
			$id = intval( $id );
			if ( empty( $id ) ) throw new Exception( get_lang( 'operation', 'error' ), 0 );

			$item_data = $this->model_room_get_by_pk( $id );
			if ( empty( $item_data ) ) throw new Exception( get_lang( 'operation', 'error' ), -1 );
			$data['item_data'] = $item_data;
		} catch ( Exception $e ) {
			init_messagebox( $e->getMessage(), 'error', $e->getCode(), module_url( 'user/main/index' ) );
			$data['exit'] = TRUE;
		}

		$this->_set_pagetitle( 'room-view' );
		$this->load->layout( 'view', $data );
	}

	/**
	 * 收集
	 * @param bool $is_edit 是否修改
	 * @return array
	 */
	private function _form_data( $is_edit = FALSE ) {
		$post_data = $this->input->post();
		return $post_data;
	}

	/**
	 * 验证规则
	 * @param bool $is_edit 是否修改
	 * @return bool
	 * @todo
	 */
	private function _validation( $is_edit = FALSE ) {
		return TRUE;
	}

	/**
	 * 添加
	 */
	public function add() {
		$data = array( );
		try {
			if ( $this->is_submit() && $this->form_validation->check_token() ) $this->_add( $data );
		} catch ( Exception $e ) {
			init_messagebox( $e->getMessage(), 'error', $e->getCode() );
		}
		$this->_set_pagetitle( 'room-add' );
		$this->load->layout( 'form', $data );
	}

	/**
	 * 添加处理
	 * @param array $data
	 */
	private function _add( &$data ) {
		$post_data = $this->_form_data();
		$data['item_data'] = $post_data;

		if ( !$this->_validation() ) throw new Exception( validation_errors(), 0 );

		$id = $this->model_room_insert( $post_data );
		$post_data['id'] = $id;
		$data['item_data'] = $post_data;

		init_messagebox( get_lang( 'success' ), 'success', 1, module_url( 'room/main/index' ) );
		$data['exit'] = TRUE;
	}

	/**
	 * 修改
	 * @param int $id
	 */
	public function edit( $id = '' ) {
		$data = array( );
		$data['is_edit'] = TRUE;
		try {
			if ( $this->is_submit() && $this->form_validation->check_token() ) {
				$this->_edit( $data );
			} else {
				$id = intval( $id );
				if ( empty( $id ) ) throw new Exception( get_lang( 'operation', 'error' ), 0 );
				$item_data = $this->model_room_get_by_pk( $id );
				if ( empty( $item_data ) ) throw new Exception( get_lang( 'operation', 'error' ), -1 );
				$data['item_data'] = $item_data;
			}
		} catch ( Exception $e ) {
			init_messagebox( $e->getMessage(), 'error', $e->getCode() );
		}
		$this->_set_pagetitle( 'room-edit' );
		$this->load->layout( 'form', $data );
	}

	/**
	 * 处理修改
	 * @param array $data
	 */
	private function _edit( &$data ) {
		$post_data = $this->_form_data( TRUE );
		$data['item_data'] = $post_data;

		if ( !$this->_validation( TRUE ) ) throw new Exception( validation_errors(), 0 );

		$this->model_room_update( $post_data );

		init_messagebox( get_lang( 'success' ), 'success', 1, module_url( 'room/main/index' ) );
		$data['exit'] = TRUE;
	}

	/**
	 * 删除
	 * @param int $id
	 */
	public function delete( $id = '' ) {
		$data = array( );
		try {
			if ( $this->is_submit() && $this->form_validation->check_token() ) {
				$this->_delete( $data );
			} else {
				$id = intval( $id );
				if ( empty( $id ) ) throw new Exception( get_lang( 'operation', 'error' ), 0 );
				$item_data = $this->model_room_get_by_pk( $id );
				if ( empty( $item_data ) ) throw new Exception( get_lang( 'operation', 'error' ), -1 );
				$data['item_data'] = $item_data;
			}
		} catch ( Exception $e ) {
			init_messagebox( $e->getMessage(), 'error', $e->getCode() );
		}
		$this->_set_pagetitle( 'room-delete' );
		$this->load->layout( 'delete', $data );
	}

	/**
	 * 处理删除
	 * @param array $data
	 */
	private function _delete( &$data ) {
		$id = intval( $this->input->post('id') );
		$this->model_room_delete( $id );
		init_messagebox( get_lang( 'success' ), 'success', 1, module_url( 'room/main/index' ) );
		$data['exit'] = TRUE;
	}

}