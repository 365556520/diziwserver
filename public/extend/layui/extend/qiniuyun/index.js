layui.define('layer', function(exports){
	var $ = layui.$,layer = layui.layer;
	exports('qiniuyun', {
        loader:function (options,callback) {
			console.log(options);
            $.getScript("http://jssdk-v2.demo.qiniu.io/dist/qiniu.min.js",function () {
				if(!options.token){
                    layer.msg('初始化参数：token不能为空.', {icon: 2});
                    return;
                }
				if(!options.domain){
                    layer.msg('初始化参数：域名不能为空.', {icon: 2});
                    return;
                }
				var token = options.token;
				var domain = options.domain;

				var config = {
					useCdnDomain: true,
					disableStatisticsReport: false,
					retryCount: options.browse_button || 6,
					region: options.browse_button || qiniu.region.z2 //七牛空间上传的区域  华东 z0 华北z1 华南z2
				};
				var putExtra = {
					fname: "",
					params: {},
					mimeType: null
				};
                var prefix = options.prefix; //名字的前缀
				$(options.elem).unbind("change").bind("change",function(){
					var file = this.files[0];
					var finishedAttr = [];
					var compareChunks = [];
					var observable;
					var key = prefix+'/'+file.name; //这个文件名字需要md5加密
					putExtra.params["x:name"] = key.split(".")[0];

					var error = function(err) {
						if(typeof options.complete === 'function'){
							options.error(err);
						}else{
							layer.msg("上传失败:"+JSON.stringify(err), {icon: 2});
						}
					};

					var complete = function(res) {
						if(typeof options.complete === 'function'){
							options.complete(res);
						}else{
							layer.msg("上传成功:"+JSON.stringify(res));
						}
					};

					var next = function(response) {
						if(typeof options.complete === 'function'){
							options.next(response);
						}else{
							var chunks = response.chunks || [];
							var total = response.total;
							// 这里对每个chunk更新进度，并记录已经更新好的避免重复更新，同时对未开始更新的跳过
							for (var i = 0; i < chunks.length; i++) {
								if (chunks[i].percent === 0 || finishedAttr[i]) {
									continue;
								}
								if (compareChunks[i].percent === chunks[i].percent) {
									continue;
								}
								if (chunks[i].percent === 100) {
									finishedAttr[i] = true;
								}
							}
							console.log("上传进度：" + total.percent + "% ");
							compareChunks = chunks;
						}
					};

					observable = qiniu.upload(file, key, token, putExtra, config);
					var subObject = {next:next,error:error,complete:complete};
					if(typeof callback === 'function'){
						callback(observable,subObject)
					}else{
						observable.subscribe({next:next,error:error,complete:complete});
					}
				})
            });
        }
	})
});
