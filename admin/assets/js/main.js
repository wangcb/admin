/** 软文通 spa v3.1.8 date:2020-05-04 License By http://tv678.com */
layui.config({
    version: '318',   // 更新组件缓存，设为true不缓存，也可以设一个固定值
    base: 'assets/module/'
}).extend({
    steps: 'steps/steps',
    notice: 'notice/notice',
    cascader: 'cascader/cascader',
    dropdown: 'dropdown/dropdown',
    fileChoose: 'fileChoose/fileChoose',
    Split: 'Split/Split',
    Cropper: 'Cropper/Cropper',
    tagsInput: 'tagsInput/tagsInput',
    citypicker: 'city-picker/city-picker',
    introJs: 'introJs/introJs',
    zTree: 'zTree/zTree'
}).use(['layer', 'setter', 'index', 'admin','treeTable'], function () {
    var $ = layui.jquery;
    var layer = layui.layer;
    var setter = layui.setter;
    var index = layui.index;
    var admin = layui.admin;

    /* 检查是否登录 */
    if (!setter.getToken()) {
        return location.replace('login/login.html');
    }

    /* 获取用户信息 */
    admin.req('/user/0', function (res) {
        if (200 === res.code) {
            setter.putUser(res.data);  // 缓存用户信息
            admin.renderPerm();  // 移除没有权限的元素
            $('#huName').text(res.data.nickname);
            res.data.avatar && $('#avatar').attr('src',res.data.avatar);
        } else {
            layer.msg('获取用户失败', {icon: 2, anim: 6});
        }
    });
    index.regRouter([{'url':'#/template/user-info'}]);

    /* 加载侧边栏 */
    admin.req('/user/menu', function (res) {
        /*res.data.unshift({display_name:'系统首页',url:'#/console/workplace',icon:'layui-icon layui-icon-home'});
        index.regRouter(res.data);  // 注册路由*/
        var len = res.data.length;
        var menus = [];
        index.regRouter(res.data);
        for (var i = 0; i < len; i++) {
            if(res.data[i].type == 0){
                menus.push(res.data[i]);
            }
        }
        menus = layui.treeTable.pidToChildren(menus, 'id', 'parent_id');
        menus.unshift({display_name:'系统首页',url:'#/console/workplace',icon:'layui-icon layui-icon-home'});
        index.renderSide(menus);  // 渲染侧边栏
        // 加载主页
        index.loadHome({
            url: '#/console/workplace',
            name: '<i class="layui-icon layui-icon-home"></i>'
        });
    });

});
