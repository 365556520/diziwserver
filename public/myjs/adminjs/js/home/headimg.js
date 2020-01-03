/**
 * 图片剪切js
 */
var headimg = function () {
    var headimgInit = function () {
        //图片
        var $image = $('#image');
        // 打开图片按钮
        var $photoInput =   $('#photoInput');
        //裁剪后的图片
        var $imageinfo ;
        // 初始化这个核心方法修改自官方demo的js
        var initCropper = function (img, input){
            var $image = img;
            var options = {
                aspectRatio: 1/1, // 纵横比
                preview: '.img-preview', // 预览图的class名
                minContainerWidth:250,
                minContainerHeight:300,
                minCanvasWidth:50,
                minCanvasHeight:50,
            };
            $image.on({
                'build.cropper': function (e) {
                    // console.log(e.type);
                },
                'built.cropper': function (e) {
                    // console.log(e.type);
                },
                'cropstart.cropper': function (e) {
                    // console.log(e.type, e.action);
                },
                'cropmove.cropper': function (e) {
                    // console.log(e.type, e.action);
                },
                'cropend.cropper': function (e) {
                    // console.log(e.type, e.action);
                },
                'crop.cropper': function (data) {
                    // 当改变剪裁容器或图片时的事件函数。
                    //获取位置数据.
                    $('#imgdatax').html(data.detail.x.toFixed(2));
                    $('#imgdatay').html(data.detail.y.toFixed(2));
                    $('#imgdatawidth').html(data.detail.width.toFixed(2));
                    $('#imgdataheight').html(data.detail.height.toFixed(2));
                    /*  //打印日志
                     //位置xy
                     console.log(data.x);
                     console.log(data.y);
                     // 裁剪区域长和高
                     console.log(data.width);
                     console.log(data.height);
                     //旋转角度
                     console.log(data.rotate);
                     console.log(data.scaleX);
                     console.log(data.scaleY);*/
                },
                'zoom.cropper': function (e) {
                    // console.log(e.type, e.ratio);
                },

            }).cropper(options);
            var $inputImage = input;
            var uploadedImageURL;
            if (URL) {
                // 给input添加监听
                $inputImage.change(function () {
                    var files = this.files;
                    var file;
                    if (!$image.data('cropper')) {
                        return;
                    }
                    if (files && files.length) {
                        file = files[0];
                        // 判断是否是图像文件
                        if (/^image\/\w+$/.test(file.type)) {
                            // 如果URL已存在就先释放
                            if (uploadedImageURL) {
                                URL.revokeObjectURL(uploadedImageURL);
                            }
                            uploadedImageURL = URL.createObjectURL(file);
                            // 销毁cropper后更改src属性再重新创建cropper
                            $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                            $inputImage.val('');
                        } else {
                            window.alert('请选择一个图像文件！');
                        }
                    }
                });
            } else {
                $inputImage.prop('disabled', true).addClass('disabled');
            }
        };

        //上传提交
        $('#submitbtn').on('click',function () {
            /*            //获取裁剪图片的
                        $imageinfo = $image.cropper('getCroppedCanvas',{width:300, height:300}).toDataURL();*/
            //把图片放到icon里面
            // $("#icon").val($imageinfo);
            var token = '' , qiniubucket = '';
            $.ajax({
                type: "get",
                url: "/admin/getQiNiuToken",
                cache: false,
                success: function (data) {
                    token = data.token;
                    qiniubucket = data.bucket;
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                }
            });
            console.log($imageinfo);
            $.getScript("http://jssdk-v2.demo.qiniu.io/dist/qiniu.min.js",function () {
                var config = {
                    useCdnDomain: true,
                    disableStatisticsReport: false,
                    retryCount:  6,
                    region: qiniu.region.z2 //七牛空间上传的区域  华东 z0 华北z1 华南z2
                };
                var putExtra = {
                    fname: "",
                    params: {},
                    mimeType: null
                };
                var file = $imageinfo;  //上传的文件
                var observable;
                //文件名字加密
                var prefix = 'diziw/images/haedimg'; //名字的前缀
                var filename= '.'+$imageinfo.type.split("/")[1]; //图片的后缀名
                // var fileExt=(/[.]/.exec(filename)) ? /[^.]+$/.exec(filename.toLowerCase()) : ''; //后缀名
                var timestamp=new Date().getMilliseconds(); //当前毫秒数返回值是 0 ~ 999 之间的一个整数
                var uuid = getUuid.init(8,16); //获取uuid
                var newfilename = timestamp+uuid+ filename ; //当前毫秒+uuid+后缀名
                var key = prefix+'/'+newfilename; //这个是文件的完整名字
                putExtra.params["x:name"] = key.split(".")[0];
                var error = function(err) {
                    console.log("上传错误信息：" + JSON.stringify(err));
                };
                var complete = function(res) {
                    let url = 'http://public.diziw.cn/'+res.key; //图片地址
                    console.log("上传成功：" + url);
                    //把图片地址放到icon里面
                    $("#headimg").val(url);
                    //提交表单
                    $('#submitForm').submit();
                    console.log("上传成功：" + JSON.stringify(res));
                };
                var next = function(response) {
                 /*  上传完成后的数据格式 {"total":{"loaded":165288,"size":165288,"percent":100}}%*/
                    console.log("上传进度：" + JSON.stringify(response) + "% ");
                };

                observable = qiniu.upload(file, key, token, putExtra, config);
                var subObject = {next:next,error:error,complete:complete};
                if(typeof callback === 'function'){
                    callback(observable,subObject)
                }else{
                    observable.subscribe({next:next,error:error,complete:complete});
                }

            });

        });


        //裁剪保存按钮
        $('#btnimg').on('click',function (){
            var $target = $('#result');
            $image.cropper('getCroppedCanvas',{
                width:300, // 裁剪的长宽
                height:300
            }).toBlob(function(blob){
                /*裁剪后得到这个图片*/
                // 裁剪后将图片放到指定标签
                $target.attr('src',URL.createObjectURL(blob));
                $imageinfo = blob;
            });
        });


        //旋转按钮
        $('#rotate-Left').on('click',function (){
            $image.cropper("rotate",-45);
        });
        $('#rotate-Right').on('click',function (){
            $image.cropper("rotate",-45);
        });
        initCropper($image,$photoInput);

    };
    return {
        init : headimgInit
    }
}();
