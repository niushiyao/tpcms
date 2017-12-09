<?php
/**
 * 图片上传类
 * @author niushiyao
 * @date  2016-09-27
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
class ImageController extends CommonController {
    private $_uploadObj;
    public function __construct()
    {
		 parent::__construct();
	}
    
    /**
	* AJAX图片上传方法
	* @author niushiyao
	* @return
	*/
    public function ajaxuploadimage()
    {
    	$upload = D("UploadImage");
    	$res = $upload->imageUpload("imgFile");
    	if($res)
		{
			show(true,'上传成功',$res);
		}else{
			show(false,'上传失败');
		}
    }
	
	/**
	* 编辑器上传图片
	* @author niushiyao
	* @date   2016-09-28
	*/
	public function kindupload()
	{
		$upload = D("UploadImage");
    	$res = $upload->imageUpload("imgFile");
    	if($res)
    	{
			return showEditor(true,$res);
		}
		return showEditor(false,'上传失败');
	}
}
