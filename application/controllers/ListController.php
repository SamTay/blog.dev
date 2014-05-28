<?php

/**
 * Class ListController
 *
 *
 */
class ListController extends FrontController {

	public function __construct() {}

	// Sort options as seen in URI
    private static $sortOptions = array('date','popularity');

	// Sort options as seen by database
	private static $sortKey=array('date'=>'created', 'popularity'=>'popularity');

    /**
     * Default action for ListController is view
     */
    public function index() {
        $this->view();
    }

	/**
	 * Modify this view function by using the postsPerRow and rowsPerPage variables.
	 */
	public function view() {
		// Define how the list looks right here!
		$postsPerRow = 4;
		$rowsPerPage = 2;

		// Set pg identifier
		if ($this::getParam('pg') && $this::getParam('pg')>0)
			$pg = (int)$this::getParam('pg');
		else
			$pg = 1;

		// Set sort option
		if ($this::getParam('sort') && array_search($this::getParam('sort'),self::$sortOptions) !== false)
			$sort = $this::getParam('sort');
		else
			$sort = self::$sortOptions[0];

		$postsPerPage = $postsPerRow*$rowsPerPage;
		$totalPosts = Factory::getModel('Post')->getRowCount();

		$totalPages = ceil($totalPosts / $postsPerPage);

		if ($pg > $totalPages) {
			$_SESSION['msg'] = 'There aren&rsquo;t that many pages in this list!';
			$_SESSION['msg-tone'] = 'warning';
			header('Location: ' . BASE_URL . DS . 'list' . DS . 'view?pg='.$totalPages.'&sort='.$sort);
			die;
		}

		$data = Factory::getModel('Post')->readAll(self::$sortKey[$sort]);
		$data['sort'] = $sort;
		$data['postsPerRow'] = $postsPerRow;
		$data['rowsPerPage'] = $rowsPerPage;
		$data['postsPerPage'] = $postsPerPage;
		$data['totalPages'] = $totalPages;

		Factory::getView('List', $data);
	}

	public static function getSortOptions() {
		return self::$sortOptions;
	}

	public static function getSortKey() {
		return self::$sortKey;
	}

}