<?php
namespace Wap\Controller;

use Wap\Common\BaseController;
use MyLib\WeChat;
use MyLib\Func;

class UserController extends BaseController
{
    protected function _initialize()
    {
        parent::_initialize();
    }
    /**
     * 登陆
     */
    public function login(){

        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token');
        $refresh_token = I('post.refresh_token', '');
        $phone=I('post.phone','');
        $pwd=I('post.pwd','');
        $str='phone='.$phone.'&pwd='.$pwd.'&access_token='.$accessToken.'&refresh_token='.
            $refresh_token;
        $data=api_curl($this->url.'/User/signIn.html',$str,'POST',$this->header);
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $this->ajaxReturn($res);
    }

    /**
     * 退出房间
     */
    public function signOut(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token');

        $str='access_token='.$accessToken;
        $data=api_curl($this->url.'/User/signOut.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $this->ajaxReturn($res);
    }

    /**
     * 获取房间列表
     */
    public function house(){
     
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token');
        $data=api_curl($this->url.'/user/getHouse.html','access_token='.$accessToken,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']='成功';
        $res['data']=$data['service_list'];
        $this->ajaxReturn($res);
    }

    /**
     * 获取房间详细信息
     */
    public function houseDetail(){

        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token','');
        $orderId=I('post.orderId','');

        $data=api_curl($this->url.'/House/getRoomInfo.html','access_token='.$accessToken.'&order_id='.$orderId,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }

        $res['code']='1';
        $res['msg']='成功';
        $res['data']=$data['service_extra'];
        if(isset($res['data']['room_img']) && !empty($res['data']['room_img'])){
            $oldLink = $res['data']['room_img'];
            $pathArr = parse_url($oldLink);
            if(strpos($_SERVER['HTTP_HOST'], ":")===false)
                $newLink = "http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$pathArr['path'];
            else
                $newLink = "http://".$_SERVER['HTTP_HOST'].$pathArr['path'];
            $res['data']['room_img'] = $newLink;
        }
        $this->ajaxReturn($res);
    }

    /**
     * 个人信息
     */
    public function userInfo(){

        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息

        $accessToken=I('post.access_token','');
        
        $data=api_curl($this->url.'/User/userInfo.html','access_token='.$accessToken,'POST',$this->header);

        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']='成功';
        $res['data']=$data['service_extra'];
        if(isset($res['data']['user']['member_avatar']) && !empty($res['data']['user']['member_avatar'])){
                $oldLink = $res['data']['user']['member_avatar'];
                $pathArr = parse_url($oldLink);
                if(strpos($_SERVER['HTTP_HOST'], ":")===false)
                        $newLink = "http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$pathArr['path'];
                else
                       $newLink = "http://".$_SERVER['HTTP_HOST'].$pathArr['path']; 
                $res['data']['user']['member_avatar'] = $newLink;
        }
        $this->ajaxReturn($res);
    }

    /**
     * 实名认证
     */
    public function certification(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $realName=I('post.realName','');
        $idCard=I('post.idCard','');
        $accessToken=I('post.access_token','');
        $str='realName='.$realName.'&idCard='.$idCard.'&access_token='.$accessToken;
        $data=api_curl($this->url.'/User/certification.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['msg']=$data['service_msg'];
            $res['code']=$data['service_code'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];

        $this->ajaxReturn($res);
    }

    /**
     * 用户修改密码修改密码
     */
    public function changePwd(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $oPwd=I('post.oPwd','');
        $nPwd=I('post.nPwd','');
        $checkPwd=I('post.checkPwd','');
        $phone=I('post.phone','');
        $accessToken=I('post.access_token','');
        $str='oPwd='.$oPwd.'&nPwd='.$nPwd.'&checkPwd='.$checkPwd.'&phone='.$phone.'&access_token='.$accessToken;
        $data=api_curl($this->url.'/User/changePwd.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];

        $this->ajaxReturn($res);
    }

    /**
     * 短信接口
     */
    public function sendMsgCode(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $type = I("post.type", "");
        $phone = I("post.phone", "");
        $verifyCode=I('post.verifyCode','');
        $accessToken=I('post.access_token','');
        $str='type='.$type.'&phone='.$phone.'&verifyCode='.$verifyCode.'&access_token='.$accessToken;
        $data=api_curl($this->url.'/User/sendMsgCode.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $this->ajaxReturn($res);
    }



    /**
     * 钱包支出
     */
    public function walletOut(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $p=I('post.p',1);
        $size=I('post.size',10);
        $accessToken=I('post.access_token','');
        $str='p='.$p.'&size='.$size.'&access_token='.$accessToken;
        $data=api_curl($this->url.'/finance/walletOut.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']='成功';
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res);
    }

    /**
     * 钱包收入
     */
    public function walletIn(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $p=I('post.p',1);
        $size=I('post.size',10);
        $accessToken=I('post.access_token','');
        $str='p='.$p.'&size='.$size.'&access_token='.$accessToken;
        $data=api_curl($this->url.'/Finance/walletIn.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']='成功';
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res);
    }

    /**
     * 检查密码的强度
     */
    public function checkPwd(){
        $res=array('get'=>0,'msg'=>'未初始化');//初始化信息
        $pwd = I('post.pwd', '');
        $accessToken=I('post.access_token','');
        $str='pwd='.$pwd.'&access_token='.$accessToken;
        $data=api_curl($this->url.'/User/checkPwd.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];

        $this->ajaxReturn($res);

    }

    /**
     * 修改手机号
     */
    public function changePhone(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $phone=I('post.phone','');
        $yzm=I('post.yzm','');
        $pwd=I('post.pwd','');
        $accessToken=I('post.access_token','');
        $str='pwd='.$pwd.'&access_token='.$accessToken.'&phone='.$phone.'&yzm='.$yzm;
        $data=api_curl($this->url.'/User/changePhone.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];

        $this->ajaxReturn($res );
    }

    /**
     * 注册
     */
    public function register(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $phone = I('post.phone', "");
        $pwd = I('post.pwd', "");
        $yzm = I('post.yzm', "");
        $type = 'reg';
        $accessToken=I('post.access_token','');
        $invite=I('post.invite','');
        $refresh_token = I('post.refresh_token', '');
        $str='pwd='.$pwd.'&access_token='.$accessToken.'&phone='.$phone.'&yzm='.$yzm.'&type='.$type.'&refresh_token='.$refresh_token.'&invite='.$invite.'&membertype=1';
        $data=api_curl($this->url.'/User/register.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $this->ajaxReturn($res );
    }

    /**
     * 用户银行卡列表
     */
    public function getBankCardList(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息

        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken;
        $data=api_curl($this->url.'/User/getBankCardList.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_list'];
        $this->ajaxReturn($res );
    }

    /**
     * 银行卡列表
     */
    public function getBanksList(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken;
        $data=api_curl($this->url.'/User/getBanksList.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_list'];
        $this->ajaxReturn($res );
    }

    /**
     * 添加银行卡
     */
    public function addBankCard(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $bindName=I('post.bindName','');
        $bankName=I('post.bankName','');
        $bankNum=I('post.bankNum','');
        $phone=I('post.phone','');
        $yzm=I('post.yzm','');
        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken.'&bindName='.$bindName.'&bankName='.$bankName
            .'&bankNum='.$bankNum.'&phone='.$phone.'&yzm='.$yzm;
        $data=api_curl($this->url.'/User/addBankCard.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];

        $this->ajaxReturn($res );
    }

    /**
     * 账户提现
     */
    public function withdraw(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $cardId=I('post.cardId','');
        $cash=I('post.cash','');
        $accessToken=I('post.access_token','');

        $str='type=h5&access_token='.$accessToken.'&cardId='.$cardId.'&cash='.$cash;
        $data=api_curl($this->url.'/Finance/withdraw.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $this->ajaxReturn($res );
    }

    /**
     * 首页待缴金额
     */
    public function ToBePaid(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken;
        $data=api_curl($this->url.'/Finance/ToBePaid.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );
    }


    /**
     * 缴费记录
     */
    public function paymentRecord(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $p=I('post.p',1);
        $size=I('post.size',10);
        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken.'&p='.$p.'&size='.$size;
        $data=api_curl($this->url.'/Finance/paymentRecord.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );
    }

    //验证码生成
    public function verify(){

        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $phone=I('get.phone','');
        $type=I('get.type','');
        $accessToken=I('get.access_token','');
         
        if(empty($phone)){

            $this->ajaxReturn($res );
        }
        ob_clean();
        $config = array(
            'fontSize' => 20, // 验证码字体大小
            'length' => 4, // 验证码位数
            'imageH' => 50,
            'imageW'=>150,
            'bg'=>array(255,255,255),
            'useNoise' => false, // 关闭验证码杂点
            'reset' => false, // 验证成功后是否重置
        );
        $verify = new \Think\AppVerify($config);
        $verify->codeSet = '0123456789';
        if($type=='getpwd'){
            $verify->entry($type,$phone);
        }
        $verify->entry($accessToken,$phone);
        exit;
    }

    /**
     * 租客待缴
     */
    public function renterBill(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $p=I('post.p',1);
        $size=I('post.size',10);
        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken.'&p='.$p.'&size='.$size;
        $data=api_curl($this->url.'/Finance/renterBill.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );
    }

    /**
     * 用户消息
     */
    public function userNotice(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token','');
        $p=I('post.p',1);
        $size=I('post.size',20);
        $str='access_token='.$accessToken.'&p='.$p.'&size='.$size;
        $data=api_curl($this->url.'/User/userNotice.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );
    }

    /**
     * 退组单
     */
    public function exitOrder(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token','');
        $orderId=I('post.orderId');
        $str='access_token='.$accessToken.'&orderId='.$orderId;

        $data=api_curl($this->url.'/User/exitOrder.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );
    }


    /**
     * 意见反馈
     */
    public function Opinion(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token','');
        $content=I('post.content');
        $str='access_token='.$accessToken.'&content='.$content;

        $data=api_curl($this->url.'/User/Opinion.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $this->ajaxReturn($res );
    }

    /**
     * 常见问题
     */
    public function commonProblem(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token','');

        $str='access_token='.$accessToken;

        $data=api_curl($this->url.'/User/commonProblem.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_list'];
        $this->ajaxReturn($res );
    }

    /**
     * 查看某个合同
     */
    public function getTheOrder(){

        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token','');
        $orderId=I("post.order_id",'');
        $str='access_token='.$accessToken.'&order_id='.$orderId;
        $data=api_curl($this->url.'/House/getTheOrder.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );

    }

    /**
     * 查看租客某个房间合同列表
     */
    public function getTheOrderList(){

        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token','');
        $orderId=I("post.order_id",'');
        $roomId=M(rental_table('order'))->where(array('order_id'=>$orderId))->field('order_room_id')->find();

        $str='is_rental=1&access_token='.$accessToken.'&room_id='.$roomId['order_room_id'];
        $data=api_curl($this->url.'/House/getOrders.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );

    }

    /**
     * 查询用户金额
     */
    public function amount(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $accessToken=I('post.access_token','');

        $str='access_token='.$accessToken;

        $data=api_curl($this->url.'/Finance/amount.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );

    }

    /**
     * 账户收支
     */
    public function payments(){
        $res=array('code'=>0,'msg'=>'未初始化');//初始化信息
        $p=I('post.p',1);
        $size=I('post.size',10);
        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken.'&p='.$p.'&size='.$size;

        $data=api_curl($this->url.'/Finance/payments.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );

    }

    /**
     * 修改密码2
     */
    public function getPwdOk(){
        $phone = I("post.phone", "");
        $yzm = I("post.yzm", ""); //手机验证码
        $npwd=I('post.npwd','');
        $type=I('post.type');
        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken.'&type='.$type.'&npwd='.$npwd.'&yzm='.$yzm.'&phone='.$phone;
        $data=api_curl($this->url.'/User/getPwdOk.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );
    }

    /**
     * 修改密码1
     */
    public function getPwd(){
        $phone = I("post.phone", "");

        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken.'&phone='.$phone;
        $data=api_curl($this->url.'/User/getPwd.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );
    }
    /**
 * 文章详细
 */
    public function articleDetail(){
        $article_id = I("post.article_id", "");

        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken.'&article_id='.$article_id;
        $data=api_curl($this->url.'/User/articleDetail.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );
    }

    /**
     * 微信基础信息
     */
    public function wxConf(){
        $url = I("request.url", "");
        $res = array("code" => 0, "msg" => "未出初始化", "data" => array());
        $webChat = new WeChat();
        $map['tp_alias'] = "haogongyu";
        $result = M(sys_table("third_party"))->where($map)->find();
        $token = $result['tp_access_token'];
        $ticket = $result['tp_ticket'];
        if ($result['tp_access_token'] == "" || $result['tp_access_token'] < time())
        {
            $token = $webChat->getToken($map['tp_alias']);
        }
        if ($result['tp_ticket'] == "" || $result['tk_expires_in'] < time())
        {
            $ticket = $webChat->getTicket($map['tp_alias'], $token);
        }
        if ($token && $ticket)
        {
            $data['jsapi_ticket'] = $ticket;
            $data['noncestr'] = generate_hash();
            $data['timestamp'] = time();
            $data['url'] = urldecode($url);
            $data = array_filter($data);
            ksort($data);
            $tmpStr = "";
            foreach ($data as $k => $v)
                $tmpStr .= "&{$k}={$v}";
            if ($tmpStr)
                $tmpStr = substr($tmpStr, 1);
            $data['signature'] = sha1($tmpStr);
            $data['appId'] = $result['tp_app_id'];
            $res = array("code" => 1, "msg" => "成功", "data" => $data);
        } else
        {
            $res = array("code" => 9, "msg" => "失败");
        }
         
        $this->ajaxReturn($res);
    }

    //oauth2认证登录
    public function fetchCodeJump()
    {
        $res=array('code'=>0,'msg'=>'未初始化');
        $code = I("post.code");
        $state = I("post.state");
        if (empty($code) || $state != "haogongyu_h5"){
            $this->ajaxReturn($res);
        }
        $webChat = new WeChat();
        $result = $webChat->getH5Oauth2TokenByCode($code);
         
        if(!isset($result['openid'])){
            $res['msg']='获取失败';
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']='成功';
        $res['data']=$result;
        $this->ajaxReturn($res );
    }

    /**
     * 线上支付
     */
    public function h5Pay(){
        $amount = I("post.amount", "");
        $periods=I('post.periods','');
        $accessToken=I('post.access_token','');
        $payType=I('post.payType','');
        $status=I('post.status','');
        $openId=I('post.openId','');
        $cli=I('post.cli',false);
        $str='access_token='.$accessToken.'&amount='.$amount.'&periods='.$periods.'&payType='.$payType.'&status='. $status.'&openId='.$openId.'&cli='.$cli;

        $data=api_curl($this->url.'/Finance/h5Pay.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );
    }

    /**
     *
     * h5钱包余额支付
     */
    public function walletPay(){
        $amount = I("post.amount", "");
        $periods=I('post.periods','');
        $periods=rtrim($periods,',');
        $accessToken=I('post.access_token','');

        $status=I('post.status','');

        $str='access_token='.$accessToken.'&amount='.$amount.'&periods='.$periods.'&status='. $status;

        $data=api_curl($this->url.'/Finance/walletPay.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }

        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $this->ajaxReturn($res );
    }

    /**
     * 消息已读
     */
    public function haveReadNotice(){
        $notice_id = I("post.notice_id", "");

        $accessToken=I('post.access_token','');

        $str='access_token='.$accessToken.'&notice_id='.$notice_id;

        $data=api_curl($this->url.'/User/haveReadNotice.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $this->ajaxReturn($res );
    }

    /**
     * 支付类型开关
     */
    public function payType(){
        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken;
        $data=api_curl($this->url.'/Finance/payType.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );
    }

    /**
     * 检测银行卡号
     */
    public function checkBankNum(){
        $cardNum=I('post.cardNum','');
        $accessToken=I('post.access_token','');
        $str='access_token='.$accessToken.'&cardNum='.$cardNum;
        $data=api_curl($this->url.'/User/checkBankNum.html',$str,'POST',$this->header);
         
        if($data['service_code']!=2000){
            $res['code']=$data['service_code'];
            $res['msg']=$data['service_msg'];
            $this->ajaxReturn($res);
        }
        $res['code']='1';
        $res['msg']=$data['service_msg'];
        $res['data']=$data['service_extra'];
        $this->ajaxReturn($res );
    }
}