"use strict";jQuery(function(s){function e(t){if(!s("body").hasClass("wp-customizer"))if(t.hasClass("expanded")){t.attr("style")&&t.data("original-style",t.attr("style"));var i=t.width();if(i<400){var e=400-i;t.css("position","relative").css("left","-"+e+"px").css("width","400px")}}else t.data("original-style")?t.attr("style",t.data("original-style")).data("original-style",null):t.removeAttr("style")}s("a.display-options").each(function(){var t=s(this),i=t.closest("div.widget");t.insertBefore(i.find("input.widget-control-save")),t.parent().removeClass("widget-control-noform").find(".spinner").remove().css("float","left").prependTo(t.parent())}),s("div#widgets-right, form#customize-controls").on("click","a.add-condition",function(t){t.preventDefault();var i=s(this).closest("div.condition"),e=i.clone().insertAfter(i);e.find("select.conditions-rule-major").val(""),e.find("select.conditions-rule-minor").html("").attr("disabled")}).on("click","a.display-options",function(t){t.preventDefault();var i=s(this).closest("div.widget");i.find("div.widget-conditional").toggleClass("widget-conditional-hide"),s(this).toggleClass("active"),i.toggleClass("expanded"),e(i),s(this).hasClass("active")?i.find("input[name=widget-conditions-visible]").val("1"):i.find("input[name=widget-conditions-visible]").val("0")}),s("div#widgets-right, form#customize-controls").on("click","a.delete-condition",function(t){t.preventDefault();var i=s(this).closest("div.condition");if(i.is(":first-child")&&i.is(":last-child"))s(this).closest("div.widget").find("a.display-options").click(),i.find("select.conditions-rule-major").val("").change();else{var e=s(this).closest("div.widget").find("input[name=savewidget]");e.removeAttr("disabled"),e.val("Save"),i.detach()}}).on("click","div.widget-top",function(){var t=s(this).closest("div.widget"),i=t.find("a.display-options");i.hasClass("active")&&i.attr("opened","true"),i.attr("opened")&&(i.removeAttr("opened"),t.toggleClass("expanded"),e(t))}),s(document).on("change","select.conditions-rule-major",function(){var t=s(this),i=t.siblings("select.conditions-rule-minor:first");if(t.val()){i.html("").append(s("<option/>").text(i.data("loading-text")));var e={action:"widget_conditions_options",major:t.val()};jQuery.post(ajaxurl,e,function(t){i.html(t).removeAttr("disabled")})}else t.siblings("select.conditions-rule-minor").attr("disabled","disabled").html("")})});