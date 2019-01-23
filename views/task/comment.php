<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">

<style type="text/css">
    /* CSS Test begin */
    .comment-box {
        margin-top: 30px !important;
    }
    /* CSS Test end */

    .comment-box img {
        width: 50px;
        height: 50px;
    }
    .comment-box .media-left {
        padding-right: 10px;
        width: 65px;
    }
    .comment-box .media-body p {
        border: 1px solid #ddd;
        padding: 10px;
    }
    .comment-box .media-body .media p {
        margin-bottom: 0;
    }
    .comment-box .media-heading {
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        padding: 7px 10px;
        position: relative;
        margin-bottom: -1px;
    }
    .comment-box .media-heading:before {
        content: "";
        width: 12px;
        height: 12px;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        border-width: 1px 0 0 1px;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
        position: absolute;
        top: 10px;
        left: -6px;
    }

    body{ background: #fafafa;}
    .widget-area.blank {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -ms-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none;
    }
    body .no-padding {
        padding: 0;
    }
    .widget-area {
        background-color: #fff;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: 0 0 16px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: 0 0 16px rgba(0, 0, 0, 0.05);
        -ms-box-shadow: 0 0 16px rgba(0, 0, 0, 0.05);
        -o-box-shadow: 0 0 16px rgba(0, 0, 0, 0.05);
        box-shadow: 0 0 16px rgba(0, 0, 0, 0.05);
        float: left;
        margin-top: 30px;
        padding: 25px 30px;
        position: relative;
        width: 100%;
    }
    .status-upload {
        background: none repeat scroll 0 0 #f5f5f5;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        float: left;
        width: 100%;
    }
    .status-upload form {
        float: left;
        width: 100%;
    }
    .status-upload form textarea {
        background: none repeat scroll 0 0 #fff;
        border: medium none;
        -webkit-border-radius: 4px 4px 0 0;
        -moz-border-radius: 4px 4px 0 0;
        -ms-border-radius: 4px 4px 0 0;
        -o-border-radius: 4px 4px 0 0;
        border-radius: 4px 4px 0 0;
        color: #777777;
        float: left;
        font-family: Lato;
        font-size: 14px;
        height: 142px;
        letter-spacing: 0.3px;
        padding: 20px;
        width: 100%;
        resize:vertical;
        outline:none;
        border: 1px solid #F2F2F2;
    }

    .status-upload ul {
        float: left;
        list-style: none outside none;
        margin: 0;
        padding: 0 0 0 15px;
        width: auto;
    }
    .status-upload ul > li {
        float: left;
    }
    .status-upload ul > li > a {
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        color: #777777;
        float: left;
        font-size: 14px;
        height: 30px;
        line-height: 30px;
        margin: 10px 0 10px 10px;
        text-align: center;
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -ms-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
        width: 30px;
        cursor: pointer;
    }
    .status-upload ul > li > a:hover {
        background: none repeat scroll 0 0 #606060;
        color: #fff;
    }
    .status-upload form button {
        border: medium none;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        color: #fff;
        float: right;
        font-family: Lato;
        font-size: 14px;
        letter-spacing: 0.3px;
        margin-right: 9px;
        margin-top: 9px;
        padding: 6px 15px;
    }
    .dropdown > a > span.green:before {
        border-left-color: #2dcb73;
    }
    .status-upload form button > i {
        margin-right: 7px;
    }
</style>
<div class='container'>
    <?php
        foreach ($data_comment as $data_comment) {
            $timestamp = strtotime($data_comment['created_at']);
            $new_date = date('d M Y h:i A', $timestamp);
    ?>
    <div class="media comment-box" style="width: 73%">
        <div class="media-body">
            <h4 class="media-heading"><?= $data_comment['user_comment']; ?> <small class="text-muted"> - <?= $new_date ?></small></h4>
            <p><?= $data_comment['comments']; ?></p>
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-6">
            <div class="widget-area no-padding blank">
                <div class="status-upload">
                    <form id="form-comment">
                        <textarea placeholder="Type your message here..." id="text-comment"></textarea>
                        <ul>
                            <li><a title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Audio"><i class="fa fa-music"></i></a></li>
                            <li><a title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Video"><i class="fa fa-video-camera"></i></a></li>
                            <li><a title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Sound Record"><i class="fa fa-microphone"></i></a></li>
                            <li><a title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Picture"><i class="fa fa-picture-o"></i></a></li>
                        </ul>
                        <button type="button" id="<?= $id ?>" class="btn btn-success green submit-comment"><i class="fa fa-share"></i> Share</button>
                    </form>
                </div><!-- Status Upload  -->
            </div><!-- Widget Area -->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("[data-toggle=tooltip]").tooltip();

        $(".submit-comment").click(function(){
            id = $(this).attr("id");
            var comment = $("#text-comment").val();
//            alert(comment);
            $.ajax({
               url : "<?php echo Yii::$app->request->baseUrl. '/task/submitcomment' ?>",
                type : 'post',
                data : {id:id,comment:comment},
                success : function(e){
                    $('#comment-content').html(e);
                }
            });
        });
    });
</script>