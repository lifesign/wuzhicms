<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>

<link href="http://www.h1jk.cn/res/css/validform.css" rel="stylesheet" />
<script src="http://www.h1jk.cn/res/js/validform.min.js"></script>
<script src="http://www.h1jk.cn/res/js/wuzhicms.js"></script>
<script type="text/javascript" src="http://www.h1jk.cn/res/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="http://www.h1jk.cn/res/js/ueditor/ueditor.all.min.js"></script>
<!--正文部分-->
<style type="text/css">
    label{font-weight: normal;
    }
    .text-blod{font-weight: bold;}
    #Validform_msg .Validform_title {
        background-color: #4585E6;
    }
    #Validform_msg .Validform_info {
        border: 1px solid #4585E6;
    }
</style>
<div class="container adframe">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            
        </div>
    </div>
</div>

<div class="container memberframe">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <!--左侧开始-->
            <div class="memberleft">
                <div class="membertitle"><h3>会员中心</h3></div>
                <div class="memberborder">
                    <?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','left'); ?>
                </div>
            </div>
            <!--左侧结束-->

            <!--右侧开始-->
            <div class="memberright">

                <ul id="myTab" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tabs1" id="1tab" role="tab" data-toggle="tab" aria-controls="tabs1" aria-expanded="true">产品信息发布</a></li>
                    <li role="presentation" class=""><a href="?m=content&f=postinfo&v=listing">我发布的信息</a></li>
                    <li class="tip-a" style="float:right;">温馨提示：我们的客服会在24小时内审核。全国免费咨询电话：010-11111111</li>
                </ul>
                <div class="memberbordertop">
                    <section class="panel">
                        <div class="panel-body" id="panel-bodys">
                            <form name="myform" class="form-horizontal" action="" method="post" id="myform">
                                <table class="table table-striped table-advance table-hover text-center">
                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-2 control-label text-right text-blod"><font color="red">*</font> 标题：</label><div class="col-sm-10 text-left">
                                            <input type="text" style="color:#" name="form[title]" id="title" maxlength="80" value="" class="form-control" datatype="*2-80" nullmsg="请输入标题" errormsg="标题至少2个字符,最多80个字符！">                                       </div></div></td>
                                    </tr>

                                    <?php $n=1;if(is_array($field_list)) foreach($field_list AS $info) { ?>
                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-2 control-label text-right text-blod"><?php if($info['star']) { ?><font color="red">*</font><?php } ?> <?php echo $info['name'];?>：</label><div class="col-sm-10 text-left">
                                            <?php echo $info['form'];?>
                                        </div></div></td>
                                    </tr>
                                    <?php $n++;}?>
                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-2 control-label text-right text-blod"><?php if($info['star']) { ?><font color="red">*</font><?php } ?> <?php echo $formdata['5']['content']['name'];?>：</label><div class="col-sm-10 text-left">
                                            <?php echo $formdata['5']['content']['form'];?>
                                        </div></div></td>
                                    </tr>
                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-2 control-label text-right"> </label><div class="col-sm-3 text-left"><input type="submit" name="submit" id="submit" value="提交" class="btn btn-order"></div></div></td>
                                    </tr>
                                </table>
                            </form>
                        </div>

                </div>

                </section>
            </div>

        </div>
            <!--右侧结束-->


        </div>
    </div>
</div>
<!--正文部分-->
<script type="text/javascript">
    $("#submit").click(function(){
        t=setTimeout("hide_formtips()",3000);
    });
    function hide_formtips() {
        $.Hidemsg();
        clearInterval(t);
    }
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:1
        });
    })
    </script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>

