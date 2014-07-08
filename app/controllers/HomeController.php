<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	public function randomKey ( $len = 5 ) 
	{
		$KEY_DATA = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$str = '';
		while ( strlen($str) < $len ) {
			$str .= $KEY_DATA[ rand(0, strlen( $KEY_DATA )-1 )];
		}
		return $str;
	}
	public function index () 
	{
		// echo url('');
		return View::make( 'index', $this->getData() );
	}

	public function image ( $key = null ) 
	{
		// $row = Image::where('key', $key)->first();
		// $arr = explode( ',', $row->data );
		// file_put_contents(base_path('a.jpg'), base64_decode($arr[1]));
		// $this->setData('img', '' );
		// $this->setData('img', $row->data );
		// return View::make('image', $this->getData());
		return View::make('image', $this->getData());
	}

	public function upload () 
	{
		$request = [ 'status' => false ];
		$data = Input::get('data');
		$md5 = md5($data);
		($name = Input::get('name'))
			and $ext = end( explode('.', $name) );
		($row = Image::where('md5', $md5 )->first()) 
			or $row = new Image;

		$limit_ext = ['jpg', 'jpeg', 'gif', 'png'];
		if ( empty($name) || ! in_array( strtolower($name), $limit_ext) ) {

			$request['msg'] = '限定副檔名為 : ' . implode(',', $limit_ext);
			
		} else {

			/* 已有相同檔案存在的話 */
			if ( ! empty( $row->id ) ) {
				$request['status'] = true;
				$request['url'] = url( $row->key );
			} else {
				$key = $this->randomKey();
				while (Image::where('key', $key)->first()) {
					$key = $this->randomKey();
				}
				$row->key = $key;
				$row->md5 = $md5;
				$row->name = Input::get('name');
				$row->data = $data;
				$row->save();
				$request['status'] = true;
				$request['url'] = url( $row->key );
				$row->path = base_path( $key . end(explode('.',$name)) );
				file_put_contents(base_path('a.jpg'), base64_decode($arr[1]));

			}
		}

		return json_encode($request);
	}

}
