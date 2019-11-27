@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        div {
            -moz-box-sizing: border-box; /*Firefox3.5+*/
            -webkit-box-sizing: border-box; /*Safari3.2+*/
            -o-box-sizing: border-box; /*Opera9.6*/
            -ms-box-sizing: border-box; /*IE8*/
            box-sizing: border-box; /*W3C标准(IE9+，Safari5.1+,Chrome10.0+,Opera10.6+都符合box-sizing的w3c标准语法)*/
        }

        .dHead {
            height: 85px;
            width: 100%;
            position: fixed;
            z-index: 5;
            top: 0;
            overflow-x: auto;
            padding: 10px;
        }

        .dBody {
            width: 100%;
            overflow: auto;
            top: 90px;
            position: absolute;
            z-index: 10;
            bottom: 5px;
        }

        .layui-btn-xstree {
            height: 35px;
            line-height: 35px;
            padding: 0px 5px;
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
    <div style="height: 100%">
        <div class="dHead">
            <a class="layui-btn layui-btn-primary layui-btn-xs layui-btn-xstree" onclick="reload()">reload</a>
            <a class="layui-btn layui-btn-primary layui-btn-xs layui-btn-xstree" onclick="query()">query</a>
            <a class="layui-btn layui-btn-primary layui-btn-xs layui-btn-xstree" onclick="add(null);">新增顶级菜单</a>
            <a class="layui-btn layui-btn-primary layui-btn-xs layui-btn-xstree" onclick="openorclose();">隐藏或打开香蕉节点</a>
            <a class="layui-btn layui-btn-primary layui-btn-xs layui-btn-xstree" onclick="getCheckData();">获取选中行数据</a>
            <a class="layui-btn layui-btn-primary layui-btn-xs layui-btn-xstree" onclick="getCheckLength();">获取选中数目</a>
            <a class="layui-btn layui-btn-primary layui-btn-xs layui-btn-xstree" onclick="print();">打印缓存对象</a>
            <a class="layui-btn layui-btn-primary layui-btn-xs layui-btn-xstree" onclick="openAll();">展开或折叠全部</a>
            <a class="layui-btn layui-btn-primary layui-btn-xs layui-btn-xstree" onclick="radioStatus();">获取单选数据</a>
            <a class="layui-btn layui-btn-primary layui-btn-xs layui-btn-xstree" onclick="test();">test</a>
            <br>
            <br>
            <b>此服务器配置不是一般低</b>，请您耐心等待，如长时间无法加载，可以手动刷新一次（一机多用，所以宽带和内存有限的问题导致资源无法及时加载成功）。
            <img src="" onerror="src=''" alt="">
        </div>
        <div class="dBody">
            <table class="layui-hidden" id="treeTable" lay-filter="treeTable"></table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var editObj = null, ptable = null, treeGrid = null, tableId = 'treeTable', layer = null;
        // layui方法
        layui.config({
            base: '/extend/layui/extend/treeGrid/'//配置 layui 第三方扩展组件存放的基础目录
        }).extend({
            treeGrid: 'treeGrid' //定义该组件模块名
        }).use(['jquery', 'treeGrid', 'layer'], function () {
            var $ = layui.jquery;
            treeGrid = layui.treeGrid;//很重要
            layer = layui.layer;
            ptable = treeGrid.render({
                id: tableId
                , elem: '#' + tableId
                , url: '/admin/ajaxIndex'
                , cellMinWidth: 100
                , idField: 'id'//必須字段
                , treeId: 'id'//树形id字段名称
                , treeUpId: 'parent_id'//树形父id字段名称
                , treeShowName: 'name'//以树形式显示的字段
                , heightRemove: [".dHead", 10]//不计算的高度,表格设定的是固定高度，此项不生效
                , height: '100%'
                , isFilter: false
                , iconOpen: false//是否显示图标【默认显示】
                , isOpenDefault: true//节点默认是展开还是折叠【默认展开】
                , loading: true
                , method: 'get'
                , isPage: false
                , limit: 1000 //默认采用100
                , cols: [[
                    {type: 'numbers'}
                    , {type: 'checkbox', sort: true}
                    , {field: 'name', width: 200, title: '菜单名称', edit: 'text', sort: true}
                    , {field: 'id', width: 60, title: 'id', sort: true}
                    , {field: 'slug', width: 200, edit: 'text', title: '权限'}
                    , {field: 'url', width: 280, edit: 'text', title: '链接'}
                    , {field: 'icon', width: 150, edit: 'text', title: '图标'}
                    , {field: 'parent_id', width: 50, edit: 'text', title: 'pid'}
                    , {field: 'sort', width: 80, edit: 'text', title: '排序', sort: true}
                    , {
                        width: 160, title: '操作', align: 'center'/*toolbar: '#barDemo'*/
                        , templet: function (d) {
                            var html = '';
                            var saveBtn = '<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="save">保存</a>';
                            var addBtn = '<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="add">添加</a>';
                            var delBtn = '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                            return saveBtn+addBtn + delBtn;
                        }
                    }
                ]]
                , parseData: function (res) {//数据加载后回调
                    return res;
                }
                , onClickRow: function (index, o) {
                    console.log(index, o, "单击！");
                    //msg("单击！,按F12，在控制台查看详细参数！");
                }
                , onDblClickRow: function (index, o) {
                    console.log(index, o, "双击");
                    msg("双击！,按F12，在控制台查看详细参数！");
                }
                , onCheck: function (obj, checked, isAll) {//复选事件
                    console.log(obj, checked, isAll, "复选");
                    msg("复选,按F12，在控制台查看详细参数！");
                }
                , onRadio: function (obj) {//单选事件
                    console.log(obj, "单选");
                    msg("单选,按F12，在控制台查看详细参数！");
                }
            });

            treeGrid.on('tool(' + tableId + ')', function (obj) {
                if (obj.event === 'del') {//删除行
                    del(obj);
                } else if (obj.event === "add") {//添加行
                    add(obj);
                } else if (obj.event === "save") {//添加行
                    save(obj);
                }
            });
            //监听单元格编辑
            treeGrid.on('edit(' + tableId + ')', function(obj){
                var value = obj.value //得到修改后的值
                    ,data = obj.data //得到所在行所有键值
                    ,field = obj.field; //得到字段
                layer.msg('[ID: '+ data.id +']  更改为：'+ value);
            });
        });

        function del(obj) {
            layer.confirm("你确定删除数据吗？如果存在下级节点则一并删除，此操作不能撤销！", {icon: 3, title: '提示'},
                function (index) {//确定回调
                    obj.del();
                    layer.close(index);
                }, function (index) {//取消回调
                    layer.close(index);
                }
            );
        }
        //保存数据
        function save(obj) {
            let data =obj ? obj.data : null;
            let param ={};
            console.log(obj, "更改和保存的数据");
            if(data){
                if (data.id!=''){ //更改数据
                    param.id = data.id;
                }
                param.name = data.name;
                param.icon = data.icon;
                param.parent_id = data.parent_id;
                param.slug = data.slug;
                param.url = data.url;
                param.sort = data.sort;
            }
        }
        var i = 100;
        //添加
        function add(pObj) {
            console.log(pObj);
            let pdata = pObj ? pObj.data : null;
            let param = {};
            if(pdata!=null){ //不是新增
                if (pdata.parent_id != 0) {
                    return msg("不是顶级菜单不可以添加！");
                }
            }
            param.id = 0;
            param.name = '';
            param.icon = '';
            param.parent_id = pdata ? pdata.id : 0;
            param.slug = '';
            param.url = '';
            param.sort = 0;
            treeGrid.addRow(tableId,pdata?pdata[treeGrid.config.indexName] + 1:0,param);  //这个地方下标报错
        }

        function print() {
            console.log(treeGrid.cache[tableId]);
            msg("对象已打印，按F12，在控制台查看！");
        }
        function msg(msg) {
            var loadIndex = layer.msg(msg, {
                time: 3000
                , offset: 'auto'//顶部
                , shade: 0
            });
        }

        function openorclose() {
            var map = treeGrid.getDataMap(tableId);
            var o = map['102'];
            treeGrid.treeNodeOpen(tableId, o, !o[treeGrid.config.cols.isOpen]);
        }


        function openAll() {
            var treedata = treeGrid.getDataTreeList(tableId);
            treeGrid.treeOpenAll(tableId, !treedata[0][treeGrid.config.cols.isOpen]);
        }

        function getCheckData() {
            var checkStatus = treeGrid.checkStatus(tableId)
                , data = checkStatus.data;
            layer.alert(JSON.stringify(data));
        }

        function radioStatus() {
            var data = treeGrid.radioStatus(tableId)
            layer.alert(JSON.stringify(data));
        }

        function getCheckLength() {
            var checkStatus = treeGrid.checkStatus(tableId)
                , data = checkStatus.data;
            layer.msg('选中了：' + data.length + ' 个');
        }

        function reload() {
            treeGrid.reload(tableId, {
                page: {
                    curr: 1
                }
            });
        }

        function query() {
            treeGrid.query(tableId, {
                where: {
                    name: 'sdfsdfsdf'
                }
            });
        }

        function test() {
            console.log(treeGrid.cache[tableId], treeGrid.getClass(tableId));


            /*var map=treeGrid.getDataMap(tableId);
            var o= map['102'];
            o.name="更新";
            treeGrid.updateRow(tableId,o);*/
        }
    </script>
    <script>
        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?e2af8415b6ffbaeb52de4d080cb4ba85";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
@endsection
