jQuery(function(l){l("#photoGridModal").on("show.bs.modal",function(a){var a=l(a.relatedTarget).children("img"),t=a.data("image"),i=a.data("caption"),d=a.data("credit"),o=a.data("source"),a=a.attr("alt"),e="",e=o?' <span class="wp-media-credit">Photo: <a href="'+o+'" target="_blank">'+d+"</a></span>":' <span class="wp-media-credit">Photo: '+d+"</span>";l(this).find(".modal-body").html('<figure><img src="'+t+'" alt="'+a+'" /><figcaption>'+i+e+"</figcaption></figure>")}),l(".entry-content").append('<div class="modal fade photo-modal" id="photoModal" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-dialog-centered w-90" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"></div></div></div></div>'),l("a > .wp-img, figure > a > img").on("click",function(a){var t,i=l(a.currentTarget);i.parent("a").attr("rel")||(a.preventDefault(),a=i.parent("a").attr("href"),t=i.attr("alt"),i=null==(i=i.parent("a").siblings("figcaption").html())?"":"<figcaption>"+i+"</figcaption>",l("#photoModal").find(".modal-body").html('<figure><img src="'+a+'" alt="'+t+'" />'+i+"</figure></div></div></div></div>"),l("#photoModal").modal("show"))})});