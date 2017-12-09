<?php
namespace Common\Model;
use Think\Model;

/**
 * 上传图片类
 * @author  singwa
 */
class UploadImageModel extends Model {
    private $_uploadObj = '';
    private $_uploadImageData = '';

    const UPLOAD = 'upload';

    public function __construct() {
        $this->_uploadObj = new  \Think\Upload();

        $this->_uploadObj->rootPath = './'.self::UPLOAD.'/';
        $this->_uploadObj->subName = date(Y) . '/' . date(m) .'/' . date(d);
    }

    /*public function upload() {
        $res = $this->_uploadObj->upload();

        if($res) {
            return '/' .self::UPLOAD . '/' . $res['file']['savepath'] . $res['file']['savename'];
        }else{
            return false;
        }
    }*/
	
	/**
	* 图片上传方法
	* @param $objFile 上传的file名
	* @return
	*/
    public function imageUpload($objFile) {
        $res = $this->_uploadObj->upload();
        if($res) {
            return '/' .self::UPLOAD . '/' . $res[$objFile]['savepath'] . $res[$objFile]['savename'];
        }else{
            return false;
        }
    }
}
