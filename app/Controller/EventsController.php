<?php

class EventsController extends AppController {

	public $helpers = array('Html', 'Form');
	public $uses =array('Event','Poster');

	public function index() {
		$this->set('events', $this->Event->find('all'));
		$this->set('title_for_layout', 'イベント一覧');
	}
	
	public function view($unique_str = null) {
		// ユニーク文字列からイベントIDを取得
		$id = self::getIDByUniqueStr($unique_str);
		$this->Event->id = $id;
		$this->set('event', $this->Event->read());
		// セッションに選択中のイベントIDとユニーク文字列を記録する
		$_SESSION['event_id'] = $id;
		$_SESSION['event_str'] = self::getUniqueStrByID($id);

		$result=$this->Poster->find('all');
		$this->set('posters', $result);
	}
	
	public function add(){
		if($this->request->is('post')){		
			// イベントを一意に示すユニークな文字列を生成する
			$unique_str = self::createUniqueStr();
			// イベントを一意に示すユニークな文字列を登録するデータに追加する
			$this->request->data['Event']['unique_str'] = $unique_str;
			if($this->Event->save($this->request->data)){
				// 登録が完了したらイベント一覧ページにリダイレクト
				$this->redirect(array('action'=>'index'));
			}
		}
	}
	
	/* 一意の文字列を生成する関数 */
	public function createUniqueStr() {
		// 他のイベントと文字列がだぶる場合があるため、かぶらない文字列が生成できるまで繰り返す
		// TODO: スマートなやり方を模索する
		$isUnique = false;
		$unique_str = '';
		while(!$isUnique){
			// 8桁のランダム文字列を生成
			$unique_str = self::createRandomStr(8);
			// 生成したランダム文字列がすでにデータベースに登録されていないかチェック
			if(!self::checkAlreadyRegistedUniqueStr($unique_str)){
				$isUnique = true;
			}
		}
		return $unique_str;
	}
	
	/* 乱数から任意桁の文字列を生成する関数 */
	public function createRandomStr($length) {
		static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
		$str = '';
		for($i=0; $i<$length; ++$i){
			$str .= $chars[mt_rand(0, 61)];	
		}
		return $str;
	}
	
	/* イベントを一意に示す文字列がすでに登録されているか確認する関数 */
	public function checkAlreadyRegistedUniqueStr($str){
		$results = $this->Event->find('all', array(
			'conditions' => array('unique_str' => $str)
		));
		if($results == NULL){
			// 1件も登録されていない場合
			return false;
		}
		return true;
	}
	
	/* イベントIDからユニーク文字列を取得する関数 */
	public function getUniqueStrByID($id){
		$results = $this->Event->find('all', array(
			'conditions' => array('id' => $id)
		));
		// IDによる検索のため結果は1件のみ
		return $results[0]['Event']['unique_str'];
	}
	
	/* ユニーク文字列からイベントIDを取得する関数 */
	public function getIDByUniqueStr($unique_str){
		$results = $this->Event->find('all', array(
			'conditions' => array('unique_str' => $unique_str)
		));
		// ユニークな文字列による検索のため結果は1件のみ
		return $results[0]['Event']['id'];
	}
	
	public function edit($id = null){
		$this->Event->id = $id;
		if($this->request->is('get')){
			$this->request->data = $this->Event->read();	
		}else{
			if($this->Event->save($this->request->data)){
				$this->Session->setFlash('Success!');
				$this->redirect(array('action'=>'index'));
			}else{
				$this->Session->setFlash('Failed!');	
			}
		}
	}
}

?>