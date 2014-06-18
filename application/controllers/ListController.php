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

	// parameters from controller
	protected $pg;
	protected $sort;
	protected $needle;
	protected $action;

	
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

		// Set parameters
		$this->setParams();

		// If there is a search parameter, refer to search method
		if ($this->needle) {
			$this->search();

		// Otherwise proceed with view method
		} else {

			$data = array();
			//Retrieve model data
			$data['posts'] = Factory::getModel(str_replace('Controller','',__CLASS__))->read(self::$sortKey[$this->sort]);

			// Set variables for use in View (redirect if necessary)
			$this->setViewParams($data);

			Factory::getView(str_replace('Controller','',__CLASS__), $data);
		}
	}

	/**
	 * Generate search bar results; if blank search, send back to previous page.
	 */
	public function search() {

		// Get params, ensure needle is not empty
		$this->setParams();
		if (!$this->needle) {
			SessionModel::set('msg', 'Don&rsquo;t search for nothing, idiot!');
			SessionModel::set('msg-tone', 'warning');
			header('location:'.$_SERVER['HTTP_REFERER']);
			die;
		}

		$data = array();
		// Store search results in GenericModel array
		$data['posts'] = Factory::getModel(str_replace('Controller', '',__CLASS__))->search(self::$sortKey[$this->sort], $this->needle);

		// Set variables for use in View (redirect if necessary)
		$this->setViewParams($data);
		$data['view']->set('needle', $this->needle);

		Factory::getView('Search', $data);
	}

	public function setParams() {
		// Set pg identifier
		$this->pg = ($this::getParam('pg') && $this::getParam('pg')>0) ? (int)$this::getParam('pg') : 1;

		// Set sort option
		if ($this::getParam('sort') && array_search($this::getParam('sort'),self::$sortOptions) !== false)
			$this->sort = $this::getParam('sort');
		else
			$this->sort = self::$sortOptions[0];

		// Set needle
		$this->needle = $this::getParam('needle');
	}

	public function setViewParams(&$data) {
		// Set all relevant parameters to help out the view
		$totalPosts = count($data['posts']);
		$data['view'] = new GenericModel();
		$data['view']
			->set('sort', $this->sort)
			->set('pg', $this->pg)
			->set('postsPerRow', $this->postsPerRow)
			->set('rowsPerPage', $this->rowsPerPage)
			->set('postsPerPage', $this->postsPerPage)
			->set('totalPosts', $totalPosts)
			->set('totalPages', max(ceil($totalPosts / $this->postsPerPage), 1));

		// If 0 results, allow view with no posts and error message
		if ($totalPosts === 0) {
			SessionModel::set('msg', 'Sorry, nothing matches your search!');
			SessionModel::set('msg-tone', 'danger');

		// Else if there are posts but greater pages are being requested, redirect to greatest available page
		} else if ($this->pg > ceil($totalPosts / $this->postsPerPage)) {
			SessionModel::set('msg', 'There aren&rsquo;t that many pages in this list!');
			SessionModel::set('msg-tone', 'warning');

			if ($this->needle) {
				$location = BASE_URL . DS . 'list' . DS . 'search?pg='.ceil($totalPosts / $this->postsPerPage).'&sort='.$this->sort.'&needle='.$this->needle;
			} else {
				$location = BASE_URL . DS . 'list' . DS . 'view?pg='.ceil($totalPosts / $this->postsPerPage).'&sort='.$this->sort;
			}

			header('Location: ' . $location);
			die;
		}
	}

	public static function getSortOptions() {
		return self::$sortOptions;
	}

	public static function getSortKey() {
		return self::$sortKey;
	}

}