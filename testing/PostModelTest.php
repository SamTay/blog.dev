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

	public static $startingTotal;
	public static $postModel;


	public static  function setUpBeforeClass() {
		self::$postModel = new PostModel;
		self::$startingTotal = self::$postModel->getRowCount();
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

		self::$postModel->setControllerData(array('postTitle'=>$title, 'postBody'=>$body));

		try {
			$postid = self::$postModel->create();
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

		self::$postModel->setControllerData(array('postTitle'=>$title, 'postBody'=>$body));

		try {
			$postid = self::$postModel->create();
		} catch (\Exception $e) {
			$errorMessage = $e->getMessage();
		}

		$this->assertInternalType('string',$postid);
	}

	public function testCreatePostSuccess() {
		self::$postModel->setControllerData(array('postTitle'=>'hackTitle', 'postBody'=>'hackBody'));
		try {
			$postid = self::$postModel->create();
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
		$data = self::$postModel->read($postid);
		$this->assertInstanceOf('GenericModel', $data);
		return $postid;
	}

	/**
	 * @dataProvider provideIdGarbage
	 * @expectedException Exception
	 * @param $postid
	 */
	public function testReadPostGarbage($postid) {
		try {
			$data = self::$postModel->read($postid);
		} catch (Exception $e){
			$msg = $e->getMessage();
		}
	}

	/**
	 * @depends testReadPostSuccess
	 * @covers \sites\blog.dev\application\models\PostModel::delete
	 */
	public function testDeletePostSuccess($postid) {
		self::$postModel->delete($postid);
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

	public function provideIdGarbage() {
		return array(
			array(''),
			array('hello'),
			array('@@'),
			array(null)
		);
	}

	/**
	 * Delete any posts added during this test
	 */
	public static function  tearDownAfterClass() {
		$endingTotal = self::$postModel->getRowCount();
		$ids = self::$postModel->getRowIds();

		for($i=$endingTotal-1; $i>=self::$startingTotal;$i--) {
			self::$postModel->delete($ids[$i]);
		}
	}
}
 