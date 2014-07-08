<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

    private $data = [];

    protected function setData( $key, $val = null )
    {
        if (is_array($key)) {
            $this->data += $key;
        } else {
            $this->data[$key] = $val;
        }
    }
    protected function getData()
    {
    	return $this->data;
    }
	
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
