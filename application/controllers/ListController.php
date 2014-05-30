<?php

/**
 * Class ListController
 *
 *
 */
class ListController extends FrontController {

	// Sort options as seen in URI
	private static $sortOptions = array('date','popularity');

	// Sort options as seen by database
	private static $sortKey=array('date'=>'created', 'popularity'=>'popularity');

	// Define how the list looks right here! Just make sure postsPerRow divides 12
	protected $postsPerRow = 4;
	protected $rowsPerPage = 2;

	protected $postsPerPage;
	
	public function __construct($postsPerRow=4, $rowsPerPage=2) {
		$this->postsPerRow = $postsPerRow;
		$this->rowsPerPage = $rowsPerPage;
		$this->postsPerPage = $postsPerRow*$rowsPerPage;
	}

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

		// Set pg identifier
		$pg = ($this::getParam('pg') && $this::getParam('pg')>0) ? (int)$this::getParam('pg') : 1;

		// Set sort option
		if ($this::getParam('sort') && array_search($this::getParam('sort'),self::$sortOptions) !== false)
			$sort = $this::getParam('sort');
		else
			$sort = self::$sortOptions[0];

		//Retrieve model data
		$data = Factory::getModel(str_replace('Controller','',__CLASS__))->readAll(self::$sortKey[$sort]);

		$totalPosts = count($data);
		$totalPages = ceil($totalPosts / $this->postsPerPage);

		if ($pg > $totalPages) {
			SessionModel::set('msg', 'There aren&rsquo;t that many pages in this list!');
			SessionModel::set('msg-tone', 'warning');
			header('Location: ' . BASE_URL . DS . 'list' . DS . 'view?pg='.$totalPages.'&sort='.$sort);
			die;
		}


        //TODO: Stay away from strict array keys and use generic model to handle get/set
        /**
         * $data
            ->set('sort', $sort)
            ->set('pg', $pg);
         */
		$data['sort'] = $sort;
		$data['pg'] = $pg;
		$data['postsPerRow'] = $this->postsPerRow;
		$data['rowsPerPage'] = $this->rowsPerPage;
		$data['postsPerPage'] = $postsPerPage;
		$data['totalPages'] = $totalPages;
		$data['totalPosts'] = $totalPosts;

		Factory::getView(str_replace('Controller','',__CLASS__), $data);
	}

	/**
	 * Generate search bar results; if blank search, send back to previous page.
	 */
	public function search() {
		// Get needle, ensure it is not empty
		if (self::getParam('needle'))
			$needle = self::getParam('needle');
		if (empty($needle)) {
			SessionModel::set('msg', 'Don&rsquo;t search for nothing, idiot!');
			SessionModel::set('msg-tone', 'warning');
			header('location:'.$_SERVER['HTTP_REFERER']);
			die;
		}

		// Set pg identifier
		if ($this::getParam('pg') && $this::getParam('pg')>0)
			$pg = (int)$this::getParam('pg');
		else
			$pg = 1;

		// Store search results in $data array and count results for view
		$data = Factory::getModel(str_replace('Controller', '',__CLASS__))->search($needle);
		$data['totalPosts'] = count($data);
		$data['postsPerPage'] = $this->postsPerRow*$this->rowsPerPage;
		$data['totalPages'] = ceil($data['totalPosts'] / $data['postsPerPage']);

		// Make sure pg being viewed exists in search results
		if ($pg > $data['totalPages']) {
			$_SESSION['msg'] = 'There aren&rsquo;t that many pages in this list!';
			$_SESSION['msg-tone'] = 'warning';
			header('Location: ' . BASE_URL . DS . 'list' . DS . 'search?needle='.$needle.'&pg='.$data['totalPages']);
			die;
		}

		// Continue setting data for View class
		$data['sort'] = $this->getSortOptions()[0];
		$data['pg'] = $pg;
		$data['postsPerRow'] = $this->postsPerRow;
		$data['rowsPerPage'] = $this->rowsPerPage;

		Factory::getView('Search', $data);
	}

	public static function getSortOptions() {
		return self::$sortOptions;
	}

	public static function getSortKey() {
		return self::$sortKey;
	}

}