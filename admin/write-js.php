<?php Typecho_Plugin::factory('admin/write-js.php')->write(); ?>
<?php Typecho_Widget::widget('Widget_Metas_Tag_Cloud', 'sort=count&desc=1&limit=200')->to($tags); ?>

<script src="<?php $options->adminUrl('javascript/timepicker.js?v=' . $suffixVersion); ?>"></script>
<script src="<?php $options->adminUrl('javascript/tokeninput.js?v=' . $suffixVersion); ?>"></script>
<script>
$(document).ready(function() {
    // 日期时间控件
    $('#date').mask('9999-99-99 99:99').datetimepicker({
        currentText     :   '<?php _e('现在'); ?>',
        prevText        :   '<?php _e('上一月'); ?>',
        nextText        :   '<?php _e('下一月'); ?>',
        monthNames      :   ['<?php _e('一月'); ?>', '<?php _e('二月'); ?>', '<?php _e('三月'); ?>', '<?php _e('四月'); ?>',
            '<?php _e('五月'); ?>', '<?php _e('六月'); ?>', '<?php _e('七月'); ?>', '<?php _e('八月'); ?>',
            '<?php _e('九月'); ?>', '<?php _e('十月'); ?>', '<?php _e('十一月'); ?>', '<?php _e('十二月'); ?>'],
        dayNames        :   ['<?php _e('星期日'); ?>', '<?php _e('星期一'); ?>', '<?php _e('星期二'); ?>',
            '<?php _e('星期三'); ?>', '<?php _e('星期四'); ?>', '<?php _e('星期五'); ?>', '<?php _e('星期六'); ?>'],
        dayNamesShort   :   ['<?php _e('周日'); ?>', '<?php _e('周一'); ?>', '<?php _e('周二'); ?>', '<?php _e('周三'); ?>',
            '<?php _e('周四'); ?>', '<?php _e('周五'); ?>', '<?php _e('周六'); ?>'],
        dayNamesMin     :   ['<?php _e('日'); ?>', '<?php _e('一'); ?>', '<?php _e('二'); ?>', '<?php _e('三'); ?>',
            '<?php _e('四'); ?>', '<?php _e('五'); ?>', '<?php _e('六'); ?>'],
        closeText       :   '<?php _e('关闭'); ?>',
        timeOnlyTitle   :   '<?php _e('选择时间'); ?>',
        timeText        :   '<?php _e('时间'); ?>',
        hourText        :   '<?php _e('时'); ?>',
        amNames         :   ['<?php _e('上午'); ?>', 'A'],
        pmNames         :   ['<?php _e('下午'); ?>', 'P'],
        minuteText      :   '<?php _e('分'); ?>',
        secondText      :   '<?php _e('秒'); ?>',

        dateFormat      :   'yy-mm-dd',
        hour            :   (new Date()).getHours(),
        minute          :   (new Date()).getMinutes()
    });

    // tag autocomplete 提示
    var tags = $('#tags'), tagsPre = [];
    
    var items = tags.val().split(','), result = [];
    for (var i = 0; i < items.length; i ++) {
        var tag = items[i];

        if (!tag) {
            continue;
        }

        tagsPre.push({
            id      :   tag,
            tags    :   tag
        });
    }

    tags.tokenInput(<?php 
    $data = array();
    while ($tags->next()) {
        $data[] = array(
            'id'    =>  $tags->name,
            'tags'  =>  $tags->name
        );
    }
    echo json_encode($data);
    ?>, {
        propertyToSearch:   'tags',
        tokenValue      :   'tags',
        searchDelay     :   0,
        preventDuplicates   :   true,
        animateDropdown :   false,
        hintText        :   '<?php _e('请输入标签名'); ?>',
        noResultsText   :   '此标签不存在, 按回车创建',
        prePopulate     :   tagsPre
    });

    // tag autocomplete 提示宽度设置
    $('#token-input-tags').focus(function() {
        var t = $('.token-input-dropdown'),
            offset = t.outerWidth() - t.width();
        t.width($('.token-input-list').outerWidth() - offset);
    });

    var slug = $('#slug'), sw = slug.width();

    if (slug.val().length > 0) {
        slug.css('width', 'auto').attr('size', slug.val().length);
    }
    
    slug.bind('input propertychange', function () {
        var t = $(this), l = t.val().length;

        if (l > 0) {
            t.css('width', 'auto').attr('size', l);
        } else {
            t.css('width', sw).removeAttr('size');
        }
    }).width();

    // 高级选项控制
    $('#advance-panel-btn').click(function() {
        $('#advance-panel').toggle();
        return false;
    });
    
});
</script>

