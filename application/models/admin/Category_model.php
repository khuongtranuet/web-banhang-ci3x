<?php


class Category_model extends CI_Model
{

	public function category_list($params, $is_count)
	{
		$page_index = isset($params['page_index']) ? $params['page_index'] : 1;
		$page_size = isset($params['page_size']) ? $params['page_size'] : 10;
		$keyword = isset($params['keyword']) ? $params['keyword'] : '';
		$type = isset($params['type']) ? $params['type'] : -1;
		$from = isset($params['from']) ? $params['from'] : 0;
		$this->db->select('*');
		$this->db->from(TBL_CATEGORIES);
		if ($is_count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by('id', 'desc');
		$this->db->limit($page_size, $from);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function query($select, $tbl, $param = '')
	{
		$sql = " SELECT $select FROM $tbl $param ";
		$result = $this->db->query($sql);
		return $result = $result->result_array();
	}

	public function insert($category)
	{
		$data = array();
		if (isset($category['name'])) {
			$data['name'] = $category['name'];
		}
		if (isset($category['description'])) {
			$data['description'] = $category['description'];
		}
		if (isset($category['image'])) {
			$data['image'] = $category['image'];
		}
		if (isset($category['parent_id']) && $category['parent_id'] != -1) {
			$data['parent_id'] = $category['parent_id'];
		}
		if (isset($category['status'])) {
			$data['status'] = $category['status'];
		}

		if ($this->db->insert(TBL_CATEGORIES, $data)) {
			return true;
		} else {
			return false;
		}

	}

	public function edit($category)
	{
		$data = array();
		if (isset($category['name'])) {
			$data['name'] = $category['name'];
		}
		if (isset($category['description'])) {
			$data['description'] = $category['description'];
		}
		if (isset($category['image'])) {
			$data['image'] = $category['image'];
		}
		if (isset($category['parent_id']) && $category['parent_id'] != -1) {
			$data['parent_id'] = $category['parent_id'];
		}
		if (isset($category['status'])) {
			$data['status'] = $category['status'];
		}

		$this->db->where('id', $category['id']);

		if ($this->db->update(TBL_CATEGORIES, $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function delete($id)
	{
		if ($this->db->delete(TBL_CATEGORIES, ['id' => $id]) && $this->db->delete(TBL_CATEGORIES, ['parent_id' => $id])){
			return true;
		} else {
			return false;
		}
	}

}
