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
	private $upload_path = 'upload/';
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
		return View::make( 'index', $this->getData() );
	}

	public function image ( $key = null ) 
	{
		$row = Image::where('key', $key)->first();
		header('Content-Type: image/jpeg');
		exit ( $row 
			? file_get_contents( $row->path ) 
			: file_get_contents( base_path('images/no_image.gif') )
		);
	}

    public function imgs () 
    {
        $list = [];
        ($imgs = Cookie::get('imgs')) or ($imgs = []);
        if ( count($imgs) > 0 ) {
            $result = Image::whereIn('id', array_keys($imgs))->get();
            foreach ( $result as $row ) {
                $list[] = [
                    'domain' => url('') . '/'
                    , 'key' => $row->key
                ];
            }
        }

        return json_encode( ['status' => true, 'imgs' => $list ] );
    }

	public function upload () 
	{
		$response = null;
		$data = Input::get('data');
		$md5 = md5($data);
		($name = Input::get('name'))
			and $ext = substr(strrchr($name, '.'), 1);
		($row = Image::where('md5', $md5 )->first()) 
			or $row = new Image;

		$limit_ext = ['jpg', 'jpeg', 'gif', 'png'];
		if ( empty($name) || ! in_array( $ext, $limit_ext) ) {

            $request = [
                'status' => false
                , 'msg' => '限定副檔名為 : ' . implode(',', $limit_ext)
            ];
            $response = Response::make( json_encode($request) );
			
		} else {

			/* 無相同檔案存在 */
			if ( empty( $row->id ) ) {

                /* 產生不重複的 key */
				$key = $this->randomKey();
				while (Image::where('key', $key)->first()) {
					$key = $this->randomKey();
				}
				list( $info, $img_data ) = explode(',', $data);
				$row->key = $key;
				$row->md5 = $md5;
				$row->name = Input::get('name');
				$row->path = base_path( $this->upload_path . $key . ".{$ext}" );
				$row->save();
				file_put_contents( $row->path, base64_decode($img_data));

			}
            $request = [ 'status' => true, 'url' => url( $row->key ) ];

			($imgs = Cookie::get('imgs')) or ($imgs = []);
			$imgs[ $row->id ] = $row->key;
            $minutes = 3 * 24 * 60;

            $response = Response::make( json_encode($request) );
            $response->withCookie( Cookie::make('imgs', $imgs, $minutes ) );


		}
		// $response = Response::make( json_encode($request) );

        return $response;
	}

}
