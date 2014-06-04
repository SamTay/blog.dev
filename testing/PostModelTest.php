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
	public $successPostId;


	public function setUp() {
		$this->postModel = new PostModel;
	}

	/**
	 * Test garbage thrown at create() method
	 *
	 * @param string $title
	 * @param string $body
	 *
	 * @covers \sites\blog.dev\application\models\PostModel::create
	 * @dataProvider provideDummyGarbage
	 */
	public function testCreatePostsGarbage($title, $body) {

		$this->postModel->setControllerData(array('postTitle'=>$title, 'postBody'=>$body));

		try {
			$postid = $this->postModel->create();
		} catch (\Exception $e) {
			$errorMessage = $e->getMessage();
		}

		$this->assertInternalType('string',$errorMessage);

	}

	/**
	 * Test successful create() method
	 *
	 * @param string $title
	 * @param string $body
	 *
	 * @covers \sites\blog.dev\application\models\PostModel::create
	 * @dataProvider provideDummySuccess
	 */
	public function testCreatePostsSuccess($title,$body) {

		$this->postModel->setControllerData(array('postTitle'=>$title, 'postBody'=>$body));

		try {
			$postid = $this->postModel->create();
		} catch (\Exception $e) {
			$errorMessage = $e->getMessage();
		}

		$this->assertInternalType('string',$postid);
		$this->successPostId = $postid;
	}

	public function testCreatePostSuccess() {
		$this->postModel->setControllerData(array('postTitle'=>'hackTitle', 'postBody'=>'hackBody'));
		try {
			$postid = $this->postModel->create();
		} catch (\Exception $e) {
			$errorMessage = $e->getMessage();
		}
		$this->assertInternalType('string',$postid);
		return $postid;
	}

	/**
	 * @depends testCreatePostSuccess
	 * @covers \sites\blog.dev\application\models\PostModel::read
	 */
	public function testReadPostSuccess($postid) {
		$data = $this->postModel->read($postid);
		$this->assertInstanceOf('GenericModel', $data);
		return $postid;
	}

	/**
	 * @depends testReadPostSuccess
	 * @covers \sites\blog.dev\application\models\PostModel::delete
	 */
	public function testDeletePostSuccess($postid) {
		$this->postModel->delete($postid);
		$this->assertEquals(\SessionModel::get('msg'), 'Your post has been successfully deleted.');
	}

	public function provideDummySuccess() {
		return array(
			array('should','work'),
			array('E', 'F')
		);
	}

	public function provideDummyGarbage() {
		return array(
			array('', ''),
			array('', 'emptyTitle'),
			array('emptyBody','')
		);
	}

}
 