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
	public static $ids;


	public static  function setUpBeforeClass() {
		self::$postModel = new PostModel;
		self::$startingTotal = self::$postModel->getRowCount();
	}

	public function setUp() {

		self::$postModel->setControllerData(array('postTitle'=>'title', 'postBody'=>'body'));
		for($i=0;$i<2;$i++)
			self::$postModel->create();

		self::$ids = array_slice(self::$postModel->getRowIds(),self::$startingTotal);
	}

	public function tearDown() {
		$endingTotal = self::$postModel->getRowCount();
		$ids = self::$postModel->getRowIds();

		for($i=$endingTotal-1; $i>=self::$startingTotal;$i--) {
			self::$postModel->delete($ids[$i]);
		}
	}

	/************************************************************* SUCCESS TESTING *********************************************************/

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

	/**
	 * @covers \sites\blog.dev\application\models\PostModel::read
	 */
	public function testReadPostsSuccess() {
		foreach(self::$ids as $postid) {
			$data = self::$postModel->read($postid);
			$this->assertInstanceOf('GenericModel', $data);
		}
	}

	public function testUpdatePostSuccess() {
		self::$postModel->setControllerData(array('postTitle'=>'titleUpdated', 'postBody'=>'bodyUpdated'));
		foreach(self::$ids as $postid) {
			try {self::$postModel->update($postid);} catch (Exception $e){};
			$this->assertEquals(\SessionModel::get('msg'), 'Your post has been successfully updated.');
		}
	}

	/**
	 * @covers \sites\blog.dev\application\models\PostModel::delete
	 */
	public function testDeletePostSuccess() {
		foreach(self::$ids as $postid) {
			self::$postModel->delete($postid);
			$this->assertEquals(\SessionModel::get('msg'), 'Your post has been successfully deleted.');
		}
	}

	/************************************************************* GARBAGE TESTING *********************************************************/

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
	 * @dataProvider provideIdGarbage
	 * @expectedException Exception
	 * @param $postid
	 */
	public function testReadPostsGarbage($postid) {
		try {
			$data = self::$postModel->read($postid);
		} catch (Exception $e){
			$msg = $e->getMessage();
		}
	}

	/**
	 * @dataProvider provideIdGarbage
	 * @expectedException Exception
	 * @param $postid
	 */
	public function testDeletePostsGarbage($postid) {
		try {
			$data = self::$postModel->delete($postid);
		} catch (Exception $e){
			$msg = $e->getMessage();
		}
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
			array(null),
			array(array()),
			array(array('1','2'))
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
 