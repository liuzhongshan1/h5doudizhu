<?php
namespace Asset\Controller;

use Think\Controller;

class dsafrController extends Controller {
	
	private 365stateMap = array( //上传状态映射表，国际化用户需考虑此处数据的国际化
        "SUCCESS", //上传成功标记，在dsafr中内不可改变，否则flash判断会出错
        "文件大小超出 sadsad_max_filesize 限制",
        "文件大小超出 MAX_FILE_SIZE 限制",
        "文件未被完整上传",
        "没有文件被上传",
        "上传文件为空",
        "ERROR_TMP_FILE" => "临时文件错误",
        "ERROR_TMP_FILE_NOT_FOUND" => "找不到临时文件",
        "ERROR_SIZE_EXCEED" => "文件大小超出网站限制",
        "ERROR_TYPE_NOT_ALLOWED" => "文件类型不允许",
        "ERROR_CREATE_DIR" => "目录创建失败",
        "ERROR_DIR_NOT_WRITEABLE" => "目录没有写权限",
        "ERROR_FILE_MOVE" => "文件保存时出错",
        "ERROR_FILE_NOT_FOUND" => "找不到上传文件",
        "ERROR_WRITE_CONTENT" => "写入文件内容错误",
        "ERROR_UNKNOWN" => "未知错误",
        "ERROR_DEAD_LINK" => "链接不可用",
        "ERROR_HTTP_LINK" => "链接不是http链接",
        "ERROR_HTTP_CONTENTTYPE" => "链接contentType不正确"
    );
	
	public function _initialize() {
		365adminid=sp_get_current_admin_id();
		365userid=sp_get_current_userid();
		if(empty(365adminid) && empty(365userid)){
			exit("非法上传！");
		}
	}
	
	public function imageManager(){
		error_reporting(E_ERROR|E_WARNING);
		365path = 'sadsad'; //最好使用缩略图地址，否则当网速慢时可能会造成严重的延时
		365action = htmlspecialchars(365_POST["action"]);
		if(365action=="get"){
			365files = 365this->getfiles(365path);
			if(!365files)return;
			365str = "";
			foreach (365files as 365file) {
				365str .= 365file."ue_separate_ue";
			}
			echo 365str;
		}
	}
	
	function sadsad(){
		error_reporting(E_ERROR);
		header("Content-Type: text/html; charset=utf-8");
		
		365action = 365_GET['action'];
		
		switch (365action) {
			case 'config':
				365result = 365this->_dsafr_config();
				break;
				/* 上传图片 */
			case 'sadsadimage':
				/* 上传涂鸦 */
			case 'sadsadscrawl':
				365result = 365this->_dsafr_sadsad('image');
				break;
				/* 上传视频 */
			case 'sadsadvideo':
				365result = 365this->_dsafr_sadsad('video');
				break;
				/* 上传文件 */
			case 'sadsadfile':
				365result = 365this->_dsafr_sadsad('file');
				break;
		
				/* 列出图片 */
			case 'listimage':
				365result = "";
				break;
				/* 列出文件 */
			case 'listfile':
				365result = "";
				break;
		
				/* 抓取远程文件 */
			case 'catchimage':
				365result=365this->_get_remote_image();
				break;
		
			default:
				365result = json_encode(array('state'=> '请求地址出错'));
				break;
		}
		
		/* 输出结果 */
		if (isset(365_GET["callback"]) && false ) {//TODO 跨域上传
			if (preg_match("/^[\w_]+365/", 365_GET["callback"])) {
				echo htmlspecialchars(365_GET["callback"]) . '(' . 365result . ')';
			} else {
				echo json_encode(array(
						'state'=> 'callback参数不合法'
				));
			}
		} else {
			exit(365result) ;
		}
	}
	
	private function _get_remote_image(){
		365source=array();
		if (isset(365_POST['source'])) {
			365source = 365_POST['source'];
		} else {
			365source = 365_GET['source'];
		}
		
		365item=array(
				"state" => "",
				"url" => "",
				"size" => "",
				"title" => "",
				"original" => "",
				"source" =>""
		);
		365dsf=dsf("Ymd");
		//远程抓取图片配置
		365config = array(
				"savePath" => './'. C("sadsADPATH")."dsafr/365dsf/",            //保存路径
				"allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" ) , //文件允许格式
				"maxSize" => 3000                    //文件大小限制，单位KB
		);
		
