"use strict";

/**
 * Adds [mediacredit] shortcode to tinymce
 */
(function () {
  tinymce.create('tinymce.plugins.MediaCredit', {
    $: jQuery,
    init: function init(ed, url) {
      var this_ = this;
      ed.on('BeforeSetContent', function (ed, o) {
        ed.content = this_._do_shcode(ed.content);
      });
      ed.on('PostProcess', function (ed, o) {
        if (ed.get) ed.content = this_._get_shcode(ed.content);
      }); // delete mediacredit html when its corresponding image is deleted

      tinymce.dom.Event.bind(document, 'mousedown', function (e) {
        var ed = tinymce.activeEditor,
            el = ed.selection.getNode(),
            parent;

        if (el.nodeName == 'DT' && ed.dom.getAttrib(el, 'class') === 'mediacredit-dt') {
          el = this_.$(el).closest('dl.mediacredit').get(0);
          ed.dom.remove(el);
        }
      });
    },
    _do_shcode: function _do_shcode(co) {
      return wp.shortcode.replace('mediacredit', co, function (a) {
        return '<dl class="mediacredit ' + a.attrs.named.align + '" data-credit="' + a.attrs.named.credit + '" data-align="' + a.attrs.named.align + '" data-width="' + a.attrs.named.width + '" style="width:' + a.attrs.named.width + 'px">' + '<dt class="mediacredit-dt">' + a.content + '<dt>' + '<dd class="wp-caption-dd">' + a.attrs.named.credit + '<dd>' + '</dl>';
      });
    },
    _get_shcode: function _get_shcode(co) {
      var this_ = this;
      return co.replace(/<dl class="mediacredit (.*?)>(.*?)<\/dl>/gi, function (a, b, c) {
        var $content = this_.$(a),
            data = $content.data();
        if (!$content.find('img').length) return '';
        $content.find('.' + data.align).removeClass(data.align);
        return wp.shortcode.string({
          tag: 'mediacredit',
          content: $content.find('dt').filter(':not(:empty)').html(),
          attrs: {
            id: $content.find('img').attr('class').replace(/\D+/g, 'attachment_'),
            width: data.width,
            align: data.align,
            credit: data.credit
          }
        });
      });
    },
    getInfo: function getInfo() {
      return {
        longname: 'UW Media Credit',
        author: 'Dane Odekirk',
        authorurl: 'http://uw.edu',
        infourl: 'http://uw.edu',
        version: tinymce.majorVersion + "." + tinymce.minorVersion
      };
    }
  });
  tinymce.PluginManager.add('mediacredit', tinymce.plugins.MediaCredit);
})();