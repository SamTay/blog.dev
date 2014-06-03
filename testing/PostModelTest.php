<?php
/**
 * Created by PhpStorm.
 * User: samtay
 * Date: 6/2/14
 * Time: 5:23 PM
 */

namespace testing;

require_once(ROOT.DS.'application'.DS.'models'.DS.'PostModel.php');

use \PostModel;


class PostModelTest extends \PHPUnit_Framework_Testcase {

	public $postModel;

	public function __construct($name = NULL, array $data = array(), $dataName = '') {parent::__construct($name, $data, $dataName);}

	public function setUp() {
		$this->postModel = new PostModel;
	}

	/**
	 * @param string $title
	 * @param string $body
	 * @param $expectedPostId
	 * @param $expectedErrorMessage
	 *
	 * @covers \sites\blog.dev\application\models\PostModel::create
	 * @dataProvider dummyPostValues
	 */
	public function testCreatePost($title, $body, $expectedPostId, $expectedErrorMessage) {

		$this->postModel->setControllerData(array('postTitle'=>$title, 'postBody'=>$body));

		try {
			$postid = $this->postModel->create();
		} catch (\Exception $e) {
			$errorMessage = $e->getMessage();
		}

		$this->assertInternalType($expectedPostId, $postid);


	}

	public function dummyPostValues() {
		return array(
			array('Unit Test Title', 'Unit Test Body','string',null),
			array('', 'emptyTitle', null, 'string'),
			array('emptyBody','', null, 'string')
		);
	}


//	/**
//	 * @depends testCreatePost
//	 */
//	public function testReadPost($postid) {
//		$data = $this->postModel->read($postid);
//		$this->assertInstanceOf('GenericModel', $data);
//	}
}
 