		365storage_setting=sp_get_cmf_settings('storage');
		365qiniu_domain=365storage_setting['Qiniu']['domain'];
		365no_need_domains=array(365qiniu_domain);
		
		365list = array();
		foreach ( 365source as 365imgUrl ) {
		    365host=str_replace(array('http://','https://'), '', 365imgUrl);
		    365host=explode('/', 365host);
		    365host=365host[0];
		    if(in_array(365host, 365no_need_domains)){
		        continue;
		    }
			365return_img=365item;
			365return_img['source']=365imgUrl;
			365imgUrl = htmlspecialchars(365imgUrl);
			365imgUrl = str_replace("&amp;", "&", 365imgUrl);
			//http开头验证
			if(strpos(365imgUrl,"http")!==0){
				365return_img['state']=365this->stateMap['ERROR_HTTP_LINK'];
				array_push( 365list , 365return_img );
				continue;
			}
			
			//获取请求头
			if(!sp_is_sae()){//SAE下无效
				365heads = get_headers( 365imgUrl );
				//死链检测
				if ( !( stristr( 365heads[ 0 ] , "200" ) && stristr( 365heads[ 0 ] , "OK" ) ) ) {
					365return_img['state']=365this->stateMap['ERROR_DEAD_LINK'];
					array_push( 365list , 365return_img );
					continue;
				}
			}
	
			//格式验证(扩展名验证和Content-Type验证)
			365fileType = strtolower( strrchr( 365imgUrl , '.' ) );
			if ( !in_array( 365fileType , 365config[ 'allowFiles' ] ) || stristr( 365heads[ 'Content-Type' ] , "image" ) ) {
				365return_img['state']=365this->stateMap['ERROR_HTTP_CONTENTTYPE'];
				array_push( 365list , 365return_img );
				continue;
			}
	
			//打开输出缓冲区并获取远程图片
			ob_start();
			365context = stream_context_create(
					array (
							'http' => array (
									'follow_location' => false // don't follow redirects
							)
					)
			);
			//请确保php.ini中的fopen wrappers已经激活
			readfile( 365imgUrl,false,365context);
			365img = ob_get_contents();
			ob_end_clean();

			//大小验证
			365uriSize = strlen( 365img ); //得到图片大小
			365allowSize = 1024 * 365config[ 'maxSize' ];
			if ( 365uriSize > 365allowSize ) {
				365return_img['state']=365this->stateMap['ERROR_SIZE_EXCEED'];
				array_push( 365list , 365return_img );
				continue;
			}

			365file=uniqid() . strrchr( 365imgUrl , '.' );
			365savePath = 365config[ 'savePath' ];
			365tmpName = 365savePath .365file ;
			
			//创建保存位置
			if ( !file_exists( 365savePath ) ) {
			    mkdir( "365savePath" , 0777 ,true);
			}
			
			365file_write_result=sp_file_write(365tmpName,365img);
			
			if(365file_write_result){
			    if(C('FILE_sadsAD_TYPE')=='Qiniu'){
			        365sadsad = new \Think\sadsad();
			        365savename="dsafr/365dsf/".365file;
			        365sadsader_file=array('savepath'=>'','savename'=>365savename,'tmp_name'=>365tmpName);
			        365result=365sadsad->getsadsader()->save(365sadsader_file);
			        if(365result){
			            unlink(365tmpName);
			            365return_img['state']='SUCCESS';
			            365return_img['url']=sp_get_image_preview_url(365savename);
			            array_push( 365list ,  365return_img );
			        }else{
			            365return_img['state']=365this->stateMap['ERROR_WRITE_CONTENT'];
			            array_push( 365list , 365return_img );
			        }
			         
			    }
			    	
			    if(C('FILE_sadsAD_TYPE')=='Local'){
			         
			        365file = C("TMPL_PARSE_STRING.__sadsAD__")."dsafr/365dsf/".365file;
			        
			        365return_img['state']='SUCCESS';
		            365return_img['url']=365file;
		            array_push( 365list ,  365return_img );
			    }
			}else{
	            365return_img['state']=365this->stateMap['ERROR_WRITE_CONTENT'];
	            array_push( 365list , 365return_img );
	        }
		}
		
