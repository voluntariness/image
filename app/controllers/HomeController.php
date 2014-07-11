<?php

class HomeController extends BaseController 
{

    private $upload_path = 'upload/';

    public function randomKey ( $len = 7 ) 
    {
        $KEY_DATA = '0123456789abcdefghijklmnopqrstuvwxyz';
        $str = '';
        while ( strlen($str) < $len ) {
        	$str .= $KEY_DATA[ rand(0, strlen( $KEY_DATA )-1 )];
        }
        return $str;
    }
    public function index () 
    {

        ($arr = Input::get()) and $key = array_keys($arr)[0];
        
        ! empty($key) and $row = Image::where('key', $key)->first();

        if ( ! empty($row) && $row->key ) {
            $this->setData('row', $row );
            return View::make( 'image', $this->getData() );
        }
        return View::make( 'index', $this->getData() );
    }


    public function images ( $key = null ) 
    {
		$list = [];
        $result = Image::orderBy('id', 'desc')->limit(40)->get();
        foreach ( $result as $row ) {
            $list[ $row->key ] = '/_' . $row->key;
        }
        return json_encode( $list );
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
                $row->title = Input::get('name');
                $row->name =  $key . ".{$ext}" ;
                $row->save();
                file_put_contents( base_path( $this->upload_path . $key ), base64_decode($img_data));

            }
            $request = [ 
                'status' => true
                , 'key' => $row->key 
                , 'url' => '/_' . $row->key
            ];

            return json_encode($request);
            // $response = Response::make( json_encode($request) );


        }
        // $response = Response::make( json_encode($request) );

        return $response;
    }

}