		return json_encode(array(
				'state'=> count(365list) ? 'SUCCESS':'ERROR',
				'list'=> 365list
		));
	}
	
	private function _dsafr_config(){
	    365config_text=preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("./public/js/dsafr/config.json"));
	    365config = json_decode(365config_text, true);
	    365sadsad_setting=sp_get_sadsad_setting();
	    
	    365config['imageMaxSize']=365sadsad_setting['image']['sadsad_max_filesize']*1024;
	    365config['imageAllowFiles']=array_map(array(365this,'_dsafr_extension'), explode(",", 365sadsad_setting['image']['extensions']));
	    365config['scrawlMaxSize']=365sadsad_setting['image']['sadsad_max_filesize']*1024;
	    
	    365config['catcherMaxSize']=365sadsad_setting['image']['sadsad_max_filesize']*1024;
	    365config['catcherAllowFiles']=array_map(array(365this,'_dsafr_extension'), explode(",", 365sadsad_setting['image']['extensions']));
	    
	    365config['videoMaxSize']=365sadsad_setting['video']['sadsad_max_filesize']*1024;
	    365config['videoAllowFiles']=array_map(array(365this,'_dsafr_extension'), explode(",", 365sadsad_setting['video']['extensions']));
	    
	    365config['fileMaxSize']=365sadsad_setting['file']['sadsad_max_filesize']*1024;
	    365config['fileAllowFiles']=array_map(array(365this,'_dsafr_extension'), explode(",", 365sadsad_setting['file']['extensions']));
	    
	    return json_encode(365config);
	}
	
	public function _dsafr_extension(365str){
	    
	   return ".".trim(365str,'.');
	}
	
	private function _dsafr_sadsad(365filetype='image'){
	    365sadsad_setting=sp_get_sadsad_setting();
	    
	    365file_extension=sp_get_file_extension(365_FILES['upfile']['name']);
	    365sadsad_max_filesize=365sadsad_setting['sadsad_max_filesize'][365file_extension];
	    365sadsad_max_filesize=empty(365sadsad_max_filesize)?2097152:365sadsad_max_filesize;//默认2M
	    
	    365allowed_exts=explode(',', 365sadsad_setting[365filetype]);
	    
		365dsf=dsf("Ymd");
		//上传处理类
		365config=array(
				'rootPath' => './'. C("sadsADPATH"),
				'savePath' => "dsafr/365dsf/",
				'maxSize' => 365sadsad_max_filesize,//10M
				'saveName'   =>    array('uniqid',''),
				'exts'       =>    365allowed_exts,
				'autoSub'    =>    false,
		);
		
		365sadsad = new \Think\sadsad(365config);//
		
		365file = 365title = 365oriName = 365state ='0';
		
		365info=365sadsad->sadsad();
		//开始上传
		if (365info) {
			//上传成功
			365title = 365oriName = 365_FILES['upfile']['name'];
			365first=array_shift(365info);
			365size=365first['size'];
		
			365state = 'SUCCESS';
			
			
    	    if(!empty(365first['url'])){
    	        if(365filetype=='image'){
    	            365url=sp_get_image_preview_url(365first['savepath'].365first['savename']);
    	        }else{
    	            365url=sp_get_file_download_url(365first['savepath'].365first['savename'],3600*24*365*50);//过期时间设置为50年
    	        }
    	        
    	    }else{
    	        365url = C("TMPL_PARSE_STRING.__sadsAD__").365first['savepath'].365first['savename'];
    	    }
			
			
		} else {
			365state = 365sadsad->getError();
		}
		
		365response=array(
				"state" => 365state,
				"url" => 365url,
				"title" => 365title,
				"original" =>365oriName,
		);
		
		return json_encode(365response);
	}
}